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

$f3->route('GET|POST /profile-continue', function ($f3){

    if(!empty($_POST)) {

        //get the form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        //add to the hive
        $f3->set('firstname', $firstname);
        $f3->set('lastname', $lastname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);

        if(validForm1()){
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['age'] = $age;
            if(!empty($gender)){
                $_SESSION['gender'] = $gender;
            }
            else{
                $_SESSION['gender'] = 'No gender selected.';
            }
            $_SESSION['phone'] = $phone;

            $f3->reroute('/profile-interests');
        }
    }
    $view = new Template();
    echo $view->render('views/profileEntry.html');
});

$f3->route('GET|POST /profile-interests', function ($f3){

    $email = $_POST['email'];
    $state = $_POST['state'];
    $seeking = $_POST['seeking'];
    $bio = $_POST['bio'];

    $f3->set('email', $email);
    $f3->set('state', $state);
    $f3->set('seeking', $seeking);
    $f3->set('bio', $bio);

    if(validEmail()){
        $_SESSION['email'] = $_POST['email'];
        if(!empty($state)){
            $_SESSION['state'] = $state;
        }
        else{
            $_SESSION['state'] = 'No state selected.';
        }
        if(!empty($seeking)){
            $_SESSION['seeking'] = $seeking;
        }
        else{
            $_SESSION['seeking'] = 'No input.';
        }if(!empty($bio)){
            $_SESSION['bio'] = $bio;
        }
        else{
            $_SESSION['bio'] = 'No bio entered.';
        }
    }


    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /summary', function ($f3){
    if(!empty($_POST)) {
        $outdoor = $_POST['outdoor'];
        $indoor = $_POST['indoor'];

        $f3->set('outdoor', $outdoor);
        $f3->set('indoor', $indoor);

        if (validForm3()) {
            if(!empty($outdoor)){
                $_SESSION['outdoor'] = implode(', ', $outdoor);
            }
            else{
                $_SESSION['outdoor'] = 'No outdoor selections made.';
            }
            if(!empty($outdoor)){
                $_SESSION['indoor'] = implode(', ', $indoor);
            }
            else{
                $_SESSION['indoor'] = 'No indoor selections made.';
            }
        }

    }


    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run fat-free
$f3->run();