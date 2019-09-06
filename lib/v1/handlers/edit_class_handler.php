<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_class_handler extends form_handler
{
    protected $selectors;




    public function initialize()
    {
        global $c, $t;


        parent::initialize();


        $this->set_title($t->edit_class);

        $this->forms[0]= new edit_class();


        $this->selectors[0]= new select_service();
        $this->selectors[1]= new select_work();
        $this->selectors[2]= new select_rank();
        $this->selectors[3]= new select_qualification();

        $this->selectors[0]->initialize();
        $this->selectors[1]->initialize();
        $this->selectors[2]->initialize();
        $this->selectors[3]->initialize();

        $this->initialize_forms();
    }
    
    
    
    
    public function config()
    {
        global $c, $s, $t;
    
        parent::config();

        $this->has['common_data_source']= true;

        $this->has['title']= true;
        $this->has['delete']= true;


        $this->i_var['current_url']= $c->update_current_url(array("id_serv", "id_work", "id_rank", "create_".$this->subject, "id_class" ));

        if ($_REQUEST['id_class']) {
            $this->i_var['current_url'] .= "&id_class=".$_REQUEST['id_class'];
        } elseif ($_REQUEST["create_".$this->subject]) {
            $this->i_var['current_url'] .= "&create_{$this->subject}=yes";
        }

        
        $this->selectors[0]->config();
        $this->selectors[1]->config();
        $this->selectors[2]->config();
        $this->selectors[3]->config();


        //------Redirect ----------------------------------------
        
        $this->selectors[0]->set_has("redirect_script", true);
        $this->selectors[1]->set_has("redirect_script", true);
    
        $current_url= $this->i_var['current_url'];
        $current_url .= "&id_serv=";
        $this->selectors[0]->set_select_properties(" onchange=\"list_goto(this, '{$current_url}')\" ");
    
        if ($_REQUEST['id_serv']) {
            $current_url= $this->i_var['current_url'];
            $current_url .= "&id_serv=".$_REQUEST['id_serv']."&id_work=";
        }
        
        $this->selectors[1]->set_select_properties(" onchange=\"list_goto(this, '{$current_url}')\" ");
    
        //----------------------------

        $this->set_title($t->create." | ".$t->edit.": ".$t->class, "h2");

        $this->reference= $this->i_var['form_name']= "edit_class";

        $this->forms[0]->set_has("submit", false);
        $this->forms[0]->set_has("form", false);

        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_class";

        
        if ($_REQUEST['id_class']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_class']);
            $this->data_source="select_class_all";
            $this->has['filter']= true;
        } else {
            $this->is['new']= true;
        }
        
        $this->forms[0]->set_id($this->id);
        $this->forms[0]->define_form();
    }

    
    
    
    
    
    public function set_filter()
    {
        global $q;

    
        if ($this->id) {
            $q->set_filter("id_class='".$this->id."'");
        }
    }

        
    
    
    
    public function onsubmit()
    {
        global $c, $s, $m, $q, $v;


        if (!$_REQUEST["yes_delete_".$this->subject]) {
            if ($_REQUEST['id_serv']) {
                $this->selectors[0]->set_selected($_REQUEST['id_serv']);
                $this->has['selected_service']= true;
            }
            
            if ($_REQUEST['id_work']) {
                $this->selectors[1]->set_selected($_REQUEST['id_work']);
                $this->has['selected_work']= true;
            }
            
            if ($_REQUEST['id_rank']) {
                $this->selectors[2]->set_selected($_REQUEST['id_rank']);
                $this->has['selected_rank']= true;
            }
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
            
            
            
            if (!$_REQUEST['id_rank'] && !$_REQUEST["yes_delete_".$this->subject]
                    && !$_REQUEST['cancel']) {
                $this->throw_msg(
                "error",
                "no_rank",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
            
            

            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_class1")) {
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
                $q->set_var("id_class", $this->id);
                    
                if (!$q->sql_action("delete_from_class1") || !$q->sql_action("save_class1")) {
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
                $q->set_var("id_class", $this->id);
                    
                if (!$q->sql_action("delete_from_class1")) {
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


        if (!$this->is['new']) {
            if ($this->data['id_serv'] && !$_REQUEST['id_serv']) {
                $this->selectors[1]->set_data("id_serv", $this->data['id_serv']);
            }
                        
            if ($this->data['id_work'] && !$_REQUEST['id_work']) {
                $this->selectors[2]->set_data("id_work", $this->data['id_work']);
            }
        }

        $this->selectors[0]->set_data();
        $this->selectors[1]->set_data();
        $this->selectors[2]->set_data();
        $this->selectors[3]->set_data();


        if (!$this->is['new'] || $this->is['submitted']) {
            if ($this->data['id_serv'] || $_REQUEST['id_serv']) {
                $id_serv= $_REQUEST['id_serv'] ? $_REQUEST['id_serv'] : $this->data['id_serv'];
                $this->selectors[0]->set_selected($id_serv);
                $this->has['selected_service']= true;
            }

            if ($this->data['id_work'] || $_REQUEST['id_work']) {
                $id_work= $_REQUEST['id_work'] ? $_REQUEST['id_work'] : $this->data['id_work'];
                $this->selectors[1]->set_selected($id_work);
                $this->has['selected_work']= true;
            }
            
            if ($this->data['id_rank'] || $_REQUEST['id_rank']) {
                $id_rank= $_REQUEST['id_rank'] ? $_REQUEST['id_rank'] : $this->data['id_rank'];
                $this->selectors[2]->set_selected($id_rank);
                $this->has['selected_rank']= true;
            }
            
            if ($this->data['id_qual'] || $_REQUEST['id_qual']) {
                $id_qual= $_REQUEST['id_qual'] ? $_REQUEST['id_qual'] : $this->data['id_qual'];
                $this->selectors[3]->set_selected($id_qual);
            }
        }
    }
    
    
    
    
    
    
    public function display()
    {
        global $t;


        if ($this->data && !isset($this->data['id_serv']) && !$_REQUEST["create_".$this->subject]
            && !$_REQUEST["yes_delete_".$this->subject] && !$_REQUEST["ask_delete_".$this->subject]) {
            echo "<div class=\"error\" >".$t->no_service_selected."</div>";
        } elseif ($this->data && !isset($this->data['id_work']) && !$_REQUEST["create_".$this->subject]
            && !$_REQUEST["yes_delete_".$this->subject] && !$_REQUEST["ask_delete_".$this->subject]) {
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

            // select work
     
            if ($this->has['selected_service']) {
                echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_work}:</p>

HTML;

                $this->selectors[1]->display();

                echo "</{$this->sections_tag}>";
            }
            
            // select  rank
            if ($this->has['selected_work']) {
                echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_rank}:</p>

HTML;

                $this->selectors[2]->display();

                echo "</{$this->sections_tag}>";

                $this->forms[0]->display();
        
                echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_qual}:</p>

HTML;

                $this->selectors[3]->display();

                echo "</{$this->sections_tag}>";

                $this->display_submit();
            }
        }
        
        echo "</form>";
    }
}
