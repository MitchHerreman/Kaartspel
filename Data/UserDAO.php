<?php

declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\User;
use Exceptions\PasswordIncorrectException;

class UserDAO
{
    public function getUsers(): array
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select id, username, password from cardgameusers";
        $resultSet = $dbh->query($sql);
        $list = array();
        foreach ($resultSet as $row) {
            $user = new User((int) $row["id"], (string) $row["username"], (string) $row["password"]);
            array_push($list, $user);
        }
        $dbh = null;
        return $list;
    }

    public function getUserByUsername($username): ?User
    {
        $sql = "select id, username, password from cardgameusers where username = :username";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            $dbh = null;
            return null;
        } else {
            $user = new User((int) $row["id"], (string) $username, (string) $row["password"]);
            $dbh = null;
            return $user;
        }
    }

    public function newUser($username, $password)
    {
        if (!empty($username) && !empty($password)) {
            $sql = "insert into cardgameusers (username, password) values (:username, :password)";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(":username" => $username, ":password" => password_hash($password, PASSWORD_DEFAULT)));
            $dbh = null;
        }
    }
}
