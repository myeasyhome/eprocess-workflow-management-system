<?php


class window
{
    public static function display(&$menu, &$main, &$msg_obj)
    {
        global $s, $u, $m, $t;

        //------------------------------------

        $window_shadow_id= $m->window_shadow_id;
        $window_id= $m->window_id;

        $m->destroy_data("window_shadow_id");
        $m->destroy_data("window_id");

        //----------------------

        if (empty($window_shadow_id)) {
            $window_shadow_id= "window_shadow";
        }
                
        if (empty($window_id)) {
            $window_id= "window";
        }
                
        //---------------------------------
                
        $title= $main->get_title();
        $previous= $m->previous_page;
        
        echo <<<HTML

<div id="{$window_shadow_id}">
&nbsp;
</div>

<div id="{$window_id}">

HTML;


        if (is_object($menu)) {
            echo "<div id=\"window_menu\">";
            $menu->display();
            echo "</div>";
        }
        
        
        echo <<<HTML

<div id="window_top">
<a style="float:left;" id="window_top_left" href="{$s->root_url}">
{$s->global_name}: {$title}
</a>

<a style="float:right;" id="window_top_close" href="{$previous}">
<img id="window_top_close_img" src="images/close1.png">
</a>

</div>

<div id="window_middle">
<div id="window_middle_margin">

HTML;
        
        $msg_obj->display();
        
        if (is_object($main)) {
            $main->display();
        }
        
        echo <<<HTML

</div>
</div>


<div id="window_bot">
<a style="float:left;" id="window_bot_close" href="{$previous}">
<img id="window_top_close_img" src="images/close1.png">
</a>

</div>

</div>

HTML;

        //------------------------------


        echo <<<HTML

<script language="javascript" type="text/javascript">
//<!--

function window_style() {
	
var obj= document.getElementById("{$window_shadow_id}");
obj.style.position= "absolute";
obj.style.top= "0";
obj.style.left= "0";
obj.style.width= "100%";
obj.style.height= "70em";
obj.style.background= "#dcdcdc";
obj.style.zIndex= "10000";
obj.style.opacity= "0.60";
obj.style.filter= "alpha(opacity=60)";

	
var obj= document.getElementById("{$window_id}");
obj.style.cssFloat= "left";
obj.style.position= "absolute";
obj.style.top= "30px";
obj.style.left= "3%";
obj.style.width= "auto";
obj.style.height= "auto";
obj.style.margin= "0 0 15em 0";
obj.style.padding= "0";
obj.style.background= "#ffffff";
obj.style.border= "1px solid #00008B";
obj.style.zIndex= "30000";



	
var obj= document.getElementById("window_top");
obj.style.width= "auto";
obj.style.height= "20px";
obj.style.text_align= "right";
obj.style.border= "1px solid #4682B4";
obj.style.background= "#4682B4";




var obj= document.getElementById("window_top_left");
obj.style.display= "block";
obj.style.cssFloat= "left";
obj.style.width= "400px";
obj.style.height= "20px";
obj.style.margin= "0 0 0 0.5em";
obj.style.color= "#ffffff";
obj.style.textDecoration= "none";



var obj= document.getElementById("window_top_close");
obj.style.display= "block";
obj.style.cssFloat= "right";
obj.style.width= "30px";
obj.style.height= "20px";
obj.style.margin= "0 0.5em 0 0";
obj.style.color= "#ffffff";
obj.style.textDecoration= "none";



var obj= document.getElementById("window_top_close_img");
obj.style.cssFloat= "right";




var obj= document.getElementById("window_middle");
obj.style.cssFloat= "left";
obj.style.width= "auto";
obj.style.height= "auto";
obj.style.padding= "1em 1em 2em 1em";
obj.style.background= "#ffffff";



var obj= document.getElementById("window_middle_margin");
obj.style.margin= "0.5em";
obj.style.width= "100%";
obj.style.height= "auto";



}

window_style();


//-->
</script>

HTML;
    }
}
