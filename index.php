<?php
/**
 * Index page
 * User: Ryan Guelzo
 * Date: 04/08/19
 */
session_start();

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload
require_once('vendor/autoload.php');

//Includes the header form
//include('views/header.html');

//Creates the instance of the base class
$f3 = Base::instance();

//Specified the default route
$f3->route('GET|POST /', function (){

    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /profile-start', function (){

//echo "here";
   $view = new Template();
   echo $view->render('views/personalinformation.html');
});

$f3->route('GET|POST /profile-continue', function (){

    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['lastname'] = $_POST['lastname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    $view = new Template();
    echo $view->render('views/profileEntry.html');
});

$f3->route('GET|POST /profile-interests', function (){

    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['bio'] = $_POST['bio'];

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /summary', function (){

    $_SESSION['indoor'] = implode(', ', $_POST['indoor']);
    $_SESSION['outdoor'] = implode(', ', $_POST['outdoor']);


    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run fat-free
$f3->run();