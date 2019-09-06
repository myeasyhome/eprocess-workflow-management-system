<?php


class select_handler_section extends website_object
{
    public function config()
    {
        $this->has['data']=false;
    
        $this->shelf= array();

        $this->shelf['change_country']= new select_handler();
        $this->shelf['change_town']= new select_handler();
        $this->shelf['select_all']= new select_handler();

        $this->shelf['change_country']->initialize();
        $this->shelf['change_town']->initialize();
        $this->shelf['select_all']->initialize();

        $this->shelf['change_country']->config("change_country");
        $this->shelf['change_town']->config("change_town");
        $this->shelf['select_all']->config("select_all");
    }
    
    
    
    
    public function set_data()
    {
        $this->shelf['change_country']->set_data();
        $this->shelf['change_town']->set_data();
        $this->shelf['select_all']->set_data();
    }
    
    
    
    
    
    public function display()
    {
        global $t;
    
        echo "<div class=\"object_section\">";

        echo "<span>";
        $this->shelf['change_country']->display();
        echo "</span>";

        echo "<span>";
        $this->shelf['change_town']->display();
        echo "</span>";

        echo "<span>";
        $this->shelf['select_all']->display();
        echo "</span>";

        echo "</div>";
    }
}
