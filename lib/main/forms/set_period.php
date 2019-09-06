<?php



class set_period extends html_form
{
    public function config()
    {
        global $t, $q;

        parent::config();

        $this->i_var['input_size']= "12";
        $this->i_var['maxlength']= "12";


        $this->has['form']= false;
        $this->has['submit']= false;

        $this->has['update_data_from_global']= true;

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="start_date";
        $fields[]="end_date";

        $this->make_sections("input_text", 2);
        
        $this->set_fields($fields);

        $this->field_param['start_date']['format']= $this->field_param['end_date']['format']= "date";
    }
}
