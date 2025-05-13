<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResolutionState;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResolutionStatesController extends Controller
{
    public function index(){
        return view('admin.resolution-states.index');
    }

    public function data()
    {
        $resolutions = ResolutionState::query();

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
            ResolutionState::create([
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
            $resolutionState = ResolutionState::findOrFail($request->resolution_type_id);
            $resolutionState->update([
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
            $resolution_type = ResolutionState::findOrFail($id);

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
