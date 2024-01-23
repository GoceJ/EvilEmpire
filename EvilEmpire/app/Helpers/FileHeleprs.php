<?php

namespace App\Helpers;

class FileHeleprs
{
    public static function saveFile($image, $dir)
    {
        $imageName = time() . "." . $image->extension();
        $image->move(public_path($dir), $imageName);
        return "/{$dir}/{$imageName}";
    }

    public static function saveMultipleImages($images, $dir, $id, $model)
    {
        foreach ($images as $key =>  $image) {
            $imageName = time() + $key + 1 . "." . $image->extension();
            $image->move(public_path($dir), $imageName);
            $image = new $model(['image' => "/{$dir}/{$imageName}"]);
            $id->images()->save($image);
        }
    }
}
