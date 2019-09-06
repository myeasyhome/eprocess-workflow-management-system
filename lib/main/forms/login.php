<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class login extends html_form
{
    protected $zone;
    protected $loggedin_obj;




    public function config()
    {
        global $c, $s, $u, $q, $t;


        parent::config();
                
        $this->zone="zn_operator";
                
        //---Default values------------------------------------

        $this->i_var['input_size']=40;
        $this->i_var['input_maxlength']=40;
        $this->i_var['textarea_rows']=8;
        $this->i_var['textarea_cols']=50;


        $this->i_var['form_name']= "login";
        $this->i_var['form_method']= "POST";
        $this->i_var['target_url']= $s->root_url."?v=login";
        $this->i_var['submit_name']= "login";
        $this->i_var['last_login_query']= "";

        $this->has['auto_redirect']= true;
        $this->has['form']= true;
        $this->has['submit']= true;
        $this->has['filter']= false;
        $this->has['loggedin_obj']= true;

        $this->has['database_data_source']= true;
        
        $this->data_source="user_login";
        
        //---------form-----------------------

        $this->define_form();

        //-------------------------------------

        $this->set_title($t->login, "h2");
        $this->i_var['loggedin_obj']= "summary";
    }

    
    
    
    
    public function define_form()
    {
        $fields= array();

        $fields[]= "username";
        $fields[]= "password";

        $this->make_sections("input_text", 1);
        $this->make_sections("password", 1);

        $this->set_fields($fields);
    }
    
    
    
    
    
    public function set_filter()
    {
        global $c, $s, $u, $q, $t;

        $string="";
                
        $q->set_filter($string);
    }
    
    
    
    
    
    
    public function set_query()
    {
        global $c, $s, $u, $q, $t;
    }
    
    
    
    
    
    
    
    public function onsubmit()
    {
        global $c, $s, $m, $u, $q, $t;

        
        if ($m->view_ref == "logout") {
            $u= null;
            unset($_SESSION['user']);
        
            $u= new user();
            $m->set_zone("zn_public");
        
            $this->throw_msg("confirm", "logout_completed", "#cls #login, #met #onsubmit");

            return;
        }

        if ($this->is_validated() === true) {
            $this->set_query();
        
            $q->set_var("username", $_REQUEST['username']);
            $q->set_var("password", $_REQUEST['password']);
        
            $this->set_data();
            $this->data_source="";

            //---------Successful login

            if ($this->numrows === 1) {

            //----- register last login date-time--------------------------

                $q->set_var("id_user", $this->data['id_user']);

                if ($this->i_var['last_login_query']) {
                    $q->sql_action($this->i_var['last_login_query']);
                } else {
                    f1::echo_warning("last_login_query not set, in #met #onsubmit,".
                            " #cls #login");
                }
            
                //---------------------------------------
            
                $m->set_zone($this->zone);
            
                $m->transfer_from_previous();

                $u->status= $this->data['user_status'] ;
            
                $u->set_status_name();

                $u->id= (int)$this->data['id_user'];

                $u->username= $this->data['username'];
            
                $u->has_create_file= $this->data['has_create_file'];
                $u->has_create_bordereau= $this->data['has_create_bordereau'];
                $u->has_create_project= $this->data['has_create_project'];
                $u->has_print_letter= $this->data['has_print_letter'];
                $u->has_stats= $this->data['has_stats'];
            
                $u->id_dept= $this->data['id_dept'];
            
                $q->set_filter("id_dept='".$this->data['id_dept']."'");
                $dept= $this->set_data_from_id("select_department1");
            
                $u->name_dept= $dept['name_dept'];
            
                if ($dept['has_search'] == 1) {
                    $u->dept_has_search= true;
                }
                
                if ($dept['has_write_letter'] == 1) {
                    $u->dept_has_write_letter= true;
                }
                
                if ($dept['has_send_sms'] == 1) {
                    $u->dept_has_send_sms= true;
                }

                //--------------------------------------------------
            
                $this->has['successful_login']= true;
            
                //--------------Redirect if applicable--------------------
            
                if ($this->has['auto_redirect']) {
                    $this->i_var['target_url'] .= "&info=successful_login";
                
                    //---Will not redirect if headers have been sent
                    $c->redirect($this->i_var['target_url']);
                
                    exit;
                }
                
                //-----------------------------

                $this->is['displayable']= false;
            } else {
                $this->throw_msg("error", "login_failed");
            }
        }
        

        if (($this->has['successful_login'] === true) || (($_GET['info'] == "successful_login")
        && !$u->successful_login && $u->id)) {
                
        //-------Transfer username
            $t->set_var("username", $u->username, false);

            //-------Transfer status_name and refresh
            $t->set_var("status_name", $u->status_name, true);
        
        
            $this->throw_msg("confirm", "successful_login", "cls#".get_class($this).", #met #onsubmit");
                
            $u->successful_login= true;
        
            $this->is['displayable']= false;
        }
        
                
        if ($this->has['loggedin_obj'] &&
            ($this->has['successful_login'] || ($_GET['info'] == "successful_login"))) {
            $error_msg= FATAL_MSG."error log1";
        
            if (!class_exists($this->i_var['loggedin_obj'])) {
                $c->insert_file($this->i_var['loggedin_obj'].".php", $this->i_var['loggedin_obj_path'], $error_msg);
            }
        
            $this->loggedin_obj= new $this->i_var['loggedin_obj']();
            $this->loggedin_obj->initialize();
            $this->loggedin_obj->config();
            $this->loggedin_obj->onsubmit();
            $this->loggedin_obj->start();
            $this->loggedin_obj->set_data();
            $this->reference= $this->loggedin_obj->get_reference();
        }
    }
    
    
    
    
    
    
    public function set_data()
    {
        global $u;


        if ($_REQUEST[($this->i_var['submit_name'])]) {
            parent::set_data();
        }
    }
    
    
            

            
            
            
    public function display()
    {
        global $c, $m, $s, $u, $q, $t;

        if ($this->is['displayable'] && !$u->is_logged_in($this->zone)) {
            echo "<div id=\"login_panel\">";


            parent::display();


            if ($this->has['sign_up_section']) {
                echo <<<HTML

<div id="sign_up">

{$t->not_a_member_ask}

<a href="{$s->root_url}?view=register">
{$t->register}
</a>

</div>

HTML;
            }
                    
            echo "</div>";
        } elseif ($this->has['loggedin_obj'] && !empty($this->loggedin_obj)) {
            $this->loggedin_obj->display();
        }
    }
}
