<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ResponsHelper
{
    public static function success($data, $message = 'Success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Error', $code = Response::HTTP_BAD_REQUEST, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}