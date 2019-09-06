<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_client_class_p2 extends edit_client_class_p1
{
    public function config()
    {
        global $c, $t, $q;

        parent::config();

        $this->i_var['input_size']= "60";
        $this->i_var['input_maxlength']= "60";
    }
    
    
    
    
    
    
    public function define_form()
    {
        global $t;

        $fields= array();

        $fields[]= $this->ignore[]= "option_qual";

        $fields[]= $this->ignore[]= "origin_qual";

        $this->make_sections("input_text", 2);

        $this->set_fields($fields);
    }
    
    
    
    
    public function start()
    {
    }
}
