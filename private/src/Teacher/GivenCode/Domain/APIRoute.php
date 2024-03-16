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

use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Enumerations\HTTPMethodsEnum;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
class APIRoute {
    private string $uri;
    private string $controllerClass;
    
    /**
     * TODO: documentation
     *
     * @param string $uri
     * @param string $controllerClass
     * @throws ValidationException
     */
    public function __construct(string $uri, string $controllerClass) {
        if (!class_exists($controllerClass)) {
            throw new ValidationException("APIRoute specified controller class [$controllerClass] does not exists.");
        }
        if (!is_a($controllerClass, AbstractController::class, true)) {
            throw new ValidationException("APIRoute specified controller class [$controllerClass] does not extend [" .
                                          AbstractController::class . "].");
        }
        $this->uri = $uri;
        $this->controllerClass = $controllerClass;
    }
    
    /**
     * TODO: documentation
     *
     * @return string
     */
    public function getUri() : string {
        return $this->uri;
    }
    
    /**
     * TODO: documentation
     *
     * @return string
     */
    public function getControllerClass() : string {
        return $this->controllerClass;
    }
    
}