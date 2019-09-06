<?php



class contact_us extends websitemail
{
    protected $contact_data;
        

    
    
    
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;




        parent::config();

        //---Default values------------------------------------


        $this->i_var['submit_name']= "send_mail";
        $this->i_var['submit_value']= $t->send_mail;

        $this->i_var['form_name']= "contact_us";

        $this->has['update_data_from_global']= true;

        $this->i_var['target_url']= $s->root_url."?view=contact_us";

        $this->i_var['input_size']=40;
        $this->i_var['input_maxlength']=40;
        $this->i_var['textarea_rows']=10;
        $this->i_var['textarea_cols']=50;


        $this->i_var['form_method']= "POST";

        $this->has['form']= true; // default
$this->has['submit']= true; // default

$this->define_form();
    }
    
    
    
    public function define_form()
    {
        $fields= array();

        $fields[]= "name";
        $fields[]= "country";
        $fields[]= "town";
        $fields[]= "email";
        $fields[]= "confirm_email";
        $fields[]= "title_subject";
        $fields[]= "message";
        $fields[]= "telephone";

        $this->ignore= array();
        $this->ignore[]= "telephone";


        $this->make_sections("input_text", 1);
        $this->make_sections("select_country", 1);
        $this->make_sections("input_text", 4);
        $this->make_sections("textarea", 1);
        $this->make_sections("input_text", 1);
        //----------------
    
        $this->i_var['fields']= $fields;
        $this->set_fields($this->i_var['fields']);
    }
    

    
    
    

    public function display()
    {
        global $c, $s, $m, $t, $q, $u;

    
            

        echo "<div class=\"contact_us\" >";
        
        
        $this->title= null;



        if ($_REQUEST['form_name'] !== $this->i_var['form_name']) {
            echo <<<HTML

<div class="form_intro" >

{$t->please_use_form_to_contactus}
	
{$t->form_info_with_sign}

</div>

HTML;
        }

        //----------------------

        parent::display();

        echo "</div>";
    }
}
