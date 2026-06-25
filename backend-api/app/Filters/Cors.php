<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH, HEAD');
        header('Access-Control-Allow-Headers: Accept, Authorization, Content-Type, X-CSRF-Token, X-Requested-With, X-API-KEY, Origin, Access-Control-Request-Method, Access-Control-Request-Headers');
        header('Access-Control-Expose-Headers: Authorization, X-Total-Count');
        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH, HEAD');
        $response->setHeader('Access-Control-Allow-Headers', 'Accept, Authorization, Content-Type, X-CSRF-Token, X-Requested-With, X-API-KEY, Origin, Access-Control-Request-Method, Access-Control-Request-Headers');
        $response->setHeader('Access-Control-Expose-Headers', 'Authorization, X-Total-Count');
        return $response;
    }
}