<?php
class Player extends Creature {

    protected $chargeCoolDown = 0;
    protected $critModifier = 2;
    protected $critChance = 10;
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

    public function getDamage()
    {
        $damage = $this->baseDamage;

        switch ($this->state) {
            case 'attack':
            break;
            case 'charge':
                $damage = $damage * 2 + random_int(0, 1);
            break;
        }

        if (random_int(1,100) <= $critChance){
            $damage = $damage * $this->critModifier;
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
