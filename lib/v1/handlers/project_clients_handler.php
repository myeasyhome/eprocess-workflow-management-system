<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class project_clients_handler extends file_clients_handler
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize("child");

        $this->objs[0]= new list_projects();
        $this->objs[1]= new list_clients();

        $this->initialize_objs();

        $this->objs[0]->set_option("view_one");
        $this->objs[1]->set_option("project");
    }
    
    
    
    
    
    public function config()
    {
        global $t;
    
        parent::config();

        $this->set_title($t->project_clients, "h1");

        $this->has['submit']= true;
    }
    
    
    
    
    
    public function start()
    {
        parent::start("child");

    
        $this->objs[0]->set_data_from_resource();

        if ($this->objs[0]->is_foreign() || $this->objs[0]->is_in_transit()) {
            $this->objs[0]->add_to_display_list("name_dept");
            $this->objs[1]->set_has("radio", false);
            $this->objs[1]->set_has("edit", false);
        }
    }
    
    
    
    
    
    public function display_submit()
    {
        global $s, $c, $m, $u, $t;

        $target_url= $s->root_url."?v=project_clients&id_proj=".$_GET['id_proj'];

        echo <<<HTML

<form name="letter_use_project" method="POST" action="{$target_url}">

<input type="hidden"  name="letter_id_proj" value="{$_GET['id_proj']}"/>

<input type="submit" class="submit_button" name="letter_use_project" value="{$t->letter_use}"/>

</form>

HTML;
    }
    
    
    
    
    public function display()
    {
        global $t;

        $_REQUEST['id_file']= $this->objs[0]->get_data("id_file");
        $_REQUEST['file_status']= 10;

        buttons::anchor_button("?v=projects", array(), $t->projects);

        buttons::anchor_button("?v=file_clients", array("id_file","file_status"), $t->the_file_clients);


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


        if ($this->has['submit']) {
            $this->display_submit();
        }
    }
}
