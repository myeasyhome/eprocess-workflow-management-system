<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_project_handler extends form_handler
{
    protected $selectors;




    public function initialize()
    {
        global $c, $m, $t;


        parent::initialize();


        $this->set_title($t->edit_project);

        $this->has['title']= true;

        $this->forms[0]= new edit_project_p1();

        $this->selectors[0]= new select_project_type();
        $this->selectors[0]->initialize();

        if ($_REQUEST['id_proj'] && ($m->view_ref == "edit_project")) {
            $this->selectors[1]= new select_project_status();
            $this->selectors[1]->initialize();
        }

        $this->initialize_forms();
    }
    
    
    
    
    public function config()
    {
        global $s;
    
        parent::config();

        $this->has['common_data_source']= true;
        $this->has['delete']= false;

        $this->subject= "project";

        $this->forms[0]->define_form();

        $this->selectors[0]->config();

        if (isset($this->selectors[1])) {
            $this->selectors[1]->config();
        }

        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_project";

        if ($_REQUEST['id_proj']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_proj']);
            $this->data_source="select_project1";
            $this->has['filter']= true;
        } else {
            $this->is['new']= true;
            $this->has['data']= false;
        }
    }

    
    
    
    
    
    public function set_filter()
    {
        global $q;

    
        if ($this->id) {
            $q->set_filter("project1.id_proj='".$this->id."'");
        }
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        global $c, $s, $m, $q, $v;


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
        && $this->is_validated()) {
            if ($_REQUEST["save_".$this->subject]
            && empty($_REQUEST['id_file'])) {
                $q->set_filter("project1.id_proj='".$this->id."'");
                $data= $this->set_data_from_id("select_project1");
                $q->clear("filter");
            
                if (is_array($data)) {
                    $_REQUEST['id_file']= $data['id_file'];
                    $_REQUEST['proj_dept']= $data['proj_dept'];
                } else {
                    f1::echo_error("query select_project1 failed in met#onsubmit, cls#edit_project_handler");
                }
            }
            
            if ($_REQUEST['id_proj_type']) {
                $_REQUEST['proj_type']= $_REQUEST['id_proj_type'];
            }
        
            if ($_REQUEST['id_proj_status']) {
                $_REQUEST['proj_status']= $_REQUEST['id_proj_status'];
            }


            $this->var_to_queries($_REQUEST);
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_var("last_trans", $data['last_trans']);
                $q->set_var("id_proj", $this->id);
                $q->set_var("id_list", 0);
                    
                if (!$q->sql_action("delete_from_project1") || !$q->sql_action("save_project1")) {
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
                                    
                $this->is['submitted']= true;
            }
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_proj", $this->id);
                    
                if (!$q->sql_action("delete_from_project1")) {
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
        
    
    
    
    
    public function set_data($name="", $value=null)
    {
        global $m, $u, $q;
    
        parent::set_data();

        
        //---------------------
        
        if ($this->data['proj_type']) {
            $q->set_filter("id_proj_type='".$this->data['proj_type']."'");
            $this->data['proj_type_dept']= $this->set_data_from_id("select_project_type1", "", "id_dept");
        }
        
        if (($m->view_ref == "create_project") ||
            ($this->data['proj_type_dept'] && ($this->data['proj_type_dept'] == $u->id_dept))) {
            $this->selectors[0]->set_data();
            $this->has['select_id_proj_type']= true;
        } else {
            $this->has['select_id_proj_type']= false;
        }
        
        //--------------

        if (isset($this->selectors[1])) {
            $this->selectors[1]->set_data();
        }
        
        //---------------------------
        
        if ($this->has['select_id_proj_type']  && ($this->selectors[0]->get_numrows() < 1)) {
            $this->throw_msg(
            "error",
            "no_proj_type_to_select",
                                    "#met #set_data, cls#".get_class($this)
        );
                                    
            $this->has['create']= false;
            $this->has['edit']= false;
            return;
        }
        
        //---------------------------------

        if ($this->has['select_id_proj_type']) {
            $proj_type= is_numeric($_REQUEST['id_proj_type']) ? $_REQUEST['id_proj_type'] : $this->data['proj_type'];
        
            if ($proj_type) {
                $this->selectors[0]->set_selected($proj_type);
            }
        }
            
        if (isset($this->selectors[1]) && $this->data['proj_status']) {
            $this->selectors[1]->set_selected($this->data['proj_status']);
        }
    }
    
    
    
    
    
    
    public function start()
    {
        global $u;
    
        parent::start();


        if ($this->numrows >= 1) {
            if ($this->data['proj_dept'] != $u->id_dept) {
                if (!$u->is_admin()) {
                    $this->throw_msg("fatal_error", "access_denied", "met#start, 
				cls#".get_class($this).", foreign project");
                } else {
                    $this->throw_msg("error", "foreign_project_not_editable", "met#start, 
				cls#".get_class($this).", foreign project");
                    $this->is['displayable']= false;
                }
            }
        }
    }
    
    
    
    
    
    
    
    public function display_submit($submit_name, $submit_value, $submit_wrap_tag)
    {
        parent::display_submit($submit_name, $submit_value, $submit_wrap_tag);
    }
    
    
    
    
    
    public function display_skeleton()
    {
        global $m, $u, $t;


        if (($m->view_ref == "create_project") ||
            $this->has['select_id_proj_type']) {
            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_proj_type}:</p>
HTML;

            $this->selectors[0]->display();

            echo "</{$this->sections_tag}>";
        } elseif ($this->data['proj_type']) {
            echo <<<HTML

<input type="hidden" name="proj_type" value="{$this->data['proj_type']}"/>	
HTML;
        }
        
        //------------------

        if (isset($this->selectors[1])) {
            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_proj_status}:</p>
HTML;

            $this->selectors[1]->display();

            echo "</{$this->sections_tag}>";
        }

        parent::display_skeleton();
    }
    
    
    
    
    
    
    public function display()
    {
        global $t;

        if ($this->is['displayable']) {
            parent::display();
        }
    }
}
