<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project HTTPMethodsEnum.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Enumerations;

/**
 * TODO: Enumeration documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
enum HTTPMethodsEnum: string {
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case DELETE = "DELETE";
}
