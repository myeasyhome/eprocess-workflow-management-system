<?php


class list_projects extends list_items_adapter
{
    protected $no_access;


    public function config()
    {
        global $s, $u, $m, $t;

        parent::config();



        
        if ($_GET['v'] == "proj_no_letter") {
            $this->option= "no_letter";
        }
        
        //-----------------------------------------

        $this->subject= "project";

        $this->no_access= 0;

        $this->reference="projects";
        $this->i_var['form_name']= $this->reference;

        $this->i_var['name_id_dept']= "proj_dept";

        $this->id_tag=$this->i_var['id_tag']="id_proj";

        $this->set_title($t->projects, "h2");
        $this->data_source="select_project1";


        $this->i_var['writable_data_list']= array("all_data");


        $this->display_list= array("id_proj", "proj_ref", "name_coming_from", "name_proj_type", "num_file", "date_created", "id_bordereau", "name_proj_status");


        if ($this->option == "transfer") {
            $this->display_list[]= "linked_to_letter";
            $this->display_list[]= "is_printed";
        }


        $this->i_var['primary_name_tag']= "id_proj";
        
        
        if ($m->view_ref == "admin_list_proj") {
            $this->display_list[]= "name_dept";
    
            $ref= $_GET['v'];
        
            $this->set_title($t->$ref, "h2");
        }
                

        $this->has['filter']= true;
        $this->has['delete']= false;
        $this->has['save']= false;
        $this->has['create']= false;


        if ($this->option == "view_one") {
            $this->has['share_data']= true;
            $this->i_var['readable_data_list'][]= "id_file";

            if ($_REQUEST['id_proj']) {
                $this->numeric_id_from_array($_REQUEST['id_proj']);
            }

            
            //------------------

            $this->has['paging']= false;
            $this->has['radio']= false;
        
            if ($_REQUEST['clients_from_search']) {
                $_REQUEST['id_file']= $_GET['id_file']= null;
            }
            
            if ($this->is['search_result']) {
                $this->display_list[]= "name_dept";
                $this->has['radio']= true;
            }
        } elseif ($this->option == "no_letter") {
            $this->set_title($t->proj_no_letter, "h2");
            $this->data_source="select_proj_no_letter";
            $this->i_var['target_url']= $s->root_url."?v=proj_no_letter";
        } elseif ($this->option == "transfer") {
            $this->i_var['file_status']= $_REQUEST['file_status'];
            $this->i_var['target_url']= $s->root_url."?v=transfer_project";
            $this->has['title']= false;
        
            $this->id_tag="id_file_proj";
        
            $this->has['checkboxes']= true;
            $this->has['radio']= false;
            $this->has['submit']= false;
            $this->has['form']= false;
        
            $this->no_result_msg= $t->no_document_transfer;
        } elseif (($m->view_ref == "projects_transit")
                    ||  (($m->view_ref == "admin_list_proj")
            && ($_GET['v'] == "all_proj_transit"))) {
            $this->option= "transit";
            $this->set_title($t->projects_transit, "h2");
            $this->i_var['target_url']= $s->root_url."?v=projects_transit";
        
        
            $this->has['checkboxes']= true;
            $this->has['radio']= false;
            $this->has['create']= false;
            $this->has['delete']= false;
            $this->has['edit']= false;
        } elseif ($m->view_ref == "proj_trans_rejected") {
            $this->option= "trans_rejected";
            $this->i_var['target_url']= $s->root_url."?v=proj_trans_rejected";
            $this->set_title($t->proj_trans_rejected, "h2");
        
            $this->has['create']= false;
            $this->has['delete']= false;
            $this->has['edit']= false;
        } elseif ($_REQUEST['id_file']) {
            $this->id= $this->require_id("numeric", $_REQUEST['id_file']);
            $this->i_var['file_status']= $_REQUEST['file_status'];
            $this->i_var['target_url']= $s->root_url."?v=file_projects";
        
            if ($this->i_var['file_status'] == 0) {
                $this->has['create']= false;
                $this->has['delete']= false;
            } elseif (($this->i_var['file_status'] == 2) || ($this->i_var['file_status'] == 3)) {
                $this->has['create']= true;
            }
        } else {
            $this->i_var['target_url']= $s->root_url."?v=projects";
        }
        
        //----------------------------
        
        
        if (!$u->has_create_project) {
            $this->has['create']= false;
        }
        
        //--------------------------------
        
        if ($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator")) {
            $this->has['data_hyperlinks']= true;
        } else {
            $this->has['data_hyperlinks']= false;
        }
    }
    
    
    
    
    
