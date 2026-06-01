<?php

use Core\Router;
use Core\Session;
use Core\ValidationException;

const BASE_PATH = __DIR__ . '/../';

session_start();

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    $path = BASE_PATH . $class . '.php';

    if (file_exists($path)) {
        require $path;
    }
});

require BASE_PATH . 'bootstrap.php';


$router = new Router();

require BASE_PATH . 'routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    return redirect($router->previousUrl());
}

Session::unflash();