<?php
require '../vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter as Router;


Router::get('/', function() {
    $page = [
        "title" => "",
    ];
    include __DIR__ . "/../templates/home.php";
});