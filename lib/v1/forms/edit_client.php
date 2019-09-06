<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_client extends html_form_adapter
{
    public function config()
    {
        global $s, $t, $q;

    
        parent::config();

        $this->subject= "client";

        $this->has['confirm_email']= false;
        $this->has['filter']= true;

        $this->reference= $this->i_var['form_name']= "edit_client";

        $this->set_title($t->create." | ".$t->edit, "h2");

        $this->i_var['target_url']= $s->root_url."?v=edit_client";

        if ($_REQUEST['id_client'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_client'])) && $this->id) {
            $this->data_source= "select_client1";
            $this->has['update_data_from_global']= false;
        } else {
            $this->is['new']= true;
        
            if (is_numeric($_REQUEST['id_file'])) {
                $q->set_filter("client1.id_file='".$_REQUEST['id_file']."'");
                $q->sql_select("select_client1", $numrows, $res);
            }
            
            if ($numrows >= $s->max_file_client) {
                $this->throw_msg(
                "error",
                "file_reached_max_clients",
                                "#cls #edit_client, #met #config"
            );
                                
                $this->is['displayable']= false;
            }
        }

        $this->define_form();

        if ($_REQUEST['id_file']) {
            $id_parent= $_REQUEST['id_file'];
        } elseif ($_REQUEST['id_proj']) {
            $id_parent= $_REQUEST['id_proj'];
        }
        
        if (!isset($id_parent)) {
            $id_parent= "";
            $this->require_id("numeric", $id_parent); // trigger require_id fatal error
        }
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="client_type";
        $fields[]="id_agent";
        $fields[]="determ_client";
        $fields[]="surname";
        $fields[]="firstname";
        $fields[]="sex";
        $fields[]="date_birth";
        $fields[]="town_birth";
        $fields[]=$this->is_numeric[]="num_phone";
        $fields[]="email";

        $this->ignore[]="id_agent";
        $this->ignore[]="num_phone";
        $this->ignore[]="email";

        $this->make_sections("radio", 1);
        $this->make_sections("input_text", 4);
        $this->make_sections("radio", 1);
        $this->make_sections("input_text", 4);

        $this->add_select_array("client_type", $s->client_types);
        $this->add_select_array("sex", $s->gender);


        if ($_REQUEST['id_file']) {
            $fields[]="id_file";
            $fields[]="file_status";
        
            $this->make_sections("hidden", 2);
        }
        
        if ($_REQUEST['id_proj']) {
            $fields[]="id_proj";
            $this->make_sections("hidden", 1);
        }
        
        //----------------------------------
        
        if ($this->id) {
            $fields[]="id_client";
            $this->make_sections("hidden", 1);
        }
                

        $this->set_fields($fields);

        $this->fields['id_client']= $this->id;

        $this->fields['id_file']= $_REQUEST['id_file'] ? $_REQUEST['id_file'] : null;
        $this->fields['file_status']= isset($_REQUEST['file_status']) ? $_REQUEST['file_status'] : null;
        $this->fields['id_proj']= $_REQUEST['id_proj'] ? $_REQUEST['id_proj'] : null;

        $this->field_param['date_birth']['format']= "date";
    }
    
    
    
    
    
    public function set_filter()
    {
        global $m, $q;

        $q->set_filter("id_client='".$this->id."'");
    }
    

    
    
    
    
    
    
    public function onsubmit()
    {
        global $c, $s, $m, $q, $u, $v, $t;


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
    
//---------------------------------

            $action_log= new action_log();
            $action_log->config();

            //--------------------------------


            $_REQUEST['date_birth']= f1::undo_custom_date($_REQUEST['date_birth']);
        
        
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_filter("id_client='".$this->id."'");
                $data= $this->set_data_from_id("select_client1");

                $q->set_var("id_file", $data['id_file']);
                $q->set_var("id_proj", $data['id_proj']);
            
                $action_log->set_old_data($data);
            }
            
        
            $this->var_to_queries($_REQUEST);
            
            
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_client1")) {
                    $this->throw_msg(
                        "error",
                        "create_failed",
                                    "#cls #edit_client, #met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                
                                                            
                $_REQUEST['new_id']= $q->get_var("new_id");
                $action_log->save($s->create_tag, "id_client", $_REQUEST);
            
                
                if ($_REQUEST['file_status'] == 1) {
                    $q->sql_action("update_file_status_2");
                }

                
                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#cls #edit_client, #met #onsubmit"
            );
            }
            
            
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_var("id_client", $this->id);

                if (!$q->sql_action("delete_from_client1") || !$q->sql_action("save_client1")) {
                    $this->throw_msg(
                        "error",
                        "save_failed",
                                    "#cls #edit_client, #met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#cls #edit_client, #met #onsubmit"
            );
                                                                    
                $action_log->save($s->edit_tag, "id_client", $_REQUEST);
            }
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_client", $this->id);
                    
                if (!$q->sql_action("delete_from_client1")) {
                    $this->throw_msg(
                        "error",
                        "delete_failed",
                                    "#cls #edit_client, #met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_deleted",
                                    "#cls #edit_client, #met #onsubmit"
            );
                $this->is['new']= true;
            }
        } elseif (($_REQUEST['form_name'] == $this->i_var['form_name']) && !$this->in_cancel_mode()) {
            $this->is['submitted']= true;
            $this->set_has("update_data_from_global", true);
        }
    }
    
    
    
    
    
    
    public function start()
    {
        global $s, $q, $u;


        if (($this->numrows >= 1) && $this->data['id_proj'] > 0) {
            $this->has['delete']= false;
        
            $q->set_filter("project1.id_proj='".$this->data['id_proj']."'");
            $proj_dept= $this->set_data_from_id("select_project1", "", "proj_dept");
        
            if ($proj_dept != $u->id_dept) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", foreign project - client");
            }
        } elseif ($this->numrows >= 1) {
            $q->set_filter("file1.id_file='".$this->data['id_file']."'");
            $file_data= $this->set_data_from_id("select_file1");
        
            if ($file_data['file_dept'] != $u->id_dept) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", foreign file - client");
                return;
            } elseif ($file_data['file_status'] == 0) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", dormant file status");
                return;
            }
        }
        

        $client_types= $s->client_types;
        $this->field_param['client_type']['selected']= isset($this->data['client_type']) ?
                                                    $client_types[$this->data['client_type']] : null;
                                                    
        $gender= $s->gender;
        $this->field_param['sex']['selected']= isset($this->data['sex']) ? $gender[$this->data['sex']] :
                                            (isset($_REQUEST['sex']) ? $gender[$_REQUEST['sex']] : null);
                                            
        if ($this->numrows >= 1) {
            $this->custom_date(array("date_birth"));
            $this->fields['date_birth']= $this->data['date_birth'];
        }
    }
}
