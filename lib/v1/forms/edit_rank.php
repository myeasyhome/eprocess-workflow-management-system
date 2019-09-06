<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_rank extends html_form_adapter
{
    protected $selectors;




    public function initialize()
    {
        global $c, $t;


        parent::initialize();


        $this->selectors[0]= new select_service();
        $this->selectors[1]= new select_work();


        $this->selectors[0]->initialize();
        $this->selectors[1]->initialize();
    }
    
    
    
    
    

    public function config()
    {
        global $c, $m, $t, $q;

    
        parent::config();


        $this->i_var['current_url']= $c->update_current_url(array("id_serv", "id_work", "create_".$this->subject, "id_rank" ));


        if ($_REQUEST["create_".$this->subject] || $_REQUEST["yes_delete_".$this->subject]) {
            $this->i_var['current_url'] .= "&create_{$this->subject}=yes";
        } elseif ($_REQUEST['id_rank']) {
            $this->i_var['current_url'] .= "&id_rank=".$_REQUEST['id_rank'];
        }
    
        
        $this->selectors[0]->config();
        $this->selectors[1]->config();


        //------Redirect ----------------------------------------

        $this->selectors[0]->set_has("redirect_script", true);
        
        $current_url= $this->i_var['current_url'];
        $current_url .= "&id_serv=";
        $this->selectors[0]->set_select_properties(" onchange=\"list_goto(this, '{$current_url}')\" ");

        //----------------------------

        
        $this->reference= $this->i_var['form_name']= "edit_rank";

        $this->set_title($t->create." | ".$t->edit.": ".$t->rank, "h2");

        $this->i_var['form_name']= "edit_rank";
        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_rank";

        if (($_GET['id_rank'] && ($this->id= $this->require_id("numeric", $_GET['id_rank'])) && $this->id)
                || ($_REQUEST['id_rank'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_rank'])) && $this->id)) {
            $this->data_source= "select_rank1";
            $this->has['update_data_from_global']= false;
            $this->has['filter']= true;
        } else {
            $this->is['new']= true;
        }

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="name_rank";
        $fields[]="determ_rank";
        $fields[]="work_cat";

        $this->make_sections("input_text", 2);
        $this->make_sections("radio", 1);

        $this->add_select_array("work_cat", $s->work_categories);


        if ($this->id && !$_REQUEST["yes_delete_".$this->subject]) {
            $fields[]="id_rank";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        $this->fields['id_rank']= $this->id;

        $list= $s->work_categories;
        $this->field_param['work_cat']['selected']= isset($_REQUEST['work_cat']) ? $list[$_REQUEST['work_cat']] : 0;
    }
    
    
    
    
    
    
    public function set_filter()
    {
        global $q;
    
        if ($this->id) {
            $q->set_filter("id_rank=".$this->id);
        }
    }


    
    
    
    
    public function onsubmit()
    {
        global $q;


        if ($_REQUEST['id_serv']) {
            $this->selectors[0]->set_selected($_REQUEST['id_serv']);
            $this->has['selected_service']= true;
        }
        
        if ($_REQUEST['id_work']) {
            $this->selectors[1]->set_selected($_REQUEST['id_work']);
            $this->has['selected_work']= true;
        }
        

        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            if (!$_REQUEST['id_serv'] && !$_REQUEST["yes_delete_".$this->subject]
                    && !$_REQUEST['cancel']) {
                $this->throw_msg(
                "error",
                "no_service",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
        
        
                            
            if (!$_REQUEST['id_work'] && !$_REQUEST["yes_delete_".$this->subject]
                    && !$_REQUEST['cancel']) {
                $this->throw_msg(
                "error",
                "no_work",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
        
        
        
            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_rank1")) {
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
                $q->set_var("id_rank", $this->id);
                    
                if (!$q->sql_action("delete_from_rank1") || !$q->sql_action("save_rank1")) {
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
                $q->set_var("id_rank", $this->id);
                    
                if (!$q->sql_action("delete_from_rank1")) {
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
        parent::set_data();

        $this->selectors[0]->set_data();
        $this->selectors[1]->set_data();


        if ($this->data['id_serv'] && !$_REQUEST['id_serv']) {
            $this->selectors[0]->set_selected($this->data['id_serv']);
            $this->has['selected_service']= true;
        }

        if ($this->data['id_work'] && !$_REQUEST['id_work']) {
            $this->selectors[1]->set_selected($this->data['id_work']);
            $this->has['selected_work']= true;
        }
    }
    
    
    
    
    
    
    
    public function display()
    {
        global $t;


        $this->display_title();

        if ($this->data && !isset($this->data['id_serv']) && !$_REQUEST["create_".$this->subject]
            && !$_REQUEST["yes_delete_".$this->subject]) {
            echo "<div class=\"error\" >".$t->no_service_selected."</div>";
        } elseif ($this->data && !isset($this->data['id_work']) && !$_REQUEST["create_".$this->subject]
            && !$_REQUEST["yes_delete_".$this->subject]) {
            echo "<div class=\"error\" >".$t->no_work_selected."</div>";
        } else {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
            $this->has['form']= false;
    
    
            if (($this->selected || $this->id) && $this->has['delete'] && $_REQUEST["ask_delete_".$this->subject]) {
                $this->ask_delete();
            }


            // select  a service
        
            echo <<<HTML
<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_serv}:</p>
HTML;

            $this->selectors[0]->display();

            echo "</{$this->sections_tag}>";

            // select  a profession
    
            if ($this->has['selected_service']) {
                echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_work}:</p>

HTML;

                $this->selectors[1]->display();

                echo "</{$this->sections_tag}>";

                parent::display();
            }
        }
        
        echo "</form>";
    }
}
