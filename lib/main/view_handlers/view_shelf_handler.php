<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class view_shelf_handler
{
    protected $shelf;


    public function __construct()
    {
        $this->shelf= array();
    }
        
        
        
        
        
    public function start_objects($position="")
    {
        global $q;
            
        if ($position) {
            if (is_object($this->shelf[$position])) {
                $obj= &$this->shelf[$position];
                $obj->initialize();
                $obj->config();
                $obj->onsubmit();
                
                $obj->set_data();
                $obj->start();
            
                $q->clear("all"); // clean queries filter
            } else {
                f1::echo_warning("no object at position \"{$position}\" ".
                        "in met#start_objects, cls#view_shelf_handler");
            }
                
            return;
        }
            
        foreach ($this->shelf as $obj_position => $obj) {
            $this->start_objects($obj_position);
        }
    }
    
    
    
    
            
    public function __set($name, $obj_class)
    {
        if (is_string($name) && class_exists($obj_class)) {
            $this->shelf[$name]= new $obj_class();
        } else {
            f1::echo_warning("arg#name or #obj_class not valid in met#__set, cls#view_shelf_handler");
        }
    }
        
        
        
        
        
    public function __get($name)
    {
        if (is_object($this->shelf[$name])) {
            $this->shelf[$name]->display();
        } else {
            f1::echo_warning("no object to display at position \"{$name}\" in met#__get, cls#view_shelf_handler");
        }
    }
        
        
        
        
    public function use_method($name, $method)
    {
        if (is_object($this->shelf[$name])) {
            $this->shelf[$name]->$method();
        } else {
            f1::echo_warning("no object at position \"{$name}\" in met#use_method, cls#view_shelf_handler");
        }
    }
        
        
        
    public function has($name)
    {
        if (is_object($this->shelf[$name])) {
            return true;
        }
    }
        
        
        
        
    public function display_window(&$msg_obj)
    {
        if (is_object($this->shelf['window'])) {
            $this->shelf['window_menu']= is_object($this->shelf['window_menu']) ? $this->shelf['window_menu'] : null;
            
            window::display($this->shelf['window_menu'], $this->shelf['window'], $msg_obj);
        }
    }
}
