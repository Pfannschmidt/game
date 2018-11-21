<?php
require 'Creature.php';
require 'Monster.php';
require 'Orc.php';
require 'Player.php';
require 'GameState.php';


GameState::init();
$player = GameState::getPlayer();
$monster = GameState::getMonster();

system('clear');
echo "\nAn Angry Monster appears in front of You\n";
do {
    $player->decreaseCoolDowns();
    $monster->decreaseCoolDowns();
    $player->echoPossibleStates();

    $move = readline();
    system('clear');
    echo "\n";

    $player->prepareTurn($move);
    $monster->prepareTurn();

    $creatures = [$player, $monster];
    shuffle($creatures);

    array_walk($creatures, function ($creature) {
      $creature->execTurn();
    });

    echo "\n";
    echo "Your Health is " . $player->getHealth();
    echo "\n";
    echo "The Monster has " . $monster->getHealth() . " Health";
    echo "\n";

} while ($monster->isAlive() && $player->isAlive());

if ($player->isAlive()) {
    echo "You Are Victorious";
}
if ($monster->isAlive()) {
    echo "Git Gud";
}
