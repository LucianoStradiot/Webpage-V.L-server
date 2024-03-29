<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class HomeInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'principalTitle',
        'biography',
        'secondaryTitle',
        'descriptionLeft',
        'descriptionRight',
        'motivationalPhrase',
        'profilePhoto',
        'helpPhoto1',
        'helpPhoto2'
    ];


}
