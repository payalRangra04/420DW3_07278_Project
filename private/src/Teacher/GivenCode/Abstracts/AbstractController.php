<?php
/*
* AbstractController.php
* 420DW3_07278_Project
* (c) 2024 Marc-Eric Boury All rights reserved
*/

namespace Teacher\GivenCode\Abstracts;

use Teacher\GivenCode\Abstracts\IController;
use Teacher\GivenCode\Enumerations\HTTPMethodsEnum;
use Teacher\GivenCode\Exceptions\RequestException;

abstract class AbstractController implements IController {
    
    public function __construct() {}
    
    public function getAllowedMethods() : array {
        $allowedMethodsArray = [];
        foreach (HTTPMethodsEnum::cases() as $httpEnumCase) {
            if (method_exists(static::class, strtolower($httpEnumCase->value))) {
                $allowedMethodsArray[] = $httpEnumCase->value;
            }
        }
        return $allowedMethodsArray;
    }
    
    public function callHttpMethod(HTTPMethodsEnum $method) : void {
        $class_method = strtolower($method->value);
        if (!method_exists(static::class, $class_method)) {
            throw new RequestException("HTTP method [$method->value] not supported.", 405, [
                "Allow" => implode(", ", $this->getAllowedMethods())
            ]);
        }
    }
}