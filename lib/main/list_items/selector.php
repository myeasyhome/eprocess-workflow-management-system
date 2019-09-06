<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




abstract class selector extends list_items
{ // creates a select list from an sql query resource


    protected $select_name; // name of html select...

    protected $default;

    protected $active;

    protected $submit_name;

    protected $submit_value;

    protected $minimum_choices;

    protected $select_properties;



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;


        $this->i_var['form_name']= "selector_form";
        $this->i_var['form_method']= "GET";

        $this->i_var['submit_name']= "submit";
        $this->i_var['submit_value']= $t->submit;
        $this->i_var['submit_wrap_tag']="div";


        $this->selected="";
        $this->default="";

        $this->data_source="";

        $this->id_tag= "id"; // default

        $this->minimum_choices= 1; //--default minimum

        $this->set_submit_input(); // default

        $this->hidden_input= "";

        $this->no_result_msg= $t->empty_section;
    }
    

    
    
    
    
    
    
    public function set_select_name($string)
    {
        $this->select_name= $string;
    }
    
    
    
    
    
    public function set_select_properties($string)
    {
        $this->select_properties= $string;
    }
    
    
    
    

    public function set_case($option)
    {
        global $c, $s, $m, $t, $q, $u;



        $this->option= $option;
    }
    
    
    
    
    
    
    
    public function set_hidden_input($value)
    {
        $this->hidden_input= $value;
    }
    
    
    
    
    
    
    
    public function set_has_submit($value)
    {
        if ($value === true) {
            $this->has[]= "submit";
        } else {
            delete_array_value($this->has, "submit");
        }
    }
    
    
    
    
    
    
    
    
    public function set_submit_input($option= "standard")
    {
        global $c, $s, $m, $t, $q, $u;



        if ($this->has['form']) {
            switch ($option) {
    
case "standard":

$this->i_var['submit_name']= "submit";
$this->i_var['submit_value']= $t->select;

break;


case "active":

$this->i_var['submit_name']= "submit";
$this->i_var['submit_value']= $t->change;

break;
    
            }
        }
    }
    
    
    
    
    
    
    
    
    public function set_minimum_choices($value)
    {
        $this->minimum_choices= $value;
    }
    
    
    
    
    
    
    
    public function set_var($name, $value)
    {
        if (!isset($this->i_var[$name])) {
            $this->i_var[$name]= $value;
        }
    }
    
    
    
    
    
    
    
    public function get_var($name)
    {
        if (isset($this->i_var[$name])) {
            return $this->i_var[$name];
        }
    }
    
    
    
    
    
    
    
    
    public function set_selected($value)
    {
        if ($value || ($value === 0)) {
            $this->selected= $value;
        }
    }
    
    
    
    
    
    
    
    
        
    public function set_default($value)
    {
        $this->default= $value;
    }
    
    
    
    
    
    
    
    public function display()
    {
        global $c, $s, $m, $t, $q, $u;


        if ($this->numrows >= $this->minimum_choices) {
            if ($this->has['form']) {
                $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
                echo $this->hidden_input;
            }
            
            
            if (empty($this->select_name)) {
                f1::echo_error("no select_name in met#display, cls#selector");
            }
            
            echo "<select name=\"{$this->select_name}\" {$this->select_properties} >";


            if ($this->default) {
                echo "<option value=\"0\">".$this->default."</option>";
            }


            // rewind sql resource
            mysql_data_seek($this->res, 0);


            while ($data = mysql_fetch_assoc($this->res)) {
                $this->data= &$data;
            
                $this->validate_data();

                if ($this->selected == $data[$this->id_tag]) {
                    $this->set_submit_input("active"); //----form has selected an option-------------------------------------

                    echo "<option value=\"".$data[$this->id_tag]."\" selected >".$data[$this->label_tag]."</option>";
                } else {
                    echo "<option value=\"".$data[$this->id_tag]."\" >".$data[$this->label_tag]."</option>";
                }
            } // closes while loop
            
            
            // rewind sql resource
            mysql_data_seek($this->res, 0);
                    
            echo "</select>";

            if ($this->has['submit']) {
                $this->display_submit($this->i_var['submit_name'], $this->i_var['submit_value'], $this->i_var['submit_wrap_tag']);
            }
            
            
            if ($this->has['form']) {
                echo "</form>";
            }
        } elseif (($this->numrows >= 1) && ($this->numrows < $this->minimum_choices)) {
            f1::echo_warning("cls#selector: number of choices too small, or change #minimum_choices");
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }
}
