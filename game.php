<?php

declare(strict_types=1);
require_once("bootstrap.php");

use Business\CardService;

// Card states:
// 0 = in deck
// 1 = in play
// 2 = defeated

session_start();
$cardSvc = new CardService();
$coin = 1;
$orderAttack = 0;
if (!isset($_SESSION["usernameP1"]) || !isset($_SESSION["usernameP2"])) {
    header("location: login.php");
    exit(0);
}
if (!isset($_SESSION["start"])) {
    $start = 0;
} else {
    $start = $_SESSION["start"];
}
if (!isset($_SESSION["turn"])) {
    $turn = 0;
} elseif ($_SESSION["turn"] === 1) {
    $turn = 1;
} elseif ($_SESSION["turn"] === 2) {
    $turn = 2;
}
if (isset($_GET["reset"]) && $_GET["reset"] === "1") {
    $cardSvc->resetGame();
    $start = 0;
    unset($_SESSION["start"], $_SESSION["turn"], $_SESSION["attackId"], $_SESSION["defendId"]);
}
if (isset($_GET["action"]) && $_GET["action"] === "flip") {
    $coin = rand(1, 2);
}
if (isset($_GET["action"]) && $_GET["action"] === "flipStart") {
    $coin = rand(1, 2);
    $_SESSION["start"] = $coin;
    $_SESSION["turn"] = $coin;
    $turn = $coin;
    $start = $coin;
}
if (isset($_GET["action"]) && $_GET["action"] === "attack") {
    $_SESSION["attackId"] = intval($_GET["id"]);
}
if (isset($_GET["action"]) && $_GET["action"] === "defend") {
    $_SESSION["defendId"] = intval($_GET["id"]);
}
if (isset($_SESSION["attackId"]) && isset($_SESSION["defendId"])) {
    $cardAttack = $cardSvc->getCardById($_SESSION["attackId"]);
    $cardDefend = $cardSvc->getCardById($_SESSION["defendId"]);
    $cardSvc->battle($cardAttack, $cardDefend);
}
if (count($cardSvc->getCardsByStateX(1, 1)) === 0 && count($cardSvc->getCardsByStateX(1, 0)) === 0) {
    $_SESSION["winner"] = $_SESSION["usernameP2"];
    header("location: winner.php");
    exit(0);
} elseif (count($cardSvc->getCardsByStateX(2, 1)) === 0 && count($cardSvc->getCardsByStateX(2, 0)) === 0) {
    $_SESSION["winner"] = $_SESSION["usernameP1"];
    header("location: winner.php");
    exit(0);
}
// Test winner with 1 card defeated
// if (count($cardSvc->getCardsByStateX(1, 2)) === 1) {
//     $_SESSION["winner"] = $_SESSION["usernameP2"];
//     header("location: winner.php");
//     exit(0);
// } elseif (count($cardSvc->getCardsByStateX(2, 2)) === 1) {
//     $_SESSION["winner"] = $_SESSION["usernameP1"];
//     header("location: winner.php");
//     exit(0);
// }
include("Presentation/Game.php");
// print $twig->render("Game.twig", array("player1Username" => $_SESSION["usernameP1"], "player2Username" => $_SESSION["usernameP2"], "coin" => $coin, "start" => $start, "orderAttack" => $orderAttack, 
// "turn" => $turn, "playingCardsP1" => $cardSvc->buildPlayingCards(1), "playingCardsP2" => $cardSvc->buildPlayingCards(2), "countCardsInDeckP1" => $cardSvc->countCardsInDeck(1), "countCardsInDeckP2" => $cardSvc->countCardsInDeck(2)));
