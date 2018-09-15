<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Photo;

class PhotoController extends BaseController
{
    /**
     * Returns all photos on the server
     *
     * @param Request $request
     * @return void
     */
    public function getAllPhotos(Request $request) : JsonResponse
    {
        // Get all of the photos and format them for the app
        $photos = Photo::all()->map(function ($photo) {
            return $photo->format();
        });

        return response()->json($photos, 200);
    }

    /**
     * Retrieves an uploaded photo and saves it on the server
     *
     * @param Request $request
     * @return void
     */
    public function addPhoto(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Unique Enough for one day of photos
            $randomEnough = time();
            $randomEnough = time() . '.' . $image->getClientOriginalExtension();

            // Images folder
            $folder = storage_path('/app/images');

            // Save the image to disk
            $image->move($destinationPath, $filename);

            return response();
        }
    }

    /**
     * Creates db entry for the photo
     *
     * @param string $photoName
     * @return void
     */
    public static function createDBEntry(string $photoName) : void
    {
        Photo::create([
            'name' =>
        ]);

    }
}
