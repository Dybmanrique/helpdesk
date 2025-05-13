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
            ->with(['file_resolution', 'file_resolution.file'])
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
        $request->validate([
            'resolution_number' => 'required|string|max:255|unique:resolutions,resolution_number',
            'description' => 'required|string|max:1500',
            'file' => 'required|file|max:5120|mimes:pdf,jpg,png',
            'resolution_type_id' => 'required|numeric',
            'resolution_state_id' => 'required|numeric'
        ]);

        try {
            $resolution = Resolution::create([
                'resolution_number' => $request->resolution_number,
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'resolution_type_id' => $request->resolution_type_id,
                'resolution_state_id' => $request->resolution_state_id,
            ]);

            $year = date('Y');
            // Store the file in the appropriate directory
            $path = $request->file->store("resolutions/{$year}");

            // Create file record in database
            $file = new File([
                'name' => $request->file->getClientOriginalName(),
                'path' => $path,
            ]);

            $file->save();

            ResolutionFile::create([
                'resolution_id' => $resolution->id,
                'file_id' => $file->id
            ]);

            // Return success response with derivation status
            return response()->json([
                'message' => 'Hecho',
                'success' => true
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
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

        try {
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
                // Obtener el archivo anterior (asumiendo solo uno)
                $existingResolutionFile = $resolution->file_resolution()->first();

                if ($existingResolutionFile) {
                    $existingFile = $existingResolutionFile->file;

                    // Eliminar archivo físico del disco si existe
                    if ($existingFile && Storage::exists($existingFile->path)) {
                        Storage::delete($existingFile->path);
                    }

                    // Eliminar registros de la base de datos
                    $existingResolutionFile->delete();
                    $existingFile?->delete(); // Eliminar el modelo File si existe
                }

                // Guardar el nuevo archivo
                $year = date('Y');
                $path = $request->file->store("resolutions/{$year}");

                $file = new File([
                    'name' => $request->file->getClientOriginalName(),
                    'path' => $path,
                ]);
                $file->save();

                ResolutionFile::create([
                    'resolution_id' => $resolution->id,
                    'file_id' => $file->id,
                ]);
            }


            return response()->json([
                'message' => 'Resolución actualizada correctamente',
                'success' => true
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false
            ]);
        }
    }


    public function view_file($uuid)
    {
        try {
            // Buscar archivo por UUID (convertir a binario)
            $binaryUuid = File::uuidToBinary($uuid);
            $file = File::where('uuid', $binaryUuid)->firstOrFail();

            // Obtener ruta y contenido
            $path = $file->path;

            if (!Storage::disk('local')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado en almacenamiento'], 404);
            }

            // Mostrar en navegador (por ejemplo PDF, imagen, etc.)
            return response()->file(storage_path("app/private/{$path}"));

            // O si quieres forzar la descarga, usa:
            // return response()->download(storage_path("app/{$path}"));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Archivo no encontrado o UUID inválido'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $resolution = Resolution::findOrFail($id);

            // Eliminar archivos físicos y sus registros
            $file = $resolution->file_resolution->file;

            // Eliminar archivo físico si existe
            if ($file && Storage::exists($file->path)) {
                Storage::delete($file->path);
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
                'message' => 'Ocurrió un error al eliminar la resolución',
                'success' => false,
            ]);
        }
    }
}
