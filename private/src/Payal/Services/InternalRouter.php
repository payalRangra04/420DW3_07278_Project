<?php
declare(strict_types=1);

namespace Payal\Services;

use Teacher\Examples\Controllers\AuthorController;
use Teacher\Examples\Controllers\BookController;
use Teacher\Examples\Controllers\ExampleController;
use Teacher\Examples\Controllers\LoginController;
use Teacher\Examples\Controllers\PageNavigator;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Domain\AbstractRoute;
use Teacher\GivenCode\Domain\APIRoute;
use Teacher\GivenCode\Domain\CallableRoute;
use Teacher\GivenCode\Domain\RouteCollection;
use Teacher\GivenCode\Domain\WebpageRoute;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 *
 */
class InternalRouter implements IService {
    
    private string $uriBaseDirectory;
    private RouteCollection $routes;
    
    /**
     * @param string $uri_base_directory
     * @throws ValidationException
     */
    public function __construct(string $uri_base_directory = "") {
        $this->uriBaseDirectory = $uri_base_directory;
        $this->routes = new RouteCollection();
//        $this->routes->addRoute(new APIRoute("/api/exampleDTO", ExampleController::class));
//        $this->routes->addRoute(new APIRoute("/api/login", LoginController::class));
//        $this->routes->addRoute(new APIRoute("/api/books", BookController::class));
//        $this->routes->addRoute(new APIRoute("/api/authors", AuthorController::class));
        $this->routes->addRoute(new WebpageRoute("/index.php", "Payal/login.php"));
        $this->routes->addRoute(new WebpageRoute("/", "Payal/login.php"));
//        $this->routes->addRoute(new CallableRoute("/pages/login", [PageNavigator::class, "loginPage"]));
//        $this->routes->addRoute(new CallableRoute("/pages/books", [PageNavigator::class, "booksManagementPage"]));
//        $this->routes->addRoute(new CallableRoute("/pages/authors", [PageNavigator::class, "authorsManagementPage"]));
    }
    
    /**
     * @return void
     * @throws RequestException
     */
    public function route() : void {
        $path = REQUEST_PATH;
        $route = $this->routes->match($path);
        
        if (is_null($route)) {
            // route not found
            throw new RequestException("Route [$path] not found.", 404);
        }
        
        $route->route();
        
    }
    
    /**
     * @param AbstractRoute $route
     * @return void
     * @throws ValidationException
     */
    public function addRoute(AbstractRoute $route) : void {
        $this->routes->addRoute($route);
    }
}