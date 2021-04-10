<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers;

/**
 *  @OA\Info(
 *      version="1.0.0",
 *      title="Banking App OpenApi",
 *      description="Banking App API Explorer..",
 *      @OA\Contact(
 *          email="gladwell_n@live.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 *  )
 *
 *  @OA\Schemes(format="http")
 *  @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      description="Paste the token below:",
 *      in="header",
 *      name="Authorization",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *  )
 *
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Swagger OpenApi server"
 *  )
 *
 *  @OA\Tag(
 *      name="Test",
 *      description="API Endpoints for testing."
 *  )
 *  @OA\Tag(
 *      name="Authentication",
 *      description="API Endpoints for user authentication."
 *  )
 *  @OA\Tag(
 *      name="Account Types",
 *      description="API Endpoints for bank account types."
 *  )
 *  @OA\Tag(
 *      name="Branhes",
 *      description="API Endpoints for bank branches."
 *  )
 * 
 *  @OA\Get(
 *      path="/hello",
 *      operationId="testRoute",
 *      tags={"Test"},
 *      summary="Simple test route",
 *      description="Returns my name.",
 *      @OA\Response(response=200, description="Successful request"),
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;
}
