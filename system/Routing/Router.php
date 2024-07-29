<?php
namespace System\Routing;

use System\Http\Request;

class Router
{
    protected array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function add(string $name, Route $route)
    {
        if (isset($this->routes[$name]))
            throw new Exception\RouteAlreadyExistsException("Route $name already exists");
        $this->routes[$name] = $route;
    }

    public function loadFromJson(array $configuration, string $prefix = "")
    {
        foreach ($configuration as $name => $route) {
            if (empty($route["path"])) {
                $this->loadFromJson($configuration[$name], ($prefix !== "" ? "$prefix." : "") . $name);
            } else {
                $this->add(($prefix !== "" ? "$prefix." : "") . $name, new Route($route["path"], $route["controller"], $route["method"], $route["enabled"]??true));
            }
        }
    }

    public function get(string $name)
    {
        return $this->routes[$name] ?? false;
    }

    public function generate(string $name, array $params = [])
    {
        if (!isset($this->routes[$name]))
            throw new Exception\RouteNotFoundException("Route $name not found");
        $urlpath = $this->routes[$name]->path;
        foreach ($params as $p => $v)
            $urlpath = str_replace('{' . $p . '}', $v, $urlpath);
        return $urlpath;
    }

    public function match(string $path, string $method = "GET")
    {
        foreach ($this->routes as $n => $r) {
            $pathMatch = preg_match($r->compiledPath, $path, $matches);
            $methodMatch = $r->method === $method or $r->method=="any";

            if ($pathMatch && $methodMatch && $r->enabled) {
                $args=array_intersect_key($matches, array_flip(array_filter(array_keys($matches), "is_string")));
                return [$n, $r, $args];
            }
        }
        return false;
    }

    public function matchRequest(Request $request)
    {
        return $this->match($request->path, $request->method);
    }
}