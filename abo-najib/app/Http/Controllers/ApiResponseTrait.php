<?php
namespace App\Http\Controllers;

trait ApiResponseTrait
{
public function ApiResponseTrait($data = null, $message = null, $status = 200)
{
    $msg = [
        'data' => $data,
        'message' => $message,
        'status' => $status,
    ];
    return response()->json($msg, $status);
}
}
