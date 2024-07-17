<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function success($data = [], $message = "Successful", $status=200)
    {
        return response()->json([
            "message" => $message ?? "Successful",
            "status" => $status,
            "data"=>$data,
        ], $status);
    }

    public function error($message = "An error Occurred", $status=500, $error = [])
    {
        return response()->json([
            "message" => $message ,
            "status" => $status,
            "error"=>$error,
        ], $status);
    }
}
