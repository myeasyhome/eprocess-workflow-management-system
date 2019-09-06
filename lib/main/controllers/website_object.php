<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class website_object
{
    protected $i_var;

    protected static $instance_counter= 0;
    protected $reference;
    protected $subject;
    protected $has;
    protected $is;
    protected $option;
    protected $id;
    protected $data_source;
    protected $numrows;
    protected $res;
    protected $row;
    protected $data;
    protected $title;
    protected $title_text;
    protected $ignore;
    protected $hidden_input;
    protected $index;
    protected $selected;
    protected $global_var;
    protected $no_result_msg;
    protected $display_list;
    protected $is_numeric;

    protected static $class_displayed;
    
    protected $sender;


    
    public function initialize()
    {
        global $c, $s, $m, $t, $q, $u;

        $this->reference="";

        $this->status= array();
    
        $this->i_var= array();

        $this->has= array();
        $this->is= array();

        $this->selected= array();

        $this->subject="item";

        $this->has['title']= true; // default
$this->has['writable_data_source']= false; // default
$this->has['data']= true;
        $this->has['share_data']= true;
        $this->has['one_data_row']= true;
        $this->has['free_data']=false;
        $this->has['extra_data']=false;
        $this->has['form_action_refresh']= true; // directs to same url when form is submitted
        $this->is['active']= true;
        $this->is['displayable']= true;

        $this->i_var['current_url']= $c->update_current_url();

        $this->i_var['writable_data_list']= array();
        $this->i_var['writable_var_list']= array();
        $this->i_var['readable_data_list']= array();
        $this->i_var['readable_var_list']= array();

        $this->i_var['submit_wrap_tag']= "div";
        $this->i_var['img_position']= "up";

        $this->i_var['input_size']= "50";
        $this->i_var['input_maxlength']= "60";

        $this->i_var['name_id_dept']= "";
        $this->i_var['tr_class']= "";

        $this->i_var['hyperlink_root']= array();
        $this->i_var['hyperlink_list']= array();
        $this->has['hyperlink_uses_id_tag']= array();
        $this->i_var['primary_name_tag']= "";

        $this->data= array();

        $this->numrows= -1;

        $this->no_result_msg= $t->empty_section;
    }

    
    
    
    
    public function initialize_global_var($name= "REQUEST")
    {
        if ($name == "POST") {
            $this->global_var= $_REQUEST;
        }
        
        if ($name == "GET") {
            $this->global_var= $_GET;
        }
        
        if ($name == "REQUEST") {
            $this->global_var= $_REQUEST;
        }
    }
    
    
    
    


    public function config()
    {
    }
    
    
    
    
    
    
        
    
    public function start()
    {
        global $m;

        if (!empty($this->data) && $m->request_data) {
            $name= $m->request_data;
        
            if (isset($this->data[$name])) {
                $m->$name= $this->data[$name];
                f1::echo_warning("requested data with reference {$name} was added to memory object");
            }
        }
    }
    
    
    
        
    
    
    public function set_filter()
    {
    }
    
    
    
    public function set_subject($value)
    {
        $this->subject= $value;
    }
    
    
    
    public function set_id($value)
    {
        $this->id= $value;
    }
    
    
    
    
    
    public function set_selected($value)
    {
        $this->selected= $value;
    }

    
    
    
    
    public function numeric_id_from_array(&$id)
    {
        if (is_array($id) && is_numeric($id[0])) {
            $id= $id[0];
        }
    }
    
    
    
    
    
    public function require_id($type="numeric", &$data)
    {

    
    //type= numeric \ string \ array
    
        $function= "is_".$type;

        if (empty($data) || !$function($data)) {
            $this->throw_msg("fatal_error", "invalid_request", "met#require_id, 
				cls#".get_class($this).", invalid id");
        } else {
            return $data;
        }
    }
    
    
    
    
    
    
    
    
    public function filter_by_period($string, $meta=array())
    {
        $period= array();

        if ($_GET['filter']) {
            $this->i_var['period_name']= $_GET['filter'];

            switch ($this->i_var['period_name']) {
            
            case "month_filter":
            
            $period= $this->make_month_period();
            
            break;
             
            case "today":
             
            $period= $this->make_period(0, -1);
             
            break;
            
            case "yesterday":
             
            $period= $this->make_period(1, 0);
             
            break;
            
            case "last7":
             
            $period= $this->make_period(7, -1);
             
            break;
         
            case "last15":
             
            $period= $this->make_period(15, -1);
            
            break;
            
            case "last30":
             
            $period= $this->make_period(30, -1);
            
            break;
            
            }
        }
        
        
        if (!empty($period)) {
            $first_datetime= $period[0];
            $last_datetime= $period[1];
        }

        //-----------
        
        if ($first_datetime) {
            if (!empty($string)) {
                $string .= " AND ";
            }

            //------------
            if ($meta['last_modified_filter']) {
                $string .= "file1.last_modified > {$first_datetime} ";
            } else {
                $string .= "file1.date_created > {$first_datetime} ";
            }
        
            //------------
            if ($last_datetime) {
                if ($meta['last_modified_filter']) {
                    $string .= " AND file1.last_modified < {$first_datetime} ";
                } else {
                    $string .= " AND file1.date_created < {$last_datetime} ";
                }
            }
        }
        
        
        return $string;
    }
    
    
    
    

    
    
    public function make_period($since_first=0, $since_last=-1)
    { // parameters in number of days
        
        $first_datetime="";
        $last_datetime="";
    
    
        if ($since_first < 1) {
            $first_datetime= $this->mysql_datetime(0);
        } else {
            $first_datetime= $this->mysql_datetime(time() - (60 * 60 * 24 * $since_first));
        }

        //----------------
        
        if ($since_last >= 0) {
            if ($since_last <= 1) {
                $last_datetime= $this->mysql_datetime(0);
            } else {
                $last_datetime= $this->mysql_datetime(time() - (60 * 60 * 24 * $since_last));
            }
        }

        $period= array($first_datetime, $last_datetime);

        return $period;
    }
    
    
    
    
    
    
    
    public function make_month_period()
    {
        $month= $_GET['month'];
        $year= $_GET['year'];


        //-----------------------------
        
        if ($_GET['month'] && !is_numeric($_GET['month'])) {
            $month= date("m", time());
        }
        
        if ($_GET['year'] && !is_numeric($_GET['year'])) {
            $year= date("Y", time());
        }
        
        //---------------------------
        
        if ($month == 12) {
            $month_after= "01";
            $year_after= (int)$year + 1;
        } else {
            $vx= (int)$month + 1;
            $month_after= sprintf("%02d", $vx);
            $year_after= $year;
        }

        //-----------------------------
        
        $first_datetime= $year.sprintf("%02d", $month)."000000";
        $last_datetime= $year_after.$month_after."000000";
                
        //---------------------------------
        
        $period= array($first_datetime, $last_datetime);

        return $period;
    }
    
    
    
    
    
        
    public function mysql_datetime($seconds)
    {
        if ($seconds === 0) {
            $date= date("Ymd000000", time());
        } else {
            $date= date("Ymd000000", $seconds);
        }

        return $date;
    }

    
    
    
    
    
    public function is_active()
    {
        if ($this->is['active'] === true) {
            return true;
        }
    }

    
    
    
    public function in_cancel_mode()
    {
        if ($_REQUEST["ask_delete_".$this->subject] || $_REQUEST['cancel']) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    public function onsubmit()
    {
    }
    
    
    
    
    
    
    public function is_displayable()
    {
        if ($this->is['displayable']) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    public function set_displayable($value= true)
    {
        if (is_bool($value)) {
            $this->is['displayable']=$value;
        }
    }
    
    
    
    
    
    public function set_form_name($value)
    {
        $this->i_var['form_name']=$value;
    }
    
    
    
    
    
    public function set_class_displayed($name)
    {
        self::$class_displayed[$name]= true;
    }
    
    
    
    
    
    
    protected function throw_msg($type, $reference, $info="")
    {
        website_msg_controller::throw_msg($this, $type, $reference, $info);
    }
    
    
    
    
    
    public function set_database_result(&$res, &$numrows)
    {
        if ($this->has['writable_database_res']) {
            $this->res= &$res;
            $this->numrows= $numrows;
        } else {
            f1::echo_warning("#res not writable in met#set_database_result, cls#".get_class($this));
        }
    }
    
    
    
    
    
    public function set_numrows($numrows)
    {
        $this->numrows= $numrows;
    }
    
    
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$this->is['active']) {
            return;
        } elseif (($name == "all_data") && in_array($name, $this->i_var['writable_data_list'])) {
            $this->data= $value;
        } elseif ($name && in_array($name, $this->i_var['writable_data_list'])) {
            $this->data[$name]= $value;
        } elseif ($this->has['update_data_from_global'] && !empty($this->global_var)) {
            $this->data= &$this->global_var;
            f1::echo_warning("data taken from global_var, in met#set_data, cls#".get_class($this));
        } elseif ($name) {
            f1::echo_error("met#set_data, to #arg \"{$name}\", failed in cls#".get_class($this));
        } elseif ($this->data_source) {
            $this->set_data_from_database();
        } elseif ($this->has['data']) {
            $this->throw_msg("fatal_error", "invalid_request", "#met #set_data, 
				cls#".get_class($this).", #set_data not possible");
        }

        $this->validate_data($this->data);
    }
    
    
    
        
    
    public function is_data_ready()
    {
        if (!$this->is['displayable']) {
            return true;
        } elseif (!empty($this->data) || !empty($this->res) || !empty($this->list)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    public function set_data_from_resource()
    {
        if (($this->numrows == 1) & $this->res) {
            $this->data= mysql_fetch_assoc($this->res);
        }
        
        if (empty($this->data)) {
            f1::echo_error("could not get data from resource in cls#".get_class($this));
        }
    }
    
    
    
    
    
    public function select_database($db)
    {
        try {
            $select= mysql_select_db($db);
        
            if (!$select) {
                throw new Exception();
            }
        } catch (Exception $e) {
            exit("Could not find selected database in #met#select_dbase".
                " cls#".get_class($this)." ".mysql_error());
        }
    }
    
    
    
    
    
    
    public function get_data($name="")
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$this->data && $this->res && $this->is['list'] && ($this->numrows == 1)) {
            $this->data= mysql_fetch_assoc($this->res);
            mysql_data_seek($this->res, 0);
        }
        

        if (!$this->has['share_data']) {
            f1::echo_comment("share data not allowed in #cls#website_object, #met#get_data, name is \"{$name}\" ");
            return;
        }

        if (in_array("all_data", $this->i_var['readable_data_list'])) {
            return $this->data;
        } elseif ($name && isset($this->data[$name])
                && in_array($name, $this->i_var['readable_data_list'])) {
            return $this->data[$name];
        } elseif ($name) {
            f1::echo_error("read data not allowed in cls#".get_class($this).", #met#get_data, name is \"{$name}\" ");
        } else {
            f1::echo_error("empty reference in cls#".get_class($this).", #met#get_data ");
        }
    }
    
    
    
    
    
    
    
    
    public function validate_data()
    {
    }
    
    
    
    
    
    
    public function custom_date($names)
    {
        foreach ($this->data as $name => $value) {
            if (in_array($name, $names)) {
                $this->data[$name]= f1::custom_date($value);
            }
        }
    }
    
    
    
    
    
    public function undo_custom_date($names, &$data)
    {
        foreach ($data as $name => $value) {
            if (in_array($name, $names)) {
                $data[$name]= f1::undo_custom_date($value);
            }
        }
    }
    
    
    
    
    
    public function custom_datetime($names)
    {
        foreach ($this->data as $name => $value) {
            if (in_array($name, $names)) {
                $this->data[$name]= f1::custom_datetime($value);
            }
        }
    }
    
    
    
    
    
    public function undo_custom_datetime($names, &$data)
    {
        foreach ($data as $name => $value) {
            if (in_array($name, $names)) {
                $data[$name]= f1::undo_custom_datetime($value);
            }
        }
    }
    
    
    
    
    
    
        
        
    public function set_data_from_database()
    {
        global $c, $s, $m, $t, $q, $u;
        

        
        if ($this->data_source) {
            $data_source=  $this->data_source;
        
        
            //-------get filter------------------------------------------

            if ($this->has['filter']) {
                $this->set_filter();
            }
        
            //----------------------------
            
            $q->sql_select($data_source, $numrows, $res, "all");

            $this->numrows= $numrows;

            if ($this->numrows >= 1) {
                $this->res= $res;
            
                //------------------
            
                if ($this->has['one_data_row']) {
                    $data= mysql_fetch_assoc($this->res);
                
                    if ($this->has['free_data']) {
                        return $data;
                    } elseif ($this->has['extra_data']) {
                        $this->data= array_merge($this->data, $data);
                        return ($this->data);
                    }
                    
                    $this->data= &$data;
                }
            }
        }
    }

    
    
    
    
    
    
    public function add_data_from_database($data_source, $option="free_data")
    {
        if (!$this->has['one_data_row']) {
            f1::echo_error("option #one_data_row not true in met#add_data_from_database, ".
                    "to use this method, #this->data must have values; cls#".get_class($this));
            return;
        }
        

        if (($option == "free_data") || ($option == "extra_data")) {
            $this->has[$option]= true;
        }
        
        $temp_data_source= $this->data_source;

        $this->data_source= $data_source;
        
        $data= $this->set_data_from_database();

        $this->data_source= $temp_data_source;

        return $data;
    }
    
        
    
    
    
    public function set_data_from_id($data_source, $id_tag="", $name_tag="", &$numrows= -1)
    {
        global $q, $t;


        if ($id_tag) {
            $q->set_var($id_tag, $this->data[$id_tag]);
        }
        

        $q->sql_select($data_source, $numrows, $res, "all");

        if ($numrows >= 1) {
            $data= mysql_fetch_assoc($res);
        
            if ($name_tag) {
                return ($data[$name_tag]);
            } else {
                return $data;
            }
        } else {
            f1::echo_warning("error, set_data_from_id failed, ".
                        "met#set_data_from_id , cls#".get_class($this));
        }
    }
    
    
    


    
    public function fill_list_from_data()
    {
        if ($this->res) {
            while ($data = mysql_fetch_assoc($this->res)) {
                $this->list[]= $data;
            }
            
            // rewind sql resource
            mysql_data_seek($this->res, 0);
        } else {
            f1::echo_error("#met #fill_list_from_data, in cls#".get_class($this));
            return;
        }
    }
    
    
    
    
    
    
    public function read_data()
    {
        if (in_array("data", $this->i_var['readable_member_list'])) {
            if ($this->data) {
                return $this->data;
            } else {
                f1::echo_error("no data to transfer in transfer_data, website_object");
            }
        } else {
            f1::echo_error("Data transfer is not authorised, in transfer_data, cls#".get_class($this));
        }
    }
            
    
    
    
    
    
    public function set_option($option)
    {
        $this->option= $option;
    }
    
        
    
    
    
    
    public function get_numrows($data_source= null)
    {
        if (($this->numrows < 0) && $this->data_source) {
            $this->set_data();
        }

        //-------------
    
        if (isset($this->numrows)) {
            return $this->numrows;
        } else {
            f1::echo_error("invalid #numrows in met#get_numrows, cls#".get_class($this));
        }
    }
    
    
    
    
    
    
    public function set_reference($value)
    {
        if (!$this->reference) {
            $this->reference= $value;
        } else {
            f1::echo_warning("already has a reference in met#set_reference, cls#".get_class($this));
        }
    }
    
    
    
    
    
    public function get_reference()
    {
        if ($this->reference && is_string($this->reference)) {
            return $this->reference;
        }
    }
    
    
    
    
    
    
    public function set_status($value)
    {
        $this->status= $value;
    }
    
    
    
    
    
    
    public function get_status()
    {
        return $this->status;
    }

    
    
    
    
    
    
    public function set_var($name, $value)
    {
        if (in_array($name, $this->i_var['writable_var_list'])) {
            $this->i_var[$name]= $value;
        } else {
            f1::echo_error("#var is not writable, in #met #set_var, cls#".get_class($this));
        }
    }
    
    
    
    
    
    
    public function get_var($string)
    {
        global $c, $s, $m, $t, $q, $u;

        if ($string && isset($this->i_var[$string])) {
            if (in_array($string, $this->i_var['readable_var_list'])) {
                return $this->i_var[$string];
            } else {
                f1::echo_error("var is not readable, in #met #get_var, cls#".get_class($this));
            }
        } else {
            f1::echo_comment("#met #get_var failed, reference was \"{$string}\", ".
                        "in #cls website_object");
        }
    }
    
    
    
    
    
    
    
    
    
    public function set_title($title, $tag="", $id="", $image=null)
    {
        if (!$title) {
            return;
        }
        
        
        $this->title="";


        $this->title_text= $title;


        //----------------Title----------------------------------------
        if ($tag) {
            $this->title= "<{$tag} id=\"{$id}\" class=\"title\">";
        }

        $this->title .= $title;

        if ($tag) {
            $this->title .= "</{$tag}>";
        }
    }
    
    
    
    
    
    
    
    public function get_title($option="text_only")
    {
        if ($option == "text_only") {
            return $this->title_text;
        } else {
            return $this->title;
        }
    }
    
    
    
    


    public function display_title()
    {
        global $c, $s, $m, $t, $q, $u;

        if (!isset($this->title)) {
            f1::echo_warning("no title found in display title");
        } elseif ($this->has['title'] && !empty($this->title)) {
            echo $this->title;
            $this->title="";
        }
    }
    
    
    
    
    
    
    
    public function display_print_title()
    {
        global $s, $u, $t;

        echo "<div class=\"print_page_title\"><h1>".$s->global_name." | ".$u->name_dept." <br/> ".$t->print_page." | ".date("d/m/Y, H:s", time())."</h1>";

        $this->display_title();

        echo "</div>";

        $this->set_has("submit", false);
        $this->set_has("radio", false);
        $this->set_has("checkboxes", false);
    }

    
    
    
    
    
    
    public function set_data_source($value)
    {
        if ($this->has['writable_data_source'] && is_string($value)) {
            $this->data_source= $value;
        } else {
            f1::echo_warning("var#set_data_source not writable, in met#set_data_source, cls#".get_class($this));
        }
    }
    

    
    
    
    
    public function set_has($name, $value)
    {
        $this->has[$name]=$value;
    
        if ($value === false) {
            $string= "#false";
        } else {
            $string= "{$value}";
        }
    
        f1::echo_comment("#has option {$name} set to {$string} in #cls ".get_class($this));
    }
    
    
    
    
    
    
    public function set_is($name, $value)
    {
        $this->is[$name]=$value;
    
        if ($value === false) {
            $string= "#false";
        } else {
            $string= "{$value}";
        }
    
        f1::echo_comment("#is option {$name} set to {$string} in #cls ".get_class($this));
    }
    
    
    
    
    
    
    
    public function is($name)
    {
        if (isset($this->is[$name])) {
            return $this->is[$name];
        }
    }
    
    
    
    
    public function has($name)
    {
        if (isset($this->has[$name])) {
            return $this->has[$name];
        }
    }
    
    
    
    
    
    
    
    public function delete_option($type, $name)
    {
        global $c, $s, $m, $t, $q, $u;

        
        if (($type === "has") && is_array($this->has)
            && is_string($name)) {
            $ref= "has";
            unset($this->has[$name]);
        } elseif (($type === "is") && is_array($this->is)
            && is_string($name)) {
            $ref= "is";
            unset($this->is[$name]);
        }
    
    
        f1::echo_comment("option with name \"{$name}\" ".
                            "was deleted from \"{$ref}\" options ");
    }
    
        
    
    
    

    public function confirm_command($reference, $text)
    {
        echo "<p class=\"msg_prompt\">{$t->$text}</p>";


        if ($_REQUEST['selected_items'] && $this->res) {
        
        //$this->fill_data_with_rows ("id_value_index");
        
        
            for ($i=0; $i < count($_REQUEST['selected_items']); $i++) {
                $id_value= $_REQUEST['selected_items'][$i];
            
                $this->data= $this->data[$id_value];
            
                $this->display_skeleton();
            }
        }
    
    

        echo <<<HTML

<input type="submit" class="submit_button" name="{$reference}" value="{$t->yes}"/>

<input type="submit" class="submit_button" name="cancel_command" value="{$t->no}"/>

HTML;
    }
    
    
    
    
    
    
    public function delete_data_list()
    {
        global $c, $s, $m, $t, $q, $u;

    
        if (is_array($this->data_list)) {
            for ($i=0; $i < count($this->data_list); $i++) {
                if ($c->set_data($this->data_list[$i])) {
                    $c->delete_data($this->data_list[$i]);
                }
            }
        }
    }
    
    
    
    
    
        
    public function var_to_queries(&$var)
    {
        global $q;

        if (is_array($var)) {
            foreach ($var as $key => $value) {
                if (!empty($value)) {
                    $q->set_var($key, $value);
                }
            }
        }
    }
    
    
    
    
    
    
    public function open_form($form_name="", $method=null, $action=null)
    {
        global $c, $s, $m, $t, $q, $u;

        

        if (!$method) {
            $method= "POST";
        }
        
        if (!$action) {
            $action= $this->i_var['target_url'];
        }
        
        if (!$form_name && $this->i_var['form_name']) {
            $form_name= $this->i_var['form_name'];
        }
        
        if ($this->has['enctype']) { // -------you need enctype to upload files...
            $enctype= " enctype=\"multipart/form-data\" ";
        } else {
            $enctype= "";
        }
        
        //---------------------

        echo <<<HTML

<form name="{$form_name}" method="{$method}" action="{$action}" {$enctype} >
	
<input type="hidden" name="form_name" value="{$form_name}"/>

HTML;


        if (($method == "GET") && $this->has['form_action_refresh'] && isset($_GET['v'])) {
            echo "<input type=\"hidden\" name=\"v\" value=\"{$_GET['v']}\"/>";
        }
    }
    
    
    
    
    
    
    
    public function display_image($file_id, $class="", $url="")
    {
        global $c, $s, $m, $t, $q, $u;
    
        $image_source= $c->get_image_filename($file_id);
        
        if (!file_exists($image_source)) {
            $image_source= "images/dummy.png";
        }

            
        $open= ($url) ? "<a class=\"link\" href=\"{$url}\" >" : "";
        $close= ($url) ? "</a>" : "";
            
            
        echo <<<HTML

{$open}
<img src="{$image_source}" class="{$class}" >
{$close}

HTML;
    }
    
    
    
    
    
    
    public function ignore_website_msg($string)
    {
        if (!isset($this->i_var['ignore_website_msg'])) {
            $this->i_var['ignore_website_msg']= array();
        }
        
    
        array_push($this->i_var['ignore_website_msg'], $string);
    }
    

    
    
    
    
    
    
    public function navigator_trail(
        $x_trail,
        $y_trail=array(),
                                $separator=" <span class=\"separator\">::</span>",
                                $mode= "write"
    ) {
                                
                                //links trail...


        global $c, $s, $m, $t, $q, $u;



        $section= "";

        //--------------------

        $section .= "<div class=\"navigator_trail_wrap\" >";

        //--------------------


        if (is_array($x_trail)) {
            $section .= "<div class=\"x_trail\" class=\"navigator_trail\">";

            for ($i=0; $i < count($x_trail); $i++) {
                if (($i == 0) && is_array($x_trail[$i])) {
                    $section .= "<a id=\"x_trail_item{$i}\" href=\"{$x_trail[$i][0]}\" >".
                "{$x_trail[$i][1]}</a>";
                } elseif (($i == 0) && $x_trail[$i]) {
                    $section .= "<span id=\"x_trail_item{$i}\" >{$x_trail[$i]}</span>";
                } elseif (is_array($x_trail[$i])) {
                    $section .= "{$separator} <a id=\"x_trail_item{$i}\"  href=\"{$x_trail[$i][0]}\" >".
                "{$x_trail[$i][1]}</a>";
                } elseif ($x_trail[$i]) {
                    $section .= "{$separator} <span id=\"x_trail_item{$i}\" > {$x_trail[$i]}</span>";
                }
            }

            $section .= "</div>";
        }
        
        
        //-----------------------------------
        
        
        if (is_array($y_trail) && !empty($y_trail)) {
            $section .= "<div id=\"y_trail\" class=\"navigator_trail\">";

            for ($i=0; $i < count($y_trail); $i++) {
                if (($i == 0) && is_array($y_trail[$i])) {
                    $section .= "<a id=\"y_trail_item{$i}\" href=\"{$y_trail[$i][0]}\" >".
                "{$y_trail[$i][1]}</a>";
                } elseif (($i == 0) && $y_trail[$i]) {
                    $section .= "<span id=\"y_trail_item{$i}\" >{$y_trail[$i]}</span>";
                } elseif (is_array($y_trail[$i])) {
                    $section .= "{$separator} <a id=\"y_trail_item{$i}\"  href=\"{$y_trail[$i][0]}\" >".
                "{$y_trail[$i][1]}</a>";
                } elseif ($y_trail[$i]) {
                    $section .= "{$separator} <span id=\"y_trail_item{$i}\" >{$y_trail[$i]}</span>";
                }
            }

            $section .= "</div>";
        }

        $section .= "</div>";

        //------------------

        if ($mode === "write") {
            echo $section;
        } else {
            return $section;
        }
    }
    
    
    
    
    
    public function display_submit($name="", $value="", $html_tag="", $html_class="submit")
    {
        global $t;

    
        if (!$name) {
            $name= "submit";
        }
                
        if (!$value) {
            $value= $t->submit;
        }
        
        if (!$html_tag) {
            $html_tag= $this->i_var['submit_wrap_tag'];
        }


        echo <<<HTML

<{$html_tag} class="{$html_class}" >

<input type="submit" class="submit_button" name="{$name}" value="{$value}"/>

</{$html_tag}>

HTML;
    }

    
    
    
    
    
    protected function basic_display()
    {
        global $f;

    
        if ($this->data && is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                echo <<<HTML

{$key} => {$data[$key]} |

HTML;
            }
        } else {
            f1::echo_error("No data to print, in cls#".get_class($this));
        }
    }

    
    
    
    
    
    
    public function display()
    {
    }
    
    
    
    
    
        
    
    
    public function upload_image()
    {
        if ($_FILES['image']) {
            $image_handler= new upload_image();
            $image_handler->config();
        
            $image_handler->set_filename($this->i_var['filename']);
            $image_handler->set_width_limits($this->i_var['width_limits']);
            $image_handler->set_height_limits($this->i_var['height_limits']);
            $image_handler->set_best_width($this->i_var['best_width']);
            $image_handler->set_best_height($this->i_var['best_height']);
            $image_handler->set_crop_side($this->i_var['crop_side']);
        
            $image_handler->upload();
        }
    }
    
    
    
    
    
    
    
    public function upload_document()
    {
        global $q;

    
    
        if ($_FILES['document']) {
            $file_handler= new upload_file();
        
            $file_handler->config();
        
            if ($this->i_var['file_maxsize']) {
                $file_handler->set_file_maxsize($this->i_var['file_maxsize']);
            }
        
            $file_handler->set_newfilename($this->i_var['filename']);
        
            $file_handler->upload();
    
            if ($file_handler->file_uploaded()) {
                $q->set_var("document_extension", $file_handler->get_file_extension());
                $q->sql_action("update_document_extension");
            }
        }
    }
    
    
    
    
    
    public function ask_delete()
    {
        global $t;

        if ($this->has['displayed_ask_delete']) {
            return;
        }

        echo <<<HTML

<div class="msg_prompt">

<span class="msg_img_wrap">
<img src="images/msg_img_info.png">
</span>


<p class="text">
{$t->ask_delete}
</p>

<input type="submit" class="submit_button" name="cancel" value="{$t->no}"/>

<input type="submit" class="submit_button" name="yes_delete_{$this->subject}" value="{$t->yes}"/>

</div>

<div class="cleared">&nbsp;</div>
HTML;

        $this->has['displayed_ask_delete']= true;
    }
    
    
    
    
    public function display_headings()
    {
        global $t;
    
        echo "<tr>";

        if ($this->has['checkboxes'] || $this->has['radio']) {
            echo "<th class=\"select\" >&nbsp;</th>";
        } // for radio or checkbox

        
        for ($i=0; $i < count($this->display_list); $i++) {
            $label= $tag= $this->display_list[$i];
        
            //-----------------------
                
            if ((strpos($label, "id_") !== false) || (strpos($label, "_id") !== false)) {
                $spacer= "<span class=\"min_width_small\">&nbsp;</span>";
            } else {
                $spacer= "<span class=\"min_width_normal\">&nbsp;</span>";
            }
        
            //---------------------------
                
            $label= $t->$label;

        
            echo <<<HTML

<th class="{$tag}">

{$label}

{$spacer}

</th>

HTML;
        }
        
        echo "</tr>";
    }
    
    
    
    
    
    public function add_to_display_list($name)
    {
        $this->display_list[]= $name;
    }
    
    
    
    
    
        
    
    
    
    
    
    public function set_data_hyperlinks($root= "", $list= array(), $bool= true)
    {
        $this->i_var['hyperlink_root'][]= $root;
        $this->i_var['hyperlink_list'][]= $list;

        if ($bool === true) {
            $this->has['hyperlink_uses_id_tag'][]= true;
        } else {
            $this->has['hyperlink_uses_id_tag'][]= false;
        }
    }
    

    
    
    
    
    public function add_hyperlinks_to_data()
    {
        for ($i=0; $i < count($this->i_var['hyperlink_list']); $i++) {
            $tag_list= $this->i_var['hyperlink_list'][$i];
        
            for ($j=0; $j < count($tag_list); $j++) {
                $tag= $tag_list[$j];

                if (in_array($tag, $this->display_list)) {
                    $id_link= $this->has['hyperlink_uses_id_tag'][$i] ? "&{$this->id_tag}={$this->data[$this->id_tag]}" : "";
                
                    $this->data[$tag]= "<a href=\"{$this->i_var['hyperlink_root'][$i]}{$id_link}\" > >> {$this->data[$tag]} </a>";
                }
            }
        }
    
        $this->i_var['hyperlink_root']= array();
        $this->i_var['hyperlink_list']= array();
        $this->has['hyperlink_uses_id_tag']= array();
    }
    
    
    
        
    
    

    public function view_data()
    {
        global $s, $u, $t;


        if (empty($this->index)) {
            $this->index= 1;
        }

        
        echo "<tr class=\"{$this->i_var['tr_class']}\" >";

        if ($this->has['checkboxes'] || $this->has['radio']) {
            echo "<td class=\"select\">";

            if ($this->has['checkboxes']) {
                $this->display_checkbox();
            } elseif ($this->has['radio']) {
                $this->display_radio();
            }

            echo "</td>";
        } elseif ($this->has['empty_td_element']) {
            echo "<td>&nbsp;</td>";
        }
        
        
        $temp= $this->data;
                        
                        
        //----------
        
        $title_row= $t->line." ".$this->index;
        $title_row .= $this->i_var['primary_name_tag'] ? ": ".$this->data[$this->i_var['primary_name_tag']] : "";

        //------------

        $this->add_hyperlinks_to_data();
                
        //-------------
    
        
        for ($i=0; $i < count($this->display_list); $i++) {
            $tag= $this->display_list[$i];
        
            $data= $this->data[$tag];
            $data= trim($data);
            $data= (empty($data)) ? "---" : $data;

            echo <<<HTML

<td title="{$title_row}" class="{$tag}">
{$data}
</td>

HTML;
        }
        
        echo "</tr>";


        $this->data= $temp;
        $data= null;
        $temp= null;
        $this->index++;
    }
    
    
    
    
    public function set_file_names()
    {
        global $m, $q, $t;


        $this->custom_datetime(array("date_created"));

        $this->custom_date(array("file_date"));

        $q->set_filter("id_file_type='".$this->data['file_type']."'");
        $this->data['name_type']= $this->set_data_from_id("select_file_type1", "", "name_type");

        $q->set_filter("id_file_cat='".$this->data['file_category']."'");
        $this->data['name_cat']= $this->set_data_from_id("select_file_category1", "", "name_cat");

        $q->set_filter("id_dept='".$this->data['dept_comingfrom']."'");
        $this->data['name_coming_from']= $this->set_data_from_id("select_department1", "", "name_dept");
    
    
        if (in_array("name_dept", $this->display_list)) {
            $q->set_filter("id_dept='".$this->data['file_dept']."'");
            $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        }
    }
    
    
    
    
    
    
    public function set_project_names()
    {
        global $m, $q, $t;


        $this->custom_datetime(array("date_created"));
        $this->custom_date(array("file_date"));


        $q->set_filter("id_proj_type='".$this->data['proj_type']."'");
        $this->data['name_proj_type']= $this->set_data_from_id("select_project_type1", "", "name_proj_type");

        $this->data['name_proj_type']= $this->data['name_proj_type'] ? $this->data['name_proj_type'] : "---";


        $q->set_filter("id_proj_status='".$this->data['proj_status']."'");
        $this->data['name_proj_status']= $this->set_data_from_id("select_project_status1", "", "name_proj_status");

        if (empty($this->data['name_proj_status'])) {
            $this->data['name_proj_status']= "---";
        }

        $q->set_filter("id_dept='".$this->data['dept_comingfrom']."'");
        $this->data['name_coming_from']= $this->set_data_from_id("select_department1", "", "name_dept");

        if (in_array("name_dept", $this->display_list)) {
            $q->set_filter("id_dept='".$this->data['proj_dept']."'");
            $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        }
        
        if (empty($this->data['id_bordereau'])) {
            $this->data['id_bordereau']= $t->waiting;
        }
    }
    
    
    
    
    
    
    public function is_foreign()
    {
        global $u;

    
        if (isset($this->data[$this->i_var['name_id_dept']]) && ($this->data[$this->i_var['name_id_dept']] != $u->id_dept)) {
            return true;
        } elseif (isset($this->data[$this->i_var['name_id_dept']]) && ($this->data[$this->i_var['name_id_dept']] == $u->id_dept)) {
            return false;
        } else {
            f1::echo_error("unexpected value for name_id_dept in cls#".get_class($this));
        }
    }
    
    
    
    
    
    public function is_in_transit()
    {
        global $u;

    
        if (isset($this->data['status_trans']) && ($this->data['status_trans'] == 2)) {
            return true;
        } elseif (isset($this->data['status_trans'])) {
            return false;
        } else {
            f1::echo_error("unexpected value for #status_trans, met#is_in_transit, cls#".get_class($this));
        }
    }
    
    
    
    
    
    public function send_sms_to_subscribers($sms_action, $document_type, $id_document)
    {
        global $s, $q;
    
        if ($document_type == 1) {
            $q->set_filter("sms_user1.id_file='".$id_document."' AND sms_user1.type_user='2'
		AND ( ADDDATE(sms_user1.date_saved,INTERVAL 30 DAY) > NOW() )");
            $q->sql_select("select_sms_user1", $numrows0, $res0, "all");
        
            $q->set_filter("file1.id_file='".$id_document."'");
            $q->sql_select("sms_file_dept", $numrows1, $res1, "all");
        } elseif ($document_type == 2) {
            $q->set_filter("sms_user1.id_proj='".$id_document."' AND sms_user1.type_user='2'
		AND ( ADDDATE(sms_user1.date_saved,INTERVAL 30 DAY) > NOW() )");
            $q->sql_select("select_sms_user1", $numrows0, $res0, "all");
        
            $q->set_filter("project1.id_proj='".$id_document."'");
            $q->sql_select("sms_proj_dept", $numrows1, $res1, "all");
        }
        
        //--------------------------
        
        if (($numrows0 >= 1) && ($numrows1 == 1)) {
            $sender= $s->num_phone_subscription;
        
            $document= mysql_fetch_assoc($res1);
            $document['date_trans']= f1::custom_date($document['date_trans']);
            $document['today']= f1::custom_long_date(date("Y-m-d", time()));
        
            while ($data0= mysql_fetch_assoc($res0)) {
                $data0['sender']= $sender;
                $data0['receiver']= $data0['num_phone'];
                $data0['document_type']= $document_type;
                $data0['id_document']= $data0['id_file'] ? $data0['id_file'] : $data0['id_proj'];
                $data0['index_of_sms']= 0;
                $data0['index_of_document']= 0;
                
            
                $clients[]= $data0;
            }
            
            //----------------------

            $this->sender= new send_sms();
        
            $this->sender->initialize();
            $this->sender->config();
        
            $this->sender->set_option("subscriber");
        
            $this->sender->set_sms_action($sms_action);
            $this->sender->set_sms();	// index of  sms is 0
            $this->sender->set_clients($clients);
            $this->sender->set_documents(array($document)); // index of document is 0
        
            $this->sender->set_data();
            $this->sender->start();
        }
    }
    
    
    
    
    
    
    public function make_initials($name)
    {
        $initials="";
    
        if (is_string($name) && $name) {
            if (strpos($name, "-") !== false) {
                $list= explode("-", $name);
                $name= implode(" ", $list);
            }
        
            $list= explode(" ", $name);
        
            for ($i=0; $i < count($list); $i++) {
                $list[$i]= trim($list[$i]);
                $initials .= substr($list[$i], 0, 1);
            }
        
            $initials= strtoupper($initials);
        }
        
        return $initials;
    }
}
