<?php

use App\Api\V1\Controllers\Auth\AuthController;
use App\Api\V1\Controllers\Bank\BranchController;
use App\Api\V1\Controllers\Bank\AccountTypeController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api'], function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('register', [AuthController::class, 'register']);
        $api->post('login', [AuthController::class, 'login'])->name('login');
        $api->post('two-factor', [AuthController::class, 'twoFactorLogin']);

        $api->group(['prefix' => 'email'], function ($api) {
            $api->get('verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
            $api->post('resend', [AuthController::class, 'resend'])->name('verification.resend');
        });

        $api->group(['prefix' => 'password'], function ($api) {
            $api->post('forgot', [AuthController::class, 'forgotPassword'])->name('password.email');
            $api->post('reset', [AuthController::class, 'resetPassword'])->name('password.reset');
        });

        $api->group(['middleware' => 'auth:api'], function ($api) {
            $api->post('refresh', [AuthController::class, 'refresh']);
            $api->get('me', [AuthController::class, 'profile']);
            $api->post('logout', [AuthController::class, 'logout']);
        });
    });

    $api->group(['middleware' => 'auth:api'], function ($api) {
        $api->group(['prefix' => 'bank'], function ($api) {
            $api->group(['prefix' => 'branches'], function ($api) {
                $api->get('list', [BranchController::class, 'index']);
            });

            $api->group(['prefix' => 'accounts'], function ($api) {
                $api->group(['prefix' => 'types'], function ($api) {
                    $api->get('list', [AccountTypeController::class, 'index']);
                });
            });
        });
    });

    $api->get('/hello', function () {
        return [
            'gladwell' => 'A Full Stack Developer!'
        ];
    });
});
