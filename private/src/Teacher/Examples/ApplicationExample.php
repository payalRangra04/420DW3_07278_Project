<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project ApplicationExample.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */

namespace Teacher\Examples;

use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Services\APIRouter;

/**
 * TODO: Class documentation
 *
 * @author Marc-Eric Boury
 * @since  2024-03-14
 */
class ApplicationExample {
    private APIRouter $router;
    
    public function __construct() {
        $this->router = new APIRouter();
    }
    
    /**
     * TODO: Function documentation
     *
     * @return void
     *
     * @author Marc-Eric Boury
     * @since  2024-03-16
     */
    public function run() : void {
        try {
            $this->router->route();
        } catch (RequestException $reqExep) {
            foreach ($reqExep->getHttpHeaders() as $headerName => $headerValue) {
                header($headerName . ": " . $headerValue);
            }
            http_response_code($reqExep->getHttpResponseCode());
            die();
        } catch (\Exception $otherException) {
            http_response_code(500);
            echo '<span style="color: red;">' . generate_exception_html($otherException) . '</span>';
            die();
        }
    }
}