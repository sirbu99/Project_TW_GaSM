<?php


class RolesMiddleware
{
    const ADMIN_PAGES = [
       // 'api:insertdata',
        'api:insertevent',
        'api:deleteEvent',
    ];

    public static function run($controller, $method)
    {
        $myRoute = strtolower(get_class($controller) . ":" . $method);
        if (in_array($myRoute, self::ADMIN_PAGES) && empty($_SESSION['IS_ADMIN'])) {
            return false;
        }
        return true;
    }
}