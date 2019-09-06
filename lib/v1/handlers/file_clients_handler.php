<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class file_clients_handler extends object_handler
{
    public function initialize($option="")
    {
        global $c, $t;


        parent::initialize();


        if ($option == "child") {
            return;
        }


        $this->has['title']= true;

        $this->objs[0]= new list_files();
        $this->objs[1]= new list_clients();

        $this->initialize_objs();

        $this->objs[0]->set_option("view_one");
        $this->objs[1]->set_option("file");
    }
    
    
    
    
    public function config()
    {
        global $t;
    
        parent::config();


        $this->set_title($t->file_clients, "h1");

        $this->has['common_data_source']= false;

        $this->subject= "client";

        $this->has("submit", false);
        $this->has("form", false);


        $this->objs[0]->set_has("title", false);
        $this->objs[0]->set_has("radio", false);
        $this->objs[0]->set_has("submit", false);
        $this->objs[0]->set_has("form", false);
    }
    
    
    
    
    
    public function start($option= "")
    {
        if ($option == "child") {
            parent::start();
            return;
        }
        
        //-------------------------
    
        $this->objs[0]->set_data_from_resource();


        if ($this->objs[0]->is_foreign()  || $this->objs[0]->is_in_transit()) {
            $this->objs[0]->add_to_display_list("name_dept");
        
            $this->objs[1]->set_has("create", false);
            $this->objs[1]->set_has("edit", false);
            $this->objs[1]->set_has("delete", false);
            $this->objs[1]->set_has("ask_delete", false);
            $this->objs[1]->set_has("radio", false);
        } elseif ($this->objs[0]->has("allowed_create_edit_delete")) {
        
        // list_files obj has allowed create_edit_delete in its met#set_data
        
            $this->objs[1]->set_has("create", true);
            $this->objs[1]->set_has("edit", true);
            $this->objs[1]->set_has("delete", true);
            $this->objs[1]->set_has("ask_delete", true);
            $this->objs[1]->set_has("radio", true);
        }
        
    
        parent::start();
    }

    
    
    
    
    public function display()
    {
        global $t;



        buttons::anchor_button("?v=files", array(), $t->files);

        buttons::anchor_button("?v=file_projects&id_file=".$_REQUEST['id_file'], array(), $t->the_file_projects);


        $this->display_title();
        
    
        echo <<<HTML
<div>
HTML;

        $this->objs[0]->display();

        echo "</div>";


        echo <<<HTML
<div>
HTML;

        $this->objs[1]->display();

        echo "</div>";
    }
}
