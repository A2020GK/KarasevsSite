<?php
namespace System\Http;
use System\Routing\Route;

class RedirectResponse extends Response {
    public function __construct(string $url) {
        parent::__construct(302);
        $this->header("Location",$url);
    }
    public static function toRoute(string $name,array $args=[]) {
        return new self(APPLICATION->router->generate($name,$args));
    }
}