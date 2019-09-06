<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_carrier extends selector
{
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->select_name= "id_carrier";

        $this->data_source="select_carrier1";

        $this->id_tag= "id_carrier";
        $this->label_tag= "name";

        $this->has['form']= false;
        $this->has['filter']= true;


        $this->default= $t->unknown;
    }
    
    
    
    
        
    
    public function set_filter()
    {
        global $u, $m, $q;


        if ($this->option == "other") {
            $q->set_filter("id_dept='".$u->id_dept."'");
        }
    }
    
    
    
    
    
    public function validate_data()
    {
        if ($this->data) {
            $this->data['name']= $this->data['surname']." ".$this->data['firstname'];
        }
    }
}
