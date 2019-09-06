<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class list_client_class_handler extends object_handler
{
    public function initialize()
    {
        parent::initialize();
    
        $this->objs[0]= new list_clients();
    
        $this->objs[1]= new list_client_class();
    
        $this->initialize_objs();
    
        $this->objs[0]->set_option("view_one");
        $this->objs[1]->set_option("client_class");
    }
    
    
    
    public function config()
    {
        global $t;
    
        parent::config();

        $this->has['common_data_source']= false;


        $this->objs[0]->set_has("form", false);

        $this->reference="list_client_class";
        $this->subject= "client_class";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=client_class";

    
        $this->has['title']= true;
        $this->set_title($t->client_class, "h1");
    }
    
    

    
    
    
    public function onsubmit()
    {
        global $q;

        
        if (isset($_REQUEST['id_client_class']) && is_numeric($_REQUEST['id_client_class'])
            && $_REQUEST["yes_delete_".$this->subject]) {
            $q->set_var("id_client_class", $_REQUEST['id_client_class']);

            if (!$q->sql_action("delete_from_client_class1")) {
                $this->throw_msg(
                        "error",
                        "delete_failed",
                                    "#met #onsubmit"
                    );
                    
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }

            $this->throw_msg(
                "confirm",
                "record_deleted",
                                    "#met #onsubmit"
            );
            $this->is['new']= true;
        }
    }
    
    
    
    
    
    

    public function display()
    {
        global $t;


        $_REQUEST['id_file']= $this->objs[0]->get_data("id_file");
        $_REQUEST['file_status']= 10;
        $_REQUEST['id_proj']= $this->objs[0]->get_data("id_proj");

        
    
        buttons::anchor_button("?v=project_clients", array("id_file", "id_proj", "file_status"), $t->the_project_clients);

        buttons::anchor_button("?v=file_clients", array("id_file", "id_proj", "file_status"), $t->the_file_clients);

    
        if ($this->title) {
            $this->display_title();
        }
        
        if ($_REQUEST['id_client_class'] && $_REQUEST['ask_delete_client_class']) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
                
            echo "<input type=\"hidden\" name=\"id_client\" value=\"". $_REQUEST['id_client']."\"/>";
            echo "<input type=\"hidden\" name=\"id_client_class\" value=\"". $_REQUEST['id_client_class']."\"/>";
                
            $this->ask_delete();
        
            echo "</form>";
        }
        
        parent::display();
    }
}
