<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_service extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();


        $this->i_var['writable_var_list'][]= "current_url";

        $this->has['share_data']= true;
        $this->i_var['readable_data_list'][]= "all_data";

        $this->set_title($t->services, "h2");

        $this->select_name= "id_serv";
        
        
        $this->data_source="select_service1";

        $this->id_tag= "id_serv"; // default
$this->label_tag= "name_serv"; // default

$this->has['submit']= false;
        $this->has['form']= false;

        $this->default= $t->unknown;
    }
    
    
    
    
    
    public function onsubmit()
    {
    }
    
    
    
    
    
    
    public function start()
    {
        global $s;

        $this->selected= isset($this->data[$this->id_tag]) ? $this->data[$this->id_tag] :
                                                    (isset($_REQUEST[$this->id_tag]) ? $_REQUEST[$this->id_tag] : null);
    }
    
    
    
    
    
    public function display()
    {
        if ($this->has['redirect_script'] && !self::$class_displayed['redirect_script']) {
            self::$class_displayed['redirect_script']= true;
        
            echo <<<HTML

<script language="javascript" type="text/javascript">
//<!--
function list_goto( x_select, x_url )
{

    selecteditem = x_select.selectedIndex ;
    newurl = x_url + x_select.options[ selecteditem ].value ;
    
	if (newurl.length != 0) {
    location.href = newurl ;
    }
	else
	document.write("Error, Could not redirect to url" + newurl);

}
//-->
</script>

HTML;
        }

        parent::display();
    }
}
