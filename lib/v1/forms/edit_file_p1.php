<?php



class edit_file_p1 extends form_handler_member
{
    public function config()
    {
        global $c, $t, $q;


        parent::config();

        $this->has['update_data_from_global']= true;

        $this->i_var['input_size']= "100";
        $this->i_var['input_maxlength']= "100";

        $this->i_var['years_select']= "before";
        $this->i_var['max_years_select']= 10;
        $this->has['form']= false;
        $this->has['submit']= false;
    }

    
    
    
    
    
    public function define_form()
    {
        global $t;

        $fields= array();

        $fields[]= "title";
        $fields[]= "file_ref";
        $fields[]= "file_date";

        $this->make_sections("input_text", 3);

        $this->set_fields($fields);

        $this->field_param['file_date']['format']= "date";
    }
    
    
    
    
    
    public function start()
    {
        if ($this->data['file_date'] && !$this->has['update_data_from_global']) {
            $this->fields['file_date']= f1::custom_date($this->fields['file_date']);
        }
    }
}
