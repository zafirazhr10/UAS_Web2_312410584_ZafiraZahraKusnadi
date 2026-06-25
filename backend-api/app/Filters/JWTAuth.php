<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class JWTAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('JWT_SECRET') ?: 'E_Inventory_System_UAS_Web2_Secret_Key_Secure_2026';
        $authHeader = $request->getHeaderLine('Authorization');

        if (empty($authHeader)) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON(['error' => 'Unauthorized: Missing Authorization header']);
            return $response;
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $request->user = $decoded;
        } catch (ExpiredException $e) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON(['error' => 'Unauthorized: Token has expired']);
            return $response;
        } catch (SignatureInvalidException $e) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON(['error' => 'Unauthorized: Invalid token signature']);
            return $response;
        } catch (\Exception $e) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON(['error' => 'Unauthorized: ' . $e->getMessage()]);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}