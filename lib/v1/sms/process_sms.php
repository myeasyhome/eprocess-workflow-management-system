<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class process_sms
{
    public static $error_regis;


    public static function process(&$sms, &$document, &$client, $separator="")
    {
        global $q, $t;



        if (empty($separator)) {
            $separator= "*#";
        } // default
        
        //---------------------

        $chunks= explode($separator, $sms);

        for ($i=0; $i < count($chunks); $i++) {
            if (strpos($chunks[$i], "*") === 0) {
                $ref= substr($chunks[$i], 1);
                
                if (!isset($document[$ref]) && !isset($client[$ref])) {
                    $t->set_var("sms_var", $ref, true);
                    
                    self::$error_regis[]= $t->sms_variable_not_exist;
                } elseif (isset($document[$ref])) {
                    $chunks[$i]= $document[$ref];
                } elseif (isset($client[$ref])) {
                    $chunks[$i]= $client[$ref];
                }
            }
        }

        if (empty(self::$error_regis)) {
            $processed= array();
            $processed= array_merge($processed, $document);
            $processed= array_merge($processed, $client);
            $processed['msg']= implode($chunks);
                    
            return $processed;
        } else {
            return false;
        }
    }

        
        
        
        
        
    public static function get_error_regis()
    {
        if (self::$error_regis) {
            $string="<div class=\"error_list\">";

            for ($i=0; $i < count(self::$error_regis); $i++) {
                $string .= "<div class=\"error\">".self::$error_regis[$i]."</div>";
            }
            
            $string .="</div>";
        
            return $string;
        }
    }
}
