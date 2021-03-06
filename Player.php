<?php
class Player extends Creature {



    public function takeDamage($damageInput)
    {

      if (random_int(1,100) <= $this->chanceEvade){
        echo "Player has evaded!\n";
        return parent::takeDamage(0);
      }

      if ($this->state == 'evade' && random_int(1,100) <= $this->chanceEvade * 2) {
        return parent::takeDamage(0);
        }

      if ($this->state == 'parry'){
        return parent::takeDamage(0);
      }

        parent::takeDamage($damageInput);
    }

    public function handleAttack()
    {
        echo "You swing your Sword in the general Direction of the Monster\n";
        $creature = GameState::getMonster();

        $additionalDamage = $this->getDamage();

        return parent::dealDamage($creature, $additionalDamage);
    }

    public function handleCharge()
    {
        echo "You gather all the Strength left in You to Charge at the Monster\n";
        $creature = GameState::getMonster();

        if ($this->chargeCoolDown > 0) {
          echo "You are way to exausted from all the charging and fail miserably\n";
          return parent::dealDamage($creature, 0);
        }

        $this->chargeCoolDown = 3;

        $damage = $this->getDamage();

        return parent::dealDamage($creature, $damage);
    }

    public function handleEvade()
    {
        echo "You duck and try to evade the Monster\n";
        return;
    }

    public function handleParry()
    {
      $monster = GameState::getMonster();

      if ($this->parryCoolDown >0) {
          return parent::dealDamage($monster, 0);
      }

      if ($monster->canBeParried()) {
        $this->parryCoolDown = 3;
        echo "I have parried your attack\n";
        return parent::dealDamage($monster, $this->getDamage());
      }

      $this->parryCoolDown = 5;

      return parent::dealDamage($monster, 0);
    }

    public function handleStun()
    {
      $monster = GameState::getMonster();

      if ($this->stunCoolDown > 0){
        return;
      }

      $this->stunCoolDown = 3;
      return parent::dealStun($monster, 2);
    }


    public function getDamage()
    {
        $damage = $this->baseDamage;
        $critChance = $this->critChance;
        $critModifier = $this->critModifier;

        switch ($this->state) {
            case 'attack':
            break;
            case 'charge':
                $damage = $damage * 2 + random_int(0, 1);
            break;
            case 'parry':
                $damage = $damage * 2;
                $critChance = $critChance * 2;
            break;
        }

        if (random_int(1,100) <= $critChance){
            echo "OMEGALOL!\n";
            $damage = $damage * $critModifier;
        }

        return $damage;
    }


    public function prepareTurn($move)
    {
        switch ($move) {
            case '1':
                $this->changeState('attack');
                break;
            case '2':
                $this->changeState('evade');
                break;
            case '3':
                if ($this->parryCoolDown > 0) {
                  $this->changeState('wait');
                  break;
                }

                $this->changeState('parry');
                break;
            case '4':
                $this->changeState('charge');
                break;
            case '5':
                $this->changeState('stun');
                break;
            default:
                $this->changeState('wait');
        }
    }

    public function echoPossibleStates()
    {
        $possibleStates = "\n 1 :attack \n 2 :evade\n";

        if ($this->parryCoolDown <= 0) {
            $possibleStates = $possibleStates . " 3 :parry\n";
        }

        if ($this->chargeCoolDown <= 0) {
            $possibleStates = $possibleStates . " 4 :charge\n";
        }

        if ($this->stunCoolDown <= 0) {
            $possibleStates = $possibleStates . " 5 :stun\n";

        }



        echo $possibleStates;
    }

    public function decreaseCoolDowns()
    {
      if ($this->chargeCoolDown > 0) {
        $this->chargeCoolDown--;
      }
      if ($this->parryCoolDown > 0) {
        $this->parryCoolDown--;
      }
      if ($this->stunCoolDown > 0)  {
        $this->stunCoolDown--;
      }

    }

    public function canBeParried()
    {
      if ($this->state == 'attack'){
        return true;
      }

      if ($this->state == 'stun'){
        return true;
      }

      return false;
    }
}
