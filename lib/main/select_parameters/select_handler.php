<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class select_handler extends html_form
{
    public function config($option="select_all")
    {
        global $c, $s, $m, $t;


        parent::config();

        $this->option= $option;

        //-----------------------------

        $this->i_var['form_method']="GET";

        $this->shelf= array();

        $this->shelf['select_country']= new select_parameter();
        $this->shelf['select_town']= new select_parameter();
        $this->shelf['select_subtown']= new select_parameter();

        $this->shelf['select_country']->initialize();
        $this->shelf['select_town']->initialize();
        $this->shelf['select_subtown']->initialize();

        $this->shelf['select_country']->config("country_id");
        $this->shelf['select_town']->config("town_id");
        $this->shelf['select_subtown']->config("subtown_id");

        $this->define_form();
    }
    
    
    
    
    
    
    public function define_form()
    {
        $fields=array();

        $fields[]="country_id";
        $fields[]="town_id";
        $fields[]="subtown_id";

        $this->set_fields($fields);

        $this->make_sections("object_section", 1);
        $this->make_sections("object_section", 1);
        $this->make_sections("object_section", 1);
    }
    
    
    
    
    
    public function onsubmit()
    {
    }
    
    
    
    
    
    public function set_data()
    {
        global $m, $q;


        $q->set_var("country_id", $m->country_id);
        $q->set_var("town_id", $m->town_id);
    
        //parent::set_data();

        switch ($this->option) {
                
        case "change_country":
        
            if ($m->country_id) {
                $this->shelf['select_country']->set_data();
                $this->add_select_object("country_id", $this->shelf['select_country']);
            }
        
        break;
        
        case "change_town":
        
            if ($m->town_id) {
                $this->shelf['select_town']->set_data();
                $this->add_select_object("town_id", $this->shelf['select_town']);
            }
        
        break;
        
        case "select_all":
        
            if (!$m->country_id) {
                $this->shelf['select_country']->set_data();
                $this->add_select_object("country_id", $this->shelf['select_country']);
            } elseif ($m->country_id && !$m->town_id) {
                $this->shelf['select_town']->set_data();
                $this->add_select_object("town_id", $this->shelf['select_town']);
            } elseif ($m->town_id) {
                $this->shelf['select_subtown']->set_data();
                $this->add_select_object("subtown_id", $this->shelf['select_subtown']);
            }
            
        break;
        
        }
        
        if (!($this->i_var['count_select_objects'] > 0)) {
            $this->has['submit']= false;
        }
    }
}
