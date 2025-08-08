<?php

namespace App\Http\Controllers;

use App\Models\ActionFile;
use App\Models\ProcedureFile;
use App\Models\ResolutionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileViewController extends Controller
{
    public function viewProcedureFile($uuid)
    {
        try {
            // Buscar archivo por UUID
            $actionFile = ProcedureFile::where('uuid', $uuid)->firstOrFail();

            // Obtener ruta del archivo en S3
            $path = $actionFile->path;

            // Verificar si el archivo existe en S3
            if (!Storage::disk('s3')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado en almacenamiento'], 404);
            }

            // Generar URL temporal (válida por 5 minutos)
            $temporaryUrl = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

            // Redirigir a la URL temporal para mostrar el archivo en el navegador
            return redirect($temporaryUrl);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Archivo no encontrado o UUID inválido'], 404);
        }
    }

    public function viewActionFile($uuid)
    {
        try {
            // Buscar archivo por UUID
            $actionFile = ActionFile::where('uuid', $uuid)->firstOrFail();

            // Obtener ruta del archivo en S3
            $path = $actionFile->path;

            // Verificar si el archivo existe en S3
            if (!Storage::disk('s3')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado en almacenamiento'], 404);
            }

            // Generar URL temporal (válida por 5 minutos)
            $temporaryUrl = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

            // Redirigir a la URL temporal para mostrar el archivo en el navegador
            return redirect($temporaryUrl);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Archivo no encontrado o UUID inválido'], 404);
        }
    }

    public function viewResolutionFile($uuid)
    {
        try {
            // Buscar archivo por UUID
            $resolutionFile = ResolutionFile::where('uuid', $uuid)->firstOrFail();

            // Obtener ruta del archivo en S3
            $path = $resolutionFile->path;

            // Verificar si el archivo existe en S3
            if (!Storage::disk('s3')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado en almacenamiento'], 404);
            }

            // Generar URL temporal (válida por 5 minutos)
            $temporaryUrl = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

            // Redirigir a la URL temporal para mostrar el archivo en el navegador
            return redirect($temporaryUrl);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Archivo no encontrado o UUID inválido'], 404);
        }
    }
}
