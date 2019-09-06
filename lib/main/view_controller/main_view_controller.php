<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class main_view_controller extends view_controller_datatype
{
    protected $view_ref;
    protected $view_handler;


    protected function config()
    {
        global $s;
    
        parent::config();

        //-----------------------

        if (isset($_REQUEST['status_id_file'])) {
            if (is_array($_REQUEST['status_id_file'])) {
                for ($i=0; $i < count($_REQUEST['status_id_file']); $i++) {
                    $list= explode("_", $_REQUEST['status_id_file'][$i]);
                    $_REQUEST['file_status'][]= $list[1];
                    $_REQUEST['id_file'][]= $list[1];
                }
            } else {
                $list= explode("_", $_REQUEST['status_id_file']);
        
                $_REQUEST['file_status']= $list[0];
                $_REQUEST['id_file']= $list[1];
            }
        }

        
        //------------------------

        if (isset($_REQUEST['status_id_user'])) {
            if (is_array($_REQUEST['status_id_user'])) {
                for ($i=0; $i < count($_REQUEST['status_id_user']); $i++) {
                    $list= explode("_", $_REQUEST['status_id_user'][$i]);
                    
                    $_REQUEST['user_status'][]= $list[0];
                    $_REQUEST['id_user'][]= $list[1];
                }
            } else {
                $list= explode("_", $_REQUEST['status_id_user']);
                
                $_REQUEST['user_status']= $list[0];
                $_REQUEST['id_user']= $list[1];
            }
        }
            
        
        //---------------------

        if (isset($_REQUEST['id_file_proj'])) {
            if (is_array($_REQUEST['id_file_proj'])) {
                for ($i=0; $i < count($_REQUEST['id_file_proj']); $i++) {
                    $list= explode("_", $_REQUEST['id_file_proj'][$i]);
                    $_REQUEST['id_file'][]= $list[0];
                    $_REQUEST['id_proj'][]= $list[1];
                }
            } else {
                $list= explode("_", $_REQUEST['id_file_proj']);
                
                $_REQUEST['id_file']= $list[0];
                $_REQUEST['id_proj']= $list[1];
            }
        }

        //------------------------
        
        
        if ($_REQUEST['id_proj'] && is_numeric($_REQUEST['id_proj'])
        && $_REQUEST['letter_use_project'] && !($_GET['v'] == "project_clients")) {
            $_REQUEST['letter_id_proj']= &$_REQUEST['id_proj'];
            unset($_REQUEST['id_proj']);
        }
        
        
        if ($_REQUEST['id_letter'] && is_numeric($_REQUEST['id_letter'])
        && $_REQUEST['letter_use_template']) {
            $_REQUEST['letter_id_letter']= &$_REQUEST['id_letter'];
            unset($_REQUEST['id_letter']);
        }
        
        
        if ($_REQUEST['is_minister'] || $_REQUEST['is_gen_dir']) {
            $_REQUEST['edit_user']= true;
        }
    }
    
    
    
    
    public function set_access_control()
    {
        global $u, $q;
    }
    
    
    

    
    
    protected function select_view()
    {
        global $c, $s, $m, $t, $q, $u;

        
        //======tools, delete=========================
        /*
        if ( $_GET['v'] == "db")
        $this->view_ref="db_queries";

        elseif ( $_GET['v'] == "mks")
        $this->view_ref="mk_select";

        elseif ( $_GET['v'] == "db_var")
        $this->view_ref="db_variables";

        elseif ( $_GET['v'] == "mock")
        $this->view_ref="mock_data";

        elseif ( $_GET['v'] == "import_to_dbase")
        $this->view_ref="import_to_dbase";
        */
        //=============================================
        
        if (!($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator"))) {
            $public= array("public_search", "file_history", "project_history");
                
                
            if ($this->set_view_from_list($public)) {
                return;
            }
        }
        
        //------------------------

        if ($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator")) {
            $not_admin= array("logout", "login", "create_file", "edit_file", "files", "file_clients",
        "files_transit", "file_trans_rejected", "create_client",
        "edit_client", "create_client_class", "letters",
        "edit_client_class", "client_class", "create_project","add_to_project", "create_proj_project" ,"edit_project", "projects",
        "file_projects", "project_clients",
        "projects_transit", "proj_trans_rejected",
        "transfer_file", "transfer_project",
        "file_history", "project_history", "letter_preview", "publish", "printed_letters", "process_preview",
        "stat_reports");
        
        
            //-------------------
        
            if ($u->dept_has_search) {
                $not_admin[]= "private_search";
            }
            
            
            if ($u->dept_has_write_letter) {
                $not_admin[]= "print_letters";
                $not_admin[]= "proj_no_letter";
                $not_admin[]= "print_selected";
                $not_admin[]= "print_all";
            }
            
            
            //-------------------
        
            if ($this->set_view_from_list($not_admin)) {
                return;
            }
        
            //---------------------------------------------------------------
        
            if ($u->is_admin()) {
                if (($_GET['v'] == "users") xor ($_GET['v'] == "edit_user")) {
                    $this->view_ref="manage_users";
                } elseif (($_GET['v'] == "file_types") xor  ($_GET['v'] == "edit_file_type")) {
                    $this->view_ref="manage_file_types";
                } elseif (($_GET['v'] == "file_categories") xor  ($_GET['v'] == "edit_file_category")) {
                    $this->view_ref="manage_file_categories";
                } elseif (($_GET['v'] == "project_types") xor  ($_GET['v'] == "edit_project_type")) {
                    $this->view_ref="manage_project_types";
                } elseif (($_GET['v'] == "project_status") xor  ($_GET['v'] == "edit_project_status")) {
                    $this->view_ref="manage_project_status";
                } elseif (($_GET['v'] == "services") xor ($_GET['v'] == "edit_service")) {
                    $this->view_ref="manage_services";
                } elseif (($_GET['v'] == "works") xor ($_GET['v'] == "edit_work")) {
                    $this->view_ref="manage_works";
                } elseif (($_GET['v'] == "ranks") xor ($_GET['v'] == "edit_rank")) {
                    $this->view_ref="manage_ranks";
                } elseif (($_GET['v'] == "class") xor ($_GET['v'] == "edit_class")) {
                    $this->view_ref="manage_class";
                } elseif (($_GET['v'] == "qualifications") xor ($_GET['v'] == "edit_qualification")) {
                    $this->view_ref="manage_qualifications";
                } elseif (($_GET['v'] == "departments") xor ($_GET['v'] == "edit_department")) {
                    $this->view_ref="manage_departments";
                } elseif (($_GET['v'] == "carriers") xor ($_GET['v'] == "edit_carrier")) {
                    $this->view_ref="manage_carriers";
                } elseif (($_GET['v'] == "manage_letters") xor ($_GET['v'] == "edit_letter")) {
                    $this->view_ref="manage_letters";
                } elseif (($_GET['v'] == "manage_stat_reports") xor ($_GET['v'] == "edit_stat_report")) {
                    $this->view_ref="manage_stat_reports";
                } elseif (($_GET['v'] == "all_files_transit") || ($_GET['v'] == "all_files_rejected")
                        || ($_GET['v'] == "all_other_files")) {
                    $this->view_ref="admin_list_files";
                } elseif (($_GET['v'] == "all_proj_transit") || ($_GET['v'] == "all_proj_rejected")
                        || ($_GET['v'] == "all_other_proj")) {
                    $this->view_ref="admin_list_proj";
                } elseif (($_GET['v'] == "manage_sms") || ($_GET['v'] == "edit_sms")) {
                    $this->view_ref="manage_sms";
                } elseif ($_GET['v'] == "send_receive_sms") {
                    $this->view_ref="send_receive_sms";
                }
            }
        }
    }
    
    
    
    
    
    
    protected function set_default_view()
    {
        global $c, $s, $m, $t, $q, $u;
    
        if (empty($this->view_ref)) {
            if ($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator")) {
                $this->view_ref="home";
            } else {
                $this->view_ref="login";
            }
        }
    }
    
    
    
    
    
    
    protected function make_objects()
    {
        global $c, $s, $m, $t, $q, $u;

        $edit_position= $s->edit_position;

        $m->set_current_url(); // keep url of current page as updated in select view()


        //--------------------------------
        
        if (($this->view_ref == "private_search") || ($this->view_ref == "public_search")) {
            $is_search_mode= true;
        } else {
            $is_search_mode= false;
        }
        
        //---------------------------------
        
        if (($this->view_ref == "private_search") && $_REQUEST['clients_from_search'] && $_REQUEST['id_file']) {
            $this->view_ref= "file_clients";
        } elseif (($this->view_ref == "private_search") && $_REQUEST['clients_from_search'] && $_REQUEST['id_proj']) {
            $this->view_ref= "project_clients";
        }

        //------------------------------------
        
        if ($is_search_mode && $_REQUEST['document_history'] && $_REQUEST['id_file']) {
            $_REQUEST['file_history']= true;
            $this->view_ref= "file_history";
        } elseif ($is_search_mode && $_REQUEST['document_history'] && $_REQUEST['id_proj']) {
            $_REQUEST['project_history']= true;
            $this->view_ref= "project_history";
        }

        //------------------------------------


        $this->add("fill_letter", "fill_letter", "lib/{$s->version}/other/", true);


        switch ($this->view_ref) {
/*
//=========Delete tools=====================================

case "mock_data":

$this->add("mock_data", "main", "lib/main/tools/", true);

break;

case "db_queries":

$this->add("db_queries", "main", "lib/main/tools/", true);

break;

case "mk_select":

$this->add("mk_select", "main", "lib/main/tools/", true);

break;

case "db_variables":

$this->add("db_variables", "main", "lib/main/tools/", true);

break;

case "import_to_dbase":

$this->add("convert_dbase_data", "", "lib/main/tools/", false);
$this->add("import_to_dbase", "main", "lib/main/tools/", true);

break;
*/
//===============================================================
        
case "login":
case "logout":

$this->add("summary", "", "lib/{$s->version}/other/", false);

$this->add("login", "main", "lib/main/forms/", true);

break;

        
case "home":

$this->add("summary", "main", "lib/{$s->version}/other/", true);

break;

    
case "manage_users":

$this->add("select_department", "", "lib/{$s->version}/selectors/", false);

        if ($_REQUEST['id_user'] xor $_REQUEST['create_item']) {
            $this->add("edit_user", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_users", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_project_types":

$this->add("select_department", "", "lib/{$s->version}/selectors/", false);

        if ($_REQUEST['id_proj_type'] xor $_REQUEST['create_item']) {
            $this->add("edit_project_type", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_project_types", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_project_status":

        if ($_REQUEST['id_proj_status'] xor $_REQUEST['create_item']) {
            $this->add("edit_project_status", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_project_status", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_file_types":

        if ($_REQUEST['id_file_type'] xor $_REQUEST['create_item']) {
            $this->add("edit_file_type", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_file_types", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_file_categories":

        if ($_REQUEST['id_file_cat'] xor $_REQUEST['create_item']) {
            $this->add("edit_file_category", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_file_categories", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_services":

        if ($_REQUEST['id_serv'] xor $_REQUEST['create_item']) {
            $this->add("edit_service", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_services", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_works":
$this->add("select_service", "", "lib/{$s->version}/selectors/", false);

        if ($_REQUEST['id_work'] xor $_REQUEST['create_item']) {
            $this->add("edit_work", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_works", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_ranks":
$this->add("select_service", "", "lib/{$s->version}/selectors/", false);
$this->add("select_work", "", "lib/{$s->version}/selectors/", false);

        if ($_REQUEST['id_rank'] xor $_REQUEST['create_item']) {
            $this->add("edit_rank", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_ranks", "main", "lib/{$s->version}/list_items/", true);
        }

break;

case "manage_class":

$this->add("form_handler_member", "", "lib/main/forms/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("select_service", "", "lib/{$s->version}/selectors/", false);
$this->add("select_work", "", "lib/{$s->version}/selectors/", false);
$this->add("select_rank", "", "lib/{$s->version}/selectors/", false);
$this->add("edit_class", "", "lib/{$s->version}/forms/", false);
$this->add("select_qualification", "", "lib/{$s->version}/selectors/", false);
        
        if ($_REQUEST['id_class'] xor $_REQUEST['create_item']) {
            $this->add("edit_class_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } else {
            $this->add("list_class", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_qualifications":

        if ($_REQUEST['id_qual'] xor $_REQUEST['create_item']) {
            $this->add("edit_qualification", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_qualifications", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_departments":

        if ($_REQUEST['id_dept'] xor $_REQUEST['create_item']) {
            $this->add("edit_department", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_departments", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "manage_carriers":

$this->add("select_department", "", "lib/{$s->version}/selectors/", false);

        if ($_REQUEST['id_carrier'] xor $_REQUEST['create_item']) {
            $this->add("edit_carrier", $edit_position, "lib/{$s->version}/forms/", true);
        } else {
            $this->add("list_carriers", "main", "lib/{$s->version}/list_items/", true);
        }

break;



case "manage_sms":

$this->add("process_sms", "", "lib/{$s->version}/sms/", false);

        if ($_REQUEST['id_sms'] xor $_REQUEST['create_sms']) {
            $this->add("edit_sms", $edit_position, "lib/{$s->version}/sms/", true);
        } else {
            $this->add("list_sms", "main", "lib/{$s->version}/sms/", true);
        }

break;


case "send_receive_sms":

$this->add("sms_data", "", "lib/{$s->version}/sms/", false);
$this->add("process_sms", "", "lib/{$s->version}/sms/", false);
$this->add("receive_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("receive_sms", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms", "", "lib/{$s->version}/sms/", false);
$this->add("object_handler", "", "lib/main/handlers/", false);

$this->add("sms_handler", "main", "lib/{$s->version}/sms/", true);

break;


case "files":
case "create_file":
case "edit_file":


$this->add("form_handler_member", "", "lib/main/forms/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("edit_file_p1", "", "lib/{$s->version}/forms/", false);
$this->add("edit_file_p2", "", "lib/{$s->version}/forms/", false);
$this->add("select_file_category", "", "lib/{$s->version}/selectors/", false);
$this->add("select_file_type", "", "lib/{$s->version}/selectors/", false);
$this->add("select_department", "", "lib/{$s->version}/selectors/", false);

$this->add("process_sms", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms", "", "lib/{$s->version}/sms/", false);


        if (($_REQUEST['id_file'] && ($_REQUEST['file_status'] != 0)
                && !(($_REQUEST['file_status'] == 3) && ($_REQUEST['ask_delete_file'] || $_REQUEST['yes_delete_file']))
                && !$_REQUEST['create_file'])
                xor ($_REQUEST['create_file'] && !$_REQUEST['id_file'])) {
            $this->add("edit_file_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } else {
            $this->add("list_files", "main", "lib/{$s->version}/list_items/", true);
        }

break;




case "files_transit":
case "file_trans_rejected":
case "admin_list_files":

$this->add("process_sms", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms", "", "lib/{$s->version}/sms/", false);

$this->add("list_files", "main", "lib/{$s->version}/list_items/", true);

break;




case "file_clients":
case "project_clients":
case "create_client":
case "edit_client":

$this->add("object_handler", "", "lib/main/handlers/", false);

$this->add("list_files", "", "lib/{$s->version}/list_items/", false);
$this->add("list_projects", "", "lib/{$s->version}/list_items/", false);
$this->add("list_clients", "", "lib/{$s->version}/list_items/", false);

$this->add("file_clients_handler", "", "lib/{$s->version}/handlers/", false);

        if ($_REQUEST['id_client'] || $_REQUEST['create_client']) {
            $this->add("edit_client", $edit_position, "lib/{$s->version}/forms/", true);
        } elseif ($_REQUEST['id_proj']) {
            $this->add("project_clients_handler", "main", "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['id_file']) {
            $this->add("file_clients_handler", "main", "lib/{$s->version}/handlers/", true);
        } elseif (strpos($m->previous_page, "=projects") !== false) {
            $this->add("list_projects", "main", "lib/{$s->version}/list_items/", true);
        } elseif (strpos($m->previous_page, "=files") !== false) {
            $this->add("list_files", "main", "lib/{$s->version}/list_items/", true);
        }
    
        
break;



case "client_class":
case "create_client_class":
case "edit_client_class":

$this->add("form_handler_member", "", "lib/main/forms/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("edit_client_class_p1", "", "lib/{$s->version}/forms/", false);
$this->add("edit_client_class_p2", "", "lib/{$s->version}/forms/", false);
$this->add("list_class", "", "lib/{$s->version}/list_items/", false);
$this->add("list_clients", "", "lib/{$s->version}/list_items/", false);
$this->add("select_qualification", "", "lib/{$s->version}/selectors/", false);
$this->add("object_handler", "", "lib/main/handlers/", false);
$this->add("list_client_class", "", "lib/{$s->version}/list_items/", false);



        if ($_REQUEST['id_client'] &&
        ($_REQUEST['id_client_class']
        && (($_REQUEST['v'] == "edit_client_class") || $_REQUEST['edit_client_class']
        || $_REQUEST['save_client_class'] || $_REQUEST['ask_delete_client_class'] || $_REQUEST['yes_delete_client_class']
                        || $_REQUEST['cancel']))
        || ($_REQUEST['create_client_class'] && !$_REQUEST['id_client_class'])) {
            $this->add("edit_client_class_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['id_client']) {
            $this->add("list_client_class_handler", "main", "lib/{$s->version}/handlers/", true);
        } elseif ($_GET['v'] == "project_clients") {
            $this->add("list_projects", "", "lib/{$s->version}/list_items/", false);
            $this->add("file_clients_handler", "", "lib/{$s->version}/handlers/", false);
            $this->add("project_clients_handler", "main", "lib/{$s->version}/handlers/", true);
        } elseif ($_GET['v'] == "file_clients") {
            $this->add("list_files", "", "lib/{$s->version}/list_items/", false);
            $this->add("file_clients_handler", "main", "lib/{$s->version}/handlers/", true);
        }
        
break;



case "projects":
case "file_projects":
case "create_project":
case "add_to_project":
case "create_proj_project":
case "edit_project":

$this->add("list_projects", "", "lib/{$s->version}/list_items/", false);

$this->add("object_handler", "", "lib/main/handlers/", false);
$this->add("form_handler_member", "", "lib/main/forms/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("edit_project_p1", "", "lib/{$s->version}/forms/", false);
$this->add("select_project_type", "", "lib/{$s->version}/selectors/", false);
$this->add("select_project_status", "", "lib/{$s->version}/selectors/", false);

$this->add("list_files", "", "lib/{$s->version}/list_items/", false);
$this->add("edit_project_handler", "", "lib/{$s->version}/handlers/", false);
$this->add("list_clients", "", "lib/{$s->version}/list_items/", false);
$this->add("create_project_handler", "", "lib/{$s->version}/handlers/", false);

$this->add("process_sms", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms", "", "lib/{$s->version}/sms/", false);


//--------------------

$from_file_projects= ($_GET['form_name'] == "projects") ? true : false;

//----------------

        if (($_REQUEST['create_project'] && !$_REQUEST['id_proj'])
                || ($_REQUEST['add_to_project'] && $_REQUEST['id_proj'])
                || (($_GET['v'] == "create_project") && !$from_file_projects)) {
            $this->add("create_project_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif (($_REQUEST['id_proj'] || $_REQUEST['parent_id_proj'])
                && ($_REQUEST['create_proj_project'] || ($_GET['v'] == "create_proj_project"))) {
            $this->add("create_proj_from_project_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['id_proj'] && ($_GET['v'] != "create_project")) {
            $this->add("edit_project_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['id_file'] && (($_GET['v'] == "file_projects") || ($_GET['v'] == "create_project"))) {
            $this->add("file_projects_handler", "main", "lib/{$s->version}/handlers/", true);
        } elseif ($this->view_ref == "file_projects") {
            $this->add("list_files", "main", "lib/{$s->version}/list_items/", true);
        } else {
            $this->add("list_projects", "main", "lib/{$s->version}/list_items/", true);
        }

break;


case "proj_no_letter":
case "projects_transit":
case "proj_trans_rejected":
case "admin_list_proj":

$this->add("process_sms", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms_datatype", "", "lib/{$s->version}/sms/", false);
$this->add("send_sms", "", "lib/{$s->version}/sms/", false);

$this->add("list_projects", "main", "lib/{$s->version}/list_items/", true);

break;


case "transfer_file":
case "transfer_project":

$this->add("edit_describe_trans", "", "lib/{$s->version}/forms/", false);
$this->add("list_files", "", "lib/{$s->version}/list_items/", false);
$this->add("list_projects", "", "lib/{$s->version}/list_items/", false);

$this->add("select_department", "", "lib/{$s->version}/selectors/", false);
$this->add("select_carrier", "", "lib/{$s->version}/selectors/", false);
$this->add("history", "", "lib/{$s->version}/list_items/", false);
$this->add("object_handler", "", "lib/main/handlers/", false);

        if ($_REQUEST['transfer_file'] || ($_REQUEST['v'] == "transfer_file")) {
            $this->add("transfer_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['transfer_project'] || ($_REQUEST['v'] == "transfer_project")) {
            $this->add("transfer_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        }

break;


case "file_history":
case "project_history":


$this->add("object_handler", "", "lib/main/handlers/", false);
$this->add("list_projects", "", "lib/{$s->version}/list_items/", false);
$this->add("list_files", "", "lib/{$s->version}/list_items/", false);
$this->add("history", "", "lib/{$s->version}/list_items/", false);
                
        if ($_REQUEST['id_file'] && $_REQUEST['file_history']) {
            $this->add("history_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['id_proj'] && $_REQUEST['project_history']) {
            $this->add("history_handler", $edit_position, "lib/{$s->version}/handlers/", true);
        } elseif ($_REQUEST['file_history']) {
            $this->add("list_files", "main", "lib/{$s->version}/list_items/", true);
        } elseif ($_GET['v'] == "file_projects") {
            $this->add("file_projects_handler", "main", "lib/{$s->version}/handlers/", true);
        } else {
            $this->add("list_projects", "main", "lib/{$s->version}/list_items/", true);
        }

break;



case "private_search":
case "public_search":

$m->search_option= $this->view_ref; // selects between search modes

//--------search form
$this->add("search_engine", "", "lib/{$s->version}/search/", false);
$this->add("search_keywords_controller", "", "lib/main/search/", false);
$this->add("form_handler_member", "", "lib/main/forms/", false);

        //---------------------

        if ($this->view_ref == "private_search") {
            $this->add("private_search_form", "", "lib/{$s->version}/search/", false);
        } elseif ($this->view_ref == "public_search") {
            $this->add("public_search_form", "", "lib/{$s->version}/search/", false);
        }
        
        //---------------------
        
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("select_file_type", "", "lib/{$s->version}/selectors/", false);
$this->add("select_department", "", "lib/{$s->version}/selectors/", false);

//------search results

$this->add("list_search_results", "", "lib/main/search/", false);
$this->add("list_search_results_c1", "", "lib/{$s->version}/search/", false);
$this->add("list_clients", "", "lib/{$s->version}/list_items/", false);
$this->add("list_files", "", "lib/{$s->version}/list_items/", false);
$this->add("list_projects", "", "lib/{$s->version}/list_items/", false);
    
$this->add("search_handler", "main", "lib/{$s->version}/search/", true);

break;


case "print_letters":
case "printed_letters":
case "letter_preview":
case "process_preview":
case "print_selected":
case "print_all":

$this->add("letter_writing_methods", "main", "lib/{$s->version}/letter_writing/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("process_letter", "", "lib/{$s->version}/letter_writing/", false);
$this->add("letter_data", "", "lib/{$s->version}/letter_writing/", false);
$this->add("select_department", "", "lib/{$s->version}/selectors/", false);
$this->add("edit_letter", "", "lib/{$s->version}/letter_writing/", false);

$this->add("object_handler", "", "lib/main/handlers/", false);
$this->add("letter_preview_handler", "", "lib/{$s->version}/letter_writing/", false);

$print_commands= array("process_preview", "print_selected", "print_all");

    
        if ($this->view_ref == "letter_preview") {
            $this->add("letter_preview_handler", "main", "lib/{$s->version}/letter_writing/", true);
        } elseif (in_array($this->view_ref, $print_commands) && !empty($_REQUEST['data_print_letter'])) {
            $this->add("print_handler", "main", "lib/{$s->version}/letter_writing/", true);
        } elseif (in_array($this->view_ref, $print_commands) && empty($_REQUEST['data_print_letter'])) {
            $_GET['v']= $m->old_v;
            $this->add("list_print_letters", "main", "lib/{$s->version}/letter_writing/", true);
        } else {
            $this->add("list_print_letters", "main", "lib/{$s->version}/letter_writing/", true);
        }

break;


case "manage_letters":
case "letters":

$this->add("letter_writing_methods", "main", "lib/{$s->version}/letter_writing/", false);
$this->add("form_handler", "", "lib/main/handlers/", false);
$this->add("process_letter", "", "lib/{$s->version}/letter_writing/", false);
$this->add("letter_data", "", "lib/{$s->version}/letter_writing/", false);
$this->add("select_department", "", "lib/{$s->version}/selectors/", false);
$this->add("edit_letter", "", "lib/{$s->version}/letter_writing/", false);
$this->add("list_print_letters", "", "lib/{$s->version}/letter_writing/", false);


$this->add("object_handler", "", "lib/main/handlers/", false);
$this->add("letter_preview_handler", "", "lib/{$s->version}/letter_writing/", false);

// preview does not appear in window but in main of letters view handler
$position= $_REQUEST['preview'] ? "main" : $edit_position;

        if ($u->is_admin() && ($_REQUEST['id_letter'] xor $_REQUEST['create_letter'])) {
            $this->add("edit_letter", $position, "lib/{$s->version}/letter_writing/", true);
        } else {
            $this->add("list_letters", "main", "lib/{$s->version}/letter_writing/", true);
        }

break;



case "manage_stat_reports":
case "stat_reports":

$this->add("set_period", "", "lib/main/forms/", false);
$this->add("select_department", "", "lib/{$s->version}/selectors/", false);
$this->add("stat_methods_datatype", "", "lib/{$s->version}/stat_report/", false);
$this->add("stat_methods", "", "lib/{$s->version}/stat_report/", false);


            if ($u->is_admin() && (($_REQUEST['id_stat_report'] &&
            ($_REQUEST['edit_item'] || $_REQUEST['ask_delete_item'] ||
                    $_REQUEST['yes_delete_item'] || $_REQUEST['cancel'] || $_REQUEST['save_item']))
                    xor $_REQUEST['create_item'])) {
                $this->add("edit_stat_report", $edit_position, "lib/{$s->version}/stat_report/", true);
            } else {
                $this->add("list_stat_reports", "main", "lib/{$s->version}/stat_report/", true);
            }
    

break;


case "publish":

$this->add("publisher_handler_controller", "main", "lib/main/publisher/", true);

break;

        }
        

        $this->add("header", "header", "lib/main/other/", true);

        $this->add("menu_c1", "menu_right_col1_a1", "lib/{$s->version}/list_items/", true);
        $this->add("menu_c2", "menu_right_col1_b1", "lib/{$s->version}/list_items/", true);
        $this->add("menu_c3", "menu_top", "lib/{$s->version}/list_items/", true);

        $this->add("list_actions", "menu_right_col2_1", "lib/{$s->version}/list_items/", true);
    }
}
