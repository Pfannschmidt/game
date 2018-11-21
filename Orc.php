<?php
class Orc extends Creature {

  public function takeDamage($damageInput)
  {
      return parent::takeDamage($damageInput);
  }

  public function takeStun($duration)
  {
      if ($this->critChance * 2 >= random_int(1,100)) {
        return;
      }

          $this->stunDuration = $duration - 1;

          echo "The Orc got stunned\n";

    }

    protected function preTurnHook()
    {
      if ($this->stunDuration > 0) {
        $this->stunDuration--;
        echo "The Orc tumbles and is still Stunned from your incredible Blow\n";
        return false;
      }

      return parent::preTurnHook();
    }

    public function handleAttack()
    {
        echo "The Orc leaps at you, and tries to dismember your Head from your Body\n";
        $creature = GameState::getPlayer();

          $damage = $this->getDamage();

        return parent::dealDamage($creature, $damage);
    }

    public function getDamage()
    {
        $damage = $this->baseDamage;
        $critChance = $this->critChance;
        $critModifier = $this->critModifier;

        switch ($this->state) {
            case 'attack':
            break;
        }

        if (random_int(1,100) <= $critChance){
            echo "ORC CRITS ON YOU!\n";
            $damage = $damage * $critModifier;
        }

        return $damage;
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
        $state = '';

        $this->state = $state ?: 'attack';
    }

    public function decreaseCoolDowns()
    {
    }
}
