<?php


function validForm1()
{
    global $f3;
    $isValid = true;
    if (!validname($f3->get('firstname'), $f3->get('lastname'))) {
        $isValid = false;
        $f3->set("errors['name']", "Not a valid name, please enter a valid name.");
    }
    if (!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter 1 or more.");
    }
    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid phone number (123-456-7890).");
    }
    return $isValid;
}

function validForm3()
{
    global $f3;
    $isValid = true;
    if (!validOutdoor($f3->get('outdoor'))) {
        $isValid = false;
        $f3->set("errors['outdoor']", "Selection not valid.");
    }
    if (!validIndoor($f3->get('indoor'))) {
        $isValid = false;
        $f3->set("errors['indoor']", "Selection not valid.");
    }
    return $isValid;
}

function validName($fname, $lname){
    return (!empty($fname) && ctype_alpha($fname)) && (!empty($lname) && ctype_alpha($lname));
}

function validAge($age){
    return !empty($age) && ctype_digit($age);
}

function validPhone($phone){
    return preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone);
}

function validEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validOutdoor($outdoor){

    $options = array('spellcasting', 'horse-riding', 'hiding', 'looting', 'fighting', 'healing');
    $verified = array();
    foreach ($options as $option) {
        if(isset($outdoor)){
            array_push($verified, $option);
        }
    }
    return sizeof($verified) > 0;
}

function validIndoor($indoor){

    $options = array('trading', 'dragon-chess', 'drinking', 'reading', 'pickpocketing', 'lock-picking',
        'story-telling', 'smithing');
    $verified = array();
    foreach ($options as $option) {
        if(isset($indoor)){
            array_push($verified, $option);
        }
    }
    return sizeof($verified) > 0;
}
