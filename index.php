<?php
/**
 * Index page
 * User: Ryan Guelzo
 * Date: 04/08/19
 */

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload
require_once('vendor/autoload.php');

//Includes the header form
include('views/header.html');

//Creates the instance of the base class
$f3 = Base::instance();

//Specified the default route
$f3->route('GET /', function (){
    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET /', function (){
   $view = new Template();
   $view->render('views/personalinformation.html');
});

$f3->route('GET /', function (){
    $view = new Template();
    $view->render('views/profileEntry.html');
});

//Run fat-free
$f3->run();
?>