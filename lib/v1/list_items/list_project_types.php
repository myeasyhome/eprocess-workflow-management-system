<?php


class list_project_types extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_project_types";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_project_type";
        $this->id_tag="id_proj_type";
        $this->set_title($t->project_types, "h2");
        $this->data_source="select_project_type1";

        $this->display_list= array("id_proj_type", "name_proj_type", "name_dept");

        $this->has['create']= true;
        $this->has['filter']= true;
    }
    
    
    
    
    
    public function set_filter()
    {
        global $s, $u, $q;
    
        $q->set_order("ORDER BY id_dept ASC");
    }

    

    
    
    

    public function display_skeleton()
    {
        global $s, $u, $q, $t;


        $q->set_filter("id_dept='".$this->data['id_dept']."'");
        $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");

        if (empty($this->data['name_dept'])) {
            $this->data['name_dept']= $t->unknown;
        }

        $this->view_data();
    }
}
