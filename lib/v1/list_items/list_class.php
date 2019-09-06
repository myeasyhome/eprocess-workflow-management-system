<?php


class list_class extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();


        $this->reference="list_class";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_class";
        $this->id_tag="id_class";
        $this->set_title($t->class, "h2");
        $this->data_source="select_class_all";

        $this->display_list= array("id_class", "name_serv", "name_work", "name_rank", "name_work_cat", "scale", "echelon", "work_class", "work_index", "name_qual");

        $this->has['create']= true;

        if ($this->option == "client_class") {
            $this->id= $this->require_id("numeric", $_REQUEST['id_client']);
            $this->has['filter']= true;
            $this->has['create']= false;
            $this->has['edit']= false;
            $this->has['delete']= true;
        
            $this->display_list= array("id_class", "name_serv", "name_work", "name_rank", "name_work_cat", "scale", "echelon", "work_class", "work_index");
        } elseif ($this->option == "all_class") {
            $this->has['create']= false;
            $this->has['edit']= false;
            $this->has['delete']= false;
        }
        

        if (is_numeric($_REQUEST['id_client']) && !$_GET['id_client']) {
            $this->i_var['current_url'] .= "&id_client=".$_REQUEST['id_client'];
        }
        
        if (is_numeric($_REQUEST['id_client_class']) && !$_GET['id_client_class']) {
            $this->i_var['current_url'] .= "&id_client_class=".$_REQUEST['id_client_class'];
        }
    }

    
    
    
    
    
    public function onsubmit()
    {
        global $q;


        if ($_REQUEST[$this->id_tag] && ($_REQUEST['form_name'] == $this->i_var['form_name'])) {
            $q->set_var($this->id_tag, $_REQUEST[$this->id_tag]);
                
            if ($this->option == "all_class") {
                if ($_REQUEST["create_".$this->subject]) {
                    if (!$q->sql_action("insert_client_class1")) {
                        $this->throw_msg(
                            "error",
                            "create_failed",
                                        "#cls #edit_client, #met #onsubmit"
                        );
                        
                        return;
                    }
                    
                    $this->throw_msg(
                    "confirm",
                    "record_created",
                                        "#cls #edit_client, #met #onsubmit"
                );
                }
            } elseif ($this->option == "client_class") {
                if ($_REQUEST["yes_delete_".$this->subject]) {
                    if (!$q->sql_action("delete_from_client_class1")) {
                        $this->throw_msg(
                            "error",
                            "delete_failed",
                                        "#cls #edit_client, #met #onsubmit"
                        );
                        
                        return;
                    }

                    $this->throw_msg(
                    "confirm",
                    "record_deleted",
                                        "#cls #edit_client, #met #onsubmit"
                );
                }
            }
        }
    }
    
    
    
    
    
    
    
    
    
    public function display_skeleton()
    {
        global $s, $q, $t;

        $work_categories= $s->work_categories;
        $work_cat= $work_categories[$this->data['work_cat']];

        $this->data['name_work_cat']= $t->$work_cat;

        $q->set_filter("id_qual='".$this->data['id_qual']."'");
        $this->data['name_qual']= $this->set_data_from_id("select_qualification1", "id_qual", "name_qual");


        $this->view_data();
    }
}
