<?php
require 'Creature.php';
require 'Monster.php';
require 'Player.php';
require 'GameState.php';


GameState::init();
$player = GameState::getPlayer();
$monster = GameState::getMonster();

do {
    echo "1 :attack \n2 :evade \n";

    $move = readline();
    echo "\n";

    switch ($move) {
        case '1':
            $player->changeState('attack');
            break;
        case '2':
            $player->changeState('evade');
            break;
    }

    $monster->prepareTurn();

    $player->execTurn();
    $monster->execTurn();

    echo "\n";
    echo "Your Health is " . $player->getHealth();
    echo "\n";
    echo "The Monster has " . $monster->getHealth() . " Health";
    echo "\n";
    echo "\n";
} while ($monster->isAlive() && $player->isAlive());

if ($player->isAlive()) {
    echo "You Are Victorious";
}
if ($monster->isAlive()) {
    echo "Git Gud";
}
