<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class memory
{
    private $previous_zone;
    private $zone;
    private $data;
    private static $data_vault=array();	// list of variables that can't be modified



    public function __construct()
    {
        $this->data= array();
    
        $this->zone= $this->previous_zone= "zn_public";
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        global $s, $c;


        $parameters= $s->set_main_parameters();

        if (is_array($parameters)) {
            foreach ($parameters as $name) {
                if (is_numeric($_GET[$name])) {
                    $this->__set($name, $_GET[$name]);
                }
            }
        }
    }
    
    
    
    
    
    public function set_current_url()
    {
        global $c;

        $this->data[$this->zone]['current_url']= $c->update_current_url();
    }
    
    
    
    
    
    public function __set($name, $value)
    {
        global $s;

    
        if (in_array($name, self::$data_vault)) {
            return;
        }
    
        if (!isset($this->data[$this->zone])) {
            $this->data[$this->zone]= array();
        }
        
        $this->data[$this->zone][$name]= $value;
    
        //------------------------
    
        $parameters= $s->set_main_parameters();

        if (is_array($parameters) && in_array($name, $parameters)) {
            $linked_names= $s->set_linked_parameters($name);

            if (is_array($linked_names)) {
                foreach ($linked_names as $linked_name) {
                    $this->unset_linked_parameters($linked_name);
                }
            }
            
            if ($value) {
                $this->set_database_data($name, $value);
            }
        }
    }
    
    
    
    
    
    public function __get($name)
    {
        if (isset($this->data[$this->zone][$name])) {
            return $this->data[$this->zone][$name];
        }
    }
    
    
    
    
    
    public function set_zone($zone)
    {
        $this->zone= $zone;
    }
    
    
    
    
    
    
    public function get_zone()
    {
        return $this->zone;
    }

    
    
    
    
    
    public function transfer_from_previous()
    {
        if (!isset($this->data[$this->zone])) {
            $this->data[$this->zone]= array();
        }
            
        if ($this->data[$this->previous_zone] && is_array($this->data[$this->previous_zone])) {
            foreach ($this->data[$this->previous_zone] as $key => $value) {
                $this->data[$this->zone][$key]= $value;
            }
        }
        
        $this->previous_zone= $this->zone;
    }
    
    
    
    
    
    
    public function reset_zone($zone)
    {
        if (isset($this->data[$zone])) {
            unset($this->data[$zone]);
        }
    }
    
    
    
    
    public function destroy_data($name)
    {
        $temp= explode("_", $name);
        $ref= trim($temp[0]);
    
        if (isset($this->data[$this->zone][$ref."_id"])) {
            unset($this->data[$this->zone][$ref."_id"]);
        }
        
        if (isset($this->data[$this->zone][$ref."_name"])) {
            unset($this->data[$this->zone][$ref."_name"]);
        }
        
        if (isset($this->data[$this->zone][$name])) {
            unset($this->data[$this->zone][$name]);
        }
    }
    
    
    
    
    
    public function unset_linked_parameters($name)
    {
        global $s;

        self::$data_vault[]=$name;
        $temp= explode("_", $name);
        $ref= trim($temp[0]);

        if (isset($this->data[$this->zone][$ref."_id"])) {
            unset($this->data[$this->zone][$ref."_id"]);
        }
            
        if (isset($this->data[$this->zone][$ref."_name"])) {
            unset($this->data[$this->zone][$ref."_name"]);
        }
    }
    
    
    
    
    
    public function set_database_data($name, $value)
    {
        global $s, $q;

        $temp= explode("_", $name);
        $ref= trim($temp[0]);

        $q->set_var($ref."_id", $value);

        if (!$this->data[$this->zone][$key]) {
            $q->sql_select($ref."_name", $numrows, $res, "all");
        
        
            if ($numrows) {
                $data= mysql_fetch_assoc($res);
            
                $this->data[$this->zone][$ref."_name"]= $data[$ref."_name"];
            }
        }
    }
    
    
    
    
    public function filter_by_parameters($string="", $query_has_conditions= false)
    {
    }
    
    
    
    
    
    public function __destruct()
    {
        global $c;


        if (empty($this->data[$this->zone]['window_displayed'])) {
            if ($this->data[$this->zone]['previous_page']) {
                $temp1= $this->data[$this->zone]['previous_page'];
            }
            
            
            $temp2= $this->data[$this->zone]['current_url'];
            
            
            if (!isset($temp1) || ($temp1 != $temp2)) {
                $this->data[$this->zone]['previous_page']= $temp2;
            }
        } else {
            unset($this->data[$this->zone]['window_displayed']);
        }


        $_SESSION['memory']= &$this;
    }
}
