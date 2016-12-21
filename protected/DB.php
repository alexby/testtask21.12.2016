<?php

/**
 * Database provider
 */
class DB
{
    /**
     * @var PDO
     */
    private static $instance;

    private function __construct()
    {}

    private function __clone()
    {}

    /**
     * @return PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDO(
                'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE'),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD')
            );
        }
        return self::$instance;
    }
}