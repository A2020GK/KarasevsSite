<?php
define("START_TIME",microtime(true));

require_once __DIR__."/../vendor/autoload.php";

LOGGER->log("[APPLICATION STARTED]","    ");
require ROOT."/app.php";