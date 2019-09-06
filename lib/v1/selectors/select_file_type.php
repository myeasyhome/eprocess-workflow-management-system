<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_file_type extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->select_name= "id_file_type";

        $this->data_source="select_file_type1";

        $this->id_tag= "id_file_type"; // default
$this->label_tag= "name_type"; // default

$this->has['submit']= false;
        $this->has['form']= false;
    }
}
