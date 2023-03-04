<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Auth;

class Media
{
    public static function profileAvatar($picture)
    {
        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);
        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $picture->move(public_path() . "/uploads" . "/users/" . Auth::user()->id . "/profile_avatar/", $file_name . "." . $ext);
            $local_url = $file_name . "." . $ext;

            $url = '/uploads/users/' . Auth::user()->id . '/profile_avatar/' . $local_url;

            return $url;
        }
        return "";
    }

    public static function convertFullUrl($url)
    {
        if ($url) {
            return asset($url);
        }
        return asset("/images/default.jpeg");
    }
}
