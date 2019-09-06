<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class text_controller
{
    protected $t;
    protected $i_var;
    protected $text_shelf;
    protected static $has;
    
    
    
    
    
    public function __construct()
    {
        $this->initialize();
        $this->config();
    }
    
    
    
    
    
    

    private function initialize()
    {
        $this->t= array();
        $this->i_var= array();
        $this->text_shelf= array();
        self::$has=array();
    }
    
    
    
    
    
    
    
    private function config()
    {
        global $c, $s, $m, $t, $q, $u;


        if (!self::$has['text_classes']) {
        
//----------------------------

            $error_msg= FATAL_MSG." Error txco_tcnf";

            //-----------------------------
        
            $this->text_shelf= $s->set_text_classes();

            $prefix= array();

            $this->text_shelf= $s->set_text_classes();

    
            for ($i=0; $i < count($this->text_shelf); $i++) {
                $list= explode(">>", $this->text_shelf[$i]);
            
                $this->text_shelf[$i]= $list[0];
                $file= $list[0].".php";
                $prefix= $list[1];
            
                $c->insert_file($file, $prefix, $error_msg);
            }
            
            //--------------------------

            if (empty($this->text_shelf)) {
                f1::echo_error("empty text_shelf, in #met #config, #cls #text_controller");
                exit;
            } else {
                self::$has['text_classes']= true;
            }
        }
    }
    
    
    
    
    
    
    public function __get($name)
    {
        global $f;
    
        if (isset($this->t[$name])) {
            return $this->t[$name];
        } else {
            f1::echo_warning("no text for: ".$name."!");
        }
    }
    
    
    
    
    
    
    public function load_text()
    {
        for ($i=0; $i < count($this->text_shelf); $i++) {
            if (class_exists($this->text_shelf[$i])) {
                $obj= new $this->text_shelf[$i]();
            } else {
                echo FATAL_MSG." Error txco_notxcl";
                exit;
            }
    
            $obj->set_var($this->i_var);
        
            $obj->call_set_text();
    
            $text= $obj->get_text();

            if (is_array($text)) {
                $this->t= array_merge($this->t, $text);
            } else {
                f1::echo_error("array type error in #cls #text_controller,
							#met #load_text");
            }
        
            unset($obj);
        }
    }
    
    
    
    
    

    public function set_var($name, $value, $refresh= true)
    {
        if ($name) {
            $this->i_var[$name]= $value;
        } else {
            echo_error("invalid #name, in met#set_var, cls#text_controller");
        }
        
        if ($refresh === true) {
            $this->load_text();
        }
        
        if (!is_bool($refresh)) {
            f1::echo_error("#var refresh is not a boolean, in #met set_var, #cls text_controller");
        }
    }
    
    
    
    
    
    
    
    protected function get_var($name= "")
    {
        return (isset($this->i_var[$name])) ? $this->i_var[$name] : "";
    }
    
    
    
    
    
    private function add_to_text_shelf($name)
    {
        $this->text_shelf[]= $name;
    }
}
