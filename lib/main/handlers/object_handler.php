<?php





/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




abstract class object_handler extends website_object
{
    protected $objs;
    
    
    
    public function initialize()
    {
        parent::initialize();
    
        $this->objs= array();
    }
    
    
    
    
    
    public function initialize_objs()
    {
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->initialize();
        }
    }
    
    
    
    
    
    public function add($key, &$obj)
    {
        $this->objs[$key]= $obj;
    }
    
    
    
    
    
    
    public function set_form_name($value)
    {
        $this->i_var['form_name']= $value;
    
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->set_form_name($value);
        }
    }
    
    
    
    
    
    
    public function set_has($name, $value)
    {
        $this->has[$name]=$value;
    
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->set_has($name, $value);
        }
    
        if ($value === false) {
            $string= "#false";
        } else {
            $string= "{$value}";
        }
    
        f1::echo_comment("#has option {$name} set to {$string} in #cls ".get_class($this));
    }
    
    
    
    
    
    
    public function set_is($name, $value)
    {
        $this->is[$name]=$value;
    
    
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->set_is($name, $value);
        }
    
        if ($value === false) {
            $string= "#false";
        } else {
            $string= "{$value}";
        }
    
        f1::echo_comment("#is option {$name} set to {$string} in #cls ".get_class($this));
    }
    
    
    
    
    
        
    public function set_var($name, $value)
    {
        if (in_array($name, $this->i_var['writable_var_list'])) {
            $this->i_var[$name]= $value;
        
            for ($i=0; $i < count($this->objs); $i++) {
                $this->objs[$i]->set_var($name, $value);
            }
        } else {
            f1::echo_error("#var is not writable, in met#set_var, cls#object_handler");
        }
    }
    
        
    
    
    
    
    public function config()
    {
        global $c, $s, $m, $u, $q, $t;

        $this->has['common_data_source']= true;

        //----------------------------------------------------------------

        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->config();
        }
    }
    
    
    
    
    
    public function onsubmit()
    {
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->onsubmit();
        }
    }
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        if ($this->has['common_data_source']) {
            parent::set_data($name, $value);

            if ($this->data) {
                for ($i=0; $i < count($this->objs); $i++) {
                    $this->objs[$i]->set_data("all_data", $this->data);
                }
            }
        } else {
            for ($i=0; $i < count($this->objs); $i++) {
                $this->objs[$i]->set_data();
            }
        }
    }
    
    
    
    
    
    
    
    public function start()
    {
        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->start();
        }
    }

    
    

    
    
    
    public function display()
    {
        global $c, $s, $m, $u, $q, $t;


        for ($i=0; $i < count($this->objs); $i++) {
            $this->objs[$i]->display();
        }
    }
}
