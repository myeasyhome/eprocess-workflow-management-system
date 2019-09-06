<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_transfer_status extends html_form
{
    public function config()
    {
        global $t, $q;

    
        parent::config();

        $this->reference= $this->i_var['form_name']= "transfer_project_status";

        $this->set_title($t->transfer_status, "h2");

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $m, $u, $t;
    
        $fields=array();

        $fields[]="transfer_status";

        $this->make_sections("combo", 1);
    
        $this->add_select_array("transfer_status", $s->transfer_status_list);
    }
}
