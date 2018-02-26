<?php
/**
 * Created by PhpStorm.
 * User: Yanick Lafontaine
 * Date: 2018-02-25
 * Time: 20:38
 */

namespace WoWCMS\Helpers;

use Dotenv\Dotenv;

/**
 * Permet le retour en arrière sur une page expiré
 */
session_cache_limiter('private_no_expire, must-revalidate');

/**
 * Start session
 */
session_start();

/**
 * Permet de calculer le temps de loading de la page
 */
$start_time = microtime(true);

/**
 * Time Zone
 */
date_default_timezone_set('America/Montreal');

/**
 * MSSQL Charset
 */
ini_set('mssql.charset', 'UTF-8');

/**
 * Load composer components
 */
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/**
 * Load .env file
 */
$dotenv = new Dotenv($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

/**
 * Error setting
 */
if (getenv("DEBUG") == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}