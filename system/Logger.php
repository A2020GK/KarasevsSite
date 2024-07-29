<?php
namespace System;

class Logger {
    protected bool $enabled;
    public function __construct() {
        $this->enabled=php_sapi_name() === "cli-server";
    }
    public function log(string $message,string $prefix="    > ") {
        if($this->enabled) error_log($prefix.$message);
    }
}