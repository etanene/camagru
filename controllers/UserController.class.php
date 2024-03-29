<?php

class UserController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->model = new User();
    }

    public function login() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $_POST['login'] = htmlentities($_POST['login']);
            $_POST['password'] = htmlentities($_POST['password']);
            $user = $this->model->getUserByLogin($_POST['login']);
            $resolve = [];
            if (isset($user) && password_verify($_POST['password'], $user['password'])) {
                if ($user['verified'] == 1) {
                    Session::set('logged', $user['login']);
                    App::redirect('/');
                } else if ($user['verification_code']) {
                    $resolve['message'] = 'Check your email for verify account';
                } else {
                    $code = hash('md5', uniqid());
                    $this->model->updateVerifyCode($user['login'], $code);
                    $this->sendVerifyCode($user['email'], $code);
                    $resolve['message'] = 'Send on your email verify account link.';
                }
            } else {
                $resolve['message'] = 'Invalid login or password.';
            }
            exit(json_encode($resolve));
        }
    }

    public function register() {
        if ($_POST && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
            $_POST['login'] = htmlentities($_POST['login']);
            $_POST['password'] = htmlentities($_POST['password']);
            $_POST['confirmpassword'] = htmlentities($_POST['confirmpassword']);
            $_POST['email'] = htmlentities($_POST['email']);
            $resolve = [];
            if (!$this->validateLogin($_POST['login'])) {
                $resolve['message'] = 'Invalid login.';
            } else if (!$this->validatePassword($_POST['password'])) {
                $resolve['message'] = 'Invalid password.';
            } else if (!$this->validateEmail($_POST['email'])) {
                $resolve['message'] = 'Invalid email.';
            } else if ($_POST['password'] != $_POST['confirmpassword']) {
                $resolve['message'] = 'Passwords do not match!';
            } else {
                $checkLogin = $this->model->getUserByLogin($_POST['login']);
                $checkEmail = $this->model->getUserByEmail($_POST['email']);
                if (isset($checkLogin)) {
                    $resolve['message'] = 'This login is already used.';
                } else if (isset($checkEmail)) {
                    $resolve['message'] = 'This email is already used.';
                } else {
                    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $code = hash('md5', uniqid());
                    $this->model->addUser($_POST['login'], $hash, $_POST['email'], $code);
                    $this->sendVerifyCode($_POST['email'], $code);
                    $resolve['message'] = 'Send on your email verify account link.';
                }
            }
            exit(json_encode($resolve));
        }
    }

    public function activate() {
        $code = isset($this->params[0]) ? $this->params[0] : null;
        if ($code) {
            $this->model->activateUser($code);
            App::redirect('/user/login');
        }
        exit();
    }

    public function reset() {
        if (isset($this->params[0])) {
            $code = $this->params[0];
            $user = $this->model->getUserByVerifyCode($code);
            if ($user) {
                Session::set('verifyCode', $code);
                Session::set('verifyUser', $user['login']);
                App::redirect('/user/resetpw');
            }
        } else if ($_POST && isset($_POST['email'])) {
            $_POST['email'] = htmlentities($_POST['email']);
            $resolve = [];
            $user = $this->model->getUserByEmail($_POST['email']);
            if (!isset($user)) {
                $resolve['message'] = 'No users with this email.';
                
            } else {
                $code = hash('md5', uniqid());
                $this->model->updateVerifyCode($user['login'], $code);
                $this->sendResetCode($user['email'], $code);
                $resolve['message'] = 'Send on your email reset passwort link.';
            }
            exit(json_encode($resolve));
        }
    }

    public function resetpw() {
        $user = Session::get('verifyUser');
        $code = Session::get('verifyCode');
        if (!($user && $code)) {
            App::redirect('/user/login');
        }
        if ($_POST && $_POST['password']) {
            $_POST['password'] = htmlentities($_POST['password']);
            $_POST['confirmpassword'] = htmlentities($_POST['confirmpassword']);
            $resolve = [];
            if (!$this->validatePassword($_POST['password'])) {
                $resolve['message'] = 'Invalid password.';
                exit(json_encode($resolve));
            } else if ($_POST['password'] != $_POST['confirmpassword']) {
                $resolve['message'] = 'Passwords do not match!';
                exit(json_encode($resolve));
            }
            $this->model->updateVerifyCode($user, NULL);
            Session::delete('verifyUser');
            Session::delete('verifyCode');
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->model->updateUserPassword($user, $password);
            App::redirect('/user/login');
        }
    }

    public function settings() {
        if (!Session::get('logged')) {
            App::redirect('/user/login');
        }
        if (isset($this->params) && $_POST) {
            switch ($this->params[0]) {
                case 'changepasswd':
                    $this->changePassword(
                        $_POST['oldpasswd'],
                        $_POST['newpasswd'],
                        $_POST['confirmpasswd']);
                    break ;
                case 'changeemail':
                    $this->changeEmail($_POST['newemail']);
                    break ;
                case 'changelogin':
                    $this->changeLogin($_POST['newlogin']);
                    break ;
                case 'notification':
                    $this->setNotification($_POST['notice']);
                    break ;
            }
        } else {
            $user = $this->model->getUserByLogin(Session::get('logged'));
            if ($user['notice']) {
                $this->data['checked'] = true;
            } else {
                $this->data['checked'] = false;
            }
        }
    }

    public function profile() {
        if (isset($this->params[0])) {
            $this->data['user'] = $this->params[0];
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

    private function validateLogin($login) {
        return preg_match('/^[A-Za-z\d]{4,12}$/', $login);
    }

    private function validatePassword($passwd) {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{4,12}$/', $passwd);
    }

    private function validateEmail($email) {
        return preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $email);
    }

    private function changePassword($oldpasswd, $newpasswd, $confirmpasswd) {
        $oldpasswd = htmlentities($oldpasswd);
        $newpasswd = htmlentities($newpasswd);
        $confirmpasswd = htmlentities($confirmpasswd);
        $user = $this->model->getUserByLogin(Session::get('logged'));
        $resolve = [];
        
        if (password_verify($oldpasswd, $user['password'])) {
            if ($newpasswd === $confirmpasswd) {
                if ($this->validatePassword($newpasswd)) {
                    $password = password_hash($newpasswd, PASSWORD_DEFAULT);
                    $this->model->updateUserPassword($user['login'], $password);
                    $resolve['message'] = 'Password changed!';
                } else {
                    $resolve['message'] = 'Not valid new password!';
                }
            } else {
                $resolve['message'] = 'New and confirm passwords do not match!';
            }
        } else {
            $resolve['message'] = 'Incorrect current password!';
        }
        exit(json_encode($resolve));
    }

    private function changeEmail($newemail) {
        $newemail = htmlentities($newemail);
        $resolve = [];

        if (!$this->model->getUserByEmail($newemail)) {
            if ($this->validateEmail($newemail)) {
                $this->model->updateUserEmail(Session::get('logged'), $newemail);
                $resolve['message'] = 'Email changed!';
            } else {
                $resolve['message'] = 'Not valid new email!';
            }
        } else {
            $resolve['message'] = 'This email already used!';
        }
        exit(json_encode($resolve));
    }

    private function changeLogin($newLogin) {
        $newLogin = htmlentities($newLogin);
        $resolve = [];

        if (!$this->model->getUserByLogin($newLogin)) {
            if ($this->validateLogin($newLogin)) {
                $this->model->updateUserLogin(Session::get('logged'), $newLogin);
                Session::set('logged', $newLogin);
                $resolve['message'] = 'Login changed!';
            } else {
                $resolve['message'] = 'Not valid login!';
            }
        } else {
            $resolve['message'] = 'This login already used!';
        }
        exit(json_encode($resolve));
    }

    private function setNotification($notice) {
        $this->model->updateUserNotice(Session::get('logged'), $notice);
        exit();
    }
}
