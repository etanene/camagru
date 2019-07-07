<?php

class UserController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User();
    }

    public function login() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getUserByLogin($_POST['login']);
            if (isset($user) && $user['verified'] == 1 && password_verify($_POST['password'], $user['password'])) {
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
                    exit();
                }
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $code = hash('md5', uniqid());
                $this->model->addUser($_POST['login'], $hash, $_POST['email'], $code);
                $activationLink = 'http://localhost:8080/user/activate/' . $code . '/';
                $subject = 'Verification account';
                $body = "
                Account activation link:
                    <a href='" . $activationLink . "'>activate</a>
                ";
                $headers = 'Content-type: text/html';
                $res = mail($_POST['email'], $subject, $body, $headers);
                App::redirect('/user/login');
        }
    }

    public function activate() {
        $code = isset($this->params[0]) ? $this->params[0] : null;
        if ($code) {
            $this->model->activateUser($code);
            App::redirect('/user/login');
            $data['message'] = 'Your account verified, you can log in!';
            return (ROOT . '/views/user/login/');
        }
        exit();
    }

    public function logout() {
        Session::destroy();
    }
}
