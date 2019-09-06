<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_client_class_p1 extends form_handler_member
{
    public function config()
    {
        global $c, $t, $q;


        parent::config();

        $this->i_var['input_size']= "20";
        $this->i_var['input_maxlength']= "20";
    }

    
    
    
    
    
    public function define_form()
    {
        global $t;

        $fields= array();

        $fields[]= "start_scale";
        $fields[]= "start_work";
        $fields[]= "id_client";

        $this->ignore[]= "start_scale";
        $this->ignore[]= "start_work";

        $this->make_sections("input_text", 2);
        $this->make_sections("hidden", 1);

        $this->set_fields($fields);

        $this->field_param['start_scale']['format']= "date";
        $this->field_param['start_work']['format']= "date";

        $this->fields['id_client']= $_REQUEST['id_client'];
    }
    
    
    
    
    
    public function start()
    {
        if ($this->data['start_scale'] && (!$this->has['start_scale'] == "rejected")) {
            $this->fields['start_scale']= f1::custom_date($this->fields['start_scale']);
        }
        
        if ($this->data['start_work'] && (!$this->has['start_work'] == "rejected")) {
            $this->fields['start_work']= f1::custom_date($this->fields['start_work']);
        }
    }
}
