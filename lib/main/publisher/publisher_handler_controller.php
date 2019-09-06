<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class publisher_handler_controller extends website_object
{
    private $handler;


    public function initialize()
    {
        if (isset($_SESSION['publisher_handler'])) {
            $this->handler= $_SESSION['publisher_handler'];
        } else {
            $this->handler= new publisher_handler();
        }
    }
    
    
    

    
    public function config()
    {
        $this->handler->config();
    }
    
    
    
    
    public function set_data()
    {
        $this->handler->set_data();
    }
    
    
    
    
    
    public function display()
    {
        $this->handler->display();
    }
}
