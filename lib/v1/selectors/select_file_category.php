<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_file_category extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->select_name= "id_file_cat";

        $this->data_source="select_file_category1";

        $this->select_name= "id_file_cat";
        $this->id_tag= "id_file_cat"; // default
$this->label_tag= "name_cat"; // default

$this->has['submit']= false;
        $this->has['form']= false;
    }
}
