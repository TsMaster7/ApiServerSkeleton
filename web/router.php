<?php

/*
 * if we work with built-in server, send all requests to the root '/',
 * but save real request uri in constant to restore it later in front controller
 */
if (php_sapi_name() == 'cli-server') {
    if ('/' != $_SERVER['REQUEST_URI']) {
        define('REAL_REQUEST_URI', $_SERVER['REQUEST_URI']);
        $_SERVER['REQUEST_URI'] = '/';
    }
}
include 'index.php';