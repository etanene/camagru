<?php

class UserController extends Controller {
    public function __construct() {
        $this->model = new User();
    }

    public function login() {
    }

    public function register() {
        
    }

    public function logout() {
        Session::destroy();
    }
}
