<?php
date_default_timezone_set('America/Bogota');
ini_set('display_errors', 1);
if(file_exists('vendor/autoload.php')){
    $vendor = 'vendor/autoload.php';
}else{
    $vendor='../vendor/autoload.php';
}
include_once($vendor);
Class Config{
    public function dataConfig(){
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
        $dotenv->load();

        return array(
            "driver" => "mysql",
            "host" => $_ENV['DB_HOST'],
            "user" => $_ENV['DB_USERNAME'],
            "pass" => $_ENV['DB_PASSWORD'],
            "database" => $_ENV['DB_DATABASE'],
            "charset" => "utf8"
        );
    }
}
