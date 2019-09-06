<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




//------Global variables

$c; // main controller
$s; // settings
$t; // text
$q; // queries
$m; // memory
$u; // user
$v; // view controller

//---------------------------------------



class main_controller
{
    private $has;
    private $data;




    public static function start($version)
    {
        global $c, $s, $m, $t, $q, $u;

        $c= new main_controller($version);
        $c->manage_display();
    }
    
    
    
    
    
    private function __construct($version)
    {
        global $s;
    
        $s= new version_settings($version);

        //-----Website settings
        $s->set_data();

        $error_msg= FATAL_MSG." Error mco_gf";
        $this->insert_files_list($s->set_files(), "", $error_msg);

        session_start(3600);
    }

    
    
    
    
    
    private function manage_display()
    {
        global $c, $s, $m, $t, $q, $u, $v;


        //----Start website object
        $this->initialize();

        // -------connect to database-----------
        $db_connect= new database_connection_controller();
        $db_connect->connect();

        //--------------------------------
        website_msg_controller::initialize();

        //------get queries object
        $q= new query_controller();

        //--set queries
        $q->set_queries();

        //----get text object
        $t= new text_controller();
        $t->load_text();

        //-------Environment

        if (isset($_SESSION['memory'])) {
            $m= $_SESSION['memory'];
        } else {
            $m= new memory();
        }

        //---------User-----------------

        
        if (isset($_SESSION['user'])) {
            $u= $_SESSION['user'];
        } else {
            $u= new user();
        }
                

        //--------------------------





        //-------------------------------

        $this->onsubmit();
        $m->onsubmit();

        //------Display page----

        $v= new version_view_controller();
        $v->manage_display();
    }

    
    


    
    public function onsubmit()
    {
    }
        
    


    
    public function initialize()
    {
        global $s;

        $this->has= array();
        $this->data= array();

        //---------------

        $this->data['remember']= array();

        //-----------------

        $s->set_development_options();
    }

    
    
    
    
    
    
    public function remember_data($ref, $value)
    {
        $this->data['remember'][$ref]= $value;
    }
    
    
    
    
    
    
    
    public function remind_data($ref)
    {
        if (isset($this->data['remember'][$ref])) {
            return $this->data['remember'][$ref];
        }
    }
    
    
    
    
    
    
    
    
    public function forget_data($ref)
    {
        if (isset($this->data['remember'][$ref])) {
            unset($this->data['remember'][$ref]);
        }
    }

    
    

    


    public function validate_input($input_ref)
    {
        if (isset($_GET[$input_ref]) && validateNumeric($_GET[$input_ref])) {
            return true;
        }
    }
    

    
    
    
        
    public function insert_file($file, $path="", $error_msg="")
    {
        if (empty($error_msg)) {
            $error_msg= FATAL_MSG." Error mco_ins";
        }

        try {
            $file= $path.$file;
        
            //echo $file."<br/>"; // debug here

            if (file_exists($file)) {
                require $file;
                return true;
            } else {
                throw new Exception();
            }
        } catch (Exception $e) {
            exit($error_msg);
        }
    }



    
        
    
    public function insert_files_list($files, $path="", $error_msg)
    {
        if (empty($error_msg)) {
            $error_msg= FATAL_MSG." Error mco_ins";
        }

        
        if ($files) {
            for ($i=0; $i < count($files); $i++) {
                $this->insert_file($files[$i], $path, $error_msg);
            }
        } else {
            exit($error_msg);
        }
    }

    
        
    
    
    
    public function set_has_comments($x_boolean)
    {
        if ($x_boolean) {
            $this->has['comments']= true;
        } else {
            $this->has['comments']= false;
        }
    }

    
    
    
    
    
    
    public function update_current_url($delete=null, $update= false)
    {
        global $s;
    
        $current_url= $s->root_url;
        
        if (isset($_GET)) {
            $counter= 0;
        
            foreach ($_GET as $key=>$value) {
                if (is_string($delete) && ($key == $delete)) {
                    continue;
                }
                
                if (is_array($delete) && (in_array($key, $delete))) {
                    continue;
                }
            
                if ($counter === 0) {
                    $current_url .= ("?".$key."=".$value);
                } else {
                    $current_url .= ("&".$key."=".$value);
                }
                
                $counter++;
            }
        }
        
        
        //---url connector
        
        if ($counter > 0) {
            $this->data['url_connector']= "&";
        } else {
            $this->data['url_connector']= "?";
        }
        
        //----------------

        if ($update) {
            $this->data['current_url']= $current_url;
        }
        
        //----------
        
        return $current_url;
    }
    
    
    
    
    
    
    public function get_status_name($selected)
    {
        global $s;

        $list= $s->user_status;
        ;
        foreach ($list as $name => $status) {
            if ($status == $selected) {
                $status_name= $name;
            }
        }
        
        if (!$status_name) {
            f1::echo_error("status name not found in met#set_status_name, cls#user");
        } else {
            return($status_name);
        }
    }
    
    
    
    
        
    public function redirect($location= null)
    {
        if (empty($location)) {
            $location= $s->root_url;
        }

        if (!headers_sent()) {
            header("Location: ".$location);
        } else {
            f1::echo_warning("met#redirect failed, in ".get_class($this));
        }
        
        return false;
    }
}
