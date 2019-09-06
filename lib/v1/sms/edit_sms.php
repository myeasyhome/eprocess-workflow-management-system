<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class edit_sms extends html_form_adapter
{
    protected $dummy_document;
    protected $dummy_clients;




    public function config($option="")
    {
        global $m, $t, $q;

    
        parent::config();

        $this->has['title_sms']= true;
        $this->has['form']= false;

        $this->i_var['form_name']= "edit_sms";
        $this->i_var['form_method']= "POST";

        $this->i_var['target_url']= $s->root_url."?v=".$m->view_ref;

        $this->i_var['input_size']= 50;
        $this->i_var['maxlength']= 50;

        $this->i_var['textarea_rows']=7;
        $this->i_var['textarea_cols']=50;

        $this->subject= "sms";

        $this->reference= $this->i_var['form_name']= "edit_sms";

        //------------------
        
        if ($_REQUEST['preview_sms']) {
            $this->set_title($t->preview." | ".$t->sms, "h2");
        } else {
            $this->set_title($t->create." | ".$t->edit.": ".$t->sms, "h2");
        }
        
        //------------------

        if ($_REQUEST['id_sms'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_sms'])) && $this->id) {
            $this->data_source= "select_sms1";
            $this->has['filter']= true;
            $this->has['update_data_from_global']= false;
        } else {
            $this->is['new']= true;
        }

        if ($option != "child") {
            $this->define_form();
        }
        
        //---------------------

        $this->dummy_document= array();
        $this->dummy_clients= array();
    }
    
    
    
    
        
    public function define_form()
    {
        $fields= array();

        if ($this->is['new']) {
            $fields[]= "action";
            $this->make_sections("input_text", 1);
        }

        $fields[]= "sms";
        $this->make_sections("textarea", 1);


        if ($this->id) {
            $fields[]="id_sms";
            $fields[]= "action";
            $this->make_sections("hidden", 2);
        }

        $this->set_fields($fields);
    }
    
    
    
    
    
    
    public function validate_data()
    {
        global $s, $c;
    }

    
    
    
    
    public function onsubmit()
    {
        global $u, $q;


        if ($_REQUEST['back_from_preview']) {
            $this->has['compulsory_sign']= false;
            return;
        }
        
        
        //------------------
        
        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            $this->var_to_queries($_REQUEST);
            $q->set_var("id_user", $u->id);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_sms1")) {
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
                $q->set_var("id_sms", $this->id);
                    
                if (!$q->sql_action("delete_from_sms1") || !$q->sql_action("save_sms1")) {
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
            
            
            if ($u->is_super_admin() && $_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_sms", $this->id);
                    
                if (!$q->sql_action("delete_from_sms1")) {
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
    
    
    
    
    public function set_filter()
    {
        global $q;
    
        if ($this->id) {
            $q->set_filter("id_sms='".$this->id."'");
        }
    }
    
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;


        parent::display_submit();

        if (!$this->is['new']) {
            echo <<<HTML

<input type="submit"  class="submit_button" name="preview_sms" value="{$t->preview}"/>

HTML;
        }
    }
    
    
    
    
    
    
    public function display()
    {
        global $t;
    
    
        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
        if ($_REQUEST['preview_sms']) {
            process_sms::process($_REQUEST['sms'], $this->dummy_document, $this->dummy_clients);
        
            $this->display_title();
        
            buttons::back(true);
        
            echo "<div class=\"sms\">";
    
            echo $_REQUEST['sms'];
        
            echo "</div>";
        } else {
            $this->display_title();
        
            echo "<div class=\"sms\">";
                        
            echo $t->use_sms_style_tags;

            parent::display();
        
            echo "</div>";
        }
        
        echo "</form>";
    }
}
