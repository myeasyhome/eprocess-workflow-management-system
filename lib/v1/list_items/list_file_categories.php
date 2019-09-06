<?php


class list_file_categories extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_file_categories";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_file_category";
        $this->id_tag="id_file_cat";
        $this->set_title($t->file_categories, "h2");
        $this->data_source="select_file_category1";

        $this->display_list= array("id_file_cat", "name_cat");

        $this->has['create']= true;
    }
    

    
    
    

    public function display_skeleton()
    {
        global $s, $u;

        $this->view_data();
    }
}
