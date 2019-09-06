<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_project_type extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->data_source="select_project_type1";

        $this->select_name="id_proj_type";
        $this->id_tag= "id_proj_type"; // default
$this->label_tag= "name_proj_type"; // default

$this->has['submit']= false;
        $this->has['form']= false;
        $this->has['filter']= true;
    }
    
    
    
    
    public function set_filter()
    {
        global $u, $q;


        $q->set_filter("id_dept='".$u->id_dept."' OR id_dept=0");
    }
}
