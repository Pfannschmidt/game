<?php
class Player extends Creature {

    public function takeDamage($damageInput)
    {
        if ($this->state == 'evade') {
          return;
        }

        parent::takeDamage($damageInput);
    }

    public function handleAttack()
    {
        $creature = GameState::getMonster();

        return parent::dealDamage($creature, random_int(0, 1));
    }

    public function handleEvade()
    {
        echo "You duck and try to evade the Monster\n";
        return;
    }
}
