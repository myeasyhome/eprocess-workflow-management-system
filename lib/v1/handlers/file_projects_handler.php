<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class file_projects_handler extends object_handler
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->objs[0]= new list_files();
        $this->objs[1]= new list_projects();

        $this->initialize_objs();

        $this->objs[0]->set_option("view_one");
    }
    
    
    
    public function config()
    {
        global $s, $t;
    
        parent::config();

        $this->has['common_data_source']= false;


        $this->reference="file_projects";

        $this->i_var['form_method']= "POST";
        $this->i_var['form_name']= $this->reference;

        $this->has("submit", false);



        $this->has['title']= true;
        $this->set_title($t->file_projects, "h1");


        $this->objs[0]->set_has("title", false);
        $this->objs[1]->set_title($t->projects, "h2");

        $this->objs[0]->set_has("radio", false);
        $this->objs[0]->set_has("checkboxes", false);

        $this->objs[0]->set_has("submit", false);
        $this->objs[0]->set_has("form", false);
    }

    

    

    
    public function display()
    {
        global $t;



        buttons::anchor_button("?v=files", array(), $t->files);

        buttons::anchor_button("?v=file_clients&id_file=".$_REQUEST['id_file'], array(), $t->the_file_clients);

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
