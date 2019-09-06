<?php


class list_works extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_works";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_work";
        $this->id_tag="id_work";
        $this->set_title($t->works, "h2");
        $this->data_source="select_work1";

        $this->has['create']= true;
        $this->has['filter']= true;
    
        $this->display_list= array("id_work", "name_work", "name_serv");
    }

    
    
    

    
    public function display_skeleton()
    {
        global $s, $u, $q;

        $q->set_filter("id_serv='".$this->data['id_serv']."'");
        $this->data['name_serv']= $this->set_data_from_id("select_service1", "", "name_serv");

        $this->view_data();
    }
}
