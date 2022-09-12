<?php

declare(strict_types=1);
require_once("bootstrap.php");

use Business\UserService;

$userService = new UserService();
$validuser = "";
if (isset($_GET["action"]) && $_GET["action"] === "register") {
    $username = $userService->getUserByUsername($_POST["username"]);
    if ($username === null) {
        if (($_POST["password"]) !== ($_POST["passwordconfirm"])) {
            // Passwords do not match
            $validuser = 1;
        } else {
            // User created
            $validuser = 2;
            $userService->newUser(htmlspecialchars($_POST["username"]), htmlspecialchars($_POST["password"]));
        }
    } else {
        // Username already exists
        $validuser = 0;
    }
}
if ($validuser === 2) {
    header("location: login.php");
    exit(0);
}
print $twig->render("Register.twig", array("validation" => $validuser));
