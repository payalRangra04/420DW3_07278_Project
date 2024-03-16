<?php
/*
* APIRouteCollection.php
* 420DW3_07278_Project
* (c) 2024 Marc-Eric Boury All rights reserved
*/

namespace Teacher\GivenCode\Domain;

use ArrayIterator;
use IteratorAggregate;
use Teacher\GivenCode\Exceptions\ValidationException;
use Traversable;

/**
 * TODO: Class documentation
 *
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
class APIRouteCollection implements IteratorAggregate {
    
    /**
     * @var APIRoute[]
     */
    private array $routes = [];
    
    /**
     * Constructor for {@see APIRouteCollection}.
     *
     * @param array $routeArray An optional array of initial {@see APIRoute} elements.
     * @throws ValidationException If the initial route array contains invalid elements.
     */
    public function __construct(array $routeArray = []) {
        // Validate the initial route array.
        foreach ($routeArray as $index => $route) {
            if (!($route instanceof APIRoute)) {
                throw new ValidationException("Invalid route in APIRouteCollection initial array: element at index [$index] is not an instance of " .
                                              APIRoute::class . ".");
            }
        }
        $this->routes = $routeArray;
    }
    
    /**
     * @inheritDoc
     */
    public function getIterator() : Traversable {
        return new ArrayIterator($this->routes);
    }
    
    /**
     * TODO: Function documentation
     *
     *
     * @param APIRoute $route           The route to add to the collection.
     * @param bool     $optNoDuplicates [OPTIONAL] Whether to forbid duplicate routes or not. Defaults to <code>true</code>.
     * @return void
     * @throws ValidationException If an equivalent route exist in the collection and duplicates are forbidden.
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public function addRoute(APIRoute $route, bool $optNoDuplicates = true) : void {
        if ($optNoDuplicates) {
            foreach ($this->routes as $index => $existingRoute) {
                if ($route == $existingRoute) {
                    // object values comparison
                    throw new ValidationException("Equivalent route already present in APIRouteCollection.");
                }
            }
        }
        $this->routes[] = $route;
    }
    
    /**
     * Removes a route from the collection.
     * Returns <code>true</code> if the specified route is found and removed, and <code>false</code>
     * if the route was not found and thus not removed.
     *
     * @param APIRoute $route The route to remove.
     * @return bool <code>true</code> if a route was removed, <code>false</code> otherwise.
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public function removeRoute(APIRoute $route) : bool {
        if (in_array($route, $this->routes)) {
            $key = array_search($route, $this->routes);
            array_splice($this->routes, 1, 1);
            return true;
        }
        return false;
    }
    
    /**
     * TODO: Function documentation
     *
     * @param string $uri
     * @param string $uri_base_directory
     * @return APIRoute|null
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public function match(string $uri, string $uri_base_directory = "") : ?APIRoute {
        foreach ($this->routes as $route) {
            if (($route instanceof APIRoute) && (rtrim($route->getUri(), "/") == rtrim($uri, "/"))) {
                return $route;
            }
        }
        return null;
    }
    
}