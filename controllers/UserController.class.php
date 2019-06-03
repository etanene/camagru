<?php

class UserController extends Controller {
    public function __construct() {
        $this->model = new User();
    }

    public function login() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getUserByLogin($_POST['login']);
            if (isset($user) && $user['password'] === $_POST['password']) {
                Session::set('logged', $user['login']);
            }
            App::redirect('/');
        }
    }

    public function register() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
                $checkLogin = $this->model->getUserByLogin($_POST['login']);
                $checkEmail = $this->model->getUserByEmail($_POST['email']);
                if (isset($checkLogin) || isset($checkEmail)) {
                    App::redirect('/');
                }
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $this->model->addUser($_POST['login'], $hash, $_POST['email']);
                Session::set('logged', $_POST['login']);
        }
    }

    public function logout() {
        Session::destroy();
    }
}
