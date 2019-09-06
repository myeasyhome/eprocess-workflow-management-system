<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/





class private_search_form extends form_handler_member
{
    public function config()
    {
        global $c, $t, $q;


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
        } elseif ($this->option == "dates") {
            $this->define_dates();
        } elseif ($this->option == "project") {
            $this->define_project();
        }
    }

    
    
    
    
    
    public function define_file()
    {
        global $t;

        $fields= array();

        $fields[]=$this->ignore[]= $this->is_numeric[]= "num_file";
        $fields[]=$this->ignore[]= "title";
        $fields[]=$this->ignore[]= "file_ref";

        $this->make_sections("input_text", 3);

        $this->set_fields($fields);
    }
    
    
    
    
    
    public function define_client()
    {
        global $t;

        $fields= array();
        $fields[]= "surname";
        $fields[]= "firstname";
        $fields[]= "date_birth";

        $this->ignore= $fields;


        $this->make_sections("input_text", 3);

        $this->set_fields($fields);

        $this->field_param['date_birth']['format']= "date";
    }
    
    
    
    
    
    public function define_dates()
    {
        global $t;

        $fields= array();

        $fields[]= "date_created";
        $fields[]= "month";
        $fields[]= "year";
        $fields[]= "file_date";

        $this->ignore= $fields;

        $this->make_sections("input_text", 4);

        $this->set_fields($fields);

        $this->field_param['date_created']['format']= "date";
        $this->field_param['month']['format']= "month";
        $this->field_param['year']['format']= "year";
        $this->field_param['file_date']['format']= "date";
    }
    
    
    
    
    public function define_project()
    {
        global $t;

        $fields= array();

        $fields[]=$this->ignore[]= $this->is_numeric[]= "id_proj";
        $fields[]=$this->ignore[]= "proj_ref";
        $fields[]=$this->ignore[]= "id_bordereau";


        $this->make_sections("input_text", 3);

        $this->set_fields($fields);
    }
}
