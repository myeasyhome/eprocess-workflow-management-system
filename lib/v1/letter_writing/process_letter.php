<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/

class process_letter
{
    public static $error_regis;


    public static function process(&$letter, &$project, &$clients, $separator)
    {
        global $q, $t;


    
        $functions= new letter_writing_methods();
        $chunks= explode($separator, $letter);

        for ($i=0; $i < count($chunks); $i++) {
            if (strpos($chunks[$i], "*") === 0) {
                $ref= substr($chunks[$i], 1);
                
                if (!isset($project[$ref]) && !isset($clients[0][$ref])) {
                    $t->set_var("letter_var", $ref, true);
                    
                    self::$error_regis[]= $t->letter_variable_not_exist;
                } elseif (isset($project[$ref])) {
                    $chunks[$i]= $project[$ref];
                } elseif (isset($clients[0][$ref])) {
                    $chunks[$i]= $clients[0][$ref];
                }
            } elseif (strpos($chunks[$i], "#") === 0) {
                $ref= substr($chunks[$i], 1);
                
                if (!method_exists($functions, $ref)) {
                    $t->set_var("letter_var", $ref, true);
                    
                    self::$error_regis[]= $t->letter_method_not_exist;
                } else {
                    $chunks[$i]= $functions->$ref($letter, $project, $clients);
                }
            }
        }

        if (empty(self::$error_regis)) {
            $letter= implode($chunks);

            return true;
        } else {
            return false;
        }
    }
        
        
        
        
        
    public static function translate_style_tags($letter, $option="to_html")
    {
        $pairs= array();

        $pairs[]= array("#Vu" => "<br/>Vu");

        // haut petit
        $pairs[]= array("<hpe>" => "<div class=\"lt_top_small\">");
        $pairs[]= array("</hpe>" => "</div>");

        // articles
        $pairs[]= array("<arc>" => "<div class=\"lt_articles\">");
        $pairs[]= array("</arc>" => "</div>");

        //  haut a droite
        $pairs[]= array("<hdr>" => "<div class=\"lt_top_right\">");
        $pairs[]= array("</hdr>" => "</div>");

        // droite
        $pairs[]= array("<dr>" => "<div class=\"lt_right\">");
        $pairs[]= array("</dr>" => "</div>");

        // droite alignement centre
        $pairs[]= array("<drc>" => "<div class=\"lt_right_alcenter\">");
        $pairs[]= array("</drc>" => "</div>");

        // milieu droit
        $pairs[]= array("<mdr>" => "<div class=\"lt_middle_right\">");
        $pairs[]= array("</mdr>" => "</div>");

        // gauche
        $pairs[]= array("<ga>" => "<div class=\"lt_left\">");
        $pairs[]= array("</ga>" => "</div>");

        // gauche alignement centre
        $pairs[]= array("<gac>" => "<div class=\"lt_left_alcenter\">");
        $pairs[]= array("</gac>" => "</div>");

        // milieu gauche
        $pairs[]= array("<mga>" => "<div class=\"lt_middle_left\">");
        $pairs[]= array("</mga>" => "</div>");

        // titre
        $pairs[]= array("<ti>" => "<div class=\"lt_title\">");
        $pairs[]= array("</ti>" => "</div>");

        // paragraphe
        $pairs[]= array("<pa>" => "<div class=\"lt_parag\">");
        $pairs[]= array("</pa>" => "</div>");

        // gras
        $pairs[]= array("<gr>" => "<span class=\"lt_bold\">");
        $pairs[]= array("</gr>" => "</span>");

        // souligne
        $pairs[]= array("<so>" => "<span class=\"lt_underline\">");
        $pairs[]= array("</so>" => "</span>");

        // encadre
        $pairs[]= array("<enc>" => "<div class=\"lt_box\">");
        $pairs[]= array("</enc>" => "</div>");

        // space
        $pairs[]= array("<esp>" => "<div class=\"lt_space\">&nbsp;</div>");

        // small space
        $pairs[]= array("<pesp>" => "<div class=\"lt_small_space\">&nbsp;</div>");


        // line break
        $pairs[]= array("<r>" => "<br/>");


        if ($option == "from_html") {
            for ($i=0; $i < count($pairs); $i++) {
                $pairs[$i]= array_flip($pairs[$i]);
            }
        }

        //-------------------------
            
        for ($i=0; $i < count($pairs); $i++) {
            $letter= strtr($letter, $pairs[$i]);
        }
            
        return $letter;
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
