<?php



class form1 extends html_form
{
    public function config()
    {
        parent::config();

        $this->set_title("form", "h2");

        $this->define_form();
    }
    
    
    
    
    
    
    public function define_form()
    {
        $fields=array();

        $fields[]="username";
        $fields[]="message";
        $fields[]="text";
        $fields[]="password";

        $this->set_fields($fields);

        $this->ignore[]="message";

        $this->make_sections("input_text", 1);
        $this->make_sections("textarea", 2);
        $this->make_sections("input_text", 1);
    }
}
