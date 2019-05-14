<?php
/**
 * Index page
 * User: Ryan Guelzo
 * Date: 04/08/19
 */

//Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload
require_once('vendor/autoload.php');
require('model/validation.php');

session_start();

//Creates the instance of the base class
$f3 = Base::instance();


//Specified the default route
$f3->route('GET|POST /', function (){

    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /profile-start', function ($f3){

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get the form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $memberStatus = $_POST['premium'];



        //add to the hive
        $f3->set('firstname', $firstname);
        $f3->set('lastname', $lastname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);
        $f3->set('member', $memberStatus);



        if(validForm1()){
            if(empty($gender)) {
                $gender = 'No gender selected.';
            }
            if($memberStatus == 'premium'){
                $premium = new PremiumMemeber($firstname, $lastname, $age, $gender, $phone);
                $_SESSION['member'] = $premium;
            } else{
                $member = new Member($firstname, $lastname, $age, $gender, $phone);
                $_SESSION['member'] = $member;
            }

            $f3->reroute('/profile-continue');
        }

    }
//echo "here";
   $view = new Template();
   echo $view->render('views/personalinformation.html');
});

$f3->route('GET|POST /profile-continue', function ($f3){

    echo $f3->get('member');

    if(!empty($_POST)) {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('bio', $bio);

        if (validEmail($email)) {
            $_SESSION['member']->setEmail($email);
            if (!empty($state)) {
                $_SESSION['member']->setState($state);
            } else {
                $_SESSION['member']->setState('No state selected.');
            }
            if (!empty($seeking)) {
                $_SESSION['member']->setSeeking($seeking);
            } else {
                $_SESSION['member']->setSeeking('No seeking selected.');
            }
            if (!empty($bio)) {
                $_SESSION['member']->setBio($bio);
            } else {
                $_SESSION['member']->setBio('No bio input.');
            }
            if(!$_SESSION['member'] instanceof PremiumMemeber){
                $f3->reroute('/summary');
            } else{
                $f3->reroute('/profile-interests');
            }
        }
    }

    $view = new Template();
    echo $view->render('views/profileEntry.html');
});

$f3->route('GET|POST /profile-interests', function ($f3){

    if(!empty($_POST)) {
        $outdoor = $_POST['outdoor'];
        $indoor = $_POST['indoor'];

        $f3->set('outdoor', $outdoor);
        $f3->set('indoor', $indoor);

        if (validForm3()) {
            if(!empty($outdoor) && !empty($indoor)){

                $_SESSION['member']->setIndoorInterests($f3->get('indoor'));
                $_SESSION['member']->setOutdoorInterests($f3->get('outdoor'));

                $_SESSION['indoor'] = implode(", ", $_SESSION['member']->getInDoorInterests());
                $_SESSION['outdoor'] = implode(", ", $_SESSION['member']->getOutDoorInterests());
            }
            else{
                $_SESSION['indoor'] = "No Indoor Interests Provided.";
                $_SESSION['outdoor'] = "No Outdoor Interests Provided.";
            }
            $f3->reroute('/summary');
        }

    }

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET|POST /summary', function ($f3){


    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run fat-free
$f3->run();