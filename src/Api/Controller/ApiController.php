<?php

namespace Api\Controller;

use Api\Model\TransactionModel;

/**
 * This controller implements logic of API
 * Class ApiController
 * @package Api\Controller
 */
class ApiController
{
    /**
     * Entry point of API Controller, routes requests to concrete  methods
     * @param $requestMethod - method of HTTP-request (POST, GET, DELETE)
     * @param $apiMethodName - name of the called API method (only 'transaction' is implemented now)
     * @param $parameters    - array of parameters for API method  (in general can be empty)
     * @return array - result of the requested API method (with understandable keys), or error structure if not found 
     */
    public function processApiRequest($requestMethod, $apiMethodName, $parameters)
    {
        //form name of API method, look for it and launch if found
        $executableApiMethodName = $apiMethodName . ucfirst($requestMethod);
        if (method_exists($this, $executableApiMethodName)) {
            return $this->{$executableApiMethodName}($parameters);
        }

        //method was not found
        return ['error' => 'method not found'];
    }

    /**
     * Implementats API transaction operation
     * @param array $params - array with 2 items: email and amount (other params if passed will be ignored)
     * @return array - structure with understandable keys:
     * status = {rejected, approved}, transaction_id (if approved), error_message (if rejected)
     */
    private function transactionPost(array $params = [])
    {
        $result = [];

        //firstly check number of parameters
        if (count($params) < 2) {
            $result['status'] = 'rejected';

            if (count($params) == 1) {
                $result['error_message'] = 'amount is not specified';
            }

            if (count($params) == 0) {
                $result['error_message'] = 'email is not specified, amount is not specified';
            }
        } else {
            try {
                //create and try to save the trnsaction
                $transaction = new TransactionModel($params[0], $params[1]);
                $result = $transaction->save();
            }
            catch (\Exception $ex) {
                $result['status'] = 'rejected';
                $result['error_message'] = $ex->getMessage();
            }
        }

        return $result;
    }
}