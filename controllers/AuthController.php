<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{


    public function index()
    {

    }

    public function login(Request $request)
    {

    }

    public function register(Request $request)
    {
        $this->setLayout('auth');

        if($request->isPost()){
            $user = new User();

            $user->loadData($request->getBody());

            if($request->validate($user->rules())){
                return 'Success';
            }

            die(var_dump($request->getErrors()));

            return $this->render('register', [
                'model' => $user,
                'errors' => $request->getErrors()
            ]);
        }

        return $this->render('register');
    }
}