<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $table = 'uploaded_files';

    protected $fillable = [
        'path',
        'filename',
        'folder',
        'mime_type',
        'file_size',
        'file_data',
    ];

    /**
     * Store or update a file in the database from a given absolute or relative path
     */
    public static function storeFromPath(string $relativePath, ?string $absolutePath = null): ?self
    {
        $cleanPath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $fullPath = $absolutePath ?: public_path($cleanPath);

        if (!file_exists($fullPath) || !is_file($fullPath)) {
            return null;
        }

        $content = file_get_contents($fullPath);
        if ($content === false) {
            return null;
        }

        $filename = basename($cleanPath);
        $parts = explode('/', $cleanPath);
        $folder = count($parts) > 1 ? $parts[count($parts) - 2] : 'general';
        $mime = @mime_content_type($fullPath) ?: 'image/jpeg';
        $size = filesize($fullPath);

        return self::updateOrCreate(
            ['path' => $cleanPath],
            [
                'filename' => $filename,
                'folder' => $folder,
                'mime_type' => $mime,
                'file_size' => $size,
                'file_data' => base64_encode($content),
            ]
        );
    }
}
