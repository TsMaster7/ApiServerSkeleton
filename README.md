# ApiServerSkeleton
Simple skeleton for the REST API server, one service is implemented as an example.

This service performs a fake logging of money transactions and returns transaction status.
The transaction status is generated randomly (“rejected” or “approved”).
If it’s not rejected the method returns your random transaction ID and the status.
When it’s rejected the method returns error message with the status.

Syntax:
POST /transaction/{email}/{amount}/

Email – user email, amount – sum of transaction (money). 

Example:
Input: POST /transaction/a@a.com/241221.30/
Output: JSON 
{
  "status": "rejected",
  "error_message": "Fraud detected!"
}

To launch the demo you need to have TransactionApiClient project also (API client: SPA + Proxy):
https://github.com/TsMaster7/ApiClientSkeleton

Deployment:

Originally these two project was designed to be deployed on built-in PHP server.
Please, try the following steps:

1)	Launch server as
	
<path_to_your_php_interpreter>/php -S 127.0.0.1:8000 -t <path_to_server_project>/TransactionApi/web/ <path_to_server_project>/TransactionApi/web/router.php

You should use router.php script to send all queries to the server entry point, 
you can use another port and host if you wish, but you will have to change server address in client application (see virtual host deployment section)

2) Launch client as

<path_to_your_php_interpreter>/php -S 127.0.0.1:8001 -t <path_to_client_project>/TransactionApiClient/web/

You can use another host and port if you wish

3) Open client application in your browser and enjoy logging transactions:
http://127.0.0.1:8001

Deployment on virtual hosts
These applications can be deployed on virtual hosts as well as on the built-in PHP server. You just need to set up virtual hosts for server-app and client-app on your web-server and set ‘web’-folders of both projects as document root. After that you must set new http-address of your server-app in client`s front controller (FrontController.php) using API_SERVER_TEST_URL constant.
