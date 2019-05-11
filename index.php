<?php
/**
 * Index page
 * User: Ryan Guelzo
 * Date: 04/08/19
 */

//Turn on Fat-Free error reporting
set_exception_handler(function($obj) use($f3){
    $f3->error(500,$obj->getmessage(),$obj->gettrace());
});
set_error_handler(function($code,$text) use($f3)
{
    if (error_reporting())
    {
        $f3->error(500,$text);
    }
});
$f3->set('DEBUG', 3);

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

        $memberStatus = $_POST['premium'];

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
        $f3->set('member', $memberStatus);

        if(validForm1()){
            if(empty($gender)) {
                $gender = 'No gender selected.';
            }
            if(!empty($memberStatus)){
                $premium = new PremiumMemeber($firstname, $lastname, $age, $gender, $phone);
                $_SESSION['member'] = $premium;
            }
            else{
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

    echo $_SESSION['member']->getLname();
    echo $_SESSION['member']->getFname();
    echo $_SESSION['member']->getAge();
    echo $_SESSION['member']->getGender();
    echo $_SESSION['member']->getPhone();

    if(!empty($_POST)) {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('bio', $bio);


        if (validEmail($f3->get('email'))) {
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
            if($f3->get('member') == 'premium'){
                $f3->reroute('/profile-interests');
            }
            else{
                $f3->reroute('/summary');
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
                $_SESSION['member']->setOutDoorInterests(implode(', ', $outdoor));
                $_SESSION['member']->setInDoorInterests(implode(', ', $indoor));
            }
            else{
                $_SESSION['outdoor'] = 'Not available for Non-Premium Members.';
                $_SESSION['indoor'] = 'Not available for Non-Premium Members.';
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