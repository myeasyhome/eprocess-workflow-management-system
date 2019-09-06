<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/





abstract class selector_from_array extends selector
{ // ceates a select menu from an array of values

    protected $list;





    public function config()
    {
        parent::config();
    
        $this->list= array();
    }
    
    
    
    
    
    
    public function set_list($array)
    {
        $this->list= $array;
    }

    
        
    
    
    
    public function display()
    {
        global $c, $s, $m, $t, $q, $u;


        if (count($this->list) >= $this->minimum_choices) {
            if ($this->has['form']) {
                $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
                echo $this->hidden_input;
            }
            

            echo "<span class=\"form_section\">";
            

            if (empty($this->select_name)) {
                f1::echo_error("no select_name in met#display, cls#selector_from_array");
            }
            
            echo "<select name=\"{$this->select_name}\" >";

                        
            
            if ($this->i_var['default']) {
                echo "<option value=\"0\">".$this->i_var['default']."</option>";
            }

        
            for ($i=0; $i < count($this->list); $i++) {
                if (!empty($this->list[$i][$this->id_tag])) {
                    $value= $this->list[$i][$this->id_tag];
                } else {
                    $value= $i;
                }
                

                if (!empty($this->list[$i][$this->label_tag])) {
                    $label= $this->list[$i][$this->label_tag];
                }

                //--------------------
                
                if ($this->i_var['selected'] === $this->list[$i][$this->id_tag]) {
                    $this->set_submit_input("active");
                
                    echo "<option value=\"{$value}\" selected >{$label}</option>";
                } else {
                    echo "<option value=\"{$value}\" >{$label}</option>";
                }
            }

            echo "</select>";

            echo "</span>";


            if ($this->has['submit']) {
                $this->display_submit($this->i_var['submit_name'], $this->i_var['submit_value'], $this->i_var['submit_wrap_tag']);
            }
            
            
            if ($this->has['form']) {
                echo "</form>";
            }
        }
    }
}
