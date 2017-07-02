<?php

namespace Utils\Classes;

use Api\Controller\ApiController;

/**
 * Processes all requests to API server application
 * Class FrontController
 * @package Utils\Classes
 */
class FrontController
{
    /**
     * if we work with built-in server and request uri was overridden,
     * restore original request uri from constant 'REAL_REQUEST_URI' (defined in router.php)
     */
    private function preDispatch()
    {
        if (php_sapi_name() == 'cli-server' && defined('REAL_REQUEST_URI')) {
            $_SERVER['REQUEST_URI'] = REAL_REQUEST_URI;
        }
    }

    /**
     * Parses request uri and calls api controller if request operation name found
     * @return array - result of api request of error structure if empty request
     */
    private function processApi()
    {
        $result = null;

        $uriParts = Request::getRequestUriParts();
        if (count($uriParts) === 1 && $uriParts[0] == '') {
            //empty request (/)
            $result = ['error' => 'Empty request'];
        } else {
            //try to process api request, api entry point call
            $result = (new ApiController())->processApiRequest(
                Request::getMethod(),
                $uriParts[0],
                array_slice($uriParts, 1)
            );
        }

        return $result;
    }

    /**
     * Front Controller`s main method of Api Server Application
     * Renders HTTP-body in JSON
     */
    public function run()
    {
        $this->preDispatch();

        $result = null;

        if (!AuthStub::auth()) {
            $result = ['error' => 'Server auth error'];
        }
        elseif ('POST' == Request::getMethod()) {
            $result = $this->processApi();
        } else {
            //we can`t handle others types of requests yet
            $result = ['error' => 'Method is unsupported'];
        }

        print json_encode($result);
    }
}