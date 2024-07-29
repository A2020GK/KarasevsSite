<?php

use System\Application;
use System\Http\Request;

$request=Request::constructFromGlobals();

$application=new Application();

$response=$application->run($request);

$response->send();

LOGGER->log("Work time ".microtime(true)-START_TIME."s.");