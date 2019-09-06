<?php



class search_engine
{
    public static function select_files_data_source()
    {
        if ($_GET['id_proj'] || $_GET['proj_ref'] || $_GET['id_bordereau']) {
            $source= "search3";
        } elseif ($_GET['surname'] || $_GET['firstname'] || $_GET['date_birth']) {
            $source= "search2";
        } else {
            $source= "search1";
        }
    
        return $source;
    }
    
    
    
    
    
    
        
    public static function select_projects_data_source()
    {
        if ($_GET['surname'] || $_GET['firstname'] || $_GET['date_birth']) {
            $source= "search_project2";
        } else {
            $source= "search_project1";
        }
    
        return $source;
    }
}
