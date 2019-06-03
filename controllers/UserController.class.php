<?php

class UserController extends Controller {
    public function __construct() {
        $this->model = new User();
    }

    public function login() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getUserByLogin($_POST['login']);
            print_r($user);
            print_r($_POST);
            if (isset($user) && $user['password'] === $_POST['password']) {
                Session::set('logged', $user['login']);
            }
            App::redirect('/');
        }
    }

    public function register() {
        
    }

    public function logout() {
        Session::destroy();
    }
}
