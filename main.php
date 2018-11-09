<?php
require 'Creature.php';
require 'Monster.php';
require 'Player.php';
require 'GameState.php';


GameState::init();
$player = GameState::getPlayer();
$monster = GameState::getMonster();

system('clear');
do {
    echo "1 :attack \n2 :evade \n";

    $move = readline();
    system('clear');
    echo "\n";

    $player->prepareTurn($move);
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
