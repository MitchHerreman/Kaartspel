<?php

declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Card;

// Card states:
// 0 = in deck
// 1 = in play
// 2 = defeated

class CardDAO
{
    public function getCards(): array
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame";
        $resultSet = $dbh->query($sql);
        $list = array();
        foreach ($resultSet as $row) {
            $card = new Card((int) $row["id"], (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], $row["stateP2"]);
            array_push($list, $card);
        }
        $dbh = null;
        return $list;
    }

    public function getCardById(int $id): Card
    {
        $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $card = new Card((int) $id, (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], (int) $row["stateP2"]);
        $dbh = null;
        return $card;
    }
    public function getCardByName(string $name): ?Card
    {
        $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where name = :name";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(":name" => $name));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            $dbh = null;
            return null;
        } else {
            $card = new Card((int)$row["id"], (string) $name, (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], (int) $row["stateP2"]);
            $dbh = null;
            return $card;
        }
    }

    public function getCardsByStateX(int $player, int $state): array
    {
        switch ($player) {
            case '1':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP1 = :state";
                break;
            case '2':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP2 = :state";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(":state" => $state));
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = array();
        foreach ($resultSet as $row) {
            switch ($player) {
                case '1':
                    $card = new Card((int) $row["id"], (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $state, (int) $row["stateP2"]);
                    break;
                case '2':
                    $card = new Card((int) $row["id"], (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], (int) $state);
                    break;
                default:
                    break;
            }
            array_push($list, $card);
        }
        $dbh = null;
        return $list;
    }

    public function updateStatePX($player, $card, $state)
    {
        switch ($player) {
            case '1':
                $sql = "update cardgame set stateP1 = :stateP1 where id = :id";
                break;
            case '2':
                $sql = "update cardgame set stateP2 = :stateP2 where id = :id";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        switch ($player) {
            case '1':
                $resultSet = $stmt->execute(array(":stateP1" => $state, ":id" => $card->getId()));
                break;
            case '2':
                $resultSet = $stmt->execute(array(":stateP2" => $state, ":id" => $card->getId()));
                break;
            default:
                break;
        }
        $dbh = null;
    }

    public function setStartHpPX($player, $id)
    {
        switch ($player) {
            case '1':
                $sql = "update cardgame set hpP1 = hp where id = :id";
                break;
            case '2':
                $sql = "update cardgame set hpP2 = hp where id = :id";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $resultSet = $stmt->execute(array(":id" => $id));
        $dbh = null;
    }

    public function resetGame()
    {
        $sql = "update cardgame set stateP1 = 0, stateP2 = 0, hpP1 = hp, hpP2 = hp";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $dbh->query($sql);
        $dbh = null;
    }

    public function updateHpPX($player, $id, $hp)
    {
        switch ($player) {
            case '1':
                $sql = "update cardgame set hpP1 = :hpP1 where id = :id";
                break;
            case '2':
                $sql = "update cardgame set hpP2 = :hpP2 where id = :id";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        switch ($player) {
            case '1':
                $stmt->execute(array(":hpP1" => $hp, ":id" => $id));
                break;
            case '2':
                $stmt->execute(array(":hpP2" => $hp, ":id" => $id));
                break;
            default:
                break;
        }
        $dbh = null;
    }

    public function getNewCards($player): Card
    {
        switch ($player) {
            case '1':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP1 = 0 order by rand() limit 1";
                break;
            case '2':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP2 = 0 order by rand() limit 1";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array());
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $card = new Card((int) $row["id"], (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], (int) $row["stateP2"]);
        $dbh = null;
        return $card;
    }
    public function getRandomCards($player): array
    {
        switch ($player) {
            case '1':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP1 = 0 order by rand() limit 4";
                break;
            case '2':
                $sql = "select id, name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2 from cardgame where stateP2 = 0 order by rand() limit 4";
                break;
            default:
                break;
        }
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $resultSet = $dbh->query($sql);
        $list = array();
        foreach ($resultSet as $row) {
            $card = new Card((int) $row["id"], (string) $row["name"], (int) $row["hp"], (int) $row["hpP1"], (int) $row["hpP2"], (int) $row["power"], (int) $row["defense"], (int) $row["speed"], (string) $row["image"], (int) $row["stateP1"], $row["stateP2"]);
            array_push($list, $card);
        }
        $dbh = null;
        return $list;
    }
    public function newCard($name, $hp, $power, $defense, $speed, $image)
    {
        if (!empty($name) && !empty($hp) && !empty($power) && !empty($defense) && !empty($speed) && !empty($image)) {
            $sql = "insert into cardgame (name, hp, hpP1, hpP2, power, defense, speed, image, stateP1, stateP2) 
            values (:name, :hp, :hp, :hp, :power, :defense, :speed, :image, 0, 0)";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(":name" => $name, ":hp" => $hp, ":power" => $power, ":defense" => $defense, ":speed" => $speed, ":image" => $image));
            $dbh = null;
        }
    }
}
