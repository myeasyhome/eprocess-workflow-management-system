<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class create_project_handler extends object_handler
{
    protected $id_proj;


    public function initialize($option="")
    {
        global $c, $t;


        parent::initialize();


        if ($option == "child") {
            return;
        }
        
        
        $this->subject= "project";

        $this->objs[0]= new edit_project_handler();
        $this->objs[1]= new list_clients();

        $this->initialize_objs();

        $this->objs[1]->set_option("file");
    }
    
    
    
    
    
    public function config($option="")
    {
        global $s, $u, $t;
    
        parent::config();


        if (!$u->has_create_project) {
            $this->throw_msg("fatal_error", "access_denied", "Create project not allowed, in cls#".get_class($this));
            return;
        }


        $this->has['common_data_source']= false;

        if ($option == "child") {
            return;
        }


        $this->set_title($t->create_project, "h2");
        $this->has['title']= true;
        
        $this->reference="create_project";

        $this->i_var['form_method']= "POST";
        $this->i_var['form_name']= $this->reference;


        $this->objs[0]->set_has("submit", false);
        $this->objs[0]->set_has("form", false);
        $this->objs[0]->set_form_name($this->i_var['form_name']);


        $this->objs[1]->set_title($t->file_clients, "h2");

        $this->objs[1]->set_has("radio", false);
        $this->objs[1]->set_has("checkboxes", true);

        $this->objs[1]->set_has("submit", false);
        $this->objs[1]->set_has("form", false);
    

        $this->i_var['target_url']= $s->root_url."?v=create_project&id_file=".$_REQUEST['id_file'];

        $this->id= $this->require_id("numeric", $_REQUEST['id_file']);


        if (is_numeric($_REQUEST['id_proj'])) {
            $this->id_proj= $_REQUEST['id_proj'];
            $this->i_var['target_url'] .= "&id_proj=".$_REQUEST['id_proj'];
        }
    }
    
    
    
    
    public function onsubmit()
    {
        global $s, $q, $m, $u, $t;


        if ($_REQUEST['new']) {
            $_REQUEST['id_proj']= null;
        
            $this->initialize();
            $this->config();
        
            $this->i_var['previous_url']= $this->i_var['current_url'];
        
            $this->i_var['target_url']= $this->i_var['current_url']= $s->root_url.
                                        "?v=create_project&id_file=".$_REQUEST['id_file'];
        }

        
        //---------------------
        
        
        if (($_REQUEST['form_name'] == "create_".$this->subject) && $_REQUEST["create_".$this->subject]
                    && empty($_REQUEST['id_client'])) {
            $this->throw_msg(
            "error",
            "create_project_select_client",
                            "no client selected"
        );
                                                        
            $this->set_is("submitted", true);
            $this->set_has("update_data_from_global", true);
            return;
        }
        
        
        if ($this->objs[0]->is_validated()
                && (($_REQUEST["create_".$this->subject] && $_REQUEST['id_client'] && is_array($_REQUEST['id_client']))
                || $_REQUEST["save_".$this->subject])
        ) {
        
                
        
        // no proj type selected
    
            if (!$_REQUEST['id_proj_type'] && !$_REQUEST["yes_delete_".$this->subject]) {
                $this->throw_msg(
            "error",
            "no_proj_type",
                                    "#met #onsubmit"
        );
                                    
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
        
            
            if (is_numeric($_REQUEST['id_client'][0])) {
                $list= $_REQUEST['id_client'][0];
            } else {
                $list= "";
            }
        
            for ($i=1; $i < count($_REQUEST['id_client']); $i++) {
                if (is_numeric($_REQUEST['id_client'][$i])) {
                    $list .= ", ".$_REQUEST['id_client'][$i];
                }
            }
        
            $list= empty($list) ? "0" : $list;
            
            
            //------Check if clients have projects---------------------
            
            if ($_REQUEST["create_".$this->subject]) {
                $q->set_filter("id_client IN (".$list.") AND id_proj <> '' ");
                $data= $this->set_data_from_id("select_client1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $this->throw_msg(
                    "confirm",
                    "record_created",
                                    "project already created, ref#1, #met #onsubmit,
									cls#create_project_handler"
                );
                
                    $_REQUEST["create_".$this->subject]= null;
                    $_REQUEST['id_proj']= $data['id_proj'];
                
                    return;
                }
            }
            
            
            if ($_REQUEST['id_proj_type']) {
                $_REQUEST['proj_type']= $_REQUEST['id_proj_type'];
            }
            
                
            if ($_REQUEST['id_proj_status']) {
                $_REQUEST['proj_status']= $_REQUEST['id_proj_status'];
            }
            
                
            //----------CREATE
        
        
            if ($_REQUEST["create_".$this->subject]) {
                $this->var_to_queries($_REQUEST);
                    
                $q->set_var("proj_dept", $u->id_dept);
            
                //---for transfer1
            
                $q->set_var("id_user", $u->id);
                $q->set_var("dept_comingfrom", $u->id_dept);
                $q->set_var("dept_goingto", $u->id_dept);
                $q->set_var("describe_trans", $t->project_created);
                $q->set_var("date_trans", "NOW()");
            
                //----------
            
                $q->set_var("id_list", $list);

                    
                $created1= $q->sql_action("insert_project1");
                $new_id= $q->get_var("new_id");
                $q->set_var("id_proj", $new_id);
            
            
                $created2= $q->sql_action("insert_proj_trans");
                $last_trans= $q->get_var("new_id");
            
                $q->set_var("last_trans", $last_trans);
                $q->set_var("id_proj", $new_id);
            
                $created3= $q->sql_action("update_proj_last_trans");
            
                if (!$created1 || !$created2 || !$created3) {
                    $this->throw_msg(
                        "error",
                        "create_failed",
                                    "#met #onsubmit,
									cls#create_project_handler"
                    );
                    
                    $this->set_is("submitted", true);
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#met #onsubmit,
									cls#create_project_handler"
            );
    
            
                if ($_REQUEST['file_status'] == 2) {
                    $q->sql_action("update_file_status_3");
                }

                
                //---------------
                
                $q->set_var("id_proj", $new_id);
                $q->set_var("id_list", $list);
                
                $q->sql_action("new_project_subcribers");
                
                $this->send_sms_to_subscribers($s->sms_new_project_subscribers_action, 2, $new_id);
                
                //----------------
            }
                    
        
            //---------------SAVE
                        
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_filter("id_client IN (".$list.") AND id_proj <> '' ");
                $data= $this->set_data_from_id("select_client1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $this->throw_msg(
                    "confirm",
                    "record_saved",
                                    "project already saved, ref#2, #met #onsubmit,
									cls#create_project_handler"
                );
                
                    $_REQUEST["create_".$this->subject]= null;
                    $_REQUEST['id_proj']= $data['id_proj'];
                
                    return;
                }
            
                //----------------------------
                        
                $q->set_filter("project1.id_proj='".$this->id_proj."'");
                $data= $this->set_data_from_id("select_project1");
        
        
                $q->set_var("last_trans", $data['last_trans']);
                        
                $this->var_to_queries($_REQUEST);
            
                $q->set_var("proj_dept", $u->id_dept);
                $q->set_var("id_proj", $this->id_proj);
                $q->set_var("id_list", $list);
            
            
                if (!$q->sql_action("delete_from_project1") || !$q->sql_action("save_project1")) {
                    $this->throw_msg(
                        "error",
                        "save_failed",
                                    "#met #onsubmit,
									cls#create_project_handler"
                    );
                    
                    $this->set_is("submitted", true);
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#met #onsubmit,
									cls#create_project_handler"
            );
                                    
                                    
                //---------------
                
                $q->set_var("id_proj", $this->id_proj);
                $q->set_var("id_list", $list);
                
                $q->sql_action("new_project_subcribers");
                
                $this->send_sms_to_subscribers($s->sms_new_project_subscribers_action, 2, $this->id_proj);
                
                //----------------
            }
            

            if ($_REQUEST["create_".$this->subject] && isset($new_id)) {
                $_REQUEST['id_proj']= $new_id;
            }
        } // closes if is_validated...
        
        
        
        if (is_numeric($_REQUEST['id_proj'])) {
            $this->initialize();
            $this->config();
        
            $this->objs[2]= new list_clients();
            $this->objs[2]->initialize();

            $this->objs[2]->set_option("new_project");
                    
            $this->objs[2]->config();
        
            $this->objs[2]->set_title($t->new_project_clients, "h2");

            $this->objs[2]->set_has("submit", false);
            $this->objs[2]->set_has("form", false);
        
            $this->objs[0]->set_has("save_mode", true);
        }
    }
    
    
    
    
    public function set_data($option="")
    {
        global $q;
    
        parent::set_data();


        if ($option == "child") {
            return;
        }

        
        if ($this->objs[1]->get_numrows() <=  0) {
            $q->set_var("id_file", $_REQUEST['id_file']);
        
            $q->sql_action("update_file_status_0");
        }
    }


    
    
    
    public function display_submit()
    {
        global $u, $t;


        echo "<input type=\"hidden\" name=\"id_file\" value=\"{$this->id}\" />";



        if ($_REQUEST['new']) {
            echo <<<HTML
		

<a class="button" href="{$this->i_var['previous_url']}" >{$t->previous}</a>



HTML;
        }
        

        if ($_REQUEST['id_proj']) {
            echo <<<HTML
		
<input type="submit" class="submit_button" name="new" value="{$t->new}"/>

<input type="submit" class="submit_button" name="save_{$this->subject}" value="{$t->save}"/>

HTML;
        } else {
            echo <<<HTML

<input type="submit" class="submit_button" name="create_{$this->subject}" value="{$t->create}"/>

HTML;
        }
    }
    
    
    
    
    
    
    public function display()
    {
        global $u, $t;

        if ($this->is['displayable']) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);

            echo <<<HTML
<div class="section1">
HTML;

            $this->objs[0]->display();

            echo "</div>";

            echo <<<HTML
<div class="section2">
HTML;

            $this->objs[1]->display();

            echo "</div>";
    
            if ($this->objs[1]->is_data_ready()) {
                $this->display_submit();
            }
    
            echo "</form>";
    
            if (is_object($this->objs[2]) && $this->objs[2]->is_data_ready()) {
                echo <<<HTML
<div class="section3">
HTML;

                $this->objs[2]->display();

                echo "</div>";
            }
        }
    }
}
