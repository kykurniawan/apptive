<?php

define('APP', true);

require_once 'core/bootstrap.php';

/**
 * List of core modules to be activated.
 */
core_modules([]);

/**
 * List of application modules to be activated.
 */
app_modules([]);

/**
 * Start our app.
 */
start_app();
