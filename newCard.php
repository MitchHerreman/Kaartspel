<?php

declare(strict_types=1);
require_once("bootstrap.php");

use Business\CardService;

session_start();
define('SITE_ROOT', realpath(dirname(__FILE__)));
$cardSvc = new CardService();
$validcard = "";
$validimage = "";
if ((isset($_SESSION["usernameP1"]) && $_SESSION["usernameP1"] === "Admin") || (isset($_SESSION["usernameP2"]) && $_SESSION["usernameP2"] === "Admin")) {
    if (isset($_POST["uploadimage"])) {
        $filename = $_FILES["image"]["name"];
        $allowed = array('png');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            // Not the right file type
            $validimage = 0;
        } else {
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "/images";
            $_SESSION["filename"] = $filename;
            move_uploaded_file($tempname, SITE_ROOT . "$folder/$filename");
            // Image uploaded
            $validimage = 1;
        }
    }
    if (isset($_GET["action"]) && $_GET["action"] === "createcard") {
        if (isset($_SESSION["filename"])) {
            $cardname = $cardSvc->getCardByName($_POST["name"]);
            if ($cardname === null) {
                // Card created
                $validcard = 1;
                $cardSvc->newCard(htmlspecialchars($_POST["name"]), intval($_POST["hp"]), intval($_POST["power"]), intval($_POST["defense"]), intval($_POST["speed"]), $_SESSION["filename"]);
                unset($_SESSION["filename"]);
            } else {
                // Card already exists
                $validcard = 0;
            }
        } else {
            // No image uploaded
            $validcard = 2;
        }
    }
    if ($validcard === 1) {
        header("location: newCard.php");
    }
    print $twig->render("NewCard.twig", array("validation" => $validcard, "validimage" => $validimage));
} else {
    header("location: login.php");
}
