<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class database_connection_controller
{
    private $dbhost;
    private $dbuser;
    private $dbpassword;
    private $dbdatabase;





    public function __construct()
    {
        database_settings::set_database_options();

        $this->dbhost = database_settings::get_host();
        $this->dbuser = database_settings::get_user();
        $this->dbpassword = database_settings::get_password();
        $this->dbdatabase = database_settings::set_database();
    }






    public function connect()
    {
        try {
            $db = mysql_connect($this->dbhost, $this->dbuser, $this->dbpassword);

            if (!$db) {
                throw new Exception();
            }
        } catch (Exception $e) {
            exit("Could not connect: ".mysql_error());
        }


        try {
            $select= mysql_select_db($this->dbdatabase, $db);

            if (!$select) {
                throw new Exception();
            }
        } catch (Exception $e) {
            exit("Could not find selected database". mysql_error());
        }
    }
}
