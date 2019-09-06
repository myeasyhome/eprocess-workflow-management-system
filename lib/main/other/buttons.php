<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class buttons extends website_object
{
    public static function back($show=false)
    {
        global $c, $s, $m, $t, $q, $u;


        if ($_REQUEST['bkb'] || $show) {
            echo <<<HTML
<div class="wrap_button">
<form>
<input type="button" value="{$t->back}" onClick="history.go(-1);return true;" >
</form>
</div>
HTML;
        }
    }
    
        
        
    
    
    
    
    public static function anchor_button($appendix1, $params=array(), $label)
    {
        global $s;


        if ($_GET['print_page']) {
            return;
        }
        

        $appendix2="";
        $counter= 0;

        if (is_array($params)) {
            for ($i=0; $i < count($params); $i++) {
                if (isset($_REQUEST[$params[$i]]) && $counter) {
                    $appendix2 .= "&".$params[$i]."=".$_REQUEST[$params[$i]];
                } elseif (isset($_REQUEST[$params[$i]]) && (strpos($appendix1, "?") === false)) {
                    $appendix2 .= "?".$params[$i]."=".$_REQUEST[$params[$i]];
                } elseif (isset($_REQUEST[$params[$i]])) {
                    $appendix2 .= "&".$params[$i]."=".$_REQUEST[$params[$i]];
                }
            }
        }
            
        echo "<a class=\"anchor_button\" href=\"{$s->root_url}{$appendix1}{$appendix2}\">{$label}</a>";
    }
}
