<?php
define("ROOT",realpath(__DIR__."/.."));
define("CONFIG_DIR",ROOT."/config");
define("TEMP_DIR",ROOT."/temp");
define("APP_DIR",ROOT."/src");
define("SYSTEM_DIR",ROOT."/system");
define("DATA_DIR",ROOT."/data");

define("LOGGER",new System\Logger());
LOGGER->log("Initial setup done");