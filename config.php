<?php

class Config {
    private static $config = [
        'host' => 'localhost',
        'dbname' => 'dev_junior',
        'username' => 'root',
        'password' => ''
    ];

    public static function get($key) {
        if (array_key_exists($key, self::$config)) {
            return self::$config[$key];
        }
        return null; 
    }
}

