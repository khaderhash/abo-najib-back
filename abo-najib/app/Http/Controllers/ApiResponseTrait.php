<?php
namespace App\Http\Controllers;

trait ApiResponseTrait
{
   public function ApiResponseTrait($data =null,$message= null,$status = null){
    $msg=[
        'data'=>$data,
        'message'=> $message,
        'status' =>$status,
    ];


    return response($msg,$status);

   }
}
