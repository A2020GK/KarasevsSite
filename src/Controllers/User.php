<?php
namespace App\Controllers;

use App\Models\Session;
use System\Http\RedirectResponse;
use System\Http\Response;
use System\Http\Request;
use App\Models\User as UserModel;

class User extends Controller
{
    public function profile(Request $request, array $args): Response
    {
        $user = UserModel::getById((int)$args["id"]);
        if (!$user)
            return new Response(404);
        return $this->renderTemplate("user.profile", ["user" => $user]);
    }
    public function login(Request $request, array $args): Response
    {
        $goto = $request->getParams["goto"] ?? "/";
        if ($this->currentUser)
            return new RedirectResponse($goto);
        else
            return $this->renderTemplate("user.login", ["fail" => false]);
    }
    public static function applySessionToken(Session $session) {
        $week = 60 * 60 * 24 * 7;

        Response::setCookieGlobal("session_token", $session->token, time() + $week);
    }
    public function handleLogin(Request $request, array $args): Response
    {
        $goto = $request->getParams["goto"] ?? "/";
        $username = $request->postParams["username"] ?? false;
        $password = $request->postParams["password"] ?? false;
        if (!boolval($username) || !boolval($password))
            return new Response(401);

        $username=strtolower($username);

        $user = UserModel::getByUsername($username);
        if ($user) {
            $auth = password_verify($password, $user->password);
            if ($auth) {
                $response = new RedirectResponse($goto);
                $session = new Session($user);
                $session->save();

                self::applySessionToken($session);

                return $response;
            }
        }
        return $this->renderTemplate("user.login",["fail"=>true]);
    }
    public function register(Request $request, array $args) {
        $goto = $request->getParams["goto"] ?? "/";
        if ($this->currentUser)
            return new RedirectResponse($goto);
        else
            return $this->renderTemplate("user.register", ["fail" => false]);
    }
    public function handleRegistration(Request $request,array $args) {
        $goto = $request->getParams["goto"] ?? "/";

        $username=$request->postParams["username"] ?? false;
        $password=$request->postParams["password"]??false;
        $name=$request->postParams["name"]??false;
        $birthday=$request->postParams["birthday"]??false;
        
        if(!boolval($username) || !boolval($password) || !boolval($name) || !boolval($birthday)) {
            return new Response(401);
        }

        $username=strtolower($username);
        $password=password_hash($password,PASSWORD_DEFAULT);

        $birthday=\DateTime::createFromFormat("Y-m-d",$birthday)
        ->getTimestamp();

        $userExists=boolval(UserModel::getByUsername($username));
        if($userExists) return $this->renderTemplate("user.register",["fail"=>true]);

        $user=new UserModel(null,$username,$password,$birthday,$name);
        $user->save();

        $session=new Session($user);
        $session->save();
        self::applySessionToken($session);

        return new RedirectResponse($goto);
    }
    public function edit(Request $request,array $args) {
        
    }
}
