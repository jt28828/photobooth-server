<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Photo;
use Faker\Provider\File;
use Illuminate\Support\Facades\Storage;

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
            
            // Unique filenames
            $filename = time() . bin2hex(random_bytes(15));
            $filenameWithExtension = $filename . '.' . $image->getClientOriginalExtension();

            // Images folder
            $folder = base_path('public/uploaded/images/');

            $completePath = $folder . $filenameWithExtension;

            // Save the image to disk
            $image->move($folder, $filenameWithExtension);

            $uploaderName = $request->input('name');

            $photoStorageLocation = self::createDBEntry($filenameWithExtension, $uploaderName);

            return response($photoStorageLocation, 201);
        }
    }

    /**
     * Deletes an existing photo
     */
    public function deletePhoto(Request $request, $filename)
    {
        $storageAddress = 'public/uploaded/images/' . $filename . '.jpg';

        $photo = Photo::whereStorageAddress($storageAddress);

        if ($photo == null) {
            return response('', 404);
        }

        // Delete the DB entry
        $photo->delete();

        // Delete the actual file
        unlink(base_path($storageAddress));

        return response('', 204);
    }

    /**
     * Creates db entry for the photo
     *
     * @param string $filename - The filename to store in the db
     * @param string $uploader - The name of the uploading person to attach to the photo
     */
    private static function createDBEntry(string $filename, string $uploader) : string
    {
        $filepath = 'public/uploaded/images/' . $filename;
        $photo = Photo::create([
            'name' => $uploader,
            'storage_address' => $filepath,
        ]);

        return $photo->storage_address;
    }
}
