<?php
class Player extends Creature {

    protected $chargeCoolDown = 0;

    public function takeDamage($damageInput)
    {
        if ($this->state == 'evade') {
          return;
        }

        parent::takeDamage($damageInput);
    }

    public function handleAttack()
    {
        echo "You swing your Sword in the general Direction of the Monster\n";
        $creature = GameState::getMonster();

        $additionalDamage = $this->getAdditionalDamage($this->state);

        return parent::dealDamage($creature, $additionalDamage);
    }

    public function handleCharge()
    {
        echo "You gather all the Strength left in You to Charge at the Monster\n";
        $creature = GameState::getMonster();

        $this->chargeCoolDown = 3;

        $additionalDamage = $this->getAdditionalDamage($this->state);

        return parent::dealDamage($creature, $additionalDamage);
    }

    public function handleEvade()
    {
        echo "You duck and try to evade the Monster\n";
        return;
    }

    protected function getAdditionalDamage($state)
    {
        switch ($state) {
            case 'attack':
                return random_int(0, 1);
            break;
            case 'charge':
                return $this->baseDamage * 2 + random_int(0, 1);
            break;
        }
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
                $this->changeState('charge');
                break;
            default:
                $this->changeState('wait');
        }
    }

    public function echoPossibleStates()
    {
        $possibleStates = "\n 1 :attack \n 2 :evade\n";

        if ($this->chargeCoolDown <= 0) {
            $possibleStates = $possibleStates . " 3 :charge\n";
        }

        echo $possibleStates;
    }

    public function decreaseCoolDowns()
    {
        $this->chargeCoolDown <= 0 ?: $this->chargeCoolDown--;
    }
}
