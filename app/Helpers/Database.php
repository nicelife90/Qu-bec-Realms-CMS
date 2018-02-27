<?php
/**
 * Created by PhpStorm.
 * User: Yanick Lafontaine
 * Date: 2018-02-26
 * Time: 20:13
 */

namespace WoWCMS\Helpers;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use Exception;
use PDO;

class Database
{
    /**
     * @var array - PDO Instances
     */
    protected static $instances = [];
    /**
     * Early initialization of this class
     * Required to register a PDO collector on all
     * database connection for the debug bar.
     */
    public static function init()
    {
        $instance_intranet = self::get();
        $instance_Ogasys = self::getOgasys();
        $instance_Magento = self::getMagento();
        $instance_Phoenix = self::getPhoenix();
        $pdoCollector = new PDOCollector();
        $pdoCollector->addConnection($instance_intranet, 'Intranet');
        $pdoCollector->addConnection($instance_Ogasys, 'Ogasys');
        $pdoCollector->addConnection($instance_Magento, 'Magento');
        $pdoCollector->addConnection($instance_Phoenix, 'Phoenix');
        Debugbar::registerPDOCollector($pdoCollector);
    }
    /**
     * Get main database connection
     *
     * @return TraceablePDO|mixed
     */
    public static function get()
    {
        /**
         * Credentials
         */
        $host = getenv('BDD_HOST');
        $username = getenv("BDD_USER");
        $password = getenv("BDD_PASS");
        $bdd = getenv("BDD_NAME");
        $dsn = 'mysql:host=' . $host . ';dbname=' . $bdd;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        /**
         * Database ID
         */
        $id = "$dsn.$username.$username.$password";
        /**
         * Check if database instance exist
         */
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        /**
         * Build or Get instance
         */
        $instance = new TraceablePDO(new PDO($dsn, $username, $password, $options));
        self::$instances[$id] = $instance;
        return $instance;
    }
    /**
     * Get Ogasys database connection
     *
     * @return TraceablePDO|mixed
     */
    public static function getOgasys()
    {
        /**
         * Credentials
         */
        $host = getenv('BDD_OGASYS_HOST');
        $username = getenv("BDD_OGASYS_USER");
        $password = getenv("BDD_OGASYS_PASS");
        $bdd = getenv("BDD_OGASYS_NAME");
        $dsn = "sqlsrv:Server=" . $host . ";Database=" . $bdd;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        /**
         * Database ID
         */
        $id = "$dsn.$username.$username.$password";
        /**
         * Check if database instance exist
         */
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        /**
         * Build or Get instance
         */
        $instance = new TraceablePDO(new PDO($dsn, $username, $password, $options));
        self::$instances[$id] = $instance;
        return $instance;
    }
    /**
     * Get Phoenix database connection
     *
     * @return TraceablePDO|mixed
     */
    public static function getPhoenix()
    {
        /**
         * Credentials
         */
        $host = getenv('BDD_PHOENIX_HOST');
        $username = getenv("BDD_PHOENIX_USER");
        $password = getenv("BDD_PHOENIX_PASS");
        $bdd = getenv("BDD_PHOENIX_NAME");
        $dsn = 'mysql:host=' . $host . ';dbname=' . $bdd;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        /**
         * Database ID
         */
        $id = "$dsn.$username.$username.$password";
        /**
         * Check if database instance exist
         */
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        /**
         * Build or Get instance
         */
        $instance = new TraceablePDO(new PDO($dsn, $username, $password, $options));
        self::$instances[$id] = $instance;
        return $instance;
    }
    /**
     * Get Magento database connection
     *
     * @return TraceablePDO|mixed
     */
    public static function getMagento()
    {
        /**
         * Credentials
         */
        $host = getenv('BDD_MAGENTO_HOST');
        $username = getenv("BDD_MAGENTO_USER");
        $password = getenv("BDD_MAGENTO_PASS");
        $bdd = getenv("BDD_MAGENTO_NAME");
        $dsn = 'mysql:host=' . $host . ';dbname=' . $bdd;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        /**
         * Database ID
         */
        $id = "$dsn.$username.$username.$password";
        /**
         * Check if database instance exist
         */
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        /**
         * Build or Get instance
         */
        $instance = new TraceablePDO(new PDO($dsn, $username, $password, $options));
        self::$instances[$id] = $instance;
        return $instance;
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
    /**
     * Get next auto increment ID of a table.
     *
     * @param $table_name
     */
    public static function getNextAutoIncrementId($table_name)
    {
        $db = self::get();
        $id = $db->query("SHOW TABLE STATUS LIKE '$table_name'")->fetchObject()->Auto_increment;
        return $id;
    }
    /**
     * Validate if field is unique
     *
     * @param       $table      - Table name
     * @param       $field      - Field name
     * @param       $value      - Value
     * @param array $exclude_id - Row Id to exclude
     *
     * @return bool
     */
    public static function fieldIsUnique($table, $field, $value, $exclude_id = [])
    {
        $db = self::get();
        //TODO: Make sure that the single quote work for numeric value.
        if (count($exclude_id) > 0) {
            $condition = implode(" AND id = ", $exclude_id);
            $count = $db->query("SELECT COUNT(*) AS C FROM $table WHERE $field='$value' AND id != $condition")->fetchObject()->C;
        } else {
            $count = $db->query("SELECT COUNT(*) AS C FROM $table WHERE $field='$value'")->fetchObject()->C;
        }
        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
}