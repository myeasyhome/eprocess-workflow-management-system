<?php


class history extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->numeric_id_from_array($_REQUEST['id_file']);


        $this->reference="history";

        $this->has['submit']= false;
        $this->has['form']= false;
        $this->has['filter']= true;


        $this->data_source= "select_transfer1";

        if ($_REQUEST['id_file'] && !$_REQUEST['id_proj']) {
            $this->numeric_id_from_array($_REQUEST['id_file']);

            $this->set_title($t->file_history, "h2");
            $this->id= $this->require_id("numeric", $_REQUEST['id_file']);
            $this->subject= "file";
            $this->id_tag= "id_file";
        } elseif ($_REQUEST['id_proj']) {
            $this->numeric_id_from_array($_REQUEST['id_proj']);
        
            $this->set_title($t->project_history, "h2");
            $this->id= $this->require_id("numeric", $_REQUEST['id_proj']);
            $this->subject= "project";
            $this->id_tag= "id_proj";
        } else {
            $this->throw_msg("fatal_error", "invalid_request", "met#config, 
				cls#history, invalid id");
        }
        
        
        $this->display_list= array("date_trans", "name_dept_comingfrom", "name_dept_goingto", "describe_trans", "name_status_trans", "operator", "info_carrier");

        $this->i_var['primary_name_tag']= "date_trans";
    }
    
    
    
    
    
    public function set_filter()
    {
        global $q;


        if ($_REQUEST['id_file'] && !$_REQUEST['id_proj']) {
            $q->set_filter("id_file='".$this->id."'");
        } elseif ($_REQUEST['id_proj']) {
            $q->set_filter("id_proj='".$this->id."'");
        }
    }
    
    
    
    
    
    public function start()
    {
        global $q;


        $this->i_var['list_dept']= array();
        $this->i_var['list_user']= array();

        $q->sql_select("select_department1", $numrows, $res, "all");

        if ($numrows >= 1) {
            while ($data= mysql_fetch_assoc($res)) {
                $this->i_var['list_dept'][$data['id_dept']]= $data['name_dept'];
            }
        }
        
        $q->sql_select("select_user1", $numrows, $res, "all");

        if ($numrows >= 1) {
            while ($data= mysql_fetch_assoc($res)) {
                $this->i_var['list_user'][$data['id_user']]= $data['username'];
            }
        }
    }

    
    

    public function display_skeleton()
    {
        global $s, $u, $q, $t;


        $this->data['date_trans']= f1::custom_datetime($this->data['date_trans']);

        if ($this->i_var['list_dept']) {
            $this->data['name_dept_comingfrom']= $this->i_var['list_dept'][$this->data['dept_comingfrom']];
            $this->data['name_dept_goingto']= $this->i_var['list_dept'][$this->data['dept_goingto']];
        } else {
            $q->set_filter("id_dept='".$this->data['dept_comingfrom']."'");
            $this->data['name_dept_comingfrom']= $this->set_data_from_id("select_department1", "", "name_dept");

            $q->set_filter("id_dept='".$this->data['dept_goingto']."'");
            $this->data['name_dept_goingto']= $this->set_data_from_id("select_department1", "", "name_dept");
        }
        
        
        if ($this->i_var['list_user']) {
            $this->data['operator']= $this->i_var['list_user'][$this->data['id_user']];
        } else {
            $q->set_filter("id_user='".$this->data['id_user']."'");
            $this->data['operator']== $this->set_data_from_id("select_user1", "", "username");
        }
        
        
        $status_list= $s->transfer_status;
        $status_trans= $status_list[$this->data['status_trans']];
        $this->data['name_status_trans']= $t->$status_trans;


        if (!in_array($this->data['status_trans'], array(1,2))) {
            $this->data['info_carrier']= $this->data['name_status_trans'];
        }
        
        
        $this->view_data();
    }
}
