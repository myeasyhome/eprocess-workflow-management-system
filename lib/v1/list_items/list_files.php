<?php


class list_files extends list_items_adapter
{
    public function config()
    {
        global $s, $u, $t, $m;

        parent::config();


        $this->subject="file";

        $this->reference="files";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=files";
        $this->id_tag="id_file";
        $this->i_var['id_tag']= "num_file";

        $this->i_var['name_id_dept']= "file_dept";

        $this->set_title($t->files, "h2");
        $this->data_source="select_file1";


        $this->i_var['writable_data_list']= array("all_data");

        $this->has['create']= true;
        $this->has['filter']= true;


        $this->display_list= array("id_file", "title", "name_coming_from", "date_created", "name_type", "name_cat", "file_ref", "file_date", "name_status");

        $this->i_var['primary_name_tag']= "id_file";


        if ($m->view_ref == "admin_list_files") {
            $ref= $_GET['v'];
        
            $this->set_title($t->$ref, "h2");
            $this->display_list[]= "name_dept";
        
            $this->has['create']= false;
            $this->has['delete']= false;
            $this->has['ask_delete']= false;
            $this->has['edit']= false;
        }
        
        
        if ($m->view_ref == "files_transit") {
            $this->option= "transit";
            $this->i_var['target_url']= $s->root_url."?v=files_transit";
            $this->set_title($t->files_transit, "h2");
        
            $this->has['checkboxes']= true;
            $this->has['radio']= false;
            $this->has['create']= false;
            $this->has['delete']= false;
            $this->has['edit']= false;
        } elseif ($m->view_ref == "file_trans_rejected") {
            $this->option= "trans_rejected";
            $this->i_var['target_url']= $s->root_url."?v=file_trans_rejected";
            $this->set_title($t->file_trans_rejected, "h2");
        
            $this->has['create']= false;
            $this->has['delete']= false;
            $this->has['edit']= false;
        } elseif ($this->option == "transfer") {
            $this->has['title']= false;
            $this->has['checkboxes']= true;
            $this->has['radio']= false;
            $this->has['submit']= false;
            $this->has['form']= false;
        
            $this->no_result_msg= $t->no_document_transfer;
        } elseif ($this->option == "view_one") {
            $this->has['paging']= false;
                
            if ($_REQUEST['id_file']) {
                $this->numeric_id_from_array($_REQUEST['id_file']);
            }
        
                
            if ($this->is['search_result']) {
                $this->display_list[]= "name_dept";
            }
        }
        
        
        if (!$u->has_create_file) {
            $this->has['create']= false;
        }
        
        
        if (!$u->is_admin()) {
            $this->has['delete']= false;
        }
        
        //--------------------
        
        if ($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator")) {
            $this->has['data_hyperlinks']= true;
        } else {
            $this->has['data_hyperlinks']= false;
        }
    }
    
    
    
    

    
    public function set_filter()
    {
        global $m, $q, $u, $s;


        if (($this->option == "view_one") &&
            ($this->id= $this->require_id("numeric", $_REQUEST['id_file'])) && $this->id) {
            $string= "file1.id_file='".$this->id."'";
        } elseif ($this->option == "transfer") {
            $string= "file1.file_dept='".$u->id_dept."' AND file1.file_status IN (1,2) AND transfer1.status_trans IN(0,1,3)";
        } elseif ($m->view_ref == "files_transit") {
            $string= "file1.file_dept='".$u->id_dept."' AND transfer1.status_trans='2'";
        } elseif ($m->view_ref == "file_trans_rejected") {
            $string= "file1.file_dept='".$u->id_dept."' AND transfer1.status_trans='3'";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_files")
                && ($_GET['v'] == "all_files_transit")) {
            $string= "transfer1.status_trans='2' ";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_files")
                && ($_GET['v'] == "all_files_rejected")) {
            $string= "transfer1.status_trans='3' ";
        } elseif ($u->is_admin() && ($m->view_ref == "admin_list_files")
                && ($_GET['v'] == "all_other_files")) {
            $string= "transfer1.status_trans IN (0,1) ";
        } else {
            $string= "file1.file_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1)";
        }
        
        //-------------------------
        
        if (is_numeric($_REQUEST["filter_".$this->id_tag]) && !empty($string)) {
            $string .= " AND file1.id_file='".$_REQUEST["filter_".$this->id_tag]."'";
        } elseif (is_numeric($_REQUEST["filter_".$this->id_tag])) {
            $string .= "file1.id_file='".$_REQUEST["filter_".$this->id_tag]."'";
        }
        
        //-----------------------------

        $q->set_filter($string);
    }

    
    
    
    
    
    public function onsubmit()
    {
        global $s, $q, $t, $u;



        if ($_REQUEST["filter_".$this->id_tag] && !is_numeric($_REQUEST["filter_".$this->id_tag])) {
            $this->throw_msg(
                "error",
                "param_must_be_numeric",
                            "id search param must be numeric"
            );
            return;
        }

        //-------------------------

        $action_log= new action_log();
        $action_log->config();


        if (($_REQUEST['file_status'] == 3) && ($_REQUEST['ask_delete_file'] || $_REQUEST['yes_delete_file'])) {
            $this->throw_msg(
            "error",
            "not_delete_file_with_project",
                            "the file has at least one project, delete file not allowed"
        );
        } elseif ((($_REQUEST['file_status'] == 0) && is_numeric($_REQUEST['file_status']))
                && ($_REQUEST["edit_".$this->subject] || $_REQUEST["ask_delete_".$this->subject])) {
            $this->throw_msg(
            "error",
            "not_edit_dormant_file",
                            "the file is dormant, edit project not allowed"
        );
        } elseif ((($_REQUEST['file_status'] == 0) && is_numeric($_REQUEST['file_status']))
                && $_REQUEST['create_project']) {
            $this->throw_msg(
            "error",
            "create_project_dormant_file",
                            "the file is dormant, create project not allowed"
        );
        } elseif (is_array($_REQUEST[$this->id_tag]) && $_REQUEST['yes_received']) {
            $q->set_filter("id_dept='".$u->id_dept."'");
            $_REQUEST['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        
            
            $list= $_REQUEST[$this->id_tag][0];
        
            for ($i=1; $i < count($_REQUEST[$this->id_tag]); $i++) {
                $list .= ", ".$_REQUEST[$this->id_tag][$i];
            }
            
            $list= empty($list) ? "0" : $list;

            
            $received= array();
    
            $q->set_filter("file1.id_file IN (".$list.") AND transfer1.status_trans='2'");
            $q->sql_select("select_file1", $numrows, $res, "all");
        
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

                    $action_log->save($s->confirm_trans_tag, "id_file", $data);
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
                            $this->send_sms_to_subscribers($s->sms_file_transfer_action, 1, $_REQUEST[$this->id_tag][$i]);
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

        
            $q->set_filter("file1.id_file IN (".$list.") AND file1.file_dept= '".$u->id_dept."'");
            $q->sql_select("select_file1", $numrows, $res, "all");
        
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
                
                    $q->set_var("id_file", $data['id_file']);	// for insert_file_transfer query
                $q->set_var("id_list", $data['id_file']);	// for update_file_trans query...
                
                $q->set_var("id_dept", $data['dept_comingfrom']);
                    $q->set_var("id_trans", $data['last_trans']);
                
                
                    $q->set_var("id_user", $u->id);
                    $q->set_var("dept_comingfrom", $u->id_dept);
                    $q->set_var("dept_goingto", $data['dept_comingfrom']);
                    $q->set_var("status_trans", 3);
                    $q->set_var("date_trans", "NOW()");
                    $q->set_var("describe_trans", $t->transfer_cancelled);
                                
            
                    $cancelled1[]= $q->sql_action("insert_file_trans");
                    $last_trans= $q->get_var("new_id");
            
                    $q->set_var("last_trans", $last_trans);
                    $cancelled2[]= $q->sql_action("update_file_last_trans");
                                
                    $cancelled3[]= $q->sql_action("update_file_dept");

                    $action_log->save($s->cancel_trans_tag, "id_file", $data);
                }
                
                                                        
                if (count($_REQUEST[$this->id_tag]) == count($cancelled3)) {
                    $this->throw_msg(
                    "confirm",
                    "cancel_transfer_confirmed",
                                "file selection transfer was annulled"
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
        global $m;

        parent::set_data($name, $value);

        if (($this->option == "view_one") && ($this->numrows == 1)) {
            $this->data= mysql_fetch_assoc($this->res);
        
            if (!$this->is_foreign() && (($this->data['file_status'] == 1) || ($this->data['file_status'] == 2))) {
                $this->has['allowed_create_edit_delete']= true;
            }
            
            $_REQUEST['file_status']= $this->data['file_status'];
            
            mysql_data_seek($this->res, 0);
        }
    }
    
    
    
    

    public function display_skeleton()
    {
        global $c, $s, $m, $t, $q, $u;

        $keep_tr_class= $this->i_var['tr_class'];


        if ($this->data['file_status'] == 0) {
            $this->i_var['tr_class']= "inactive";
        }
        
        //------------------

        $this->i_var['tr_class']= $this->is_foreign() ? "foreign" : $this->i_var['tr_class'];

        //-------------------
    
        if (($_GET['form_name'] == "search") && $this->has['data_hyperlinks']) {
            $q->set_filter("file1.id_file > ".$this->data['id_file']
                    ." AND file_dept='".$u->id_dept."' AND transfer1.status_trans IN (0,1)");
        
            $q->sql_select("select_file1", $numrows, $res, "all");
            
            $paging_max_items= $s->paging_max_items;
            $paging_max_items= ($paging_max_items > 0) ? $paging_max_items : 1;
            $numrows= ($numrows > 0) ? $numrows : 1;
            
            $pg= floor($numrows / $paging_max_items)+1;
            
            $pg= ($pg >= 1) ? $pg : 1;

            $this->set_data_hyperlinks($s->root_url."?v=files&pg=".$pg."&selected=".
            $this->data['id_file'], array("id_file"), false);
        }
    
        //--------------------
    
        if (is_numeric($_GET['selected']) && ($_GET['selected'] == $this->data['id_file'])) {
            $this->i_var['tr_class']= "selected";
        }

        //------------------------

        $this->set_file_names();

        $file_status= $s->file_status;
        $string= $file_status[$this->data['file_status']]; // file status starts at 1
        $this->data['name_status']= $t->$string;

        $this->data["status_id_file"]= $this->data['file_status']."_".$this->data[$this->id_tag];

        $keep= $this->id_tag;
        $this->id_tag= "status_id_file";

        $this->view_data();

        $this->id_tag= $keep;

        $this->i_var['tr_class']= $keep_tr_class;
    }
    
    
    
    
    
    
    
    public function display_submit()
    {
        global $u, $t;
    
    
        parent::display_submit();


        if (($this->option != "transit") && ($this->numrows >= 1)) {
            echo <<<HTML


<input type="submit" class="submit_button" name="file_clients" value="{$t->clients}"/>


<input type="submit" class="submit_button" name="file_projects" value="{$t->projects}"/>


<input type="submit" class="submit_button" name="transfer_file" value="{$t->transfer}"/>


<input type="submit" class="submit_button" name="file_history" value="{$t->history}"/>


HTML;
        } elseif (($this->option == "transit") && ($this->numrows >= 1)) {
            echo <<<HTML


<input type="submit" class="submit_button" name="file_clients" value="{$t->clients}"/>

<input type="submit" class="submit_button" name="ask_file_received" value="{$t->selection_received}"/>

<input type="submit" class="submit_button" name="ask_cancel_transfer" value="{$t->cancel_transfer}"/>

HTML;
        }
    }
    
    
    
    
    
    public function ask_confirm()
    {
        global $q, $u, $t;


        if ($_REQUEST['ask_file_received'] && $_REQUEST['id_file'] && is_array($_REQUEST['id_file'])) {
            $command= "yes_received";
            $msg= $t->confirm_selection_received;
        } elseif ($_REQUEST['ask_cancel_transfer'] && $_REQUEST['id_file'] && is_array($_REQUEST['id_file'])) {
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


        echo "<span class=\"focus\">{$t->sp_file} {$t->num} {$_REQUEST['id_file'][0]}</span>
			<input type=\"hidden\" name=\"id_file[]\" value=\"{$_REQUEST['id_file'][0]}\" />";
            

        for ($i=1; $i < count($_REQUEST['id_file']); $i++) {
            echo " | <span class=\"focus\">{$t->sp_file} {$t->num} {$_REQUEST['id_file'][$i]}</span>";

            echo "<input type=\"hidden\" name=\"id_file[]\" value=\"{$_REQUEST['id_file'][$i]}\" />";
        }
            
        echo <<<HTML
	
</div>

<input type="submit" class="submit_button" name="{$command}" value="{$t->yes}"/>

<input type="submit" class="submit_button" name="no" value="{$t->no}"/>

</div>

</form>

HTML;
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
