<?php





/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




abstract class form_handler extends html_form_adapter
{
    protected $forms;
    
    
    
    public function initialize()
    {
        parent::initialize();
    
        $this->forms= array();
        $this->fields= array();
    }
    
    
    
    
    
    public function initialize_forms()
    {
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->initialize();
        }
    }
    
    
    
    
    
    public function set_form_name($value)
    {
        $this->i_var['form_name']= $value;
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->set_form_name($value);
        }
    }
    
    
    
    
    public function initialize_global_var($name="REQUEST")
    {
        parent::initialize_global_var($name);
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->initialize_global_var($name);
        }
    }
    
    
    
    
    public function set_has($name, $value)
    {
        $this->has[$name]=$value;
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->set_has($name, $value);
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
    
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->set_is($name, $value);
        }
    
        if ($value === false) {
            $string= "#false";
        } else {
            $string= "{$value}";
        }
    
        f1::echo_comment("#is option {$name} set to {$string} in #cls ".get_class($this));
    }
    
    
    
    
    
    public function add($key, &$form)
    {
        $this->forms[$key]= $form;
    }
    
    
    
    
    
        
    public function set_var($name, $value)
    {
        if (in_array($name, $this->i_var['writable_var_list'])) {
            $this->i_var[$name]= $value;
        
            for ($i=0; $i < count($this->forms); $i++) {
                $this->forms[$i]->set_var($name, $value);
            }
        } else {
            f1::echo_error("#var is not writable, in #met #set_var, #cls form_handler");
        }
    }
    
        
    
    
    
    
    public function config()
    {
        global $c, $s, $m, $u, $q, $t;

        parent::config();

        $this->has['common_data_source']= true;

        //----------------------------------------------------------------

        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->config();
            $this->fields= array_merge($this->fields, $this->forms[$i]->get_fields());
            $this->fields_list= array_merge($this->fields_list, $this->forms[$i]->get_fields_list());
            $this->ignore= array_merge($this->ignore, $this->forms[$i]->get_ignore());
        }
    }
    
    
    
    
    
    
    public function is_validated()
    {
        $failed;
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->set_form_name($this->i_var['form_name']);

            if (!$this->forms[$i]->is_validated()) {
                $failed= true;
            }
        }
        
        $validated= !$failed ? true : false;
        
        return $validated;
    }
        
    
    
    
    
    
    public function onsubmit()
    {
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->onsubmit();
        }
    }
    
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        if ($this->has['common_data_source']) {
            parent::set_data($name, $value);

            if ($this->data) {
                for ($i=0; $i < count($this->forms); $i++) {
                    $this->forms[$i]->set_has("update_data_from_global", $this->has['update_data_from_global']);
                    $this->forms[$i]->set_data("all_data", $this->data);
                }
            }
        } else {
            for ($i=0; $i < count($this->forms); $i++) {
                $this->forms[$i]->set_data();
            }
        }
    }
    
    
    
    
    
    
    
    public function start()
    {
        parent::start();
    
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->set_subject($this->subject);
            $this->forms[$i]->start();
        }
    }
    
    
    
    
    
    public function display_skeleton()
    {
        for ($i=0; $i < count($this->forms); $i++) {
            $this->forms[$i]->display();
        }
    }
    
    
    
    
    
    public function display()
    {
        global $c, $s, $m, $u, $q, $t;

    

        if ($this->has['form']) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        }
    
    
        if (($this->selected || $this->id) && $_REQUEST["ask_delete_".$this->subject]) {
            $this->ask_delete();
        }
    

        $this->display_skeleton();

        if ($this->has['submit']) {
            $this->display_submit($this->i_var['submit_name'], $this->i_var['submit_value'], $this->i_var['submit_wrap_tag']);
        }
        
        if ($this->has['form']) {
            echo "</form>";
        }
    }
}
