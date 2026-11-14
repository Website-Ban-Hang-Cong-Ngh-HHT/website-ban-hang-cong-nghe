<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->index(),
    'login'     => (new HomeController)->login(),
    'register'  => (new HomeController)->register(),
    'admin'     => (new HomeController)->admin(),
    default     => (new HomeController)->index(),
};