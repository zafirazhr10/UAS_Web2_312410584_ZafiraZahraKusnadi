<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
public $allowedOrigins = ['*'];
public $allowedHeaders = ['Content-Type', 'Authorization'];
public $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
    public $exposedHeaders = [];
    public $maxAge = 0;
    public $supportsCredentials = false;
}
