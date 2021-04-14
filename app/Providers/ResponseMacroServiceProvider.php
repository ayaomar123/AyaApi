<?php


namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($data) {
            return Response::json([
                'msg' => 'success',
                'status'=> 200,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($message, $status = 400) {
            return Response::json([
                'msg'  => 'error',
                'message' => $message,
            ], $status);
        });
    }
}
