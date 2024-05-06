<?php

namespace Payal;

use Debug;
use ErrorException;
use Exception;
use Payal\Services\InternalRouter;

/**
 *
 */
class Application {
    private InternalRouter $router;
    
    public function __construct() {
        $this->router = new InternalRouter();
    }
    
    
    /**
     * @return void
     */
    public function run() : void {
        // start the output buffering
        ob_start();
        try {
            // route the request
            $this->router->route();
            
            $error = error_get_last();
            if ($error === null) {
                // flush the output buffer
                ob_end_flush();
                return;
            }
            throw new ErrorException($error['message'], 500, $error['type'], $error['file'], $error['line']);
            
        } catch (Exception $exception) {
            
            ob_end_clean();
            
            Debug::logException($exception);
            Debug::outputException($exception);
            die();
        }
    }
}