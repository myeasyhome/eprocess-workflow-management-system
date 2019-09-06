<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_class extends form_handler_member
{
    protected $selectors;




    public function initialize()
    {
        global $c, $t;


        parent::initialize();
    }

    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;

        $fields=array();

        $fields[]="scale";
        $fields[]="work_class";
        $fields[]="echelon";
        $fields[]= $this->is_numeric[]= "work_index";

        $this->make_sections("select_number", 3);
        $this->make_sections("input_text", 1);


        if ($this->id && !$_REQUEST["yes_delete_".$this->subject]) {
            $fields[]="id_class";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        if ($this->id) {
            $this->fields['id_class']= $this->id;
        }


        $this->config_select_number("scale", 1, 3);
        $this->config_select_number("work_class", 1, 3);
        $this->config_select_number("echelon", 1, 3);
    }
}
