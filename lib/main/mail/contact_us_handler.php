<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class contact_us_handler extends website_object
{
    protected $contact_obj;



    public function __construct()
    {
        $this->contact_obj= new contact_us();
    }
    
    
    
    


    
    public function initialize()
    {
        parent::initialize();
        $this->contact_obj->initialize();
    }
    
    
    
    
    
    
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;



        $this->data_source="website_text";

        $text_ref= "contact_us";

        if (empty($text_ref)) {
            $this->throw_msg("fatal_error", "invalid_request", "#met #config, 
						#cls #contact_us handler, no text_ref");

            return;
        } else {
            $q->set_var("text_ref", $text_ref);
            $q->set_limit(" LIMIT 1");
        }
        
        $this->contact_obj->config();
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        parent::onsubmit();
        $this->contact_obj->onsubmit();
    }
    
    
    
    
    
    public function set_data()
    {
        parent::set_data();
        $this->contact_obj->set_data();
    }
    
    
    
    
    
    
    public function display()
    {
        if (!$this->is['displayable']) {
            return;
        }
    
    
        echo <<<HTML

<h1 class="title">{$this->data['title']}</h1>

{$this->data['body']}

HTML;

        $this->contact_obj->display();
    }
}
