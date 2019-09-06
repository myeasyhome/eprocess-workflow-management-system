<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class action_log extends website_object
{
    protected $type_action;
    protected $new_data;
    protected $old_data;
    protected $watch_list;



    public function config()
    {
        global $s;

        $this->watch_list= array("surname", "firstname", "date_birth", "num_phone", "email"); // default
    }

    
    
    public function set_watch_list(&$watch_list)
    {
        if (is_array($watch_list)) {
            $this->watch_list= &$watch_list;
        }
    }
    
    
    
    
    public function set_old_data(&$old_data)
    {
        if (is_array($old_data)) {
            $this->old_data= &$old_data;
        }
    }
    
    
    
    
    public function save($type_action, $id_tag, &$new_data)
    {
        global $s;
    
        $this->new_data= $new_data;
    
        if (($type_action == $s->edit_tag)
                && ($this->has_important_change() === true)) {
            $this->register_action($type_action, $id_tag);
        } elseif ($type_action != $s->edit_tag) {
            $this->register_action($type_action, $id_tag);
        }
    }
    
    
    
    
    private function has_important_change()
    {
        if (empty($this->old_data)) {
            f1::echo_warning("empty #old_data in met#has_changed, cls#action_log");
            return;
        }
    
                
        foreach ($this->new_data as $key => $value) {
            if (isset($this->old_data[$key])
                    && (trim($this->old_data[$key]) != trim($this->new_data[$key]))) {
                $change= true;
            
                if (in_array($key, $this->watch_list)) {
                    $save= true;
                }
            }
        }
        
        
        if ($change && $save) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    private function to_string($data)
    {
        global $t;
    
        $string= "";
        $counter= 0;
    
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->watch_list)) {
                continue;
            }
    
            $label= $t->$key;
            
            if ($counter > 0) {
                $string .= "; {$label}: {$value} ";
            } else {
                $string .= "{$label}: {$value} ";
            }
                
            $counter++;
        }
        
        return $string;
    }
    
    
    
    
    private function register_action($type_action, $id_tag)
    {
        global $q, $u, $m, $t;

        //------------------

        $this->new_data['username']= $u->username;
        $this->new_data['date_time']= date("d/m/Y, H:i", time());

        if ($this->new_data['date_birth']) {
            $this->old_data['date_birth']= f1::custom_date($this->old_data['date_birth']);
            $this->new_data['date_birth']= f1::custom_date($this->new_data['date_birth']);
        }

        if (is_array($this->old_data)) {
            $old_data= $this->to_string($this->old_data);
        }
        
        $this->new_data['new_data']= $this->to_string($this->new_data);

        //------------------

        foreach ($this->new_data as $key => $value) {
            $t->set_var($key, $value);
        }
        
        $t->set_var("old_data", $old_data);
        
        $t->load_text(); // refresh
    
        $ref= "act_".$type_action."_".$id_tag;

        $describe= $t->$ref;
    
        if (empty($describe)) {
            f1::echo_error("empty action describe in met#register_action, cls#action_log");
            return;
        }
        
        $q->set_var("id_user", $u->id);
        $q->set_var("type_action", $type_action);
        $q->set_var("describe_action", $describe);
    
        $q->sql_action("insert_action_log1");
    }
}
