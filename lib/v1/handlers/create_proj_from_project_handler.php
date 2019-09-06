<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class create_proj_from_project_handler extends create_project_handler
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize("child");

        $this->subject= "project";

        $this->objs[0]= new edit_project_handler();
        $this->objs[1]= new list_clients();

        $this->initialize_objs();

        $this->objs[1]->set_option("proj_project");
    }
    
        
    
    
    public function config()
    {
        global $s, $u, $t;

        
        if (!$_REQUEST['parent_id_proj'] && $_REQUEST['id_proj']) {
            $_REQUEST['parent_id_proj']= $_REQUEST['id_proj'];
        
            $_REQUEST['id_proj']= null;
            $_REQUEST['id_proj']= null;
            $_GET['id_proj']= null;
        }
        
        
        $this->id= $this->require_id("numeric", $_REQUEST['parent_id_proj']);
    
        //------------------------------------------------

        parent::config("child");

        $this->has['common_data_source']= false;

        $this->set_title($t->create_proj_project, "h2");
        $this->has['title']= true;
    
        $this->reference="create_proj_project";

        $this->i_var['form_method']= "POST";
        $this->i_var['form_name']= $this->reference;


        $this->objs[0]->set_has("submit", false);
        $this->objs[0]->set_has("form", false);
        $this->objs[0]->set_form_name($this->i_var['form_name']);


        $this->objs[1]->set_title($t->project_clients, "h2");

        $this->objs[1]->set_has("radio", false);
        $this->objs[1]->set_has("checkboxes", true);

        $this->objs[1]->set_has("submit", false);
        $this->objs[1]->set_has("form", false);
    

        $this->i_var['target_url']= $s->root_url."?v=create_proj_project";
        
        //-------------------------

        if (is_numeric($_REQUEST['id_proj'])) {
            $this->id_proj= $_REQUEST['id_proj'];
            $this->i_var['target_url'] .= "&id_proj=".$_REQUEST['id_proj'];
        }
    }
    
    
    
    
    
    public function onsubmit()
    {
        global $s, $q, $m, $u, $t;


        if ($_REQUEST['new']) {
            $previous_url= $s->root_url."?v=create_proj_project&parent_id_proj=".$_REQUEST['parent_id_proj'].
                                        "&id_proj=".$_REQUEST['id_proj'];
                                        
                                        
            $_REQUEST['id_proj']= null;
            $_REQUEST['id_proj']= null;
                
            $this->initialize();
            $this->config();
                
            $this->i_var['previous_url']= $previous_url;
        }
        
        
        if (($_REQUEST['form_name'] == "create_proj_".$this->subject) && $_REQUEST["create_proj_".$this->subject]
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
                && (($_REQUEST["create_proj_".$this->subject] && $_REQUEST['id_client'] && is_array($_REQUEST['id_client']))
                || $_REQUEST["save_".$this->subject])
                ) {
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
            
            if ($_REQUEST["create_proj_".$this->subject] && is_numeric($_REQUEST['parent_id_proj'])) {
                $q->set_filter("id_client IN (".$list.") AND id_proj <> '".$_REQUEST['parent_id_proj']."' ");
                $data= $this->set_data_from_id("select_client1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $this->throw_msg(
                    "confirm",
                    "record_created",
                                    "project already created, ref#1, #met #onsubmit,
									cls#".get_class($this)
                );
                
                    $_REQUEST["create_proj".$this->subject]= null;
                    $_REQUEST['id_proj']= $data['id_proj'];
                }
            }
            
            //----------------------------
            
            if ($_REQUEST['id_proj_type']) {
                $_REQUEST['proj_type']= $_REQUEST['id_proj_type'];
            }
            
            if ($_REQUEST['id_proj_status']) {
                $_REQUEST['proj_status']= $_REQUEST['id_proj_status'];
            }
        
        
            //---CREATE
        
            if ($_REQUEST["create_proj_".$this->subject]) {
                $q->set_filter("id_client IN (".$list.") AND id_proj <> '".$this->id."' ");
                $data= $this->set_data_from_id("select_client1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $this->throw_msg(
                    "confirm",
                    "record_created",
                                    "project already saved, ref#1, #met #onsubmit,
									cls#".get_class($this)
                );
                
                    $_REQUEST["create_".$this->subject]= null;
                    $_REQUEST['id_proj']= $data['id_proj'];
                
                    //return;
                }
            
                //----------------------------
                        
                $this->var_to_queries($_REQUEST);
        
            
                $q->set_var("proj_dept", $u->id_dept);
            
            
                //---for transfer1
            
                $q->set_var("id_user", $u->id);
                $q->set_var("dept_comingfrom", $u->id_dept);
                $q->set_var("dept_goingto", $u->id_dept);
                $q->set_var("describe_trans", $t->project_created);
                $q->set_var("date_trans", "NOW()");
            
            
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
									cls#".get_class($this)
                    );
                                    
                    $this->set_is("submitted", true);
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#met #onsubmit,
									cls#".get_class($this)
            );
                                    
            
                //---------------
            
                $q->set_var("id_proj", $new_id);
                $q->set_var("id_list", $list);
            
                $q->sql_action("new_project_subcribers");
            
                $this->send_sms_to_subscribers($s->sms_new_project_subscribers_action, 2, $new_id);
            
                //----------------
            }
                    
        
            //-SAVE
                        
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_filter("id_client IN (".$list.") AND id_proj <> '".$this->id."' ");
                $data= $this->set_data_from_id("select_client1", "", "", $numrows);
            
                if ($numrows >= 1) {
                    $this->throw_msg(
                    "confirm",
                    "record_saved",
                                    "project already saved, ref#2, #met #onsubmit,
									cls#".get_class($this)
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
									cls#".get_class($this)
                    );
                    
                    $this->set_is("submitted", true);
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#met #onsubmit,
									cls#".get_class($this)
            );
                                    
                                    
                //---------------
                
                $q->set_var("id_proj", $this->id_proj);
                $q->set_var("id_list", $list);
                
                $q->sql_action("new_project_subcribers");
                
                $this->send_sms_to_subscribers($s->sms_new_project_subscribers_action, 2, $this->id_proj);
                
                //----------------
            }
            

            if ($_REQUEST["create_proj_".$this->subject] && isset($new_id)) {
                $_REQUEST['id_proj']= $new_id;
            }
        }
        
        if ($_REQUEST['id_proj']) {
            $_REQUEST['id_proj']= $_REQUEST['id_proj'];
        
            $this->initialize();
        
            $this->objs[0]->set_has("save_mode", true);
        
            $this->config();
        
            $this->objs[2]= new list_clients();
            $this->objs[2]->initialize();

            $this->objs[2]->set_option("new_project");
                    
            $this->objs[2]->config();
        
            $this->objs[2]->set_title($t->new_project_clients, "h2");

            $this->objs[2]->set_has("submit", false);

            $this->has['save_mode']= true;
        }
    }

    
    
    
    
    public function set_data()
    {
        global $q;

    
        parent::set_data("child");

        if (is_numeric($_REQUEST['parent_id_proj'])) {
            $q->set_filter("project1.id_proj='".$_REQUEST['parent_id_proj']."'");
            $proj_data= $this->set_data_from_id("select_project1");
        
            $this->data['id_file']= $proj_data['id_file'];
            $this->data['proj_type']= $proj_data['proj_type'];
            $this->data['proj_dept']= $proj_data['proj_dept'];
        }
        
        if (!$this->data['id_file']) {
            f1::echo_error("No valid #id_file in met#set_data, cls#create_proj_from_project_handler");
        }
    }
        
        
    
    
    
    public function start()
    {
        global $u;


        if (isset($this->data['proj_dept']) && ($this->data['proj_dept'] != $u->id_dept)) {
            if (!$u->is_admin()) {
                $this->throw_msg("fatal_error", "access_denied", "met#start, 
			cls#".get_class($this).", foreign project");
            } else {
                $this->throw_msg("error", "foreign_project_not_editable", "met#start, 
			cls#".get_class($this).", foreign project");
                $this->is['displayable']= false;
            }
        }

    
    
        if ($this->objs[1]->get_numrows() <= 1) {
            $this->objs[0]->set_displayable(false);
        }
    }
    
    
    
    
    
    public function display_submit()
    {
        global $u, $t;


        echo "<input type=\"hidden\" name=\"parent_id_proj\" value=\"{$this->id}\" />";

        echo "<input type=\"hidden\" name=\"proj_type\" value=\"{$this->data['proj_type']}\" />";

        echo "<input type=\"hidden\" name=\"id_file\" value=\"{$this->data['id_file']}\" />";


        if ($_REQUEST['new']) {
            echo <<<HTML
		

<a class="button" href="{$this->i_var['previous_url']}" >{$t->previous}</a>



HTML;
        }
        

        if ($_REQUEST['id_proj'] && $this->objs[1]->get_numrows() > 1) {
            echo <<<HTML
		
<input type="submit" class="submit_button" name="new" value="{$t->new}"/>

<input type="submit" class="submit_button" name="save_{$this->subject}" value="{$t->save}"/>

HTML;
        } elseif ($this->objs[1]->get_numrows() > 1) {
            echo <<<HTML

<input type="submit" class="submit_button" name="create_proj_{$this->subject}" value="{$t->create}"/>

HTML;
        }
    }
}
