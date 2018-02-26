<?php
/**
 * Created by PhpStorm.
 * User: Yanick Lafontaine
 * Date: 2018-02-25
 * Time: 20:34
 */

namespace WoWCMS\Helpers;

use PDO;
use Exception;

class Database
{
    public static function get()
    {
        /**
         * Credentials
         */
        $host = getenv('HOST');
        $username = getenv("USER");
        $password = getenv("PASS");
        $bdd = getenv("BDD");
        $dsn = 'mysql:host=' . $host . ';dbname=' . $bdd;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        /**
         * Connexion
         */
        return new PDO($dsn, $username, $password, $options);
    }

    /**
     * Simple way to do transaction
     *
     * @param array $statements - Statements
     *
     * @throws Exception
     */
    public static function transaction(Array $statements)
    {
        $db = self::get();
        try {
            $db->beginTransaction();
            foreach ($statements as $statement) {
                $db->exec($statement);
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}