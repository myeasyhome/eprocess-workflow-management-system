<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class sms_handler extends object_handler
{
    protected $delay;



    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->objs[0]= new receive_sms();
        $this->objs[0]->initialize();

        $this->delay= "30000";
    }
    
    
    
    
    
    public function config()
    {
        global $s, $t;
    
        parent::config();

        $this->has['common_data_source']= false;

        $this->has['title']= true;

        $this->set_title($t->send_receive_sms, "h2");


        if ($_GET['pause']) {
            $this->has['reload']= false;
        } else {
            $this->has['reload']= true;
        }
    }

    

    

    
    public function display()
    {
        global $s, $t;
    
        if (!$_GET['print_page']) {
            if ($this->has['reload']) {
                echo <<<HTML




<div id="curtain"></div>

<script language="javascript" type="text/javascript">
//<!--

var timeOutId1;
var timeOutId2;

function refresh() {

location.href="{$s->root_url}?v=send_receive_sms";
var button= document.getElementById("control_button");

}



function control_sms_handler (button) {

var name= button.value;

var name_pause= "{$t->pause}";
var name_start= "{$t->start}";


		if (name == name_pause) {
		
		clearTimeout(timeOutId1);
		clearTimeout(timeOutId2);
		button.value= name_start;
		button.setAttribute("class", "sms_control_pause");
		
		}		
		else if (name == name_start) {
		
		setTimeout(refresh, 3000);
		button.value= name_pause;
		button.setAttribute("class", "sms_control_run");
		
		}
}




var curtain_left= 0;
var width= 160;
var easing= 10;
var move= 1;
var stop;


function display_curtain() {
	
var curtain= document.getElementById("curtain");
curtain.style.background= "#fff url('images/eprocess_logo_large.png') 10em 10em no-repeat";
curtain.style.zIndex= "100000";
curtain.style.position= "absolute";
curtain.style.width= width+"%";
curtain.style.height= "100%";
curtain.style.top= "0px";
curtain.style.left= "0px";

}


function move_curtain () {
	
	if (width >= 0 ) {

	display_curtain();

	width -= easing;	
	width -= move;
	
	if (easing > 0)
	easing -= 2;
	
	}
	else {
	
	curtain.style.display= "none";
	clearInterval(stop);

	}

}

function start_move () {

stop= setInterval(move_curtain, 1);

}


display_curtain();

timeOutId1= setTimeout(start_move, 1000);
timeOutId2= setTimeout(refresh, {$this->delay});

//-->
</script>

HTML;
            }
        


            echo "<input type=\"button\" class=\"sms_control_run\" onclick=\"control_sms_handler(this)\" value=\"{$t->pause}\" >";
        }
        
        //----------------------------

    
        echo <<<HTML

<div class="wrap_sms_report">

HTML;

        $this->display_title();

        $this->objs[0]->display();

        echo "</div>";
    }
}
