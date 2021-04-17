<?php


namespace app\controllers;


use app\core\Application;
use app\core\Request;
use app\core\Validator;
use app\models\User;

class AuthController extends Controller
{
    public function index()
    {
        $user = new User();
        return view("auth/login", ['model' => $user]);
    }

    public function login(Request $request)
    {
        $isValid = $request->validate([
            'email' => [Validator::RULE_REQUIRED, Validator::RULE_EMAIL],
            'password' => [Validator::RULE_REQUIRED]
        ]);

        $user = new User();
        if ($isValid) {
            $user->loadData($request->getBody());

            if ($user->login()) {
                session()->setFlash('success', 'You are logged in');
                return redirect('/');
            }
        }

        return view('auth/login', [
            'model' => $user,
            'errors' => $request->getErrors()
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();
        if ($request->isPost()) {
            if ($request->validate($user->rules())) {
                $user->loadData($request->getBody());
                $user->save();


                session()->setFlash('success', 'You are registered');
                redirect('/login');
            }

            return view('auth/register', [
                'model' => $user,
                'errors' => $request->getErrors()
            ]);
        }

        return view('auth/register', [
            'model' => $user,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        return view("auth/forgot-password");
    }

    public function resetPassword(Request $request)
    {
        return view("auth/reset-password");
    }

    public function logout()
    {
        app()->logout();
        redirect('/');
    }
}