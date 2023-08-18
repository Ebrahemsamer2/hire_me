<?php 

namespace Models;

class Session 
{   
    public static function add($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function start()
    {
        if(session_status() === PHP_SESSION_NONE) 
            session_start();
    }

    public static function checkLogin()
    {
        if(session_status() === PHP_SESSION_NONE) 
            session_start();

        return isset($_SESSION['user']);
    }

    public static function destroy()
    {
        if(session_status() === PHP_SESSION_NONE) 
            session_start();

        foreach($_SESSION as $key => $value)
            unset($_SESSION[$key]);
        
        session_destroy();
    }
}