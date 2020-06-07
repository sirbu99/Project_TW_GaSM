<?php


class AuthMiddleware
{

    const EXCLUDED_PAGES = [
        'home:loginpage',
        'home:login',
        'home:register',
        'home:statistics',
        'home:page_404',
    ];

    public static function run($controller, $method)
    {
        $isLoggedIn = $_SESSION['LOGGED_IN'] ?? false;
        $myRoute = strtolower(get_class($controller) . ":" . $method);
        return  $isLoggedIn || in_array($myRoute, self::EXCLUDED_PAGES);
    }
}