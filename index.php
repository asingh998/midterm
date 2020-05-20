<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once("vendor/autoload.php");
require_once("model/data-layer.php");

//Instantiate the F3 Base class
$f3 = Base::instance();

//Default route
$f3->route('GET /', function() {
    echo '<h1>Midterm Survey</h1>';
    echo '<a href="views/survey.html">Take my midterm survey</a>';

    //$views = new Template();
    //echo $views->render('views/home.html');
});

$f3->route('GET|POST /survey', function($f3) {
    //echo '<h1>breakfast page.</h1>';
    $choices = getChoices();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        //["food"]=>"tacos" ["meal"]=>"lunch"

        //Validate the data

        if (empty($_POST['name'])) {
            echo "<p>Please enter a name</p>";
        }
        //Data is valid
        else {
            //Store the data in the session array
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['choices'] = $_POST['choices'];

            $f3->reroute('summary');

        }
    }

    $f3->set('choices', $choices);
    $views = new Template();
    echo $views->render('views/survey.html');
});

$f3->route('GET /summary', function() {
    //echo '<h1>Thank you for your order!</h1>';


    $views = new Template();
    echo $views->render('views/summary.html');

});

//Run F3
$f3->run();