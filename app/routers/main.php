<?php

use Apptive\Core\Brains\Response;
use Apptive\Core\Brains\Route;

Route::when('home', function () {
    Response::make()->sendPage('home');
});
