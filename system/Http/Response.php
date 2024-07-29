<?php
namespace System\Http;

class Response
{
    public static array $cookies=[];
    public function __construct(
        public int $statusCode = 200,
        public string $body = "",
        public array $headers = [],
    ) {
    }

    public static function setCookieGlobal(string $name,string $value,int|null $expires=null,string $path="/") {
        self::$cookies[$name]=[$name,$value,$expires,$path];
    }
    public function setCookie(string $name,string $value,int|null $expires,string $path="/") {
        self::setCookieGlobal($name,$value,$expires,$path);
    }
    public function header(string $name, string $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        foreach(self::$cookies as $cookie) {
            setcookie(...$cookie);
        }

        echo $this->body;
    }
}