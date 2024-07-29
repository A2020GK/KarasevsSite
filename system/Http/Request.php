<?php
namespace System\Http;
use System\Routing\Route;

class Request
{
    public Route $route;
    public string $path;
    public function __construct(
        public string $method,
        public string $uri,
        public array $headers = [],
        public array $getParams = [],
        public array $postParams = [],
        public array $cookies =[],
        public string $body = ''
    ) {
        $this->path = parse_url($this->uri, PHP_URL_PATH);
    }

    public static function constructFromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $headers = getallheaders();
        $getParams = $_GET;
        $postParams = $_POST;
        $cookies=$_COOKIE;
        $body = file_get_contents('php://input');

        return new self($method, $uri, $headers, $getParams, $postParams, $cookies, $body);
    }
}