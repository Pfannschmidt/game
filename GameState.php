<?php

class GameState {
    private static $player;
    private static $monster;

    public static function init() {
        self::$monster = new Monster(10);
        self::$player = new Player(5);
    }

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
