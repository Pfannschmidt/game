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

      if ($this->state == 'parry' && $this->parryCoolDown <= 0){
        return parent::takeDamage(0);
      }

      return parent::takeDamage($damageInput);
  }

    public function takeStun($duration)
    {
          if ($this->state == 'parry') {
            return;
          }

          $this->stunDuration = $duration;

          echo "the monster got stunned\n";

    }

    protected function preTurnHook()
    {
      if ($this->stunDuration > 0) {
        echo "The Monster tumbles and is still Stunned from your incredible Blow\n";
        return false;
      }

      return parent::preTurnHook();
    }

    public function handleAttack()
    {
        echo "The Monster leaps at you, and tries to dismember your Head from your Body\n";
        $creature = GameState::getPlayer();

          $damage = $this->getDamage();

        return parent::dealDamage($creature, $damage);
    }

    public function handleEvade()
    {
        echo "The Monster jumps back out of your reach\n";
        return;
    }

    public function handleParry()
    {
      $player = GameState::getPlayer();

      if ($this->parryCoolDown >0) {
          return parent::dealDamage($player, 0);
      }

      if ($player->canBeParried()) {
        $this->parryCoolDown = 3;
        echo "I have parried your attack\n";
        return parent::dealDamage($player, $this->getDamage());
      }

      $this->parryCoolDown = 5;

      return parent::dealDamage($player, 0);
    }

    public function getDamage()
    {
        $damage = $this->baseDamage;
        $critChance = $this->critChance;
        $critModifier = $this->critModifier;

        switch ($this->state) {
            case 'attack':
            break;
            case 'parry':
                $critChance = $critChance * 2;
            break;
        }

        if (random_int(1,100) <= $critChance){
            echo "MONSTER CRITS ON YOU!\n";
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

        if ($this->parryCoolDown <= 0) {
          $state = 'parry';
        }

        if ($this->parryCoolDown == 5) {
          $state = 'evade';
        }

        if (!$state && $this->health < 4 && random_int(1,3) == 1) {
          $state = 'evade';
        }

        $this->state = $state ?: 'attack';
    }

    public function decreaseCoolDowns()
    {
      if ($this->stunDuration > 0) {
        $this->stunDuration--;
      }
    }
}
