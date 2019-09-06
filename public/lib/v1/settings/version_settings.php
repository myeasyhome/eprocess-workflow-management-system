<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class version_settings extends default_settings
{
    public function set_data()
    {
        parent::set_data();

        // app url

        $this->data['app_url']= "**************";

        // SMS

        $this->data['num_phone_request']= "016223104";
        $this->data['num_phone_subscription']= "016223104";

        $this->data['sms_file_reply_action']= "reply_for_file";
        $this->data['sms_project_reply_action']= "reply_for_project";

        $this->data['sms_file_subscription_action']= "file_subscription_confirmation";
        $this->data['sms_project_subscription_action']= "project_subscription_confirmation";

        $this->data['sms_file_transfer_action']= "file_transfer";
        $this->data['sms_project_transfer_action']= "project_transfer";

        $this->data['sms_new_project_subscribers_action']= "new_id_project";

        //---------------

        $this->data['client_types']=array("candidate_smp", "candidate_vlteer", "candidate_dcs", "candidate_ctt", "employee");
        $this->data['file_status']=array("dormant_with_projects", "active_no_client", "active_no_project", "active_with_project");
        $this->data['transfer_status']= array("registration", "received", "transit", "not_received");
        $this->data['department_type']= array("internal", "external");
        $this->data['work_categories']= array("work_cat_1", "work_cat_2", "work_cat_3");


        $this->data['scales']= array("1","2","3");
        $this->data['work_classes']= array("1","2","3");
        $this->data['echelons']= array("1","2","3");


        $this->data['private_search_fields']= array("id_file_type", "dept_comingfrom", "id_file", "title", "file_ref", "id_dept", "surname", "firstname", "date_birth", "date_created", "month", "year", "file_date", "id_proj", "proj_ref", "id_bordereau");

        $this->data['public_search_fields']= array("id_file", "surname", "firstname", "date_birth", "id_bordereau");


        $this->data['search_project_fields']= array("surname", "firstname", "date_birth", "id_proj", "id_bordereau");


        $this->data['qual_levels']= array("no_qual","cepe", "bepc", "bac", "bac2", "bac3", "bac4", "bac5", "doc", "prof");

        $this->data['open_main_table']= "<table class=\"main_table\" cellspacing=\"0\" cellpadding=\"0\">";

        $this->data['max_letter_num_pages']= 10;
        $this->data['letter_page_break']= "##page_break##";

        $this->data['max_file_client']= 50;

        //--------------------------

        $this->data['publisher_num_documents']= 50;
        $this->data['publisher_pagesize']= 10;
    }




    /*
        function set_text_classes () {
    
    $classes= parent::set_text_classes();
    
    //------select queries classes------
    
    //----------------
    
    return $classes;
    
        }
    */




    public function set_queries_classes()
    {
        $classes= parent::set_queries_classes();

        //------select queries classes------

        $prefix= "lib/{$this->data['version']}/queries/";

        $classes[]="stat_queries>>".$prefix;
        $classes[]="sms_queries>>".$prefix;

        //----------------

        return $classes;
    }






    public function set_db_variables()
    {
        $i_var= array();

        $i_var['id_carrier']="0";
        $i_var['id_dept']="";
        $i_var['surname']="";
        $i_var['firstname']="";
        $i_var['num_phone']="";
        $i_var['id_class']="0";
        $i_var['id_rank']="0";
        $i_var['scale']="0";
        $i_var['work_class']="0";
        $i_var['echelon']="0";
        $i_var['work_index']="0";
        $i_var['id_qual']="0";
        $i_var['id_client']="0";
        $i_var['id_file']="0";
        $i_var['id_proj']="0";
        $i_var['id_agent']="";
        $i_var['surname']="";
        $i_var['firstname']="";
        $i_var['date_birth']="";
        $i_var['town_birth']="";
        $i_var['client_type']="0";
        $i_var['sex']="0";
        $i_var['num_phone']="0";
        $i_var['email']="";
        $i_var['id_client_class']="0";
        $i_var['id_client']="0";
        $i_var['id_rank']="0";
        $i_var['scale']="0";
        $i_var['work_class']="0";
        $i_var['echelon']="0";
        $i_var['work_index']="0";
        $i_var['start_scale']="0000-00-00";
        $i_var['start_work']="0000-00-00";
        $i_var['id_qual']="0";
        $i_var['option_qual']="";
        $i_var['origin_qual']="";
        $i_var['id_dept']="0";
        $i_var['name_dept']="";
        $i_var['dept_type']="0";
        $i_var['has_search']="0";
        $i_var['has_write_letter']="0";
        $i_var['has_send_sms']="0";
        $i_var['id_file']="0";
        $i_var['file_dept']="0";
        $i_var['file_type']="0";
        $i_var['file_category']="0";
        $i_var['title']="";
        $i_var['date_created']="";
        $i_var['file_status']="0";
        $i_var['file_ref']="";
        $i_var['file_date']="0000-00-00";
        $i_var['id_file_cat']="0";
        $i_var['name_cat']="";
        $i_var['id_file_type']="0";
        $i_var['name_type']="";
        $i_var['id_letter']="0";
        $i_var['id_dept']="0";
        $i_var['id_user']="0";
        $i_var['title_letter']="";
        $i_var['body_letter']="";
        $i_var['describe_letter']="";
        $i_var['id']="0";
        $i_var['sender']="";
        $i_var['receiver']="";
        $i_var['msg']="";
        $i_var['senttime']="";
        $i_var['receivedtime']="";
        $i_var['msgtype']="";
        $i_var['operator']="";
        $i_var['id']="0";
        $i_var['sender']="";
        $i_var['receiver']="";
        $i_var['msg']="";
        $i_var['senttime']="";
        $i_var['receivedtime']="";
        $i_var['reference']="";
        $i_var['msgtype']="0";
        $i_var['operator']="";
        $i_var['errrormsg']="";
        $i_var['status']="";
        $i_var['id_print_letter']="0";
        $i_var['date_created']="";
        $i_var['date_printed']="";
        $i_var['id_user']="0";
        $i_var['id_proj']="0";
        $i_var['id_letter']="0";
        $i_var['total_cc']="0";
        $i_var['is_printed']="0";
        $i_var['id_proj']="0";
        $i_var['proj_ref']="";
        $i_var['proj_dept']="0";
        $i_var['proj_type']="0";
        $i_var['date_created']= $i_var['last_modified']= $i_var['date_trans']= "NOW()";
        $i_var['id_file']="0";
        $i_var['id_bordereau']="";
        $i_var['proj_status']="0";
        $i_var['id_proj']="0";
        $i_var['id_keep']="0";
        $i_var['name_var']="";
        $i_var['value']="";
        $i_var['id_letter']="0";
        $i_var['id_proj_status']="0";
        $i_var['name_proj_status']="";
        $i_var['id_proj_type']="0";
        $i_var['name_proj_type']="";
        $i_var['id_bordereau']="";
        $i_var['id_qual']="0";
        $i_var['name_qual']="";
        $i_var['trial_period']= 1;
        $i_var['id_rank']="0";
        $i_var['id_serv']="0";
        $i_var['id_work']="0";
        $i_var['work_class']="0";
        $i_var['name_rank']="";
        $i_var['determ_rank']="";
        $i_var['id_serv']="0";
        $i_var['name_serv']="";
        $i_var['id_stat_report']="0";
        $i_var['stat_method']="";
        $i_var['title_report']="";
        $i_var['describe_report']="";
        $i_var['id_sms']="0";
        $i_var['id_user']="0";
        $i_var['sms']="";
        $i_var['last_modified']="NOW()";
        $i_var['action']="";
        $i_var['id_sms_in']="0";
        $i_var['num_phone']="";
        $i_var['sms']="";
        $i_var['id_sms_out']="0";
        $i_var['num_phone']="";
        $i_var['sms']="";
        $i_var['id_client']="0";
        $i_var['id_file']="0";
        $i_var['id_proj']="0";
        $i_var['date_saved']="NOW()";
        $i_var['type_user']="0";
        $i_var['last_sent']="NOW()";
        $i_var['id_trans']="0";
        $i_var['id_file']="0";
        $i_var['id_proj']="0";
        $i_var['date_trans']="NOW()";
        $i_var['id_user']="0";
        $i_var['dept_comingfrom']="0";
        $i_var['dept_goingto']="0";
        $i_var['describe_trans']="";
        $i_var['status_trans']="0";
        $i_var['id_carrier']="0";
        $i_var['info_carrier']="";
        $i_var['id_user']="0";
        $i_var['username']="";
        $i_var['firstname']="";
        $i_var['surname']="";
        $i_var['password']="";
        $i_var['user_status']="0";
        $i_var['has_create_file']="0";
        $i_var['has_create_bordereau']="0";
        $i_var['has_create_project']="0";
        $i_var['has_print_letter']="0";
        $i_var['has_stats']= 0;
        $i_var['id_work']="0";
        $i_var['id_serv']="0";
        $i_var['name_work']="";

        return $i_var;
    }




    public function __construct($version)
    {
        parent::__construct($version);
    }




    public function __set($name, $value)
    {
        parent::__set($name, $value);
    }




    public function __get($name)
    {
        return (parent::__get($name));
    }
}
