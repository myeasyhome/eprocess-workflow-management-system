<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


abstract class website_msg_controller
{
    private static $type_list;
    private static $register;
    
    
    
    
    public static function initialize()
    {
        if (!isset(self::$type_list)) {
        
//---messages saved will be retrieved in the same order
            self::$type_list= array("fatal_error", "error", "confirm",
                                            "inform", "keep_inform", "form_error");
        }
        
        self::$register= array();
    }
    
    
    
    
    
    
    
    public static function throw_msg(&$obj, $type, $reference, $info="")
    {
        global $c, $s, $m, $t, $q, $u;

        
        if ($t->$reference) {
            self::$register[$type]= array();
        
        
        
            if (!in_array($type, self::$type_list)) {
                f1::echo_error("Could not create website msg as \"{$type}\" is not a valid type".
                        " in #met #set_self, #cls #self_controller");
                return;
            }

        
            //-------
        
            self::$register[$type]['reference']= $reference;

            
            //----------debugging
            
            if ($s->show_messages) {
                self::show_msg_created($type, $reference, $info);
            }
            
            //--------------------
        } else {
            f1::echo_error("Empty website msg not allowed. Name is \"{$reference}\".".
                        " #met #throw_msg, #cls #website_msg_controller");
        }
    }
    
    
    
    
    
    
    
    private static function show_msg_created($type, $reference, $info="")
    {
        global $t;
    
        $body= $t->$reference;


        echo <<<HTML

<span style="font:bold 1.3em helvetica, sans-serif, arial;">

<span style="color:blue;">***************</span><br/><br/>

<span style="color:red;">Creating website message: {$type}...</span><br/>


<span style="color:green;">

{$body}

, {$info}

</span><br/><br/>

<span style="color:blue;">***************</span>

</span>

HTML;
    }
    
    
    
    

    
    public static function get_msg(&$obj, $type)
    {
        global $c, $s, $m, $t, $q, $u;



        $msg= array();

        
        if (in_array($type, self::$type_list)) {
            $msg= self::$register[$type];
                        
            //----ignore msg
            
            if ($ignore= $obj->get_var("ignore_msg")) {
                if (is_array($ignore) && in_array($msg['reference'], $ignore)) {
                    f1::echo_comment("#msg #reference ignored in #cls#website_msg_controller, #met#get_msg");
                    return;
                }
            }
                
                
            //---If form_error, check if same form_name
                
            if (isset($msg['form_name'])) {
                $form_name= $obj->get_var("form_name");
                    
                if ($form_name != $msg['form_name']) {
                    return;
                }
            }
            
            //----------
            
            if ($msg['reference']) {
                $msg['type']= $type;
                return $msg;
            }
        } else {
            f1::echo_error("Invalid type in #met #get_msg, ".
                    "#cls #self");
            return;
        }
    }
    
    
    
    
    
    
    
    public static function get_keep_inform_msg()
    {
        if ($_SESSION['keep_inform']) {
            return $_SESSION['keep_inform'];
        }
    }
    
    
    
    
    
    
    
    public static function end_keep_inform_msg()
    {
        if ($_SESSION['keep_inform']) {
            unset($_SESSION['keep_inform']);
        }
    }

    
    
    
    
    
    public static function throw_action_msg()
    {
        global $c, $s, $m, $t, $q, $u;





        if (!isset($_GET['do'])) {
            return;
        }
        
        //-------------------------------------------

        $info= "";

    
        if ($name= $_GET['do']) {
            switch ($name) {

            case "successful_login":
            
            $type= "confirm";
            
            //-------Transfer username
            $t->set_var("username", $c->get_user_data("username"), false);

            //-------Transfer status_name and refresh
            $t->set_var("user_status_name", $c->get_user_data("status_name"));
                    
            break;
            
            }
        }
        
        
        if ($type && $name) {
            self::throw_msg($type, $name, $info);
        }
    }
    
    

    
    
        
    
    public static function has_fatal_error()
    {
        if (self::$register['fatal_error']) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    public static function has_error()
    {
        if (self::$register['error']) {
            return true;
        } else {
            return false;
        }
    }
}
