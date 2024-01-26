<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeInfo;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Resources\HomeInfoResource;

class HomeInfoController extends Controller
{
    public function getInfo()
    {
        $info = HomeInfo::latest()->first();

        return new HomeInfoResource($info);
    }

    public function updateInfo(Request $request)
    {
        try {
            $info = HomeInfo::latest()->first();

            if (!$info) {
                $info = new HomeInfo();
            }

            $updateFields = $request->only([
                'principalTitle',
                'biography',
                'secondaryTitle',
                'descriptionLeft',
                'descriptionRight',
                'motivationalPhrase',
            ]);

            $photoFields = [
                'profilePhoto',
                'helpPhoto1',
                'helpPhoto2',
            ];

            foreach ($photoFields as $field) {
                if ($request->hasFile($field)) {
                    $oldPhoto = $info->$field;

                    if ($oldPhoto) {
                        Cloudinary::destroy($oldPhoto);
                    }

                    $photoPath = $request->file($field)->storeOnCloudinary()->getPublicId();
                    $info->update([$field => $photoPath]);
                }
            }

            $info->fill($updateFields);
            $info->save();

            return new HomeInfoResource($info);
        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

}
