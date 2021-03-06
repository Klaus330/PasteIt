<?php

namespace app\controllers;

use app\core\Application;
use app\core\routing\Request;
use app\models\Paste;
use app\models\Syntax;
use DateTime;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $captchaCode = "";
        if (app()::isGuest()) {
            $captchaCode = CaptchaController::genCaptcha();
        }

        $model = session()->hasFlash("model") ? session()->getFlash('model') : new Paste();
        $syntaxes = Syntax::find();
        $latestPastes = Paste::latest(5, ["expired" => 0, "exposure" => 0]);


        if(session()->hasFlash('errors')){
            $errors = session()->getFlash('errors');
        }

        return view('home',
            [
                'captchaCode' => $captchaCode,
                'syntaxes' => $syntaxes,
                'latestPastes' => $latestPastes,
                'errors' => $errors ?? []
            ]);
    }
}