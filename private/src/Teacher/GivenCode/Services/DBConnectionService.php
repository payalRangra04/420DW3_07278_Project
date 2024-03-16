<?php
/*
* DBConnectionService.php
* 420DW3_07278_Project
* (c) 2024 Marc-Eric Boury All rights reserved
*/

namespace Teacher\GivenCode\Services;

use PDO;
use Teacher\GivenCode\Abstracts\IService;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
class DBConnectionService implements IService {
    
    private const DB_NAME = "420dw3_07278_project";
    private static ?PDO $CONNECTION;
    
    /**
     * TODO: Function documentation
     *
     * @static
     * @return PDO
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public static function getConnection() : PDO {
        self::$CONNECTION ??= new PDO("mysql:dbname=" . self::DB_NAME . ";host=" . $_SERVER["HTTP_HOST"], "root", "");
        return self::$CONNECTION;
    }
    
}