    public function set_filter()
    {
        global $m, $q, $u;


        if (($this->option == "view_one") &&
            ($this->id= $this->require_id("numeric", $_REQUEST['id_proj'])) && $this->id) {
            $string= "project1.id_proj='".$this->id."'";
        } elseif ($this->option == "transfer") {
            $string= "project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans IN(0,1,3)";
        } elseif ($m->view_ref == "projects_transit") {
            $string= "project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans='2'";
        } elseif ($m->view_ref == "proj_trans_rejected") {
            $string= "project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans='3'";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_proj")
            && ($_GET['v'] == "all_proj_transit")) {
            $string= "transfer1.status_trans='2' ";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_proj")
            && ($_GET['v'] == "all_proj_rejected")) {
            $string= "transfer1.status_trans='3' ";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_proj")
                && ($_GET['v'] == "all_other_proj")) {
            $string= "transfer1.status_trans IN (0,1) ";
        } elseif ($this->id) {
            $string= "project1.id_file='".$this->id."' AND transfer1.status_trans IN(0,1)";
        
            if (!$u->is_admin()) {
                $string .= " AND project1.proj_dept='".$u->id_dept."'";
            }
        } elseif ($this->option == "no_letter") {
            $string= "AND project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans IN(0,1,3)";
        } else {
            $string= "project1.proj_dept='".$u->id_dept."' AND transfer1.status_trans IN(0,1)";
        }
        
        //-------------------------
        
        if (is_numeric($_REQUEST["filter_".$this->id_tag]) && !empty($string)) {
            $string .= " AND project1.id_proj='".$_REQUEST["filter_".$this->id_tag]."'";
        } elseif (is_numeric($_REQUEST["filter_".$this->id_tag])) {
            $string .= "project1.id_proj=='".$_REQUEST["filter_".$this->id_tag]."'";
        }
        
        //-----------------------------

        $q->set_filter($string);
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        global $s, $q, $u, $t;
    
    
        if ($_REQUEST["filter_".$this->id_tag] && !is_numeric($_REQUEST["filter_".$this->id_tag])) {
            $this->throw_msg(
            "error",
            "param_must_be_numeric",
                            "id search param must be numeric"
        );
            return;
        }
        
        
        //---------------------------------
        

        $action_log= new action_log();
        $action_log->config();


    
        if (is_array($_REQUEST[$this->id_tag]) && $_REQUEST['yes_received']) {
            $q->set_filter("id_dept='".$u->id_dept."'");
            $_REQUEST['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        
            
            $list= $_REQUEST[$this->id_tag][0];
        
            for ($i=1; $i < count($_REQUEST[$this->id_tag]); $i++) {
                $list .= ", ".$_REQUEST[$this->id_tag][$i];
            }
            
            $list= empty($list) ? "0" : $list;
            
            
            $received= array();

            $q->set_filter("project1.id_proj IN (".$list.") AND transfer1.status_trans='2'");
            $q->sql_select("select_project1", $numrows, $res, "all");
        
            if ($numrows < 1) {
                $this->throw_msg(
                "confirm",
                "selection_received_confirmed",
            "document received status was updated"
            );
                            
                return;
            } elseif ($numrows >= 1) {
                while ($data= mysql_fetch_assoc($res)) {
                    $data['name_dept']= &$_REQUEST['name_dept'];
            
                    $q->set_var("id_trans", $data['last_trans']);
                
                    $received[]= $q->sql_action("update_transfer_set_received");

                    $action_log->save($s->confirm_trans_tag, "id_proj", $data);
                }
                
                if (count($_REQUEST[$this->id_tag]) == count($received)) {
                    $this->throw_msg(
                    "confirm",
                    "selection_received_confirmed",
                    "document received status was updated"
                );
                    
                    //---------------
                
                    if ($u->dept_has_send_sms) {
                        for ($i=0; $i < count($_REQUEST[$this->id_tag]); $i++) {
                            $this->send_sms_to_subscribers($s->sms_project_transfer_action, 2, $_REQUEST[$this->id_tag][$i]);
                        }
                    }
                
                    //----------------
                }
            }
        } elseif (is_array($_REQUEST[$this->id_tag]) && $_REQUEST['yes_cancel_transfer']) {
            $q->set_filter("id_dept='".$u->id_dept."'");
            $old_name_dept= $this->set_data_from_id("select_department1", "", "name_dept");
            $_REQUEST['old_name_dept']= $old_name_dept;
        
            $list= $_REQUEST[$this->id_tag][0];
        
            for ($i=1; $i < count($_REQUEST[$this->id_tag]); $i++) {
                $list .= ", ".$_REQUEST[$this->id_tag][$i];
            }
            
            $list= empty($list) ? "0" : $list;

            
            $q->set_filter("project1.id_proj IN (".$list.") AND project1.proj_dept= '".$u->id_dept."'");
            $q->sql_select("select_project1", $numrows, $res, "all");
        
            if ($numrows < 1) {
                $this->throw_msg(
                    "confirm",
                    "cancel_transfer_confirmed",
                                "#met #onsubmit, cancel transfer already done"
                );
                            
                return;
            } elseif ($numrows >= 1) {
                $cancelled1=array();
                $cancelled2=array();
                $cancelled3=array();
            

                while ($data= mysql_fetch_assoc($res)) {
                    $data['old_name_dept']= $old_name_dept;
                
                    $q->set_filter("id_dept='".$data['dept_comingfrom']."'");
                    $new_name_dept= $this->set_data_from_id("select_department1", "", "name_dept");
            
                    $_REQUEST['new_name_dept']= $data['new_name_dept']= $new_name_dept;
                                
                    //--------------------------------
                
                    $q->set_var("id_proj", $data['id_proj']);	// for insert_proj_trans query
                $q->set_var("id_list", $data['id_proj']);	// for update_proj_last_trans query...
                
                $q->set_var("id_dept", $data['dept_comingfrom']);
                    $q->set_var("id_trans", $data['last_trans']);
                
                
                    $q->set_var("id_user", $u->id);
                    $q->set_var("dept_comingfrom", $u->id_dept);
                    $q->set_var("dept_goingto", $data['dept_comingfrom']);
                    $q->set_var("status_trans", 3);
                    $q->set_var("date_trans", "NOW()");
                    $q->set_var("describe_trans", $t->transfer_cancelled);
                                
            
                    $cancelled1[]= $q->sql_action("insert_proj_trans");
                    $last_trans= $q->get_var("new_id");
            
                    $q->set_var("last_trans", $last_trans);
                    $cancelled2[]= $q->sql_action("update_proj_last_trans");
                                
                    $cancelled3[]= $q->sql_action("update_proj_dept");

                    $action_log->save($s->cancel_trans_tag, "id_proj", $data);
                }
                
                                                        
                if (count($_REQUEST[$this->id_tag]) == count($cancelled3)) {
                    $this->throw_msg(
                    "confirm",
                    "cancel_transfer_confirmed",
                                "project selection transfer was annulled"
                );
                }
            } else {
                $this->throw_msg(
                "error",
                "action_failed",
                                    "#met #onsubmit"
            );
                    
                return;
            }
        }
    }
    
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        parent::set_data($name, $value);

        if (($this->option == "view_one") && ($this->numrows == 1)) {
            $this->data= mysql_fetch_assoc($this->res);

            if (!$this->is_foreign()) {
                $this->has['allowed_create_edit_delete']= true;
            }
    
            mysql_data_seek($this->res, 0);
        }
    }
    
    
    
    
    
