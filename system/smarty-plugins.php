<?php
use Smarty\Template;

function smarty_tag_route($params, Template $template) {
    $name=$params["name"];
    unset($params["name"]);
    $app=APPLICATION;
    return $app->router->generate($name,$params);
}


function smarty_tag_workingTime($params, Template $template) {
    return microtime(true)-START_TIME;
}

APPLICATION->smarty->registerPlugin(Smarty\Smarty::PLUGIN_FUNCTION, "route", "smarty_tag_route");
APPLICATION->smarty->registerPlugin(Smarty\Smarty::PLUGIN_FUNCTION,"workingTime","smarty_tag_workingTime");