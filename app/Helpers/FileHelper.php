<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileHelper
{
    public static function upload(UploadedFile $file, string $folder): string
    {
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.\-]/', '_', $file->getClientOriginalName());
        $destination = public_path($folder);
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        $file->move($destination, $filename);

        return "$folder/$filename";
    }
}
