<?php
namespace System;

use Smarty\Smarty;
use System\Http\Request;
use System\Http\Response;
use System\Routing\Router;
use System\Routing\Route;

class Application
{
    public Router $router;
    public Smarty $smarty;
    public function __construct()
    {
        LOGGER->log("Application created");
        $this->router = new Router();
        $this->router->loadFromJson(
            json_decode(file_get_contents(CONFIG_DIR . "/routes.json"), true)
        );

        LOGGER->log("Initializing Smarty");

        $this->smarty=new Smarty();
        $this->smarty->setTemplateDir(APP_DIR."/Views");
        $this->smarty->setCompileDir(TEMP_DIR."/smarty/compile");

        define("APPLICATION",$this);
        
        require_once SYSTEM_DIR."/smarty-plugins.php";
        require_once SYSTEM_DIR."/legacy/patch-smarty-strftime.php";


    }
    public function runRoute(Request $request,string $name,Route $route,array $args) {
        LOGGER->log("Found route $name");
        $prefix="\\App\\Controllers\\";

        $handler=explode("::",$route->handler,2);
        $handlerAction=$handler[1];
        $handlerClass=$handler[0];
        
        $handler=$prefix.$handlerClass;

        $handler=new $handler($this,$request);

        return $handler->$handlerAction($request,$args);
    }
    public function run(Request $request):Response {
        LOGGER->log("Analyzing request");
        $response=new Response(204);
        if($route=$this->router->matchRequest($request)) {
            $response=$this->runRoute($request,...$route);
        } else {
            LOGGER->log("Route not found. Exiting with 404..");
            $response=new Response(404);
        }
        if($response->statusCode!=200) {
            $route=$this->router->get("error");
            $response=$this->runRoute($request,"error",$route,["code"=>$response->statusCode]);
        }
        return $response;
    }
}