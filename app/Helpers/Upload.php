<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

/**
 * Created by PhpStorm.
 * User: ylafontaine
 * Date: 2017-11-21
 * Time: 11:20
 */

namespace ThreenityCMS\Helpers;

use upload as UploadClass;

class Upload
{
    /**
     * Validate and upload an profile image
     *
     * @param $file_object - Image
     * @param $path - Where to upload image
     */
    public static function profile_image($file_object, $path)
    {
        $handle = new UploadClass($file_object, 'fr_FR');
        if ($handle->uploaded) {
            $handle->file_max_size = '4M';
            $handle->file_safe_name = true;
            $handle->file_name_body_pre = 'profile_';
            $handle->file_auto_rename = true;
            $handle->dir_auto_create = false;
            $handle->mime_check = true;
            $handle->allowed = ['image/*'];
            $handle->image_convert = 'png';
            $handle->png_compression = 5;
            $handle->image_interlace = true;
            $handle->process($path);
            if ($handle->processed) {

                $data = [
                    "msg" => $handle->file_dst_name,
                    "uploaded" => true,
                ];

                $handle->clean();

                return $data;
            } else {

                $data = [
                    "msg" => $handle->error,
                    "uploaded" => false,
                ];

                return $data;
            }
        }

        $data = [
            "msg" => "Erreur inconnue.",
            "uploaded" => false,
        ];

        return $data;
    }
}