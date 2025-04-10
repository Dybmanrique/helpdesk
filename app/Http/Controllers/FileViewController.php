<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileViewController extends Controller
{
    public function view(File $file)
    {

        $path = storage_path('app/private/' . $file->path);

        if (!file_exists($path)) {
            abort(404);
        }

        // Autorization logic here

        $mime = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mime,
        ]);
    }
}
