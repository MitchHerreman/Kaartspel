<?php

declare(strict_types=1);
require_once("bootstrap.php");

session_start();
// Test
// $winner = "Mitch";
if (isset($_SESSION["winner"])) {
    $winner = $_SESSION["winner"];
    print $twig->render("Winner.twig", array("winner" => $winner));
} else {
    header("location: login.php");
}
