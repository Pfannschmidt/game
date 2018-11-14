<?php
class Monster extends Creature {


  public function takeDamage($damageInput)
  {
      if (random_int(1,100) <= $this->chanceEvade){
        echo "Monster has evaded!\n";
        return parent::takeDamage(0);
      }

      if ($this->state == 'evade' && random_int(1,100) <= $this->chanceEvade * 2) {
        return parent::takeDamage(0);
      }

      return parent::takeDamage($damageInput);
  }

    public function handleAttack()
    {
        echo "The Monster leaps at you, and tries to dismember your Head from your Body\n";
        $creature = GameState::getPlayer();

          $damage = $this->baseDamage;

          if (random_int(1,100) <= $this->critChanceMonster){
            echo "Monster crits\n";
            $damage = $damage * $this->critModifierMonster;
          }

        return parent::dealDamage($creature, $damage);
    }

    public function handleEvade()
    {
        echo "The Monster jumps back out of your reach\n";
        return;
    }

    public function canBeParried()
    {
      if ($this->state == 'attack'){
        return true;
      }

      return false;
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
