<?php
namespace System;

use System\Http\Response;
class Controller {
    public function __construct(
        protected Application $application
    ){
    }
    protected function renderTemplate(string $filename,array $vars=[]) {
        LOGGER->log("Rendering Smarty template $filename");
        foreach($vars as $name=>$value) $this->application->smarty->assign($name,$value);
        return new Response(200,$this->application->smarty->fetch(str_replace(".","/",$filename).".tpl"));
    }
}