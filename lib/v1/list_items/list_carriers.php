<?php


class list_carriers extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_carriers";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_carrier";
        $this->id_tag="id_carrier";
        $this->set_title($t->carriers, "h2");
        $this->data_source="select_carrier1";
        $this->has['create']= true;

        $this->display_list= array("id_carrier", "name_dept", "surname", "firstname", "num_phone");
    }
    
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u, $q;


        $q->set_filter("id_dept='".$this->data['id_dept']."'");
        $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");

        $this->view_data();
    }
}
