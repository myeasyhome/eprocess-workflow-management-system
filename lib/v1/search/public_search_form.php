<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/





class public_search_form extends form_handler_member
{
    public function config()
    {
        global $m, $c, $t, $q;


        parent::config();

        $this->has['update_data_from_global']= true;

        $this->i_var['input_size']= "45";
        $this->i_var['input_maxlength']= "45";

        $this->i_var['years_select']= "before";
        $this->i_var['max_years_select']= 10;
        $this->has['form']= false;
        $this->has['submit']= false;

        //-------------------------------------------------------------

        if ($this->option == "file") {
            $this->define_file();
        } elseif ($this->option == "client") {
            $this->define_client();
        } elseif ($this->option == "project") {
            $this->define_project();
        }
        
        $m->no_print_button= true;
    }

    
    
    
    
    
    public function define_file()
    {
        global $t;

        $fields= array();

        $fields[]=$this->is_numeric[]= "num_file";

        $this->make_sections("input_text", 1);

        $this->set_fields($fields);
    }
    
    
    
    
    
    public function define_client()
    {
        global $t;

        $fields= array();
        $fields[]= "surname";
        $fields[]="firstname";
        $fields[]=$this->ignore[]="date_birth";

        $this->make_sections("input_text", 3);

        $this->set_fields($fields);

        $this->field_param['date_birth']['format']= "date";
    }
    
    
    
    
    public function define_project()
    {
        global $t;

        $fields= array();

        $fields[]=$this->ignore[]= $this->is_numeric[]= "id_proj";
        $fields[]=$this->ignore[]= "id_bordereau";

        $this->make_sections("input_text", 2);

        $this->set_fields($fields);
    }
}
