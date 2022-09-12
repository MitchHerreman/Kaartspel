<?php

declare(strict_types=1);

namespace Business;

use Data\CardDAO;
use Entities\Card;

// Card states:
// 0 = in deck
// 1 = in play
// 2 = defeated

class CardService
{
    static function cardToHtml($card, $player)
    {
        $id = $card->getId();
        if (isset($_GET["id"]) && $id == $_GET["id"] && $_GET["player"] === "$player") {
            print '<td class="selectedCard">';
        } else {
            print '<td class="card">';
        }
        switch ($player) {
            case '1':
                if (isset($_SESSION["turn"]) && $_SESSION["turn"] === 1) {
                    print '<a href="game.php?action=attack&id=' . $id . '&player=' . $player . '" class="tdLink">';
                } elseif (isset($_SESSION["turn"]) && $_SESSION["turn"] === 2) {
                    print '<a href="game.php?action=defend&id=' . $id . '&player=' . $player . '" class="tdLink">';
                } else {
                    print '<a href="#" class="tdLink">';
                };
                break;
            case '2':
                if (isset($_SESSION["turn"]) && $_SESSION["turn"] === 2) {
                    print '<a href="game.php?action=attack&id=' . $id . '&player=' . $player . '" class="tdLink">';
                } elseif (isset($_SESSION["turn"]) && $_SESSION["turn"] === 1) {
                    print '<a href="game.php?action=defend&id=' . $id . '&player=' . $player . '" class="tdLink">';
                } else {
                    print '<a href="#" class="tdLink">';
                };
                break;
            default:
                break;
        }
        print '<p class="textcard">' . $card->getName() . '</p>
        <img class="characterimg" src="images/' . $card->getImage() . '" alt="' . $card->getName() . '">
        <p class="textcard">HP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/';
        switch ($player) {
            case '1':
                print $card->getHpP1();
                break;
            case '2':
                print $card->getHpP2();
            default:
                break;
        }
        print '.png" alt="hp"><br>
        Power &nbsp;&nbsp;&nbsp;<img src="images/' . $card->getPower() . '.png" alt="power"><br>
        Defense <img src="images/' . $card->getDefense() . '.png" alt="defense"><br>
        Speed &nbsp;&nbsp;&nbsp;<img src="images/' . $card->getSpeed() . '.png" alt="speed"></p>
        </a>
        </td>';
    }
    static function randomCardsStart($player)
    {
        $cardDAO = new CardDAO();
        $randomCards = $cardDAO->getRandomCards($player);
        foreach ($randomCards as $cardrandom) {
            $cardId = $cardrandom->getId();
            $card = $cardDAO->getCardById($cardId);
            $cardDAO->updateStatePX($player, $card, 1);
            self::cardToHtml($card, $player);
        }
    }
    static function getNewCard($player)
    {
        $cardDAO = new CardDAO();
        $newCard = $cardDAO->getNewCards($player);
        $cardDAO->updateStatePX($player, $newCard, 1);
        self::cardToHtml($newCard, $player);
    }
    static function battle($cardAttack, $cardDefend)
    {
        $cardDAO = new CardDAO();
        global $orderAttack;
        global $coin;
        if ($cardAttack->getSpeed() > $cardDefend->getSpeed()) {
            if ($_SESSION["turn"] === 1) {
                self::attackerAttacksFirst($cardAttack, $cardDefend, 1, 2, $cardDAO);
                $_SESSION["turn"] = 2;
            } elseif ($_SESSION["turn"] === 2) {
                self::attackerAttacksFirst($cardAttack, $cardDefend, 2, 1, $cardDAO);
                $_SESSION["turn"] = 1;
            }
        } elseif ($cardAttack->getSpeed() < $cardDefend->getSpeed()) {
            if ($_SESSION["turn"] === 1) {
                self::defenderAttacksFirst($cardAttack, $cardDefend, 1, 2, $cardDAO);
                $_SESSION["turn"] = 2;
            } elseif ($_SESSION["turn"] === 2) {
                self::defenderAttacksFirst($cardAttack, $cardDefend, 2, 1, $cardDAO);
                $_SESSION["turn"] = 1;
            }
        } elseif ($cardAttack->getSpeed() === $cardDefend->getSpeed()) {
            $orderAttack = 1;
            if (isset($_GET["action"]) && $_GET["action"] === "flipSpeed") {
                $coin = rand(1, 2);
                if ($coin === 1) {
                    if ($_SESSION["turn"] === 1) {
                        self::attackerAttacksFirst($cardAttack, $cardDefend, 1, 2, $cardDAO);
                        $_SESSION["turn"] = 2;
                    } elseif ($_SESSION["turn"] === 2) {
                        self::defenderAttacksFirst($cardAttack, $cardDefend, 2, 1, $cardDAO);
                        $_SESSION["turn"] = 1;
                    }
                } elseif ($coin === 2) {
                    if ($_SESSION["turn"] === 1) {
                        self::defenderAttacksFirst($cardAttack, $cardDefend, 1, 2, $cardDAO);
                        $_SESSION["turn"] = 2;
                    } elseif ($_SESSION["turn"] === 2) {
                        self::attackerAttacksFirst($cardAttack, $cardDefend, 2, 1, $cardDAO);
                        $_SESSION["turn"] = 1;
                    }
                }
                $orderAttack = 0;
            }
        }
    }

