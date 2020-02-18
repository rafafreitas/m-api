<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2019
 * Time: 12:00
 */

namespace App\Connection;

class Credentials
{
    protected static $host;
    protected static $dbName;
    protected static $user;
    protected static $password;
    protected static $driver;
    protected static $charset;

    /**
     * Credentials constructor.
     */
    public function __construct()
    {
        define("ENVIRONMENT_DEV_DB", false);

        if(ENVIRONMENT_DEV_DB){
            //Dev
            self::$host = 'localhost:3307';
            self::$dbName = 'm_app';
            self::$user = 'root';
            self::$password = 'usbw';
            self::$driver = 'pdo_mysql';
            self::$charset = 'utf8';
        }else{
            //Prod
//            self::$host = 'localhost';
             self::$host = 'sql50.main-hosting.eu';
            self::$dbName = 'u900272964_mapi';
            self::$user = 'u900272964_mapi';
            self::$password = 'hO#ˆ&YO&()7rC1';
            self::$driver = 'pdo_mysql';
            self::$charset = 'utf8';
        }

    }

    /**
     * @return string
     */
    public static function getHost()
    {
        if (!self::$host)
        {
            new Credentials();
        }
        return self::$host;
    }

    /**
     * @return string
     */
    public static function getDbname()
    {
        if (!self::$dbName)
        {
            new Credentials();
        }
        return self::$dbName;
    }

    /**
     * @return string
     */
    public static function getUser()
    {
        if (!self::$user)
        {
            new Credentials();
        }
        return self::$user;
    }

    /**
     * @return string
     */
    public static function getPassword()
    {
        if (!self::$password)
        {
            new Credentials();
        }
        return self::$password;
    }

    /**
     * @return string
     */
    public static function getDriver()
    {
        if (!self::$driver)
        {
            new Credentials();
        }
        return self::$driver;
    }

    /**
     * @return string
     */
    public static function getCharset()
    {
        if (!self::$charset)
        {
            new Credentials();
        }
        return self::$charset;
    }

}