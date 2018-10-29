<?php namespace App\Http\Controllers;


trait ResponseTrait
{
    protected function responseJson($message)
    {
        return response()->json([
            'is_error' => false,
            'response' => $message
        ]);
    }

    protected function responseJsonError($error, $code)
    {
        return response()->json([
            'is_error' => true,
            'response' => false,
            'error' => $error
        ], $code);
    }
}