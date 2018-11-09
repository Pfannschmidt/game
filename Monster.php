<?php
class Monster extends Creature {

  public function takeDamage($damageInput)
  {
      if ($this->state == 'evade') {
        parent::takeDamage($damageInput / 2);
      }

      parent::takeDamage($damageInput);
  }

    public function handleAttack()
    {
        echo "The Monster leaps at you, and tries to dismember your Head from your Body\n";
        $creature = GameState::getPlayer();

        return parent::dealDamage($creature);
    }

    public function handleEvade()
    {
        echo "The Monster jumps back out of your reach\n";
        return;
    }

    public function prepareTurn($move = null)
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
