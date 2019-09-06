<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class edit_file_handler extends form_handler
{
    protected $selectors;




    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->subject= "file";

        $this->set_title($t->edit_file);

        $this->has['title']= true;

        $this->forms[0]= new edit_file_p1();
        $this->forms[1]= new edit_file_p2();

        $this->selectors[0]= new select_file_category();
        $this->selectors[1]= new select_file_type();

        if ($_REQUEST['create_file'] || ($this->has_transfer() === false)) {
            $this->selectors[2]= new select_department();
        }

        $this->selectors[0]->initialize();
        $this->selectors[1]->initialize();

        if (isset($this->selectors[2])) {
            $this->selectors[2]->initialize();
            $this->selectors[2]->set_option("other");
        }

        $this->initialize_forms();
    }
    
    
    
    
    public function config()
    {
        global $s;
    
        parent::config();

        $this->has['common_data_source']= true;


        $this->forms[0]->define_form();
        $this->forms[1]->define_form();


        $this->selectors[0]->config();
        $this->selectors[1]->config();

        if (isset($this->selectors[2])) {
            $this->selectors[2]->config();
        }

        $this->i_var['form_name']= "edit_file";
        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_file";

        
        if ($_REQUEST['id_file']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_file']);
            $this->data_source="select_file1";
            $this->has['filter']= true;
        } elseif (!$_REQUEST['id_file']) {
            $this->is['new']= true;
        }
    }

    
    
    
    
    
    public function set_filter()
    {
        global $q;

    
        if ($this->id) {
            $q->set_filter("file1.id_file='".$this->id."'");
        }
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


            if (($_REQUEST["create_".$this->subject] || !$this->i_var['has_transfer'])
                    && !($_REQUEST["ask_delete_".$this->subject] || $_REQUEST["yes_delete_".$this->subject])
                && !$_REQUEST['id_dept']) {
                $this->throw_msg(
                "error",
                "no_department",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
        
                return;
            }
        

            $_REQUEST['file_category']= is_numeric($_REQUEST['id_file_cat']) ? $_REQUEST['id_file_cat'] : 0;
            $_REQUEST['file_type']= is_numeric($_REQUEST['id_file_type']) ? $_REQUEST['id_file_type'] : 0;
        
            // for action log
            $q->set_filter("id_file_cat='".$_REQUEST['file_category']."'");
            $_REQUEST['name_cat']= $this->set_data_from_id("select_file_category1", "", "name_cat");

        
            $this->undo_custom_datetime(array("file_date"), $_REQUEST);

        
            if ($_REQUEST["create_".$this->subject]) {
                $this->var_to_queries($_REQUEST);
                
            
                $q->set_var("file_dept", $u->id_dept);
            
                //---for transfer1
            
                $q->set_var("id_user", $u->id);
                $q->set_var("dept_comingfrom", $_REQUEST['id_dept']);
                $q->set_var("dept_goingto", $u->id_dept);
                $q->set_var("describe_trans", $t->file_created);
                $q->set_var("date_trans", "NOW()");
                $q->set_var("file_status", 1);
            
                $created1= $q->sql_action("insert_file1");
                $id_file= $q->get_var("new_id");
                $q->set_var("id_file", $id_file);
            
                $created2= $q->sql_action("insert_file_trans");
                $last_trans= $q->get_var("new_id");
                $q->set_var("last_trans", $last_trans);
            
                $created3= $q->sql_action("update_file_last_trans");
            
                if (!$created1 || !$created2 || !$created3) {
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
                                    
                $_REQUEST['new_id']= $id_file;
                $action_log->save($s->create_tag, "id_file", $_REQUEST);
            }
            
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_filter("file1.id_file='".$this->id."'");
                $data= $this->set_data_from_id("select_file1");

                $action_log->set_old_data($data);
                        
            
                $this->var_to_queries($_REQUEST);
                
            
                $q->set_var("id_file", $this->id);
                $q->set_var("file_dept", $u->id_dept);
                $q->set_var("last_trans", $data['last_trans']);
            
            
                if (!$q->sql_action("delete_from_file1") || !$q->sql_action("save_file1")) {
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
            
            
                $action_log->save($s->edit_tag, "id_file", $_REQUEST);
            
            
                // if it is a new file, not transferred, with one record in transfer table
                if ($this->i_var['has_transfer'] === false) {
                    $q->set_var("id_trans", $data['last_trans']);
                    $q->set_var("dept_comingfrom", $_REQUEST['id_dept']);
                    $q->sql_action("update_file_comingfrom");
                }
            }
            
                        
            
            if ($u->is_admin() && $_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_file", $this->id);
                    
                if (!$q->sql_action("delete_from_file1")) {
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
    
    
    
    
    public function has_transfer()
    {
        global $q;

        if (is_numeric($_REQUEST['id_file'])) {
            $q->set_filter("id_file='".$_REQUEST['id_file']."'");

            $this->set_data_from_id("select_transfer1", "", "", $numrows);

        
            if ($numrows > 1) {
                $this->i_var['has_transfer']= true;
                return true;
            } else {
                $this->i_var['has_transfer']= false;
                return false;
            }
        } else {
            f1::echo_warning("invalid #id_file, met#has_transfer, cls#edit_transfer_handler");
        }
    }
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        parent::set_data();

        $this->selectors[0]->set_data();
        $this->selectors[1]->set_data();

        if (isset($this->selectors[2])) {
            $this->selectors[2]->set_data();
        }

        if ($this->data) {
            $this->data['file_category']= $this->is['submitted'] ? $_REQUEST['file_category']: $this->data['file_category'];
            $this->selectors[0]->set_selected($this->data['file_category']);
        
            $this->data['file_type']= $this->is['submitted'] ? $_REQUEST['file_type']: $this->data['file_type'];
            $this->selectors[1]->set_selected($this->data['file_type']);
        
            if (isset($this->selectors[2])) {
                $this->data['dept_comingfrom']= $this->is['submitted'] ? $_REQUEST['id_dept']: $this->data['dept_comingfrom'];
                $this->selectors[2]->set_selected($this->data['dept_comingfrom']);
            }
        }
    }
    
    
    
    
    public function start()
    {
        global $u;
    
        parent::start();


        if ($this->numrows >= 1) {
            if ($this->data['file_dept'] != $u->id_dept) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", foreign file");
                return;
            } elseif ($this->data['file_status'] == 0) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", dormant file status");
                return;
            }
        }
    }
    
    
    

    public function display_skeleton()
    {
        global $t;
    
    
        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_cat}:</p>
HTML;

        $this->selectors[0]->display();

        echo "</{$this->sections_tag}>";


        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_type}:</p>
HTML;

        $this->selectors[1]->display();

        echo "</{$this->sections_tag}>";


        if (isset($this->selectors[2])) {
            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->dept_comingfrom}:</p>
HTML;

            $this->selectors[2]->display();

            echo "</{$this->sections_tag}>";
        }
        
        
        parent::display_skeleton();
    }
}
