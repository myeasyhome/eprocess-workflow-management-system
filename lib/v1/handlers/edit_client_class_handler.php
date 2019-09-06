<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_client_class_handler extends form_handler
{
    protected $onfocus;
    protected $list;
    protected $selector;



    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->onfocus= new list_client_class();
        $this->onfocus->initialize();
        $this->onfocus->set_option("view_one");

        $this->forms[0]= new edit_client_class_p1();
        $this->forms[1]= new edit_client_class_p2();

        $this->list= new list_class();
        $this->list->initialize();

        $this->selector= new select_qualification();
        $this->selector->initialize();

        $this->initialize_forms();
    }
    
    
    
    
    public function config()
    {
        global $s, $t;

        parent::config();

        $this->has['common_data_source']= true;

        $this->onfocus->config();

        $this->list->config();
        $this->selector->config();


        $this->forms[0]->set_has("title", true);
        $this->forms[0]->set_title($t->client_dates, "h2");

        $this->forms[0]->define_form();
        $this->forms[1]->define_form();

        $this->selector->set_title($t->client_qualification, "h2");

        $this->list->set_has("submit", false);
        $this->list->set_has("form", false);


        $this->subject= "client_class";

        $this->set_title($t->edit_client_class, "h1");

        $this->has['form']= true;
        $this->has['submit']= true;

        $this->i_var['form_name']= "edit_client_class";
        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=edit_client_class";

        $pg= $s->pagenum_tag;

        if ($_GET[$pg]) {
            $this->i_var['target_url'] .= "&".$pg."=".$_GET[$pg];
        }

        
        if ($_REQUEST['id_client_class']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_client_class']);
            $this->data_source="select_client_class_all";
            $this->has['filter']= true;
        } else {
            $this->is['new']= true;
        }
    }

    
    
    
    
    
    public function set_filter()
    {
        global $q;

    
        if ($this->id) {
            $q->set_filter("id_client_class='".$this->id."'");
        }
    }
    
    
    
    

    
    public function onsubmit()
    {
        global $c, $s, $m, $q, $u, $v, $t;


        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
        && $this->is_validated()) {
            if (is_numeric($_REQUEST['id_class'])) {
                $q->set_filter("id_class='".$_REQUEST['id_class']."'");
                $class= $this->set_data_from_id("select_class_all");
            } elseif (is_numeric($_REQUEST['id_client_class'])) {
                $q->set_filter("id_client_class='".$_REQUEST['id_client_class']."'");
                $class= $this->set_data_from_id("select_client_class_all");
            }
            
            
            if ($class && is_array($class)) {
                foreach ($class as $key => $value) {
                    $q->set_var($key, $value);
                }
            } elseif (!$_REQUEST["yes_delete_".$this->subject]) {
                f1::echo_warning("invalid #class in met#onsubmit, cls#edit_client_class_handler");
            
                $this->throw_msg(
                "error",
                "select_id_class",
                                    "#met #onsubmit"
            );
                                    
                $this->is['submitted']= true;
                $this->set_has("update_data_from_global", true);
                return;
            }
            
            $this->undo_custom_date(array("start_scale", "start_work"), $_REQUEST);

            $this->var_to_queries($_REQUEST); // id_qual is overriden, as we use id_qual from POST
            
                    
            if ($class && $_REQUEST["create_".$this->subject]) {
                if (!$q->sql_action("insert_client_class1")) {
                    $this->throw_msg(
                        "error",
                        "create_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $_REQUEST['id_client_class']= $q->get_var("new_id");
            
            
                $this->onfocus->initialize();
                $this->onfocus->set_option("view_one");
            
                $this->config();
                    
            
                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#met #onsubmit"
            );
            
                $this->is['new']= true;
            }
            
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_var("id_client_class", $this->id);

                if (!$q->sql_action("delete_from_client_class1") || !$q->sql_action("save_client_class1")) {
                    $this->throw_msg(
                        "error",
                        "save_failed",
                                    "met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#met #onsubmit"
            );
            }
            
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_client_class", $this->id);
                    
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
        } elseif (($_REQUEST['form_name'] == $this->i_var['form_name']) && !$this->in_cancel_mode()) {
            $this->is['submitted']= true;
            $this->set_has("update_data_from_global", true);
        }
    }
    

    
    
    
    
    public function set_data($name="", $value=null)
    {
        global $t;

        parent::set_data();

        if ($this->numrows >= 1) {
            $this->onfocus->set_database_result($this->res, $this->numrows);
        } elseif ($this->id) {
            $this->onfocus->set_data();
        }
        
        
        $this->list->set_data();
        $this->selector->set_data();

        if ($this->data['id_qual'] || $_REQUEST['id_qual']) {
            $id_qual= $_REQUEST['id_qual'] ? $_REQUEST['id_qual'] : $this->data['id_qual'];
            $this->selector->set_selected($id_qual);
        }
    }
    
    
    
    
    
    public function start()
    {
        global $t;
    
        parent::start();
    
        if ($this->is['new']) {
            $this->set_title($t->create.": ".$t->client_class, "h1");
        }
    }

    
    
    
    
    
    public function display_skeleton()
    {
        global $t;

        if (($this->numrows >= 1) || $this->onfocus->is_data_ready()) {
            echo "<div class=\"wide\">";

            $this->onfocus->display_title();
            $this->onfocus->display();

            echo "</div>";
        } else {
            $this->display_title();
        }
    
        echo "<div class=\"wide\">";

        $this->list->display_title();
        $this->list->display();

        echo "</div>";


        echo "<div class=\"wide\">";

        $this->forms[0]->display_title();
        $this->forms[0]->display();

        $this->selector->display_title();
        $this->selector->display();

        $this->forms[1]->display();

        echo "</div>";
    }

    
    
    
    public function display_submit()
    {
        global $m;
    
        echo "<input type=\"hidden\" name=\"id_client\" value=\"".$_REQUEST['id_client']."\"/>";


        if (!$this->is['new'] && $_REQUEST['id_client_class']) {
            echo "<input type=\"hidden\" name=\"id_client_class\" value=\"".$_REQUEST['id_client_class']."\"/>";
        }

        parent::display_submit();
    }
}
