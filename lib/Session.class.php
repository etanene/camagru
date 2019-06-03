<?php

class Session {
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset ($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_destroy();
        App::redirect('/user/login');
    }
}
