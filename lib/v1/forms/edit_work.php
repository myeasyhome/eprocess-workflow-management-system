<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/

class edit_work extends html_form_adapter
{
    protected $selectors;




    public function initialize()
    {
        global $c, $t;


        parent::initialize();


        $this->selectors[0]= new select_service();
        $this->selectors[0]->initialize();
    }
    
    
    
    
    

    public function config()
    {
        global $t, $q;

    
        parent::config();


        $this->selectors[0]->config();

        $this->reference= $this->i_var['form_name']= "edit_work";

        $this->set_title($t->create." | ".$t->edit.": ".$t->profession, "h2");


        $this->i_var['form_name']= "edit_work";
        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_work";



        if (($_GET['id'] && ($this->id= $this->require_id("numeric", $_GET['id'])) && $this->id)
                || ($_REQUEST['id_work'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_work'])) && $this->id)) {
            $this->data_source= "select_work1";
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

        $fields[]="name_work";
        $fields[]="determ_work";


        $this->make_sections("input_text", 2);

        if ($this->id && !$_REQUEST["yes_delete_".$this->subject]) {
            $fields[]="id_work";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        $this->fields['id_work']= $this->id;
    }
    
    
    
    
    public function set_filter()
    {
        global $q;
    
        if ($this->id) {
            $q->set_filter("id_work=".$this->id);
        }
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        global $q;


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            if (!$_REQUEST['id_serv']) {
                $this->throw_msg(
                "error",
                "no_service",
                                        "#met #onsubmit"
            );
                                        
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
        
        
            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_work1")) {
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
                $q->set_var("id_work", $this->id);
                    
                if (!$q->sql_action("delete_from_work1") || !$q->sql_action("save_work1")) {
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
                $q->set_var("id_work", $this->id);
                    
                if (!$q->sql_action("delete_from_work1")) {
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

        if ($this->data['id_serv'] && !$_REQUEST["yes_delete_".$this->subject]) {
            $this->selectors[0]->set_selected($this->data['id_serv']);
        }
    }

    
    
    
    
    public function display()
    {
        global $t;


        $this->display_title();

        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        $this->has['form']= false;
        
        
        if ($this->data && !isset($this->data['id_serv'])
                && !$_REQUEST["create_".$this->subject] && !$_REQUEST["yes_delete_".$this->subject]
                && !$_REQUEST['cancel']) {
            echo "<div class=\"error\" >".$t->no_service_selected."</div>";
        } else {
            if (($this->selected || $this->id) && $this->has['delete'] && $_REQUEST["ask_delete_".$this->subject]) {
                $this->ask_delete();
            }
        
        
            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_serv}:</p>
HTML;

            $this->selectors[0]->display();

            echo "</{$this->sections_tag}>";


            parent::display();
        }
        
        echo "</form>";
    }
}
