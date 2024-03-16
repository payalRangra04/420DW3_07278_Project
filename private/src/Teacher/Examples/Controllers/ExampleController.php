<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project ExampleController.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-16
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\Examples\Controllers;

use Teacher\Examples\DAOs\ExampleDAO;
use Teacher\Examples\Services\ExampleService;
use Teacher\GivenCode\Abstracts\AbstractController;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-16
 */
class ExampleController extends AbstractController {
    private ExampleService $exampleService;
    
    public function __construct() {
        parent::__construct();
        $this->exampleService = new ExampleService();
    }
    
    public function get() {
        // TODO: HTTP GET handling
    }
    
    public function post() {
        // TODO: HTTP POST handling
    }
    
    public function put() {
        // TODO: HTTP PUT handling
    }
    
    public function delete() {
        // TODO: HTTP DELETE handling
    }
}