<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project APIRoute.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Domain;

use Teacher\GivenCode\Enumerations\HTTPMethodsEnum;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
class APIRoute {
    private HTTPMethodsEnum $method;
    private string $controllerClass;
    
    /**
     * TODO: documentation
     *
     * @param HTTPMethodsEnum $method
     * @param string          $controllerClass
     */
    public function __construct(HTTPMethodsEnum $method, string $controllerClass) {
        $this->method = $method;
        $this->controllerClass = $controllerClass;
    }
    
    /**
     * TODO: documentation
     *
     * @return HTTPMethodsEnum
     */
    public function getMethod() : HTTPMethodsEnum {
        return $this->method;
    }
    
    /**
     * TODO: documentation
     *
     * @param HTTPMethodsEnum $method
     */
    public function setMethod(HTTPMethodsEnum $method) : void {
        $this->method = $method;
    }
    
    /**
     * TODO: documentation
     *
     * @return string
     */
    public function getControllerClass() : string {
        return $this->controllerClass;
    }
    
    /**
     * TODO: documentation
     *
     * @param string $controllerClass
     */
    public function setControllerClass(string $controllerClass) : void {
        $this->controllerClass = $controllerClass;
    }
    
}