<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
     * @OA\Info(
     *      title="Digital Wallet API Documentation", 
     *      version="1.0.0",
     *      description="Digital Wallet Description",
     * )
     * 
     *@OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Digital Wallet API Server"
     * )
     * 
     * @OA\SecurityScheme(
     *      securityScheme="apiAuth",
     *      in="header",
     *      bearerFormat="JWT",
     *      type="http",
     *      scheme="bearer"
     * )
     */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
