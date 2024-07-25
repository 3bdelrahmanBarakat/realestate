<?php

namespace App\Http\Controllers\API\Traits;

trait APIResponse
{
    public function success($status, $message, $data, $links = null)
    {
        $response = [
            "success" => true,
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "links" => $links,
        ];

        return response()->json($response, $status);
    }

    public function error($status, $message, $errors)
    {
        $response = [
            "success" => false,
            "status" => $status,
            "message" => $message,
            "errors" => $errors
        ];

        return response()->json($response, $status);
    }
}