    public function display_skeleton()
    {
        global $s, $q, $t, $u, $m;


        if ($this->has['data_hyperlinks'] && $this->option == "view_one") {
            $q->set_filter("project1.id_proj > ".$this->data['id_proj']
                            ." AND proj_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1)");
            $q->sql_select("select_project1", $numrows, $res, "all");
        
            $paging_max_items= $s->paging_max_items;
            $paging_max_items= ($paging_max_items > 0) ? $paging_max_items : 1;
            $numrows= ($numrows > 0) ? $numrows : 1;
        
            $pg= floor($numrows / $paging_max_items)+1;
        
            $pg= ($pg >= 1) ? $pg : 1;
        
            $this->set_data_hyperlinks(
            $s->root_url."?v=projects&pg=".$pg."&selected=".$this->data['id_proj'],
                                        array("id_proj"),
            false
        );
        }
                
        //-----------------------------
    
        if ($this->has['data_hyperlinks']) {
            $this->data['num_file']= $this->data['id_file'];
                
            $q->set_filter("file1.id_file > ".$this->data['id_file']);
            $q->sql_select("select_file1", $numrows, $res, "all");
            
            $paging_max_items= $s->paging_max_items;
            $paging_max_items= ($paging_max_items > 0) ? $paging_max_items : 1;
            $numrows= ($numrows > 0) ? $numrows : 1;
            
            $pg= floor($numrows / $paging_max_items)+1;
            
            $pg= ($pg >= 1) ? $pg : 1;

            $this->set_data_hyperlinks($s->root_url."?v=files&pg=".$pg."&selected=".
            $this->data['id_file'], array("num_file"), false);
        }
        
        //-----------------------
        
        
        $keep_tr_class= $this->i_var['tr_class'];
        
        if (is_numeric($_GET['selected']) && ($_GET['selected'] == $this->data['id_proj'])) {
            $this->i_var['tr_class']= "selected";
        }


        //--------------------------

        $this->set_project_names();


        $this->i_var['tr_class']= $this->is_foreign() ? "foreign" : $this->i_var['tr_class'];
    
    
        if ($this->option == "transfer") {
            $this->data['id_file_proj']= $this->data['id_file']."_".$this->data['id_proj'];
        }
        

        if ($this->option == "transfer") {
            $this->data['linked_to_letter']= "<span class=\"red\">".$t->no."</span>";
            $this->data['is_printed']= "<span class=\"red\">".$t->no."</span>";
        
        
            $q->set_filter("AND print_letter1.id_proj='".$this->data['id_proj']."'");
            $data= $this->set_data_from_id("select_print_letter1", "", "", $numrows);
        
            if ($numrows == 1) {
                $this->data['linked_to_letter']= "<span class=\"blue\">".$t->yes."</span>";
            
                if (isset($data['is_printed']) && ($data['is_printed'] == 1)) {
                    $this->data['is_printed']= "<span class=\"blue\">".$t->yes."</span>";
                }
            }
        }

        
        $this->view_data();
        
        
        $this->i_var['tr_class']= $keep_tr_class;
    }

    
    
    
    
    
    public function ask_confirm()
    {
        global $q, $u, $t;


        if ($_REQUEST['ask_project_received'] && $_REQUEST['id_proj'] && is_array($_REQUEST['id_proj'])) {
            $command= "yes_received";
            $msg= $t->confirm_selection_received;
        } elseif ($_REQUEST['ask_cancel_transfer'] && $_REQUEST['id_proj'] && is_array($_REQUEST['id_proj'])) {
            $command= "yes_cancel_transfer";
            $msg= $t->confirm_cancel_transfer;
        } else {
            return;
        }

        
        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);


