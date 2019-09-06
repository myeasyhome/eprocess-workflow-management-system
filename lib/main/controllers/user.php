<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

All rights reserved

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class user
{
    protected $data;



    public function __construct()
    {
        $this->data= array();

        //-------Default----------------------------

        $this->data['name']= ucfirst($t->guest);

        $status= $s->user_status;
        $this->data['status']= $status['guest']; // public status
    }
    
    
    
    
    
    
    public function has_data()
    {
        if (!empty($this->data)) {
            return true;
        } else {
            return false;
        }
    }

    


    public function __set($name, $value)
    {
        $variables= array("id", "username", "status", "id_dept", "name_dept", "successful_login", "last_time_logged_in", "last_time_verified",
"dept_has_search", "dept_has_write_letter", "dept_has_send_sms", "has_create_file", "has_create_bordereau", "has_create_project", "has_print_letter","has_stats");
                    
                    
        if (in_array($name, $variables)) {
            $this->data[$name]= $value;
        } else {
            echo_comment("A variable with name \"{$name}\" is not allowed, ".
                        "in met#set_data, cls#user");
        }
    }
    
    
    
    
    
    
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            f1::echo_comment("data with name \"{$name}\" could not be found and returned,".
                        " in met#get, cls#user ");
                        
            return false;
        }
    }
    
    
    
    
    
    
    public function set_status_name()
    {
        global $s;

        $list= $s->user_status;

        foreach ($list as $name => $status) {
            if ($status == $this->data['status']) {
                $this->data['status_name']= $name;
            }
        }
        
        if (!$this->data['status_name']) {
            f1::echo_error("status name not found in met#set_status_name, cls#user");
        }
    }
    
    
    
    
    
    
    public function is_logged_in($zone)
    {
        global $s, $m;

        $allowed= $s->$zone;

        if ($this->data['id'] && is_array($allowed) && in_array($this->data['status'], $allowed)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    public function is_privy($reference)
    {
        global $s;


        switch ($reference) {
        
        default:
        
        return true;
        
        break;
        
        }

        return false;
    }
    
    
    
    public function is_editor()
    {
        global $c, $s, $m, $t, $q, $u;

        if ($this->is_logged_in($m->get_zone())) {
            if (($list= $s->editor_group)
                    && is_array($list)
                    && in_array($this->data['status'], $list)) {
                return true;
            }
        }
        
        return false;
    }
    
    
    
    

    public function is_admin()
    {
        global $s;
    
        if (($list=$s->admin_group)
            && is_array($list)
            && in_array($this->data['status'], $list)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    public function is_super_admin()
    {
        global $s;
    
        if (($list= $s->super_admin_group)
            && is_array($list)
            && in_array($this->data['status'], $list)) {
            return true;
        } else {
            return false;
        }
    }

    
    
    
    
    
    public function __destruct()
    {
        $_SESSION['user']= &$this;
    }
}
