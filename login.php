<?php

declare(strict_types=1);
require_once("bootstrap.php");

use Business\UserService;

session_start();
$userSvc = new UserService();
$validationP1 = "";
$validationP2 = "";
$usernameP1 = "";
$usernameP2 = "";
if (isset($_SESSION["filename"])) {
    unset($_SESSION["filename"]);
}
if (isset($_GET["action"]) && $_GET["action"] === "loginP1") {
    $user = $userSvc->getUserByUsername($_POST["usernameP1"]);
    if ($user === null) {
        // User doesn't exist
        $_SESSION["validuserP1"] = 0;
    } else {
        $hashPassword = $user->getPassword();
        if (!password_verify($_POST["passwordP1"], $hashPassword)) {
            // Password incorrect
            $_SESSION["validuserP1"] = 1;
        } else {
            // Login succesful
            $_SESSION["validuserP1"] = 2;
            $_SESSION["usernameP1"] = $_POST["usernameP1"];
        }
    }
}
if (isset($_GET["action"]) && $_GET["action"] === "loginP2") {
    $user = $userSvc->getUserByUsername($_POST["usernameP2"]);
    if ($user === null) {
        // User doesn't exist
        $_SESSION["validuserP2"] = 0;
    } else {
        $hashPassword = $user->getPassword();
        if (!password_verify($_POST["passwordP2"], $hashPassword)) {
            // Password incorrect
            $_SESSION["validuserP2"] = 1;
        } else {
            // Login succesful
            $_SESSION["validuserP2"] = 2;
            $_SESSION["usernameP2"] = $_POST["usernameP2"];
        }
    }
}
if (isset($_SESSION["validuserP1"])) {
    $validationP1 = $_SESSION["validuserP1"];
}
if (isset($_SESSION["validuserP2"])) {
    $validationP2 = $_SESSION["validuserP2"];
}
if (isset($_SESSION["usernameP1"])) {
    $usernameP1 = $_SESSION["usernameP1"];
}
if (isset($_SESSION["usernameP2"])) {
    $usernameP2 = $_SESSION["usernameP2"];
}
if (isset($_SESSION["validuserP1"]) && $_SESSION["validuserP1"] === 2 && isset($_SESSION["validuserP2"]) && $_SESSION["validuserP2"] === 2) {
    header("location: game.php");
    exit(0);
}
print $twig->render("Login.twig", array("validationP1" => $validationP1, "validationP2" => $validationP2, "usernameP1" => $usernameP1, "usernameP2" => $usernameP2));
