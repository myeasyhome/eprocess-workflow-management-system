<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_department extends html_form_adapter
{
    public function config()
    {
        global $t, $q;

    
        parent::config();

        $this->reference= $this->i_var['form_name']= "edit_department";

        $this->set_title($t->create." | ".$t->edit." | ".$t->department, "h2");

        $this->i_var['textarea_rows']="3";
        $this->i_var['textarea_cols']="90";

        if (($_GET['id'] && ($this->id= $this->require_id("numeric", $_GET['id'])) && $this->id)
                || ($_REQUEST['id_dept'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_dept'])) && $this->id)) {
            $this->data_source= "select_department1";
            $q->set_filter("id_dept=".$this->id);
        } else {
            $this->is['new']= true;
        }

        $this->define_form();
    }
    
    
    
    
    
    public function define_form()
    {
        global $s, $u, $t;
    
        $fields=array();

        $fields[]="name_dept";
        $fields[]="determ_dept";
        $fields[]="dept_describe";
        $fields[]="dept_type";
        $fields[]="has_search";
        $fields[]="has_write_letter";
        $fields[]="has_send_sms";

        $this->make_sections("input_text", 2);
        $this->make_sections("textarea", 1);
        $this->make_sections("radio", 4);

        $this->ignore[]= "dept_describe";


        $this->add_select_array("dept_type", $s->department_type);
        $this->add_select_array("has_search", $s->no_yes);
        $this->add_select_array("has_write_letter", $s->no_yes);
        $this->add_select_array("has_send_sms", $s->no_yes);


        if ($this->id) {
            $fields[]="id_dept";
            $this->make_sections("hidden", 1);
        }
                
        $this->set_fields($fields);

        $this->fields['id_dept']= $this->id;
    }
    
    
    
    
    
    public function validate_data()
    {
        global $s, $c;

        if ($this->data) {
            $list= $s->department_type;

            $this->field_param['dept_type']['selected']= $list[$this->data['dept_type']];
        
            $list= $s->no_yes;
        
            $this->field_param['has_search']['selected']= $list[$this->data['has_search']];
            $this->field_param['has_write_letter']['selected']= $list[$this->data['has_write_letter']];
            $this->field_param['has_send_sms']['selected']= $list[$this->data['has_send_sms']];
        }
    }
    
    
    
    
    
    public function onsubmit()
    {
        global $q;
        


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            $this->var_to_queries($_REQUEST);
                                        
            if ($_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_department1")) {
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
                $q->set_var("id_dept", $this->id);
                    
                if (!$q->sql_action("delete_from_department1") || !$q->sql_action("save_department1")) {
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
                $q->set_var("id_dept", $this->id);
                    
                if (!$q->sql_action("delete_from_department1")) {
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
