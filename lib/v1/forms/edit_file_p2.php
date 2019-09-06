<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_file_p2 extends edit_file_p1
{
    public function define_form()
    {
        global $t;

        $fields= array();

        if ($_REQUEST['id_file']) {
            $fields[]= "id_file";
            $fields[]= "date_created";
            $fields[]= "file_status";
            $this->make_sections("hidden", 3);
        }

        $this->set_fields($fields);
    }
    
    
    
    
    
    public function start()
    {
    }
}
