<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api'], function ($api) {
    $api->get('/hello', function () {
        return [
            'gladwell' => 'A Full Stack Developer!'
        ];
    });
});
