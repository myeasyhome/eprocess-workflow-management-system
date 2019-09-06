<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_project_status extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->data_source="select_project_status1";

        $this->select_name="id_proj_status";
        $this->id_tag= "id_proj_status"; // default
$this->label_tag= "name_proj_status"; // default

$this->has['submit']= false;
        $this->has['form']= false;
    }
}
