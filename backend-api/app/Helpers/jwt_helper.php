<?php

if (!function_exists('generate_jwt')) {
    function generate_jwt($user) {
        $key = getenv('JWT_SECRET_KEY');
        $iat = time();
        $exp = $iat + 3600;

        $payload = [
            'iss' => 'yourdomain.com',
            'aud' => 'yourdomain.com',
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ]
        ];

        return \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('validate_jwt')) {
    function validate_jwt($token) {
        $key = getenv('JWT_SECRET_KEY');

        try {
            $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
}