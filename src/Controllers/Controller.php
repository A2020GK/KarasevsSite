<?php
namespace App\Controllers;
use App\Models\Session;
use System\Application;
use System\Http\Request;
use System\Http\Response;
use App\Models\User;
use App\Controllers\User as UserController;

class Controller extends \System\Controller {
    public User|false $currentUser=false;
    public function __construct(Application $application,Request $request) {
        parent::__construct($application);

        if($token=$request->cookies["session_token"]??false) {
            $session=Session::getByToken($token);
            if($session) {
                $session->save();

                UserController::applySessionToken($session);

                $this->currentUser=$session->user;
            } else Response::setCookieGlobal("session_token","_none",time()-3600);
        }
        $application->smarty->assign("currentUser",$this->currentUser);
    }
}