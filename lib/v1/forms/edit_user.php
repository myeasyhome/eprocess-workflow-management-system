<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_user extends html_form_adapter
{
    protected $selector;

    
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->selector= new select_department();
        $this->selector->initialize();
    }
    
    
    
    

    public function config()
    {
        global $c, $t, $q;

    
        parent::config();

        $this->selector->config();

        $this->reference= $this->i_var['form_name']= "edit_user";

        $this->set_title($t->create." | ".$t->edit, "h2");

        if (($_GET['id'] && ($this->id= $this->require_id("numeric", $_GET['id'])) && $this->id)
                || ($_REQUEST['id_user'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_user'])) && $this->id)) {
            $this->i_var['target_url']= $c->update_current_url(array("status_id_user", "ask_delete_".$this->subject));
            $this->data_source= "select_user1";
            $this->has['update_data_from_global']= false;
            $this->has['filter']= true;
        } else {
            $this->is['new']= true;
        }

        $this->define_form();
    }
    
    
    
    
    
    public function set_filter()
    {
        global $q;

        $q->set_filter("id_user=".$this->id);
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="username";
        $fields[]="surname";
        $fields[]="firstname";
        $fields[]="password";

        $fields[]="has_create_file";
        $fields[]="has_create_bordereau";
        $fields[]="has_create_project";
        $fields[]="has_print_letter";

        $fields[]="has_stats";

        $fields[]="user_status";

        $this->make_sections("input_text", 4);
        $this->make_sections("radio", 6);

        $status_list= $this->use_status_list();

        $this->add_select_array("user_status", $status_list);
        $this->add_select_array("has_create_file", $s->no_yes);
        $this->add_select_array("has_create_bordereau", $s->no_yes);
        $this->add_select_array("has_create_project", $s->no_yes);
        $this->add_select_array("has_print_letter", $s->no_yes);
        $this->add_select_array("has_stats", $s->no_yes);


        if ($this->id) {
            $fields[]="id_user";
            $this->make_sections("hidden", 1);
        }
                

        $this->set_fields($fields);

        $this->fields['id_user']= $this->id;
    }
    
    
    
    
    
    
    public function validate_data()
    {
        global $s, $c;

    
        if (($this->numrows >= 1) && $this->data) {
            $this->field_param['user_status']['selected']= $this->use_status_list("get_one", $this->data['user_status']);
        } elseif ($_REQUEST['user_status'] && $this->has['update_data_from_global']) {
            $this->field_param['user_status']['selected']= $this->use_status_from_global();
        }

        
        $list= $s->no_yes;
        
        $this->field_param['has_create_bordereau']['selected']= $list[$this->data['has_create_bordereau']];
        
        $this->field_param['has_create_file']['selected']= $list[$this->data['has_create_file']];
        
        $this->field_param['has_create_project']['selected']= $list[$this->data['has_create_project']];
        
        $this->field_param['has_print_letter']['selected']= $list[$this->data['has_print_letter']];
        
        $this->field_param['has_stats']['selected']= $list[$this->data['has_stats']];
        
        //---------do not show password-------------
        
        $this->data['password']="";
    }
    
    
    
    
    
    public function use_status_list($option="", $num_status=0)
    {
        global $s, $u;

        $status_list= $s->user_status;
        $list= array();

        foreach ($status_list as $key=>$value) {
            if (($key != "guest") &&
                !$u->is_super_admin() && ($key != "super_admin")) {
                $list[]= $value."_".$key;
            } elseif (($key != "guest") && $u->is_super_admin()) {
                $list[]= $value."_".$key;
            }
            
            
            if (($option == "get_one") && ($num_status == $value)) {
                return ($value."_".$key);
            }
        }
        
        return $list;
    }
    
    
    
    
    
    public function use_status_from_global()
    {
        if (is_numeric($_REQUEST['user_status'])) {
        
        // get status list saved in shelf (html_form property )
            
            $temp= $this->shelf['user_status'][($_REQUEST['user_status'])];
            return $temp;
        } else {
            return "0_x";
        }
    }
    
    
    
    
    
    public function is_validated()
    {
        global $q, $t;
    
    
        if (parent::is_validated() === true) {
            if ($_REQUEST["create_".$this->subject] && $_REQUEST['username']) {
                $q->set_filter("user1.username='".f1::fix_slashes($_REQUEST['username'])."'");
                $this->set_data_from_id("select_user1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $t->set_var("username", $_REQUEST['username'], true);
                    $this->throw_msg("error", "username_taken", "username already in database,
									met#is_validated, ".get_class($this));
                
                    return false;
                }
            }
            
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    public function onsubmit()
    {
        global $s, $u, $q;


        // stop empty password message
                
        if ($_REQUEST["ask_delete_".$this->subject] || $_REQUEST['cancel'] || $_REQUEST["yes_delete_".$this->subject]) {
            $this->ignore[]= "password";
        }
        
        // make minister
        
        if ($_REQUEST['is_minister']) {
            $q->set_filter("is_gen_dir='1'");
            $gen_dir= $this->set_data_from_id("select_user1", "", "id_user", $numrows);
        
            if ($gen_dir == $this->id) {
                $this->throw_msg("error", "already_gen_dir", "user already the general director,".get_class($this));
                return;
            }
        
            $q->set_filter("is_minister='1'");
            $old_minister= $this->set_data_from_id("select_user1", "", "id_user", $numrows);
                
            if ($numrows != 1) {
                $old_minister= 0;
            }
        
        
            $q->set_var("old_minister", $old_minister);
            $q->set_var("new_minister", $this->id);
    
    
            if ($q->sql_action("update_is_minister")) {
                $this->throw_msg("confirm", "new_minister_saved", "new minister saved,".get_class($this));
            }
        }
        
                
        // make general director
        
        if ($_REQUEST['is_gen_dir']) {
            $q->set_filter("is_minister='1'");
            $minister= $this->set_data_from_id("select_user1", "", "id_user", $numrows);
        
            if ($minister == $this->id) {
                $this->throw_msg("error", "already_minister", "user already the minister,".get_class($this));
                return;
            }
        
            $q->set_filter("is_gen_dir='1'");
            $old_gen_dir= $this->set_data_from_id("select_user1", "", "id_user", $numrows);
        
            if ($numrows != 1) {
                $old_gen_dir= 0;
            }
        
        
            $q->set_var("old_gen_dir", $old_gen_dir);
            $q->set_var("new_gen_dir", $this->id);
    
            if ($q->sql_action("update_is_gen_dir")) {
                $this->throw_msg("confirm", "new_gen_dir_saved", "new gen_dir saved,".get_class($this));
            }
        }
                
        
        
        
        // stop if administrator tries to delete administrator
        
        if ($_REQUEST["edit_".$this->subject] || $_REQUEST["save_".$this->subject]
        || $_REQUEST["ask_delete_".$this->subject] || $_REQUEST["yes_delete_".$this->subject]) {
            $subject_status= $_REQUEST['user_status'];
            $status_list= $s->user_status;
        
            if (!$u->is_super_admin() && $u->is_admin() && ($subject_status == $status_list['admin'])) {
                $this->throw_msg("error", "no_admin_edit_admin", "administrator cannot edit administrator,
						in met#onsubmit,".get_class($this));
                        
                $_REQUEST["ask_delete_".$this->subject]= null;
                $_REQUEST["yes_delete_".$this->subject]= null;
                $this->has['abort']= true;
            }
        }

        
        //-------Validation

        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
        
            // no department selected
        
            if (!$_REQUEST['id_dept'] && !$_REQUEST["yes_delete_".$this->subject]) {
                $this->throw_msg(
                "error",
                "no_department",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
            
        
            $_REQUEST['user_status']= substr($this->use_status_from_global(), 0, 1);
        
            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_user1")) {
                    $this->throw_msg(
                        "error",
                        "create_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#met #onsubmit"
            );
            }
            
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_var("id_user", $this->id);
                    
                if (!$q->sql_action("delete_from_user1") || !$q->sql_action("save_user1")) {
                    $this->throw_msg(
                        "error",
                        "save_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#met #onsubmit"
            );
            }
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_user", $this->id);
                    
                if (!$q->sql_action("delete_from_user1")) {
                    $this->throw_msg(
                        "error",
                        "delete_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                $this->throw_msg(
                "confirm",
                "record_deleted",
                                    "#met #onsubmit"
            );
                $this->is['new']= true;
            }
        } elseif (($_REQUEST['form_name'] == $this->i_var['form_name']) && !$this->in_cancel_mode()) {
            $this->is['submitted']= true;
            $this->set_has("update_data_from_global", true);
        }
    }
    
    
    
    
    
    public function set_data()
    {
        global $q;


        if (!$this->has['abort']) {
            parent::set_data();
        }
        
        $q->clear("all");
        $this->selector->set_data();

        if ($this->data['id_dept']) {
            $this->selector->set_selected($this->data['id_dept']);
        }
    }
    
    
    
    
    
    public function display_skeleton()
    {
        global $t;



        if ($this->data['is_minister'] == 1) {
            echo "<div class=\"bold_info\">*** ".$t->minister." ***</div>";
        }
        
        
        if ($this->data['is_gen_dir'] == 1) {
            echo "<div class=\"bold_info\">*** ".$t->gen_dir." ***</div>";
        }
        
        
        
    
        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_dept}:</p>
HTML;

        $this->selector->display();

        echo "</{$this->sections_tag}>";
    }
}
