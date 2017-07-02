<?php

namespace Utils\Classes;

/**
 * Simple auth tool 
 * Class AuthStub
 * @package Utils\Classes
 */
class AuthStub
{
    /**
     * Checks clientId and authToken
     * @return bool - if client allowed
     */
    public static function auth()
    {
        /*
         * Storage of client, have data in format [client_1_id => client_1_digest_salt, ...] 
         */
        $clientSaltStorage = [
            'w92w9ue838eu2h5y' => 'Black rock',
            's392s3i3849ud48d' => 'Crazy cat',
            'cnrf83f392e2kskd' => 'Happy new year',
            //...
        ];

        $params = Request::getParams();

        if (!isset($params['authToken']) || !isset($params['clientId'])) {
            //one or both auth parameters omitted
            return false;
        }

        if (!in_array($params['clientId'], array_keys($clientSaltStorage))) {
            //unknown client
            return false;
        }

        if ($params['authToken'] !== sha1(Request::getFullUrl() . $clientSaltStorage[$params['clientId']])) {
            //digest verification failed
            return false;
        }

        return true;
    }

}