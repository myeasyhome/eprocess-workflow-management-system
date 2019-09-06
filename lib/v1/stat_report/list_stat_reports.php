<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class list_stat_reports extends list_items_adapter
{
    protected $form;

    
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->form= new set_period();
        $this->form->initialize();
    }
    
    
    
    
    public function config()
    {
        global $m, $u, $t;


        if (!$u->has_stats) {
            $this->throw_msg("fatal_error", "access_denied", "met#config, 
			cls#".get_class($this).", no access to stats");
            return;
        }
        

        parent::config();


        $this->has['form']= false;
        $this->has['submit']= false;

        $this->has['create']= false;
        $this->has['delete']= false;
        $this->has['ask_delete']= false;
        $this->has['edit']= false;
        $this->has['radio']= false;
        $this->has['checkboxes']= false;

        $this->i_var['target_url']= $s->root_url."?v=stat_reports";

        if ($u->is_admin() && $m->view_ref == "manage_stat_reports") {
            $this->i_var['target_url']= $s->root_url."?v=manage_stat_reports";

            $this->has['create']= true;
            $this->has['delete']= true;
            $this->has['edit']= true;
            $this->has['ask_delete']= true;
        }
        

        $this->has['radio']= true;

        
        $this->form->config();
        $this->form->set_ignore("start_date");
        $this->form->set_ignore("end_date");


        $this->reference="list_stat_reports";
        $this->i_var['form_name']= $this->reference;

        $this->form->set_form_name($this->i_var['form_name']);

        $this->id_tag="id_stat_report";
        $this->set_title($t->stat_reports, "h2");
        $this->data_source="select_stat_report1";


        $this->display_list= array("id_stat_report", "title_report", "describe_report");

        if ($u->is_admin()) {
            $this->display_list[]= "name_dept";
            $this->display_list[]= "stat_method";
        }
    }
    
    
    
    
    public function is_validated()
    {
        global $q, $t;

        if ($this->form->is_validated() && $_REQUEST['id_stat_report']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_stat_report']);

            $functions= new stat_methods();
        
            $q->set_filter("id_stat_report='".$this->id."'");
            $data= $this->set_data_from_id("select_stat_report1");
        
            $this->data['stat_method']= $data['stat_method'];
            $this->data['title_report']= $data['title_report'];

            if (!method_exists($functions, $this->data['stat_method'])) {
                $this->throw_msg("error", "no_stat_method", "method not found for stat report, in met#is_validated,
				 class#list_stat_reports");
            } else {
                unset($functions);
                return true;
            }
        }
        
        return false;
    }
    
    
    
    
    
    public function onsubmit()
    {
        global $t;
    
        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
            $this->report= new stat_methods();
            $this->report->initialize();
            $this->report->config();
            $this->report->set_title($this->data['title_report'], "h2");
                
                
            $start= "start_".$this->data['stat_method'];
                
            if (method_exists($this->report, $start)) {
                $this->report->$start();
            }

        
            if ($_REQUEST['start_date']) {
                $list= explode("/", $_REQUEST['start_date']);
                
                $datetime= $list[2].$list[1].$list[0]."000000";
                
                $this->report->set_start_date($datetime);
            }
                
            if ($_REQUEST['end_date']) {
                $list= explode("/", $_REQUEST['end_date']);
                
                $datetime= $list[2].$list[1].$list[0]."235959";
                
                $this->report->set_end_date($datetime);
            }
        }
    }
    
    
    
    
    
    public function set_data()
    {
        if (is_object($this->report) && $this->data['stat_method']) {
            return;
        }
        
        parent::set_data();

        $this->form->set_data();
    }
    
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u, $q, $t;

        if ($this->data['id_dept']) {
            $q->set_filter("id_dept='".$this->data['id_dept']."'");
            $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        }
        
        if (empty($this->data['name_dept'])) {
            $this->data['name_dept']= "---";
        }

        $this->view_data();
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;

        
        parent::display_submit();


        if ($this->numrows >= 1) {
            echo <<<HTML

<input type="submit" class="submit_button" name="view_stat_report" value="{$t->view_stat_report}"/>

HTML;
        }
    }
    
    
    
    
    
    public function display()
    {
        global $m;

    
        if (is_object($this->report) && $this->data['stat_method']) {
            $stat_method= &$this->data['stat_method'];
        
            echo "<div class=\"stat_report\">";
            $this->report->$stat_method();
            echo "</div>";
        } else {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
            parent::display();
        
            if (($this->numrows >= 1) && !$_GET['print_page']) {
                $this->form->display();

                $this->display_submit();
            }
        
            echo "</form>";
        }
    }
}
