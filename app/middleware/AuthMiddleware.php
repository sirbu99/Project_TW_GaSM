<?php


class AuthMiddleware
{

    const EXCLUDED_PAGES = [
        'home:index',
        'home:login',
        'home:register',
    ];

    public static function run($controller, $method)
    {
        $isLoogedIn = $_SESSION['LOGGED_IN'] ?? false;
        $myRoute = strtolower(get_class($controller) . ":" . $method);
        return  $isLoogedIn || in_array($myRoute, self::EXCLUDED_PAGES);
    }
}