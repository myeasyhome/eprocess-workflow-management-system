<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class default_settings
{
    protected $data;
    protected $has;

    
    
    

    public function __construct($version)
    {
        $this->data= array();
        $this->has= array();

        $this->data['version']= $version;
    }
    

    

    public function set_data()
    {
        $this->data['is_demo']= false;
    
        $this->data['global_name']= "e-PROCESS MFPRE";

        $this->data['main_email']= "postmaster@mfpre.cg";

        $this->data['root_url']= "index.php";

        $this->data['language_ref']= "fr"; // french

        $this->data['website_style_mode']= "final"; // select style mode: basic | production | final


        //------------user status--------------------

        $status= array();
        $status['guest']= 1;
        $status['operator']= 5;
        $status['supervisor']= 6;
        $status['admin']= 7;
        $status['super_admin']= 9;

        //-------------user groups--------------------

        $this->data['observer_group']= array($status['supervisor']);
        $this->data['editor_group']= array($status['operator']);
        $this->data['admin_group']= array($status['admin'], $status['super_admin']);
        $this->data['super_admin_group']= array($status['super_admin']);

        //---------------save status list

        $this->data['user_status']= &$status;

        //---------------user access layers-------------------

        $this->data['zn_observer']= array($status['supervisor']);

        $this->data['zn_operator']= array($status['operator'],
                                            $status['admin'], $status['super_admin']);
                                            
        $this->data['zn_admin']= array($status['admin'], $status['super_admin']);

        //----------------------------

        $this->data['no_yes']=array("no", "yes");
        $this->data['gender']=array("male", "female");


        //Action tags

        $this->data['create_tag']= "crea";
        $this->data['edit_tag']= "edit";
        $this->data['delete_tag']= "dele";
        $this->data['transfer_tag']= "trans";
        $this->data['cancel_trans_tag']= "ccltr";
        $this->data['confirm_trans_tag']= "cfitr";

        //-----------------

        $this->data['pagenum_tag']= "pg";
        $this->data['paging_max_items']= 20;
        $this->data['paging_maxpages']= 40;

        //------------------

        $this->data['edit_position']= "window"; // window | main

//---------------------
    }

    
    
    
    
    
    public function __set($name, $value)
    {
        return;
    }
    
    
    
    
    
    
    
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            f1::echo_comment("data with name \"{$name}\" could not be found and returned,".
                        " in met#get, #cls #default_settings ");
                        
            return false;
        }
    }
    
    
    
    
    

    public function has($name)
    {
        if (isset($this->has[$name])) {
            return $this->has[$name];
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    public function is($name)
    {
        if (isset($this->is[$name])) {
            return $this->is[$name];
        } else {
            return false;
        }
    }
    
    
    
    public function get_data($name)
    {
        if (empty($name)) {
            f1::echo_error("empty string, in #met #get_var, #cls default_config");
            return;
        } elseif (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }
    
    
    
    

    
    
    public function set_files()
    {
        $files= array();

        $files[]= "lib/main/functions/f1.php"; // functions

        $files[]= "lib/main/controllers/website_object.php";

        $files[]= "lib/main/database/database_connection_controller.php";
        $files[]= "lib/main/website_msg/website_msg_controller.php";

        //$files[]= "lib/main/controllers/search_keywords_controller.php";

        $files[]= "lib/main/controllers/query_controller.php";
        $files[]= "lib/main/controllers/text_controller.php";

        $files[]= "lib/main/controllers/action_log.php";

        $files[]= "lib/main/controllers/memory.php";
        $files[]= "lib/main/controllers/user.php";


        $files[]= "lib/main/controllers/view_controller_datatype.php";
        $files[]= "lib/main/view_controller/main_view_controller.php";
        $files[]= "lib/".$this->data['version']."/view_controller/version_view_controller.php";

        $files[]= "lib/main/settings/database_settings.php";

        $files[]= "lib/main/text/text_settor.php";

        $files[]= "lib/main/view_handlers/view_shelf_handler.php";
        $files[]= "lib/main/view_handlers/view_handler_datatype.php";

        //$files[]= "lib/main/search/search_engine.php";

        $files[]= "lib/main/list_items/paging.php";
        $files[]= "lib/main/list_items/list_items.php";
        $files[]= "lib/main/list_items/list_items_adapter.php";
        $files[]= "lib/main/list_items/selector.php";

        $files[]= "lib/main/forms/html_form.php";
        $files[]= "lib/main/forms/html_form_adapter.php";
        $files[]= "lib/main/website_msg/website_msg.php";
        $files[]= "lib/main/other/buttons.php";

        $files[]= "lib/main/list_items/menu.php";

        $files[]= "lib/main/other/window.php";

        $files[]= "lib/main/publisher/publisher.php";
        $files[]= "lib/main/publisher/publisher_handler.php";


        //--------------------

        return $files;
    }
    
    
    
    
    
    public function set_text_classes()
    {
        $classes= array();

        //------select text classes------

        $prefix= "lib/main/text/".$this->data['language_ref']."/";

        $classes[]="specific_txt>>".$prefix;
        $classes[]="msg_txt>>".$prefix;
        $classes[]="vocab_txt>>".$prefix;
        $classes[]="form_txt>>".$prefix;
        $classes[]="list_txt>>".$prefix;
        $classes[]="action_txt>>".$prefix;

        //----------------
    
        return $classes;
    }
    
    
    
    
    
    
    public function set_queries_classes()
    {
        $classes= array();

        //------select queries classes------

        $prefix= "lib/main/queries/";

        $classes[]="main_queries>>".$prefix;


        // delete
        $classes[]="common_queries>>".$prefix;
        $classes[]="import_queries>>".$prefix;

        //----------------
    
        return $classes;
    }
    
    
    
    
    
    
    public function set_development_options()
    {

/*
$this->data['show_variables']= true; // uncomment to show variables...
$this->data['show_messages']= true; // uncomment to show messages
$this->data['show_queries']= true; // uncomment to see sql queries
*/
    }



        
    
    
    
    
    public function set_main_parameters()
    {
        $list= array("country_id", "town_id", "subtown_id");
                                            
        return $list;
    }
    
    
    
    
    
    
    public function set_linked_parameters($name)
    {
        $list= array();

        switch ($name) {
            
            case "country_id":
            $list= array("town_id", "subtown_id");
            
            break;
            
            case "town_id":
            $list= array("subtown_id");
            
            break;
            
            }
            
        return $list;
    }
    
    
    
    

    public function set_view_handler()
    {
        if ($_GET['print_page']) {
            $this->data['view_handler']= "reports_view_handler";
        } elseif ($_GET['v'] == "publish") {
            $this->data['view_handler']= "publish_view_handler";
        } elseif (($_REQUEST['data_print_letter']) && $_REQUEST['process_preview']) {
            $this->data['view_handler']= "letters_view_handler";
        } elseif ($_REQUEST['preview']) {
            $this->data['view_handler']= "letters_view_handler";
        } elseif (!empty($_REQUEST['data_print_letter'])
        && ($_REQUEST['print_selected'] ||	$_REQUEST['print_all'])) {
            $this->data['view_handler']= "letters_view_handler";
        } elseif ($_GET['view_stat_report'] && $_REQUEST['id_stat_report']) {
            $this->data['view_handler']= "reports_view_handler";
        } else {
            $this->data['view_handler']= "main_view_handler";
        }
    }
    
    
    
    
    
    
    public function set_status_list()
    {
    }
    
    
    
    
    
    
    
    
    public function set_categories_list()
    {
    }
    
        
    
    
    
    
    
    public function set_subcategories_list()
    {
    }
    
    
    
    
    
    
    
    public function set_level_list()
    {
    }

    
    
    
    
    
    
    
    public function set_types_list()
    {
    }
    
    
    
    
    
    public function set_db_variables()
    {
        $i_var= array();


        return $i_var;
    }
}
