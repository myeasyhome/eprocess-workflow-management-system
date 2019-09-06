<?php


class list_services extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_services";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_service";
        $this->id_tag="id_serv";
        $this->set_title($t->services, "h2");
        $this->data_source="select_service1";
        $this->has['create']= true;
    
        $this->display_list= array("id_serv", "name_serv");
    }
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u;

        $this->view_data();
    }
}
