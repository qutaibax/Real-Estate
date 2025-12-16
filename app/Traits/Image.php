<?php

namespace App\Traits;

use Couchbase\RequestCanceledException;

trait Image
{
    public static function uploadimage($request, $file = 'image')
    {
        if (!$request->hasFile($file)) {
            return false;
        }
        $image = $request->file($file);
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imageName = $image->storeAs('images', $imageName, 'public');
        return $imageName;
    }


}
