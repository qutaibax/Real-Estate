<?php

namespace App\Traits;

trait Image
{
    public static function uploadimage($request, $file = 'image')
    {
        if (!$request->hasFile($file)) {
            return false;
        }
        $path = $request->file($file)->store('images', ['disk'=>'public']);
        return $path;
    }
}
