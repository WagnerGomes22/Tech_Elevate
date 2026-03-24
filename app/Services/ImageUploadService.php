<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    /**
     * Upload an image to a specified directory
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string Image name
     */
    public function upload(UploadedFile $file, string $path = 'img/events'): string
    {
        $extension = $file->extension();
        $imageName = md5($file->getClientOriginalName() . strtotime("now")) . "." . $extension;

        // Salva a imagem diretamente na pasta public
        $file->move(public_path($path), $imageName);

        return $imageName;
    }

    /**
     * Delete an image from a specified directory
     *
     * @param string|null $imageName
     * @param string $path
     * @return void
     */
    public function delete(?string $imageName, string $path = 'img/events'): void
    {
        if ($imageName && file_exists(public_path($path . '/' . $imageName))) {
            unlink(public_path($path . '/' . $imageName));
        }
    }
}
