<?php

abstract class Creature
{
    protected $health;
    protected $baseDamage;
    protected $state = 'wait';
    protected $critModifier;
    protected $critChance;
    protected $chanceEvade;

    public function __construct($health, $baseDamage = 1, $critChance = 10, $critModifier = 2, $chanceEvade = 10)
    {
        $this->baseDamage = $baseDamage;
        $this->health = $health;
        $this->critChance = $critChance;
        $this->critModifier = $critModifier;
        $this->chanceEvade = $chanceEvade;


    }

    public function changeState($state)
    {
        $this->state = $state;
    }

    public abstract function prepareTurn($move);

    public function execTurn()
    {
        $method = 'handle' . ucfirst($this->state);

        return $this->$method();
    }

    public function handleWait()
    {
        echo get_called_class() . " is Waiting...\n";
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function takeDamage($damageInput)
    {
        echo get_called_class() . ' has taken ' . $damageInput . " Damage\n";

        $this->health = $this->health - $damageInput;
    }

    protected function dealDamage(Creature $creature, $damage = 0)
    {
        return $creature->takeDamage($damage);
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    abstract public function canBeParried();
}
