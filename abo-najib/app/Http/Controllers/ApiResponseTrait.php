<?php
namespace App\Http\Controllers;

trait ApiResponseTrait
{
public function ApiResponseTrait($data = null, $message = null, $status = 200)
{
    $arr = [
        'data' => $data,
        'message' => $message,
        'status' => $status,
    ];
    return response()->json($arr, $status);
}
}
