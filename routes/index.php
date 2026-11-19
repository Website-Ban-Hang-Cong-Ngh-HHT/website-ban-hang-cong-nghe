<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    'login'     => (new AuthController)->login(),
    'register'  => (new AuthController)->register(),
    'logout'    => (new AuthController)->logout(),
    'admin'             => (new HomeController)->admin(),
    'checkout'          => (new HomeController)->checkout(),
    'checkout-confirm'  => (new HomeController)->checkoutConfirm(),
    default             => (new HomeController)->index(),
};
