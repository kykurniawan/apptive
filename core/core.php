<?php

if (!function_exists('error_handler')) {
    function error_handler($error)
    {
        if ($error instanceof PageNotFoundException) {
            http_response_code(404);
            exit();
        }

        throw $error;
    }
}
