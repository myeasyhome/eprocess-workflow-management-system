<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class list_print_letters extends list_items_adapter
{
    protected $bordereau_msg;
    protected $proj_types;
    
    
    public function config()
    {
        global $s, $t;

        parent::config();


        $this->selected= array();
        $this->proj_types= array();


        $this->reference="list_print_letters";
        $this->i_var['form_name']= $this->reference;

        $this->i_var['target_url']= $this->i_var['current_url'];
    
        $this->id_tag="data_print_letter";

        $this->i_var['id_tag']= "num_proj";
        $this->i_var['filter_id_tag']= "id_proj";

        $this->data_source="select_print_letter1";


        if ($_GET['v'] == "print_letters") {
            $this->option= "print_letters";
            $this->set_title($t->print_letters, "h2");
            $this->has['delete']= true;
            
            $this->display_list= array("id_print_letter", "date_created", "id_proj", "name_proj_type", "proj_ref",
                                        "title_letter", "username");
        } elseif ($_GET['v'] == "printed_letters") {
            $this->option= "printed_letters";
            $this->set_title($t->printed_letters, "h2");
            $this->has['delete']= false;
            
            $this->display_list= array("id_print_letter", "date_created", "id_proj", "num_bordereau", "date_printed",
            "name_proj_type", "proj_ref", "title_letter", "username");
        }
            
            
        //----------------------------------------------------------

        if (is_array($_REQUEST['data_print_letter'])) {
            for ($i=0; $i < count($_REQUEST['data_print_letter']); $i++) {
                $list= explode("_", $_REQUEST['data_print_letter'][$i]);
                $this->selected[$i]= $this->require_id("numeric", $list[0]);
                $this->proj_types[$i]= $this->require_id("numeric", $list[1]);
            }
        } elseif (is_array($_REQUEST['id_print_letter'])) {
            for ($i=0; $i < count($_REQUEST['id_print_letter']); $i++) {
                $this->selected[$i]= $this->require_id("numeric", $_REQUEST['id_print_letter'][$i]);
            }
        }
                    

        $this->has['edit']= false;
        $this->has['filter']= true;
        $this->has['radio']= false;
        $this->has['checkboxes']= true;
        $this->has['filter_box']= true;
    }
    
    
    
    
    
    public function onsubmit()
    {
        global $u, $q, $m, $t;

        $done1;
        $done2;

        $affected= array();


        // is printed status
        
        if ($u->dept_has_write_letter && $u->has_print_letter && $_REQUEST['set_printed'] && $this->selected) {
            $list= $this->selected[0];
                
            for ($i=1; $i < count($this->selected); $i++) {
                $list .= ", ".$this->selected[$i];
            }
        
            $list= empty($list) ? "0" : $list;
                
            $q->set_filter("print_letter1.id_print_letter IN (".$list.")");
        
            if (!$q->sql_action("update_is_printed")) {
                $this->throw_msg(
                "error",
                "action_failed",
                "#met #onsubmit,
				cls#".get_class($this)
            );
            } else {
                $this->throw_msg(
                "confirm",
                "set_printed_done",
                                    "print letter status set to printed"
            );
            }
            
            $q->clear("all");
        }
        
        
        // not printed status
        
        if ($u->dept_has_write_letter && $u->has_print_letter && $_REQUEST['set_not_printed'] && $this->selected) {
            $list= $this->selected[0];
                
            for ($i=1; $i < count($this->selected); $i++) {
                $list .= ", ".$this->selected[$i];
            }
        
            $list= empty($list) ? "0" : $list;
                
            $q->set_filter("print_letter1.id_print_letter IN (".$list.")");
        
            if (!$q->sql_action("update_not_printed")) {
                $this->throw_msg(
                "error",
                "action_failed",
                "#met #onsubmit,
				cls#".get_class($this)
            );
            } else {
                $this->throw_msg(
                "confirm",
                "set_not_printed_done",
                                    "print letter status set to not printed"
            );
            }
            
            $q->clear("all");
        }

        
        // create bordereau
        if ($u->has_create_bordereau && $_REQUEST['create_bordereau'] && $this->selected && $this->proj_types) {
            for ($i=0; $i < count($this->selected); $i++) {
                $q->set_filter("AND print_letter1.id_print_letter='".$this->selected[$i]."' AND project1.id_bordereau=''");
                $print_letter= $this->set_data_from_id("select_print_letter1", "", "", $numrows);

                if ($numrows < 1) {
                    continue;
                }
            
                $q->set_filter("id_proj_type='".$this->proj_types[$i]."'");
                $proj_type= $this->set_data_from_id("select_project_type1");
            
                $id_bordereau= ++$proj_type['id_bordereau'];
            
                $year_id_bordereau= date("Y", time())."-".$id_bordereau;
            
                $q->set_var("id_bordereau", $id_bordereau);
                $q->set_var("id_proj_type", $proj_type['id_proj_type']);
            
                if ($q->sql_action("update_proj_type_id_bordereau")) {
                    $done1= true;
                }
                
                $q->set_var("year_id_bordereau", $year_id_bordereau);
                $q->set_var("id_proj", $print_letter['id_proj']);
            
                if ($q->sql_action("update_project_id_bordereau")) {
                    $done2= true;
                }
                
                if ($done1 && $done2) {
                    $affected[]= array($print_letter['id_proj'], $year_id_bordereau);
                    $this->has['new_bordereau']= true;
                }
                
                $q->clear("all");
            }
    
            //----------------------------
            
            if ($this->has['new_bordereau']) {
                $string = "<div class=\"msg_confirm\"><div class=\"msg_margin\"><p>{$t->new_bordereau_confirm}:</p>";

                $string .= "<span class=\"focus\">{$t->num_of_project} {$affected[0][0]}: 
								<span class=\"blue\">{$affected[0][1]}</span></span>";
            
                for ($i=1; $i < count($affected); $i++) {
                    $string .= "<span class=\"focus\"> | {$t->num_of_project} {$affected[$i][0]}: 
						<span class=\"blue\">{$affected[$i][1]}</span></span>";
                }
            
                $string .= "</div></div>";
            
                $this->new_bordereau_msg= $string;
            }
        }
        
        
        

        if ($_REQUEST["yes_delete_".$this->subject] && $this->selected) {
            $list= $this->selected[0];
            
            for ($i=1; $i < count($this->selected); $i++) {
                $list .= ", ".$this->selected[$i];
            }
                        
            $q->set_var("id_list", $list);
                    
            if (!$q->sql_action("delete_from_print_letter1")) {
                $this->throw_msg(
                    "error",
                    "delete_failed",
                                "#met #onsubmit"
                );
                
                return;
            }

            $this->throw_msg(
                "confirm",
                "record_deleted",
                                    "#met #onsubmit"
            );
        }
    }
    
    
    
            
    
    public function set_filter()
    {
        global $u, $m, $q;


        if ($this->option == "print_letters") {
            $q->set_filter("AND print_letter1.is_printed='0'");
        } elseif ($this->option == "printed_letters") {
            $q->set_filter("AND print_letter1.is_printed='1'");
        }

        if (!$u->is_admin()) {
            $q->set_filter("AND project1.proj_dept='".$u->id_dept."'");
        }
        
        //-------------------------
        
        if (is_numeric($_REQUEST['filter_id_proj'])) {
            $q->set_filter("project1.id_proj='".$_REQUEST['filter_id_proj']."'");
        }

        //-----------------------------
    }

    
    

    
    public function display_skeleton()
    {
        global $s, $u, $q, $t;

        $this->custom_datetime(array("plt_date_created", "date_printed"));

        $q->set_filter("id_proj_type='".$this->data['proj_type']."'");
        $this->data['name_proj_type']= $this->set_data_from_id("select_project_type1", "", "name_proj_type");

        $this->data['date_created']= &$this->data['plt_date_created'];

        $q->set_filter("id_user='".$this->data['plt_id_user']."'");
        $this->data['username']= $this->set_data_from_id("select_user1", "", "username");

        $this->data['data_print_letter']= $this->data['id_print_letter']."_".$this->data['proj_type'];

        $this->data['num_bordereau']= $this->data['id_bordereau'] ? $this->data['id_bordereau'] : "---";

        $this->set_data_hyperlinks($s->root_url."?v=project_clients&id_proj={$this->data['id_proj']}", array("id_proj"), false);

        $this->view_data();
    }
    
    
    
    
    
    public function display_submit()
    {
        global $s, $m, $u, $t;


        parent::display_submit();
    

        if ($this->numrows > 0) {
            echo <<<HTML

<input type="submit" class="submit_button" name="process_preview" value="{$t->preview}"/>

HTML;

            if ($u->dept_has_write_letter && $u->has_print_letter) {
                echo <<<HTML

<input type="submit" class="submit_button" name="print_selected" value="{$t->print}"/>

<input type="submit" class="submit_button" name="print_all" value="{$t->print_all}"/>

HTML;

                if ($this->option == "print_letters") {
                    echo <<<HTML

<input type="submit" class="submit_button" name="set_printed" value="{$t->set_printed}"/>
				
HTML;
                } elseif ($this->option == "printed_letters") {
                    echo <<<HTML

<input type="submit" class="submit_button" name="set_not_printed" value="{$t->set_not_printed}"/>
				
HTML;
                }
            }
            
            if ($u->has_create_bordereau && ($this->option == "printed_letters")) {
                echo <<<HTML

<input type="submit" class="submit_button" name="create_bordereau" value="{$t->create_bordereau}"/>

HTML;
            }
            
            $pg= $s->pagenum_tag;
            
            if ($_GET[$pg]) {
                echo <<<HTML

<input type="hidden" name="{$pg}" value="{$_GET[$pg]}"/>

HTML;
            }
            
            
            if ($_GET['filter_id_proj']) {
                echo <<<HTML

<input type="hidden" name="filter_id_proj" value="{$_GET['filter_id_proj']}"/>

HTML;
            }
        }
    }
    
    
    
    
    
    public function ask_delete()
    {
        global $q, $u, $t;


        echo <<<HTML

<div class="section">

<div class="prompt">

<p>{$t->ask_delete_print_letters}</p>

HTML;


        echo "<span class=\"focus\">{$t->num} {$this->selected[0]}</span>
			<input type=\"hidden\" name=\"id_print_letter[]\" value=\"{$this->selected[0]}\" />";
            

        for ($i=1; $i < count($this->selected); $i++) {
            echo " | <span class=\"focus\">{$t->num} {$this->selected[$i]}</span>";

            echo "<input type=\"hidden\" name=\"id_print_letter[]\" value=\"{$this->selected[$i]}\" />";
        }
            
        echo <<<HTML
	
</div>

<input type="submit" class="submit_button" name="yes_delete_{$this->subject}" value="{$t->yes}"/>

<input type="submit" class="submit_button" name="cancel" value="{$t->no}"/>

</div>

HTML;
    }

    
    
    
    
    
    public function display()
    {
        global $t;
    
    
        $this->display_title();

        if ($this->has['new_bordereau'] && $this->new_bordereau_msg) {
            echo $this->new_bordereau_msg;
        }
        
        $this->display_filter_box();
        
        parent::display();
    }
}
