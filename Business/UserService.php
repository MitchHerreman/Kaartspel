<?php

declare(strict_types=1);

namespace Business;

use Data\UserDAO;

class UserService
{
    public function getUserByUsername(string $username) {
        $userDAO = new UserDAO();
        $user = $userDAO->getUserByUsername($username);
        return $user;
    }
    public function newUser(string $username, string $password)
    {
        $userDAO = new UserDAO();
        $userDAO->newUser($username, $password);
    }
}
