<?php
class Monster extends Creature {

    public function handleAttack()
    {
        $creature = GameState::getPlayer();

        return parent::dealDamage($creature);
    }

    public function handleEvade()
    {
        return;
    }

    public function prepareTurn()
    {
        switch ($this->state) {
            case 'attack':
                $this->state = 'evade';
                break;
            case 'evade':
                $this->state = 'attack';
                break;
            default:
                $this->state = 'attack';
        }
    }
}
