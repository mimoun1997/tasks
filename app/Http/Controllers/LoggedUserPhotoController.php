<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoggedUserPhotoController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $photo = $this->userPhotoExists($request->user()) ? $request->user()->photo->url : $this->defaultPhoto();
        //dd($photo);
        //dd(Storage::disk('local')->allFiles());
        return response()->file(Storage::disk('local')->path($photo), [
            'Cache-Control' => 'no-cache, must-revalidate, no-store, max-age=0, private',
            'Pragma' => 'no-cache']);
    }

    protected function userPhotoExists($user)
    {
        return $user->photo && Storage::disk('local')->exists($user->photo->url);
    }

    protected function defaultPhoto()
    {
        return 'public/photos/default.png';//User::DEFAULT_PHOTO_PATH;
    }
}
