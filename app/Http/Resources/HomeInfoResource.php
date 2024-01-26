<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HomeInfoResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'principalTitle' => $this->principalTitle,
            'biography' => $this->biography,
            'secondaryTitle' => $this->secondaryTitle,
            'descriptionLeft' => $this->descriptionLeft,
            'descriptionRight' => $this->descriptionRight,
            'motivationalPhrase' => $this->motivationalPhrase,
            'profilePhoto' => $this->profilePhotoUrl(),
            'helpPhoto1' => $this->helpPhoto1(),
            'helpPhoto2' => $this->helpPhoto2(),
        ];
    }

    protected function profilePhotoUrl()
    {
        return $this->profilePhoto ? Cloudinary::getImage($this->profilePhoto)->toUrl() : null;
    }
    protected function helpPhoto1()
    {
        return $this->helpPhoto1 ? Cloudinary::getImage($this->helpPhoto1)->toUrl() : null;
    }
    protected function helpPhoto2()
    {
        return $this->helpPhoto2 ? Cloudinary::getImage($this->helpPhoto2)->toUrl() : null;
    }

}


