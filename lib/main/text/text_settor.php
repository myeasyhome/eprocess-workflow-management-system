<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




abstract class text_settor extends website_object
{
    protected $t;
    protected $i_var;
    
    
    

    public function initialize()
    {
        parent::initialize();
    
        $this->t= array();
    }
    


    
    
    
    public function set_var(&$i_var)
    {
        if (is_array($i_var)) {
            $this->i_var= &$i_var;
        } else {
            f1::echo_error("#i_var not an array in met#set_var, cls#text_settor");
        }
    }
    
    
    
    
    
    
    
    public function call_set_text()
    {
        $this->set_text($this->t);
    }
    
    
    
    
    
    
    
    protected function set_text(&$t)
    {
    }
    
    
    
    

    public function get_text()
    {
        if ($this->t) {
            return $this->t;
        }
    }
}
