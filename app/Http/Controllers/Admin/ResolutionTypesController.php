<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResolutionType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResolutionTypesController extends Controller
{
    public function index(){
        return view('admin.resolution-types.index');
    }

    public function data()
    {
        $resolutions = ResolutionType::query();

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
            'name' => 'required|string|max:255',
        ]);

        try {
            ResolutionType::create([
                'name' => $request->name
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
            'resolution_type_id' => 'required|numeric',
            'name' => 'required|string|max:255',
        ]);

        try {
            $resolutionType = ResolutionType::findOrFail($request->resolution_type_id);
            $resolutionType->update([
                'name' => $request->name
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

    public function destroy($id)
    {
        try {
            $resolution_type = ResolutionType::findOrFail($id);

            // Eliminar la resolución
            $resolution_type->delete();

            return response()->json([
                'message' => 'Eliminado correctamente',
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error en el servidor',
                'success' => false,
            ]);
        }
    }
}
