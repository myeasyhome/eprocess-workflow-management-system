<?php


class list_client_class extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_client_class";
        $this->subject= "client_class";
        $this->i_var['form_name']= $this->reference;

        $this->id_tag="id_client_class";
        $this->set_title($t->the_client_class, "h2");
        $this->data_source="select_client_class_all";


        $this->has['filter']= true;


        if ($this->option == "client_class") {
            $this->i_var['target_url']= $s->root_url."?v=client_class";
            $this->has['form']= true;
            $this->has['submit']= true;
            $this->has['create']= true;
        } elseif ($this->option == "view_one") {
            $this->i_var['writable_data_list'][]= "all_data";
            $this->has['writable_database_res']= true;
            $this->has['submit']= false;
            $this->has['form']= false;
            $this->has['radio']= false;
        }


        //$this->id= $this->require_id("numeric", $_REQUEST['id_client']);

        $this->display_list= array("id_client_class", "start_scale", "name_serv", "name_work", "name_rank", "name_work_cat", "scale", "work_class", "echelon", "work_index", "start_work", "name_qual", "option_qual", "origin_qual");
    }
    
    
    
    
    
    public function set_filter()
    {
        global $m, $q, $u;


        if (($this->option == "client_class") && ($id= $this->require_id("numeric", $_REQUEST['id_client'])) && $id) {
            $q->set_filter("id_client='".$id."' ");
        } elseif (($this->option == "view_one") &&
            ($this->id= $this->require_id("numeric", $_REQUEST['id_client_class'])) && $this->id) {
            $string= "id_client_class='".$this->id."'";
        }

        $q->set_filter($string);
    }
    
    
    
    
    
    public function display_skeleton()
    {
        global $s, $q, $t;
    
        $work_categories= $s->work_categories;
        $work_cat= $work_categories[$this->data['work_cat']];

        $this->data['name_work_cat']= $t->$work_cat;
    
    
        $q->set_filter("id_qual='".$this->data['id_qual']."'");
        $this->data['name_qual']= $this->set_data_from_id("select_qualification1", "", "name_qual");
    
        $this->custom_date(array("start_scale", "start_work"));


        $this->view_data();
    }
    
    
    
    
    
    public function display_submit()
    {
        echo "<input type=\"hidden\" name=\"id_client\" value=\"".$_REQUEST['id_client']."\"/>";

        parent::display_submit();
    }
}
