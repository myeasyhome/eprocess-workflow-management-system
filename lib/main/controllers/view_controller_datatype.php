<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



abstract class view_controller_datatype
{
    protected $shelf;
    protected $has;


    public function manage_display()
    {
        $this->config();
        $this->set_access_control();
        $this->select_view();
        $this->set_default_view();
        $this->start();
        $this->make_objects();
        $this->start_objects();
        $this->display();
    }
    
    
    

    protected function config()
    {
        global $c, $s, $m, $t, $q, $u;

        $this->shelf= new view_shelf_handler();

        $s->set_view_handler();

        $view_handler_name= $s->view_handler;

        //-----------------------------------
        
        $error_msg=FATAL_MSG." Error dfs_novh";
        
        $c->insert_file("lib/main/view_handlers/".$view_handler_name.".php", "", $error_msg);

        //---------------------------------------



        $this->view_handler= new $view_handler_name();

        $this->has= array();
    }
    
        
    
    
    
    protected function set_access_control()
    {
    }
    
    
    
    
    protected function set_view_from_list(&$list)
    {
        global $m;
    
        for ($i=0; $i < count($list); $i++) {
            if (isset($_REQUEST[$list[$i]])) {
                $m->old_v= $_GET['v'];
                $_GET['v']= $list[$i];
                $this->view_ref= $list[$i];
                return true;
            }
        }
            

        if (isset($_GET['v']) && (in_array($_GET['v'], $list))) {
            $this->view_ref= $_GET['v'];
            return true;
        }
        
        return false;
    }
    
    
    
    
    protected function select_view()
    {
    }

    
    

    
        
    public function add($obj_class, $position, $prefix="", $insert=true)
    {
        global $c, $s, $m, $t, $q, $u;


        if (($position == "window") && $insert) {
            $m->window_displayed= true;
        }
        
        //------------------------------------------------------------

        if (!(substr(trim($prefix), 0, 4) === "lib/")) {
            $version= $s->version;

            $prefix= "lib/".$version."/".$prefix;
        }

        //--------------

        $error_msg= FATAL_MSG." error vdt1";

        if (!class_exists($obj_class)) {
            $c->insert_file($obj_class.".php", $prefix, $error_msg);
        }

        //------------

        if ($insert) {
            $this->shelf->$position= $obj_class;
        }
    }
    
    
    
    
    
    public function start()
    {
    }
    
    
    
    
    
    protected function make_objects()
    {
    }
    
    
    
    
    
    
    protected function start_objects()
    {
        global $m;

        $m->view_ref= $this->view_ref;
    
        $this->shelf->start_objects();
    }
    
    
    
    
    public function start_new($position, $view_ref="")
    {
        global $m;

        if ($view_ref) {
            $m->view_ref= $this->view_ref;
        }
        
        $this->shelf->start_objects($position);
    }
    
    
    
        
    
    protected function set_displayable($position, $value)
    {
        if ($this->shelf[$position] && is_bool($value)) {
            $this->shelf[$position]->set_displayable($value);
        }
    }
    
        
    
    
    
    
    protected function display()
    {
        f1::display_main_variables();


        $msg_obj= new website_msg();
        $msg_type= "";

        $msg= $msg_obj->get_msg();

        if ($msg && ($msg['type'] == "fatal_error")) {
            $msg_obj->display();
        } else {
            $this->view_handler->set_object_shelf($this->shelf);
            $this->view_handler->display($msg_obj);
        }
    }
}
