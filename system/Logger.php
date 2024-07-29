<?php
namespace System;

class Logger {
    protected bool $enabled;
    public function __construct() {
        $this->enabled=json_decode(file_get_contents(\CONFIG_DIR."/logging.json"),true)["enabled"];
    }
    public function log(string $message,string $prefix="    > ") {
        if($this->enabled) error_log($prefix.$message);
    }
}