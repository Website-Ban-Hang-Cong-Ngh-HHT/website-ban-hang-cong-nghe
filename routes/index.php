<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    'login'     => (new AuthController)->login(),
    'register'  => (new AuthController)->register(),
    'logout'    => (new AuthController)->logout(),
    'admin'     => (new HomeController)->admin(),
    default     => (new HomeController)->index(),
};
