<?php



class month_filter extends html_form
{
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;



        parent::config();

        if (isset($_GET)) {
            $this->global_var= $_GET;
        }	// default

        $this->i_var['form_method']= "GET";

        //---Default values------------------------------------

        $this->i_var['target_url']= $c->update_current_url("filter");
        $this->i_var['form_name']= "filter";

        $this->i_var['years_select']= "before";
        $this->i_var['max_years_select']= 5;

        $this->has['form']= true; // default
$this->has['submit']= true; // default

//-----------------------------------------

        $fields= array();

        $fields[]= "filter";
        $fields[]= "view";
        $fields[]= "month";
        $fields[]= "year";

        $this->make_sections("hidden", 2);
        $this->make_sections("undefined", 2);


        $this->i_var['fields']= $fields;
        $this->set_fields($this->i_var['fields']);
    }
    
    
    
    
    
    public function set_data()
    {
        parent::set_data();

        $this->fields['filter']= "month_filter";
    }
    
    
    
    
    
    public function display()
    {
        echo "<div class=\"month_filter\">";
        
        parent::display();

        echo "</div>";
    }
}
