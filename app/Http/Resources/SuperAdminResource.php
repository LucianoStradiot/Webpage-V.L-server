<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SuperAdminResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'profile_photo' => $this->profilePhotoUrl()
        ];
    }

    protected function profilePhotoUrl()
    {
        return $this->profile_photo ? Cloudinary::getImage($this->profile_photo)->toUrl() : null;
    }

}
