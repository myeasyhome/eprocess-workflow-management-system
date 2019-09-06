<?php


class list_project_status extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_project_status";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_project_status";
        $this->id_tag="id_proj_status";
        $this->set_title($t->project_status, "h2");
        $this->data_source="select_project_status1";
        $this->has['create']= true;

        $this->display_list= array("id_proj_status", "name_proj_status");
    }
    

    
    
    

    public function display_skeleton()
    {
        global $s, $u;

        $this->view_data();
    }
}
