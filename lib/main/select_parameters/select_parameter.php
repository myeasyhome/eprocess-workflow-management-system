<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class select_parameter extends selector
{
    public function config($option)
    {
        global $m, $q;
    
        parent::config();
    
        switch ($option) {
        
        case "country_id":
        $this->select_name=$option;
        $this->data_source="countries";
        $this->id_tag= "country_id";
        $this->label_tag= "country_name";
        $this->i_var['selected']=$m->country_id;

        break;
        
        case "town_id":
        $this->select_name=$option;
        $this->data_source="towns";
        $this->id_tag= "town_id";
        $this->label_tag= "town_name";
        $this->i_var['selected']=$m->town_id;

        break;
        
        case "subtown_id":
        $this->select_name=$option;
        $this->data_source="subtowns";
        $q->set_var("town_id", $m->town_id);
        $this->id_tag= "subtown_id";
        $this->label_tag= "subtown_name";
        $this->i_var['selected']=$m->subtown_id;
        
        break;
        
        }
    }
}
