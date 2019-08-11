<?php

class UserController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User();
    }

    public function login() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getUserByLogin($_POST['login']);
            $resolve = [];
            if (isset($user) && password_verify($_POST['password'], $user['password'])) {
                if ($user['verified'] == 1) {
                    Session::set('logged', $user['login']);
                    App::redirect('/');
                } else {
                    $code = hash('md5', uniqid());
                    $this->model->updateVerifyCode($user['login'], $code);
                    $this->sendVerifyCode($user['email'], $code);
                    // $data['message'] = 'Your account not verified, check your email again!';
                    // return (ROOT . '/views/user/login.php');
                    // App::redirect('/user/login');
                    // exit();
                    $resolve['message'] = 'Send on your email verify code.';
                    exit(json_encode($resolve));   
                }
            }
            $resolve['message'] = 'Invalid login or password.';
            exit(json_encode($resolve));
        }
    }

    public function register() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
                $checkLogin = $this->model->getUserByLogin($_POST['login']);
                $checkEmail = $this->model->getUserByEmail($_POST['email']);
                if (isset($checkLogin) || isset($checkEmail)) {
                    App::redirect('/');
                    // exit();
                }
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $code = hash('md5', uniqid());
                $this->model->addUser($_POST['login'], $hash, $_POST['email'], $code);
                $this->sendVerifyCode($_POST['email'], $code);
                // $data['message'] = 'Check your email to verified account';
                // return (ROOT . '/views/user/login.php');
                App::redirect('/user/login');
                // exit();
        }
    }

    public function activate() {
        $code = isset($this->params[0]) ? $this->params[0] : null;
        if ($code) {
            $this->model->activateUser($code);
            App::redirect('/user/login');
            // $data['message'] = 'Your account verified, you can log in!';
            // return (ROOT . '/views/user/login.php');
        }
        exit();
    }

    public function reset() {
        if (isset($this->params[0])) {
            $code = $this->params[0];
            $user = $this->model->getUserByVerifyCode($code);
            if ($user) {
                // App::redirect('/user/resetpw');
                Session::set('verifyCode', $code);
                Session::set('verifyUser', $user['login']);
                App::redirect('/user/resetpw');
            } else {
                App::redirect('/');
            }
            // exit();
        } else if ($_POST && isset($_POST['email'])) {
            $user = $this->model->getUserByEmail($_POST['email']);
            if (!isset($user)) {
                exit();
            }
            $code = hash('md5', uniqid());
            $this->model->updateVerifyCode($user['login'], $code);
            $this->sendResetCode($user['email'], $code);
            App::redirect('/user/login');
            // exit();
        }
    }

    public function resetpw() {
        $user = Session::get('verifyUser');
        $code = Session::get('verifyCode');
        if (!($user && $code)) {
            App::redirect('/user/login');
            // exit();
        }
        if ($_POST && $_POST['password']) {
            $this->model->updateVerifyCode($user, NULL);
            Session::delete('verifyUser');
            Session::delete('verifyCode');
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->model->updateUserPassword($user, $password);
            App::redirect('/user/login');
        }
    }

    public function logout() {
        Session::destroy();
    }

    private function sendResetCode($email, $code) {
        $link = 'http://localhost:8080/user/reset/' . $code . '/';
        $subject = 'Reset account password';
        $body = "
        Link to reset password:
            <a href='" . $link . "'>reset</a>
        ";
        $headers = 'Content-type: text/html';
        $res = mail($email, $subject, $body, $headers);
    }

    private function sendVerifyCode($email, $code) {
        $link = 'http://localhost:8080/user/activate/' . $code . '/';
        $subject = 'Verification account';
        $body = "
        Account activation link:
            <a href='" . $link . "'>activate</a>
        ";
        $headers = 'Content-type: text/html';
        $res = mail($email, $subject, $body, $headers);
    }
}
