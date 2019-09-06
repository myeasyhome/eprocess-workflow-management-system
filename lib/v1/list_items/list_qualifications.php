<?php


class list_qualifications extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_qualifications";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_qualification";
        $this->id_tag="id_qual";
        $this->set_title($t->qualifications, "h2");
        $this->data_source="select_qualification1";

        $this->display_list= array("id_qual", "name_qual", "name_qual_level", "trial_period");

        $this->has['create']= true;
    }
    
    
    
        

    
    public function display_skeleton()
    {
        global $s, $u, $t;

        $qual_level= $this->data['qual_level'];
        $this->data['name_qual_level']= $t->$qual_level;

        $this->view_data();
    }
}
