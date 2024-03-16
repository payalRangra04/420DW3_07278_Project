<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project APIRouter.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\GivenCode\Services;

use Teacher\Examples\Controllers\ExampleController;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Domain\APIRoute;
use Teacher\GivenCode\Domain\APIRouteCollection;
use Teacher\GivenCode\Enumerations\HTTPMethodsEnum;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
class APIRouter implements IService {
    
    private string $uri_base_directory;
    private APIRouteCollection $routes;
    
    /**
     * @param string $uri_base_directory
     * @throws ValidationException
     */
    public function __construct(string $uri_base_directory = "") {
        $this->uri_base_directory = $uri_base_directory;
        $this->routes = new APIRouteCollection();
        $this->routes->addRoute(new APIRoute("/api/exempleDTO", ExampleController::class));
    }
    
    /**
     * TODO: Function documentation
     *
     * @return void
     * @throws RequestException
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public function route() : void {
        $uri = $_SERVER["REQUEST_URI"];
        $method = HTTPMethodsEnum::getValue($_SERVER["REQUEST_METHOD"]);
        $route = $this->routes->match($uri, $this->uri_base_directory);
        
        if (is_null($route)) {
            // route not found
            throw new RequestException("Route [$uri] not found.", 404);
        }
        
        $controllerClass = $route->getControllerClass();
        $controller = (new $controllerClass());
        if (!($controller instanceof AbstractController)) {
            // this should not happen ever as it is validated inside the APIRoute constructor.
            throw new Exception("APIRoute specified controller class [$controllerClass] does not extend [" .
                                AbstractController::class . "].");
        }
        $controller->callHttpMethod($method);
        
    }
}