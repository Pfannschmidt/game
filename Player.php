<?php
class Player extends Creature {

    public function takeDamage($damageInput)
    {
        parent::takeDamage($damageInput);
    }

    public function handleAttack()
    {
        $creature = GameState::getMonster();

        return parent::dealDamage($creature, random_int(0, 1));
    }

    public function handleEvade()
    {
        return;
    }
}
