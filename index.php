<?php 

if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

require_once './configs/env.php';
require_once './configs/helper.php';

// Tự động nạp Model và Controller (hỗ trợ đường dẫn Windows có dấu tiếng Việt)
spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel      = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    if (is_file($fileModel) || file_exists($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_file($fileController) || file_exists($fileController)) {
        require_once $fileController;
    }
});

// Điều hướng trang web
require_once './routes/index.php';
