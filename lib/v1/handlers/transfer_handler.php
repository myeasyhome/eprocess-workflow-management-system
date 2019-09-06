<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class transfer_handler extends object_handler
{
    public function initialize($option="")
    {
        global $c, $t;


        parent::initialize();

        if ($_REQUEST['transfer_file'] || ($_REQUEST['v'] == "transfer_file")) {
            $this->objs[0]= new list_files();
        } elseif ($_REQUEST['transfer_project'] || ($_REQUEST['v'] == "transfer_project")) {
            $this->objs[0]= new list_projects();
        }
        
        $this->objs[1]= new select_department();
        $this->objs[2]= new select_carrier();
        $this->objs[3]= new edit_describe_trans();

        $this->initialize_objs();

        $this->objs[0]->set_option("transfer");
        $this->objs[1]->set_option("other_internal");
        $this->objs[2]->set_option("other");
    }
    
    
    
    
    public function config()
    {
        global $s, $q, $t;
    
        parent::config();

        $this->has['common_data_source']= false;


        $this->i_var['form_name']= "tranfer";
        $this->i_var['form_method']= "POST";

        $this->objs[1]->set_has("submit", false);
        $this->objs[2]->set_has("submit", false);
        $this->objs[3]->set_has("submit", false);

        $this->objs[1]->set_has("form", false);
        $this->objs[2]->set_has("form", false);
        $this->objs[3]->set_has("form", false);

        if ($_REQUEST['transfer_file'] || ($_REQUEST['v'] == "transfer_file")) {
            $this->set_title($t->transfer_file, "h1");
            $this->subject= "file";
            $this->i_var['transfer_query_1']= "insert_file_trans";
            $this->i_var['transfer_query_2']= "update_file_last_trans";
            $this->i_var['transfer_query_3']= "update_file_dept";
            $this->id_tag= "id_file";
            $this->i_var['target_url']= $s->root_url."?v=transfer_file";
        } elseif ($_REQUEST['transfer_project'] || ($_REQUEST['v'] == "transfer_project")) {
            $this->set_title($t->transfer_project, "h1");
            $this->subject= "project";
            $this->i_var['transfer_query_1']= "insert_proj_trans";
            $this->i_var['transfer_query_2']= "update_proj_last_trans";
            $this->i_var['transfer_query_3']= "update_proj_dept";
            $this->id_tag= "id_proj";
            $this->i_var['target_url']= $s->root_url."?v=transfer_project";
        } else {
            $this->throw_msg("fatal_error", "invalid_request", "met#config, 
				cls#transfer_handler, invalid command");
        }
        
        
        
        $pg= $s->pagenum_tag;

        if ($_GET[$pg]) {
            $this->i_var['target_url'] .= "&".$pg."=".$_GET[$pg];
        }
    }
    
    

    
    

    public function onsubmit()
    {
        global $c, $s, $m, $q, $u, $v, $t;


        $name= $this->option;


        if ($_REQUEST['form_name'] == $this->i_var['form_name']) {
            if ($_REQUEST["transfer_".$this->subject]) {
                if (!($_REQUEST['id_dept'])) {
                    $this->throw_msg(
                    "error",
                    "no_department",
                                            "#met #onsubmit"
                );
                                                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                
                if (!($_REQUEST['id_carrier'])) {
                    $this->throw_msg(
                    "error",
                    "no_carrier",
                                        "#met #onsubmit"
                );
                        
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                
                $describe_trans= trim($_REQUEST['describe_trans']);
                
                if (empty($describe_trans)) {
                    $this->throw_msg(
                    "error",
                    "no_describe_trans",
                                        "#met #onsubmit"
                );
                        
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                
                if ($_REQUEST['transfer_file'] && is_array($_REQUEST['id_file'])) {
                    $name_id= "id_file";
                } elseif ($_REQUEST['transfer_project'] && is_array($_REQUEST['id_proj'])) {
                    $name_id= "id_proj";
                }

                    
                if (!isset($name_id) || !$_REQUEST[$name_id]) {
                    $this->throw_msg(
                    "error",
                    "no_document",
                                        "#met #onsubmit"
                );
                                        
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }
                
                
                            
            
                //---------------------------------

                $action_log= new action_log();
                $action_log->config();

                $q->set_filter("id_dept='".$u->id_dept."'");
                $old_name_dept= $this->set_data_from_id("select_department1", "", "name_dept");
            
                if (is_numeric($_REQUEST['id_dept'])) {
                    $q->set_filter("id_dept='".$_REQUEST['id_dept']."'");
                    $new_name_dept= $this->set_data_from_id("select_department1", "", "name_dept");
                }

                $new_data['old_name_dept']= $old_name_dept;
                $new_data['new_name_dept']= isset($new_name_dept) ? $new_name_dept : $t->unkown;
                            
                //--------------------------------
            
                
                $list= $_REQUEST[$name_id][0];
        
                for ($i=1; $i < count($_REQUEST[$name_id]); $i++) {
                    $list .= ", ".$_REQUEST[$name_id][$i];
                }
                
                $list= empty($list) ? "0" : $list;


                if ($_REQUEST['transfer_file']) {
                    $q->set_filter("file1.id_file IN (".$list.") AND file1.file_dept='".$_REQUEST['id_dept']."'");
                    $this->set_data_from_id("select_file1", "", "", $numrows);
                } elseif ($_REQUEST['transfer_project']) {
                    $q->set_filter("project1.id_proj IN ('".$list."') AND project1.proj_dept='".$_REQUEST['id_dept']."'");
                    $this->set_data_from_id("select_project1", "", "", $numrows);
                }
                
                if (isset($numrows) && ($numrows >= 1)) {
                    $this->throw_msg(
                        "confirm",
                        "document_transferred",
                                    "#met #onsubmit"
                    );
                                    
                    return;
                }
                            
                $q->set_var("info_carrier", $this->set_info_carrier($old_name_dept));
            
                $this->var_to_queries($_REQUEST);
            
                $q->set_var("id_list", $list);
                $q->set_var("file_dept", $_REQUEST['id_dept']);
                $q->set_var("id_user", $u->id);
                $q->set_var("dept_comingfrom", $u->id_dept);
                $q->set_var("dept_goingto", $_REQUEST['id_dept']);
                $q->set_var("status_trans", 2);
                $q->set_var("date_trans", "NOW()");

            
                for ($i=0; $i < count($_REQUEST[$name_id]); $i++) {
                    if (is_array($_REQUEST['id_file'])) {
                        if (is_numeric($_REQUEST['id_file'][$i])) {
                            $q->set_var("id_file", $_REQUEST['id_file'][$i]);
                        } else {
                            $this->throw_msg(
                            "fatal_error",
                            "invalid_request",
                                    "#met #onsubmit, id_file not numeric..."
                        );
                    
                            $this->is['submitted']= true;
                            $this->set_has("update_data_from_global", true);
                            return;
                        }
                    }
            
                    $q->set_var($name_id, $_REQUEST[$name_id][$i]);
                    $transferred1= $q->sql_action($this->i_var['transfer_query_1']);
                
                    $last_trans= $q->get_var("new_id");
                    $q->set_var("last_trans", $last_trans);
                    $transferred2= $q->sql_action($this->i_var['transfer_query_2']);
                
                    if ($transferred1 && $transferred2) {
                        $new_data[$name_id]= $_REQUEST[$name_id][$i];
                
                        $action_log->save($s->transfer_tag, $name_id, $new_data);
                    }
                }


                if (!$q->sql_action($this->i_var['transfer_query_3'])) {
                    $this->throw_msg(
                        "error",
                        "action_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "document_transferred",
                                    "#met #onsubmit"
            );
            }
        }
    }
    
    
    
    
    
        
    public function set_data($name="", $value=null)
    {
        parent::set_data();


        if ($_REQUEST['id_dept']) {
            $this->objs[1]->set_selected($_REQUEST['id_dept']);
        }
        
        if ($_REQUEST['id_carrier']) {
            $this->objs[2]->set_selected($_REQUEST['id_carrier']);
        }
    }
    
    
    
    
    
    
    public function set_info_carrier($name_dept="")
    {
        global $q;

        if (is_numeric($_REQUEST['id_carrier']) && is_numeric($_REQUEST['id_dept'])) {
            $q->set_filter("id_carrier=".$_REQUEST['id_carrier']);
            $data= $this->set_data_from_id("select_carrier1");
    
            if (empty($name_dept)) {
                $q->set_filter("id_dept='".$_REQUEST['id_dept']."'");
                $data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
            } else {
                $data['name_dept']= $name_dept;
            }
            
            $info= <<<HTML
{$data['surname']} {$data['firstname']}, {$data['num_phone']} - {$data['name_dept']}
HTML;

            return $info;
        } else {
            echo_warning("invalid #id_carrier and #id_dept in ".
                        "met#set_info_carrier, cls#transfer_handler");
        }
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;

        echo <<<HTML

<input type="submit" class="submit_button" name="transfer_{$this->subject}" value="{$t->transfer}"/>

HTML;
    }

    
    
    
    
    public function display()
    {
        global $t;
    
    
        $this->display_title();

        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);

        echo "<input type=\"hidden\" name=\"{$this->id_tag}\" value=\"{$this->id}\" />";

        echo "<div class=\"form_section\">";
        $this->objs[0]->display_title();
        $this->objs[0]->display();
        echo "</div>";

        if ($this->objs[0]->get_numrows() >= 1) {
            echo "<div class=\"form_section\"><p class=\"form_label\">{$t->department}:</p>";

            $this->objs[1]->display();
            echo "</div>";

            echo "<div class=\"form_section\"><p class=\"form_label\">{$t->carrier}:</p>";

            $this->objs[2]->display();
            echo "</div>";

            echo "<div class=\"form_section\">";
            $this->objs[3]->display();
            echo "</div>";

            $this->display_submit();
        }

        echo "</form>";
    }
}
