<?php
namespace App\Controllers;
use System\Controller;
use System\Http\Request;

class Error extends Controller {
    public function error(Request $request,array $args=[]) {
        $code=$args["code"];

        $r=$this->renderTemplate("error",["code"=>$code]);
        $r->statusCode=$code;
        return $r;
    }
}