<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class database_settings
{
    private static $host;
    private static $user;
    private static $password;
    private static $database;





    public static function set_database_options()
    {
        self::$host = "localhost";
        self::$user = "novisql1";
        self::$password = "fui4RKFKrjk5JL6";
        self::$database = "eprocessdb";
    }





    public static function get_host()
    {
        return self::$host;
    }



    public static function get_user()
    {
        return self::$user;
    }



    public static function get_password()
    {
        return self::$password;
    }



    public static function set_database()
    {
        return self::$database;
    }
}
