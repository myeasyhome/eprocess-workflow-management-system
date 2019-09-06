<?php


class summary extends website_object
{
    protected $delay;


    public function config()
    {
        global $t;
    
        $this->numrows= array();
        $this->delay= 15000;
    }



    public function set_data()
    {
        global $u, $q;

        //---------------


        //-----------------

        $q->set_filter("file1.file_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1) AND file1.file_status > 0 ");
        $this->set_data_from_id("select_file1", "", "", $this->numrows['active_files']);

        $q->set_filter("file1.file_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1) AND file1.file_status= '0' ");
        $this->set_data_from_id("select_file1", "", "", $this->numrows['inactive_files']);

        $q->set_filter("file1.file_dept='".$u->id_dept."' AND transfer1.status_trans='2'");
        $this->set_data_from_id("select_file1", "", "", $this->numrows['files_transit']);
    
        $q->set_filter("file1.file_dept='".$u->id_dept."' AND transfer1.status_trans='3'");
        $this->set_data_from_id("select_file1", "", "", $this->numrows['file_trans_rejected_br']);

        //--------------------

        $q->set_filter("project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1)");
        $this->set_data_from_id("select_project1", "", "", $this->numrows['projects']);

        $q->set_filter("project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans='2'");
        $this->set_data_from_id("select_project1", "", "", $this->numrows['projects_transit']);

        $q->set_filter("project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans='3'");
        $this->set_data_from_id("select_project1", "", "", $this->numrows['proj_trans_rejected_br']);

        //-----------------------

        $q->set_filter("AND project1.proj_dept='".$u->id_dept."' AND print_letter1.is_printed='0'");
        $this->set_data_from_id("select_print_letter1", "", "", $this->numrows['print_letters']);

        $q->set_filter("AND project1.proj_dept='".$u->id_dept."' AND print_letter1.is_printed='1' AND id_bordereau IS NULL");
        $this->set_data_from_id("select_print_letter1", "", "", $this->numrows['no_id_bordereau']);
    }
    
    
    
    
    
    public function display()
    {
        global $s, $u, $t;

        $list1= array("active_files", "inactive_files");
        $list2= array("projects", "print_letters", "no_id_bordereau");
        $list3= array("files_transit", "projects_transit");
        $list4= array("file_trans_rejected_br", "proj_trans_rejected_br");

        $group0= "";
        $group1= "";
        $group2= "";
        $group3= "";


        foreach ($this->numrows as $key => $value) {
            $string= "<div class=\"info\"><span class=\"label\">{$t->$key}: </span><span class=\"data\">{$value}</span></div>";
        
            if (in_array($key, $list1)) {
                $group1 .= $string;
            } elseif (in_array($key, $list2)) {
                $group2 .= $string;
            } elseif (in_array($key, $list3)) {
                $group3 .= $string;
            } elseif (in_array($key, $list4)) {
                $group4 .= $string;
            } else {
                $group0 .= $string;
            }
        }
        
        
        
        echo <<<HTML

<div class="wrap_home">

<h1>{$u->name_dept}</h1>

<div class="summary" >

<div class="left">{$t->v_summary}</div>

<div class="right">

{$group0}

<h2 class="title">{$t->files}</h2>

{$group1}

<h2 class="title">{$t->projects}</h2>

{$group2}

<h2 class="title">{$t->transit}</h2>

{$group3}

<h2 class="title">{$t->rejected}</h2>

{$group4}
		
</div>

</div>

</div>


<script language="javascript" type="text/javascript">
//<!--

function refresh() {

location.href="{$s->root_url}?v=home";

}

setTimeout(refresh, {$this->delay});
	
//-->
</script>

HTML;
    }
}
