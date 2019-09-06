<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_project_p1 extends form_handler_member
{
    public function config()
    {
        global $c, $t, $q;


        parent::config();

        $this->i_var['input_size']= "40";
        $this->i_var['input_maxlength']= "40";

        $this->i_var['years_select']= "before";
        $this->i_var['max_years_select']= 10;
        $this->has['form']= false;
        $this->has['submit']= false;
    }

    
    
    
    
    
    public function define_form()
    {
        global $t, $m;

        $fields= array();


        $fields[]= "proj_ref";
        $this->make_sections("input_text", 1);

            
            
        if ($_REQUEST['id_file']) {
            $fields[]= "id_file";
            $this->make_sections("hidden", 1);
        }
            
        if ($_REQUEST['file_status']) {
            $fields[]= "file_status";
            $this->make_sections("hidden", 1);
        }
                        
        if ($_REQUEST['id_proj']) {
            $fields[]= "id_proj";
            $fields[]= "proj_dept";
            $fields[]= "date_created";
                
            $this->make_sections("hidden", 3);
        }
        

        $this->set_fields($fields);

        // Because of common_data_source option of the form handler
            
        $this->fields['id_file']= $_REQUEST['id_file'] ? $_REQUEST['id_file'] : null;
        $this->fields['file_status']= isset($_REQUEST['file_status']) ? $_REQUEST['file_status'] : null;
        $this->fields['id_proj']= $_REQUEST['id_proj'] ? $_REQUEST['id_proj'] : null;
    }
}
