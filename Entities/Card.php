<?php

declare(strict_types=1);

namespace Entities;

class Card
{
    private int $id;
    private string $name;
    private int $hp;
    private int $hpP1;
    private int $hpP2;
    private int $power;
    private int $defense;
    private int $speed;
    private string $image;
    private int $stateP1;
    private int $stateP2;
    public function __construct(int $id, string $name, int $hp, int $hpP1, int $hpP2, int $power, int $defense, int $speed, string $image, int $stateP1, int $stateP2)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hp = $hp;
        $this->hpP1 = $hpP1;
        $this->hpP2 = $hpP2;
        $this->power = $power;
        $this->defense = $defense;
        $this->speed = $speed;
        $this->image = $image;
        $this->stateP1 = $stateP1;
        $this->stateP2 = $stateP2;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getHp(): int
    {
        return $this->hp;
    }
    public function getHpP1(): int
    {
        return $this->hpP1;
    }
    public function getHpP2(): int
    {
        return $this->hpP2;
    }
    public function getPower(): int
    {
        return $this->power;
    }
    public function getDefense(): int
    {
        return $this->defense;
    }
    public function getSpeed(): int
    {
        return $this->speed;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getStateP1(): int
    {
        return $this->stateP1;
    }
    public function getStateP2(): int
    {
        return $this->stateP2;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
    public function setHp(int $hp)
    {
        $this->name = $hp;
    }
    public function setPower(int $power)
    {
        $this->power = $power;
    }
    public function setDefense(int $defense)
    {
        $this->defense = $defense;
    }
    public function setSpeed(int $speed)
    {
        $this->speed = $speed;
    }
    public function setImage(string $image)
    {
        $this->image = $image;
    }
}
