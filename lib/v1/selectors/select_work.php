<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_work extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->i_var['writable_data_list'][]= "id_serv";

        $this->set_title($t->work, "h2");

        $this->select_name= "id_work";

        $this->data_source="select_work1";

        $this->id_tag= "id_work"; // default
$this->label_tag= "name_work"; // default

$this->has['submit']= false;
        $this->has['form']= false;
        $this->has['filter']= true;

        $this->default= $t->unknown;
    }
    
    
    
    
    
    public function set_filter()
    {
        global $q;

    
        if (is_numeric($_REQUEST['id_serv'])) {
            $q->set_filter("id_serv='".$_REQUEST['id_serv']."'");
        } elseif ($this->data['id_serv']) {
            $q->set_filter("id_serv='". $this->data['id_serv']."'");
        }
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
