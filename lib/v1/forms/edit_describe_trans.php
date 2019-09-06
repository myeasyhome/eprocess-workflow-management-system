<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_describe_trans extends html_form
{
    protected $selectors;

    
    
    
    
    

    public function config()
    {
        global $t, $q;

        parent::config();

        $this->i_var['textarea_rows']="2";
        $this->i_var['textarea_cols']="90";

        $this->define_form();
    }

    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
    
        $fields=array();

        $fields[]="describe_trans";

        $this->make_sections("textarea", 1);

        $this->set_fields($fields);


        if ($_REQUEST['describe_trans']) {
            $this->fields['describe_trans']= $_REQUEST['describe_trans'];
        }
    }
}
