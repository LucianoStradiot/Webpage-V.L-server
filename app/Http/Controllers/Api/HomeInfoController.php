<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeInfo;
use Illuminate\Http\Request;

class HomeInfoController extends Controller
{
    public function getInfo()
    {
        $info = HomeInfo::latest()->first();

        return response()->json($info);
    }

    public function updateInfo(Request $request)
    {

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

        $info->fill($updateFields);
        $info->save();

        return response()->json(['message' => 'Information updated successfully']);
    }
}
