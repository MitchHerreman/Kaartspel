<?php

declare(strict_types=1);
require_once("bootstrap.php");

use Business\CardService;

session_start();
if (isset($_GET["action"]) && $_GET["action"] = "logoutP1") {
    unset($_SESSION["usernameP1"], $_SESSION["validuserP1"]);
}
if (isset($_GET["action"]) && $_GET["action"] = "logoutP2") {
    unset($_SESSION["usernameP2"], $_SESSION["validuserP2"]);
}
if (isset($_GET["action"]) && $_GET["action"] = "logout") {
    $cardSvc = new CardService();
    $cardSvc->resetGame();
    unset($_SESSION["usernameP2"], $_SESSION["validuserP2"], $_SESSION["usernameP1"], $_SESSION["validuserP1"]);
}
header("location: login.php");
