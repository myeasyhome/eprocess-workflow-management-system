<?php


class list_ranks extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_ranks";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_rank";
        $this->id_tag="id_rank";
        $this->set_title($t->ranks, "h2");
        $this->data_source="select_rank1";
        $this->has['create']= true;
    
        $this->display_list= array("id_rank", "name_rank", "name_work_cat", "name_work", "name_serv");
    }
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u, $q, $t;

        $q->set_filter("id_serv='".$this->data['id_serv']."'");
        $this->data['name_serv']= $this->set_data_from_id("select_service1", "", "name_serv");

        $q->set_filter("id_work='".$this->data['id_work']."'");
        $this->data['name_work']= $this->set_data_from_id("select_work1", "", "name_work");

        $work_categories= $s->work_categories;
        $work_cat= $work_categories[$this->data['work_cat']];

        $this->data['name_work_cat']= $t->$work_cat;

        $this->view_data();
    }
}
