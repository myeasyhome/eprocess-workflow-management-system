<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_stat_report extends html_form_adapter
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->selector= new select_department();
        $this->selector->initialize();
    }
    
    
    
    

    public function config()
    {
        global $u, $t, $q;


        if (!$u->is_super_admin() && !$u->has_stats) {
            $this->throw_msg("fatal_error", "access_denied", "met#config, 
			cls#".get_class($this).", no access to stats");
            return;
        }
        
    
        parent::config();

        $this->selector->config();

        $this->i_var['textarea_rows']="2";
        $this->i_var['textarea_cols']="90";

        $this->reference= $this->i_var['form_name']= "edit_stat_report";

        $this->set_title($t->create." | ".$t->edit." | ".$t->stat_report, "h2");

        if (($_GET['id_stat_report'] && ($this->id= $this->require_id("numeric", $_GET['id_stat_report'])) && $this->id)
                || ($_REQUEST['id_stat_report'] &&
                        ($this->id= $this->require_id("numeric", $_REQUEST['id_stat_report'])) && $this->id)) {
            $this->data_source= "select_stat_report1";
            $q->set_filter("id_stat_report=".$this->id);
        } else {
            $this->is['new']= true;
        }

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="stat_method";
        $fields[]="title_report";
        $fields[]="describe_report";

        $this->ignore[]="describe_report";

        $this->make_sections("input_text", 2);
        $this->make_sections("textarea", 1);

        if ($this->id) {
            $fields[]="id_stat_report";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        $this->fields['id_stat_report']= $this->id;
    }
    
    
    
    
    public function validate_data()
    {
        global $s, $c;
    }
    
    
    
    
    public function onsubmit()
    {
        global $q;
        


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            $this->var_to_queries($_REQUEST);
                        
                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_stat_report1")) {
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
                $q->set_var("id_stat_report", $this->id);
                    
                if (!$q->sql_action("delete_from_stat_report1") || !$q->sql_action("save_stat_report1")) {
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
                $q->set_var("id_stat_report", $this->id);
                    
                if (!$q->sql_action("delete_from_stat_report1")) {
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
    
        parent::set_data();
        $q->clear("all");

        $this->selector->set_data();
        $this->selector->set_selected($this->data['id_dept']);
    }
    
    

    
    

    public function display_skeleton()
    {
        global $t;
    
        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_dept}:</p>
HTML;

        $this->selector->display();

        echo "</{$this->sections_tag}>";
    }
}
