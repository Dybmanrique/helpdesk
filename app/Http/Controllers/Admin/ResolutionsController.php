<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Resolution;
use App\Models\ResolutionFile;
use App\Models\ResolutionState;
use App\Models\ResolutionType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ResolutionsController extends Controller
{
    public function index()
    {

        $resolution_types = ResolutionType::all();
        $resolution_states = ResolutionState::all();

        return view('admin.resolutions.index', compact('resolution_types', 'resolution_states'));
    }

    public function data()
    {

        $resolutions = Resolution::query()
            ->with(['file_resolution'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($resolutions)
            ->addColumn('actions', function ($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'resolution_number' => 'required|string|max:255|unique:resolutions,resolution_number',
                'description' => 'required|string|max:1500',
                'file' => 'required|file|max:5120|mimes:pdf,jpg,png',
                'resolution_type_id' => 'required|numeric',
                'resolution_state_id' => 'required|numeric'
            ]);

            $resolution = Resolution::create([
                'resolution_number' => $request->resolution_number,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'resolution_type_id' => $request->resolution_type_id,
                'resolution_state_id' => $request->resolution_state_id,
            ]);

            $year = date('Y');

            // Opción 1: Laravel genera el nombre automáticamente (recomendado)
            $path = $request->file('file')->store("resolutions/{$year}", 's3');

            // Opción 2: Si necesitas más control, puedes usar storeAs con hash único
            // $uniqueName = Str::random(40) . '.' . $request->file('file')->getClientOriginalExtension();
            // $path = $request->file('file')->storeAs("resolutions/{$year}", $uniqueName, 's3');

            ResolutionFile::create([
                'resolution_id' => $resolution->id,
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => $path,
            ]);

            // Return success response
            return response()->json([
                'message' => 'Hecho',
                'success' => true
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor: ' . $ex->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'resolution_id' => 'required|numeric|exists:resolutions,id',
            'resolution_number' => 'required|string|max:255|unique:resolutions,resolution_number,' . $request->resolution_id,
            'description' => 'required|string|max:1500',
            'file' => 'nullable|file|max:5120|mimes:pdf,jpg,png',
            'resolution_type_id' => 'required|numeric',
            'resolution_state_id' => 'required|numeric'
        ]);

        // Buscar la resolución existente
        $resolution = Resolution::findOrFail($request->resolution_id);

        // Actualizar campos de la resolución
        $resolution->update([
            'resolution_number' => $request->resolution_number,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'resolution_type_id' => $request->resolution_type_id,
            'resolution_state_id' => $request->resolution_state_id,
        ]);

        // Verificar si se ha enviado un nuevo archivo
        if ($request->hasFile('file')) {
            $file = $resolution->file_resolution;

            // Eliminar archivo físico de S3 si existe
            if ($file && Storage::disk('s3')->exists($file->path)) {
                Storage::disk('s3')->delete($file->path);
            }

            $file?->delete();

            // Guardar el nuevo archivo
            $year = date('Y');
            // $path = $request->file->store("resolutions/{$year}");
            $path = $request->file('file')->store("resolutions/{$year}", 's3');

            ResolutionFile::create([
                'resolution_id' => $resolution->id,
                'name' => $request->file->getClientOriginalName(),
                'path' => $path,
            ]);
        }


        return response()->json([
            'message' => 'Resolución actualizada correctamente',
            'success' => true
        ]);
        try {
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $resolution = Resolution::findOrFail($id);

            // Eliminar archivos físicos y sus registros
            $file = $resolution->file_resolution;

            // Eliminar archivo físico de S3 si existe
            if ($file && Storage::disk('s3')->exists($file->path)) {
                Storage::disk('s3')->delete($file->path);
            }

            // Eliminar registros en la BD
            $resolution->file_resolution->delete();
            $file?->delete();

            // Eliminar la resolución
            $resolution->delete();

            return response()->json([
                'message' => 'Resolución eliminada correctamente',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al eliminar la resolución: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }
}
