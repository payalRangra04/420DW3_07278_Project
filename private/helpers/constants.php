<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project constants.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

/**
 * The directory separator symbol in web/URL paths.
 * @const
 */
const WEB_DIRECTORY_SEPARATOR = "/";
const NAMESPACE_PATH_SEPARATOR = "/";
const DB_DATETIME_FORMAT = "Y-m-d H:i:s.u";
const HTML_DATETIME_FORMAT = "Y-m-d\TH:i:sP";


// <editor-fold defaultstate="collapsed" desc="ABSOLUTE PATHS (FILESYSTEM PATHS)">

/**
 * Absolute path to the project's root directory
 * @const
 */
define("PRJ_ROOT_DIR",
       realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR);

/**
 * Absolute path to the 'public' directory of the project.
 * @const
 */
const PRJ_PUBLIC_DIR = PRJ_ROOT_DIR . "public" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the 'private' directory of the project.
 * @const
 */
const PRJ_PRIVATE_DIR = PRJ_ROOT_DIR . "private" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the 'src' directory of the project.
 * @const
 */
const PRJ_SRC_DIR = PRJ_PRIVATE_DIR . "src" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the 'fragments' directory of the project.
 * @const
 */
const PRJ_FRAGMENTS_DIR = PRJ_PRIVATE_DIR . "fragments" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the public 'images' directory of the project.
 * @const
 */
const PRJ_IMAGES_DIR = PRJ_PUBLIC_DIR . "images" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the public 'css' directory of the project.
 * @const
 */
const PRJ_CSS_DIR = PRJ_PUBLIC_DIR . "css" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the public 'js' directory of the prohject.
 * @const
 */
const PRJ_JS_DIR = PRJ_PUBLIC_DIR . "js" . DIRECTORY_SEPARATOR;

/**
 * Absolute path to the public 'pages' directory of the project.
 * @const
 */
const PRJ_PAGES_DIRE = PRJ_PUBLIC_DIR . "pages" . DIRECTORY_SEPARATOR;

// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="WEB PATHS (URLs)">

/**
 * Web path to the root project directory with dynamic hostname.
 * Example: 'localhost/<rootDirectory>'
 * @const
 */
define("WEB_ROOT_DIR",
       $_SERVER["HTTP_HOST"] . WEB_DIRECTORY_SEPARATOR . "420DW3_07278_Project" . WEB_DIRECTORY_SEPARATOR);

/**
 * Web path to the public 'css' directory.
 * @const
 */
const WEB_CSS_DIR = WEB_ROOT_DIR . "css" . WEB_DIRECTORY_SEPARATOR;

/**
 * Web path to the public 'js' directory.
 * @const
 */
const WEB_JS_DIR = WEB_ROOT_DIR . "js" . WEB_DIRECTORY_SEPARATOR;

/**
 * Web path to the public 'pages' directory.
 * @const
 */
const WEB_PAGES_DIR = WEB_ROOT_DIR . "pages" . WEB_DIRECTORY_SEPARATOR;

/**
 * Web path to the public 'images' directory.
 * @const
 */
const WEB_IMAGES_DIR = WEB_ROOT_DIR . "images" . WEB_DIRECTORY_SEPARATOR;

// </editor-fold>