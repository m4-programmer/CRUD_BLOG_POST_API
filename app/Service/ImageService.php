<?php

namespace App\Service;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    static function getInstance(): ImageService
    {
        return new ImageService();
    }

    public function uploadImage($image, $oldImage = null): string|null
    {
        $user = auth()->user();
        if ($image){
            if ($oldImage) {
                $oldImagePath = public_path().'\\'.$oldImage;
                if (file_exists($oldImagePath)) {
                    if (unlink($oldImagePath)) {
                        App::isLocal() && Log::info("Old image deleted successfully: $oldImagePath");
                    } else {
                        App::isLocal() && Log::error("Failed to delete old image: $oldImagePath");
                    }
                } else {
                    App::isLocal() &&  Log::warning("Old image not found: $oldImagePath");
                }

            }
            $imageName = time() . '-'. Str::random(5) . '.' . $image->getClientOriginalExtension();
            $image->move("assets/uploads/images", $imageName);
            App::isLocal() && Log::info("Image uploaded successfully: $imageName");

            return "assets/uploads/images/" .$imageName;
        }
        App::isLocal() && Log::info("No Image uploaded");
        return null;
    }
    public function getImage($request, $name){
        if ($request->hasFile($name)) {
            return $request->file($name);
        }
        return null;
    }
}
