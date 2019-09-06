<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_department extends selector
{
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();


        $this->select_name= "id_dept";

        $this->data_source="select_department1";

        $this->id_tag= "id_dept"; // default
$this->label_tag= "name_dept"; // default

$this->has['form']= false;
        $this->has['filter']= true;

        $this->default= $t->unknown;

        $this->minimum_choices= 1; //--default minimum
    }
    
    
    
    
    
    public function set_filter()
    {
        global $u, $m, $q;


        if ($this->option == "other") {
            $q->set_filter("id_dept <> '".$u->id_dept."'");
        } elseif ($this->option == "internal") {
            $q->set_filter("dept_type ='0'");
        } elseif ($this->option == "other_internal") {
            $q->set_filter("id_dept <> '".$u->id_dept."' AND dept_type ='0'");
        } elseif ($this->option == "external") {
            $q->set_filter("dept_type ='1'");
        }
    }
}
