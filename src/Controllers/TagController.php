<?php

namespace Bendt\Instagram\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Bendt\Instagram\Services\TagService;
use Bendt\Instagram\InstaLite\InstaLite;

class TagController
{
    public function schedule(Request $request)
    {
        $post = TagService::getSchedulePost();
        if(!$post) return response()->json(['success'=>0, 'message' => 'No schedule post!']);
        $username = config('bendt-instagram.username');
        $password = config('bendt-instagram.password');

        try {
            $image_url = storage_path('app/public'.$post->image_url);
            $content = TagService::compose($post);
            
            $instagram = new InstaLite($username, $password, false);
            $instagram->uploadPhoto($image_url, $content, $post->alt);

            $post->is_posted = true;
            $post->save();

            return response()->json(['success'=>1]);
        } catch (\Exception $e) {
            return response()->json(['success'=>0, 'message' => 'InstaLite Throws: '.$e->getMessage()]);
        }
    }
}
