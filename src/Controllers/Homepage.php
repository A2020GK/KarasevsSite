<?php
namespace App\Controllers;
use System\Http\Request;
use System\Http\Response;

class Homepage extends Controller {
    public function index(Request $request):Response {
        return $this->renderTemplate("homepage");
    }
}