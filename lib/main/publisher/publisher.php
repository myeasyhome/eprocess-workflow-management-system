<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class publisher extends list_items
{
    protected $document;
    protected $num_part;
    protected $total_parts;
    protected $delay;


    public function config()
    {
        parent::config();

        $this->delay= 25000;
        $this->num_part= 0;
        $this->document= array();
        $this->list= array();

        $this->display_list= array();

        $this->display_list['file']= array("title" , "name_cat", "name_type", "name_dept", "name_status", "date_created", "name_coming_from", "file_date" );

        $this->display_list['project']= array("proj_ref", "id_bordereau", "name_dept", "name_proj_status", "date_created", "name_coming_from", "num_file");
    }
    
    
    
    
    
    public function add_client(&$client)
    {
        $this->list[]= $client;
    }
    
    
    
    
    public function set_document_data($data)
    {
        $this->document= &$data;
    }
    
    
    
    
    public function display_top()
    {
        global $t;


        if ($this->document['t_id_proj'] > 0) {
            $clients_of_document= $t->clients_of_project;
            $this->id_tag= "t_id_proj";
        } elseif ($this->document['t_id_file'] > 0) {
            $clients_of_document= $t->clients_of_file;
            $this->id_tag= "t_id_file";
        }
        
        echo <<<HTML

 <div class="art-header">
                    <div class="art-header-center">
                        <div class="art-header-png"></div>
                    </div>
                    <div class="art-logo">
                       <h1 id="name-text" class="art-logo-name"><a href="#">
					 {$clients_of_document} {$this->document[$this->id_tag]}</a></h1>

HTML;

        if ($this->num_part > 0) {
            echo <<<HTML

<h2>{$this->num_part} / {$this->total_parts}</h2>

HTML;
        }
        
        echo "</div></div>";
    }
    
    
    
    
    
    private function document_to_string($allowed)
    {
        global $t;
    
        $string= "";
    
        foreach ($this->document as $key => $value) {
            if (is_array($allowed) && !in_array($key, $allowed)) {
                continue;
            }
    
            $label= $t->$key;
            
            $string .= <<<HTML
<span class="clear">&nbsp;</span>
<img src="pub_images/postheadericon2.png" width="26" height="26" alt="" />
<h2 class="document">
<span class="label">{$label}: </span><span class="data">{$value}</span>
</h2>

HTML;
        }
        
        return $string;
    }
    
    
    
    
    public function set_num_part($num)
    {
        $this->num_part= $num;
    }
    
    
    
    
    
    public function set_total_parts(&$num)
    {
        $this->total_parts= &$num;
    }
    
    
    
    
    
    
    public function display_document_data()
    {
        global $t;
        
        echo "<div class=\"pub_document\">";

        if ($this->id_tag == "t_id_file") {
            $this->data= &$this->document;
        
            $this->data['id_file']= $this->data['t_id_file'];
        
            $this->set_file_names();
        
            echo $this->document_to_string($this->display_list['file']);
        } elseif ($this->id_tag == "t_id_proj") {
            $this->data= &$this->document;
        
            $this->data['num_file']= $this->data['id_file']= $this->data['f_id_file'];
            $this->data['id_proj']= $this->data['t_id_proj'];
            $this->data['date_created']= $this->data['p_date_created'];
        
            $this->set_project_names();
        
            echo $this->document_to_string($this->display_list['project']);
        } else {
            f1::echo_error("unexpected #id_tag in met#display, cls#publisher");
        }
        
        echo "</div>";

        HTML;
    }
    
    
    
    
    
    
    public function display_skeleton()
    {
        global $t;


        echo <<<HTML

 <h2 class="client"><img src="pub_images/postheadericon.png" width="26" height="26" alt="" />
<span class="surname">{$this->data['surname']}</span> <span class="firstname">{$this->data['firstname']}</span>
</h2>

HTML;
    }

    
    
    
    
    
    public function display()
    {
        global $s;
    
    
        echo <<<HTML

<div id="curtain">&nbsp;</div>

<script language="javascript" type="text/javascript">
//<!--

function refresh() {

location.href="{$s->root_url}?v=publish";

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
curtain.style.height= "40em";
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

setTimeout(start_move, 1000);

setTimeout(refresh, {$this->delay});
	

//-->
</script>

HTML;

?>


<div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
			
			<?php $this->display_top(); ?>
               
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
					
					
					<div class="pub_clients">
					<?php parent::display(); ?>	
					</div>
					
					
                    <?php $this->display_document_data(); ?>
      
                    </div>
                </div>
                <div class="cleared"></div>
                
				
        		<div class="cleared"></div>
            </div>
        </div>


<?php
    }
}
