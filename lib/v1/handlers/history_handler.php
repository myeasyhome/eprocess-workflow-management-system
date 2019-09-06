<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class history_handler extends object_handler
{
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        if ($_REQUEST['file_history']) {
            $this->objs[0]= new list_files();
        } else {
            $this->objs[0]= new list_projects();
        }
        
        $this->objs[1]= new history();

        $this->initialize_objs();

        $this->objs[0]->set_option("view_one");
    }
    
    
    
    public function config()
    {
        global $s, $t;
    
        parent::config();

        $this->has['common_data_source']= false;

        $this->reference="history";

        $this->i_var['form_method']= "POST";
        $this->i_var['form_name']= $this->reference;

        $this->set_has("submit", false);

        if ($_REQUEST['file_history']) {
            $this->set_title($t->file_history);
            $this->objs[0]->set_title($t->sp_file." ".$_REQUEST['id_file'], "h2");
        } elseif ($_REQUEST['project_history']) {
            $this->set_title($t->project_history);
            $this->objs[0]->set_title($t->project." ".$_REQUEST['id_proj'], "h2");
        }
        
        
        $this->objs[1]->set_title($t->history, "h2");

        $this->objs[0]->set_has("radio", false);
        $this->objs[0]->set_has("checkboxes", false);

        $this->objs[1]->set_has("radio", false);
        $this->objs[1]->set_has("checkboxes", false);

        $this->objs[0]->set_has("submit", false);
        $this->objs[0]->set_has("form", false);
    }

    

    

    
    public function display()
    {
        global $t;
    
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
