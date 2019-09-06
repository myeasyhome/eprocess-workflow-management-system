<?php


class list_file_types extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_file_types";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_file_type";
        $this->id_tag="id_file_type";
        $this->set_title($t->file_types, "h2");
        $this->data_source="select_file_type1";

        $this->display_list= array("id_file_type", "name_type");

        $this->has['create']= true;
    }
    

    
    
    

    public function display_skeleton()
    {
        global $s, $u;

        $this->view_data();
    }
}
