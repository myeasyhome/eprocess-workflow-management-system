<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class client_class_handler extends object_handler
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        
        $this->set_title($t->client_class);

        $this->has['title']= true;

        $this->objs[0]= new list_client();
        $this->objs[1]= new list_class();

        $this->initialize_objs();

        $this->objs[0]->set_option("view_one");
        $this->objs[1]->set_option("client_class");
    }
    
    
    
    
    public function config()
    {
        parent::config();

        $this->has['common_data_source']= false;

        $this->has("submit", false);
        $this->has("form", false);
    }

    
    
    
    
    public function display()
    {
        global $t;
    
    
        echo <<<HTML
<div>
HTML;

        $this->objs[0]->display();

        echo "</div>";


        echo <<<HTML
<div>
HTML;

        $this->objs[1]->display();

        echo "</div>";
    }
}