        echo <<<HTML

<div class="section">

<div class="prompt">

<p>{$msg}</p>

HTML;


        echo "<span class=\"focus\">{$t->project} {$t->num} {$_REQUEST['id_proj'][0]}</span>
			<input type=\"hidden\" name=\"id_proj[]\" value=\"{$_REQUEST['id_proj'][0]}\" />";
            

        for ($i=1; $i < count($_REQUEST['id_proj']); $i++) {
            echo " | <span class=\"focus\">{$t->project} {$t->num} {$_REQUEST['id_proj'][$i]}</span>";

            echo "<input type=\"hidden\" name=\"id_proj[]\" value=\"{$_REQUEST['id_proj'][$i]}\" />";
        }
            
        echo <<<HTML
	
</div>

<input type="submit" class="submit_button" name="{$command}" value="{$t->yes}"/>

<input type="submit" class="submit_button" name="no" value="{$t->no}"/>

</div>

</form>

HTML;
    }
    
    
    
    
    
        
    
    public function display_submit()
    {
        global $m, $u, $t;


        if (($this->no_access > 0) && ($this->no_access == $this->numrows)) {
            return;
        }
        
        
        if (is_numeric($_REQUEST['id_file'])) {
            echo "<input type=\"hidden\" name=\"id_file\" value=\"{$_REQUEST['id_file']}\" />";
            
            if (is_numeric($_REQUEST['file_status'])) {
                echo "<input type=\"hidden\" name=\"file_status\" value=\"{$_REQUEST['file_status']}\" />";
            } else {
                f1::echo_error("No file status, cls#".get_class($this));
            }
        }
        
        parent::display_submit();
        
        
        if ($this->numrows >= 1) {
            if ($_REQUEST['file_status'] == 3) {
                echo <<<HTML

<input type="submit" class="submit_button" name="add_to_project" value="{$t->add_clients}"/>

HTML;
            }
            
            if ($this->option != "no_letter") {
                if ($this->option != "transit") {
                    if ($u->has_create_project) {
                        echo <<<HTML

<input type="submit" class="submit_button" name="create_proj_project" value="{$t->create_proj_project}"/>

HTML;
                    }
                    
                    echo <<<HTML

<input type="submit" class="submit_button" name="transfer_project" value="{$t->transfer}"/>

HTML;
                } elseif (($this->option == "transit") && ($m->view_ref != "admin_list_proj")) {
                    echo <<<HTML

<input type="submit" class="submit_button" name="ask_project_received" value="{$t->project_received}"/>

<input type="submit" class="submit_button" name="ask_cancel_transfer" value="{$t->cancel_transfer}"/>

HTML;
                }
            }
            
            
            echo <<<HTML

<input type="submit" class="submit_button" name="project_history" value="{$t->history}"/>

<input type="submit" class="submit_button" name="project_clients" value="{$t->clients}"/>

HTML;

            if ($m->view_ref != "admin_list_proj") {
                echo <<<HTML
			
<input type="submit" class="submit_button" name="letter_use_project" value="{$t->letter_use}"/>

HTML;
            }
        }
    }
        
    
    
    
    
    public function display()
    {
        $this->display_title();

        $this->ask_confirm();

        $this->display_filter_box();


        if ($this->numrows < 1) {
            $this->has['headings']= false;
        }

        parent::display();
    }
}
