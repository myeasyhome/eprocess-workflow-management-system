<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_qualification extends html_form_adapter
{
    public function config()
    {
        global $t, $q;

    
        parent::config();

        $this->i_var['input_size']= "150";
        $this->i_var['maxlength']= "150";

        $this->reference= $this->i_var['form_name']= "edit_qualification";

        $this->set_title($t->create." | ".$t->edit, "h2");

        if (($_GET['id'] && ($this->id= $this->require_id("numeric", $_GET['id'])) && $this->id)
                || ($_REQUEST['id_qual'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_qual'])) && $this->id)) {
            $this->data_source= "select_qualification1";
            $this->has['update_data_from_global']= false;
            $q->set_filter("id_qual=".$this->id);
        } else {
            $this->is['new']= true;
        }

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="name_qual";
        $fields[]="determ_qual";
        $fields[]="qual_level";
        $fields[]= $this->is_numeric[]= "trial_period";

        $this->make_sections("input_text", 2);
        $this->make_sections("radio", 1);
        $this->make_sections("input_text", 1);

        $this->add_select_array("qual_level", $s->qual_levels);


        if ($this->id) {
            $fields[]="id_qual";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        $this->fields['id_qual']= $this->id;
    }
    
    
    
    
    public function validate_data()
    {
        global $s, $c;

        if ($this->data) {
            $list= $s->department_type;

            $this->field_param['qual_level']['selected']= $list[$this->data['qual_level']];
        }
    }
    
    
    
    
    public function onsubmit()
    {
        global $s, $q;


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            if (is_numeric($_REQUEST['status'])) {
                $temp= $this->shelf['status'][($_REQUEST['status'])];
                $temp = explode("_", $temp);
            
                $_REQUEST['status']= $temp[0];
            }
        
            $qual_levels= $s->qual_levels;
            $_REQUEST['qual_level']= $qual_levels[$_REQUEST['qual_level']];
        
            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_qualification1")) {
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
                $q->set_var("id_qual", $this->id);
                    
                if (!$q->sql_action("delete_from_qualification1") || !$q->sql_action("save_qualification1")) {
                    $this->throw_msg("error", "save_failed", "#met #onsubmit");
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg("confirm", "record_saved", "#met #onsubmit");
            }
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_qual", $this->id);
                    
                if (!$q->sql_action("delete_from_qualification1")) {
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
}
