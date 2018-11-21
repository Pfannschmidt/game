<?php

class GameState {
    private static $player;
    private static $monster;
    private static $level;

    public static function init() {
        self::$level = 0;
        self::$monster = new Orc(10, 2, 20, 2);
        self::$player = new Player(5);
    }

    public static function nextRound() {
        self::$level++;
        $monsterChooser = random_int(0,1);
        switch ($monsterChooser) {
          case 0:
            self::$monster = new Orc(10, 2, 20, 2);
            break;

          case 1:
              self::$monster = new Monster(10);
              break;

          default:
              self::$monster = new Monster(10);
            break;
        }
        self::$player = new Player(self::$level);
    }

    private function __construct(){}

    /**
     * @return mixed
     */
    public static function getPlayer()
    {
        return self::$player;
    }

    /**
     * @return mixed
     */
    public static function getMonster()
    {
        return self::$monster;
    }
}