    static function attackerAttacksFirst($cardAttack, $cardDefend, $playerAttack, $playerDefend)
    {
        $cardDAO = new CardDAO();
        switch ($playerDefend) {
            case '1':
                $newHpDefend = ($cardDefend->getHpP1()) - (($cardAttack->getPower()) - ($cardDefend->getDefense()));
                break;
            case '2':
                $newHpDefend = ($cardDefend->getHpP2()) - (($cardAttack->getPower()) - ($cardDefend->getDefense()));
            default:
                break;
        }
        $cardDAO->updateHpPX($playerDefend, $cardDefend->getId(), $newHpDefend);
        if ($newHpDefend <= 0) {
            $cardDAO->updateStatePX($playerDefend, $cardDefend, 2);
        } else {
            switch ($playerAttack) {
                case '1':
                    $newHpAttack = ($cardAttack->getHpP1()) - (($cardDefend->getPower()) - ($cardAttack->getDefense()));
                    break;
                case '2':
                    $newHpAttack = ($cardAttack->getHpP2()) - (($cardDefend->getPower()) - ($cardAttack->getDefense()));
                default:
                    break;
            }
            $cardDAO->updateHpPX($playerAttack, $cardAttack->getId(), $newHpAttack);
            if ($newHpAttack <= 0) {
                $cardDAO->updateStatePX($playerAttack, $cardAttack, 2);
            }
        }
        unset($_SESSION["attackId"]);
        unset($_SESSION["defendId"]);
    }

    static function defenderAttacksFirst($cardAttack, $cardDefend, $playerAttack, $playerDefend)
    {
        $cardDAO = new CardDAO();
        switch ($playerAttack) {
            case '1':
                $newHpAttack = ($cardAttack->getHpP1()) - (($cardDefend->getPower()) - ($cardAttack->getDefense()));
                break;
            case '2':
                $newHpAttack = ($cardAttack->getHpP2()) - (($cardDefend->getPower()) - ($cardAttack->getDefense()));
            default:
                break;
        }
        $cardDAO->updateHpPX($playerAttack, $cardAttack->getId(), $newHpAttack);
        if ($newHpAttack <= 0) {
            $cardDAO->updateStatePX($playerAttack, $cardAttack, 2);
        } else {
            switch ($playerDefend) {
                case '1':
                    $newHpDefend = ($cardDefend->getHpP1()) - (($cardAttack->getPower()) - ($cardDefend->getDefense()));
                    break;
                case '2':
                    $newHpDefend = ($cardDefend->getHpP2()) - (($cardAttack->getPower()) - ($cardDefend->getDefense()));
                default:
                    break;
            }
            $cardDAO->updateHpPX($playerDefend, $cardDefend->getId(), $newHpDefend);
            if ($newHpDefend <= 0) {
                $cardDAO->updateStatePX($playerDefend, $cardDefend, 2);
            }
        }
        unset($_SESSION["attackId"]);
        unset($_SESSION["defendId"]);
    }
    public function resetGame()
    {
        $cardDAO = new CardDAO();
        $cardDAO->resetGame();
    }
    public function getCardById(int $id)
    {
        $cardDAO = new CardDAO();
        $card = $cardDAO->getCardById($id);
        return $card;
    }
    public function getCardByName(string $name)
    {
        $cardDAO = new CardDAO();
        $card = $cardDAO->getCardByName($name);
        return $card;
    }
    public function getCardsByStateX(int $player, int $state)
    {
        $cardDAO = new CardDAO();
        $cards = $cardDAO->getCardsByStateX($player, $state);
        return $cards;
    }
    static function buildPlayingCards(int $player)
    {
        $cardDAO = new CardDAO();
        $tab = $cardDAO->getCards();
        switch ($player) {
            case '1':
                $countStartP1 = 0;
                foreach ($tab as $card) {
                    $state = $card->getStateP1();
                    if ($state !== 0) {
                        $countStartP1++;
                    }
                }
                if ($countStartP1 === 0) {
                    self::randomCardsStart(1, $cardDAO);
                } else {
                    $cardP1 = $cardDAO->getCardsByStateX(1, 1);
                    foreach ($cardP1 as $validcard) {
                        self::cardToHtml($validcard, 1);
                    }
                    if (count($cardDAO->getCardsByStateX(1, 1)) < 4 && (count($cardDAO->getCardsByStateX(1, 0)) > 0)) {
                        self::getNewCard(1);
                    }
                }
                break;
            case '2':
                $countStartP2 = 0;
                foreach ($tab as $card) {
                    $state = $card->getStateP2();
                    if ($state !== 0) {
                        $countStartP2++;
                    }
                }
                if ($countStartP2 === 0) {
                    self::randomCardsStart(2, $cardDAO);
                } else {
                    $cardP2 = $cardDAO->getCardsByStateX(2, 1);
                    foreach ($cardP2 as $validcard) {
                        self::cardToHtml($validcard, 2);
                    }
                    if (count($cardDAO->getCardsByStateX(2, 1)) < 4 && (count($cardDAO->getCardsByStateX(2, 0)) > 0)) {
                        self::getNewCard(2);
                    }
                }
                break;
            default:
                break;
        }
    }
    static function countCardsInDeck($player)
    {
        $cardDAO = new CardDAO;
        $countCards = count($cardDAO->getCardsByStateX($player, 0));
        return $countCards;
    }
    public function newCard(string $name, int $hp, int $power, int $defense, int $speed, string $image)
    {
        $cardDAO = new CardDAO();
        $cardDAO->newCard($name, $hp, $power, $defense, $speed, $image);
    }
}
