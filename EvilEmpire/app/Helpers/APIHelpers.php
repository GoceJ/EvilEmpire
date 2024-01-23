<?php

namespace App\Helpers;

class APIHelpers {
    public static function createApiResponse($isError, $code, $message, $content) {
        $result = [];

        if($isError) {
            $result['success'] = false;
            $result['code'] = $code;
            $result['message'] = $message;
        } else {
            $result['success'] = true;
            $result['code'] = $code;
            if($content == null) {
                $result['message'] = $message;
            } else {
                $result['data'] = $code;
            }
        }

        return $result;
    }

}