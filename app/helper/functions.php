<?php

use Symfony\Component\HttpFoundation\Response;

function error_response($error){
    return response()->json(
        [
            'status' => false,
            'error' => $error,
        ],
        400
    );
}

function success_response($data, $message='',$status)
{
    return response()->json(
        [
            'status' => true,
            'user' => $data,
            'message' => $message,
        ],
        $status
    );
}
