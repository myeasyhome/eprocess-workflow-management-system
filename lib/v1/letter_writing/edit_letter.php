<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class edit_letter extends html_form_adapter
{
    protected $max_num_pages;
    protected $selector;



    
    public function initialize()
    {
        global $c, $t;


        parent::initialize();

        $this->selector= new select_department();
        $this->selector->initialize();
    }
    
    

    
    public function config($option="")
    {
        global $s, $m, $t, $q;

    
        parent::config();

        $this->selector->config();
        $this->selector->set_default($t->all);

        //-----------------------
        
        $this->max_num_pages= 3; // default

        if (is_numeric($_GET['max_num_pages']) && ($_GET['max_num_pages'] <= $s->max_letter_num_pages)) {
            $this->max_num_pages= $_GET['max_num_pages'];
        }
        
        //--------------------------

        $this->has['select_department']= true;
        $this->has['title_letter']= true;
        $this->has['form']= false;

        $this->i_var['form_name']= "edit_letter";
        $this->i_var['form_method']= "POST";

        $this->i_var['target_url']= $s->root_url."?v=".$m->view_ref;

        $this->i_var['input_size']=100;
        $this->i_var['input_maxlength']=100;
        $this->i_var['textarea_rows']=40;
        $this->i_var['textarea_cols']=100;

        $this->subject= "letter";

        $this->reference= $this->i_var['form_name']= "edit_letter";

        $this->set_title($t->create." | ".$t->edit.": ".$t->letter, "h2");

        if ($_REQUEST['id_letter'] && ($this->id= $this->require_id("numeric", $_REQUEST['id_letter'])) && $this->id) {
            $this->data_source= "select_letter1";
            $this->has['filter']= true;
            $this->has['update_data_from_global']= false;
        } else {
            $this->is['new']= true;
        }

        if ($option != "child") {
            $this->define_form();
        }
    }
    
    
    
    
        
    public function define_form()
    {
        $fields= array();


        if ($this->has['title_letter']) {
            $fields[]= "title_letter";
            $this->make_sections("input_text", 1);
        }
        
        $num_pages= 0;
        
        while ($num_pages < $this->max_num_pages) {
            $num_pages++;
        
            $fields[]= "body_letter".$num_pages;
            
            if ($num_pages > 1) {
                $this->ignore[]= "body_letter".$num_pages;
            }
        }

        
        $this->make_sections("textarea", $num_pages);


        if ($this->id) {
            $fields[]="id_letter";
            $this->make_sections("hidden", 1);
        }

        $this->set_fields($fields);
    }
    
    
    
    
    
    
    public function validate_data()
    {
        global $s, $c;



        if ($this->numrows >= 1) {
            $counter= 0;
            $pages= explode($s->letter_page_break, $this->data['body_letter']);
        
            for ($i=0; $i < count($pages); $i++) {
                $pages[$i]= trim($pages[$i]);
            
                if (!empty($pages[$i])) {
                    $counter++;
                
                    $this->data["body_letter".($i+1)]= $pages[$i];
                } else {
                    break;
                }
            }
            
            if ($counter && !$_REQUEST['max_num_pages']) {
                $this->max_num_pages= $counter;
            
                $this->main_sections= array();
                $this->i_var['section_counter']= 0;
                $this->fields= array();
                $this->ignore= array();
            
                $this->define_form();
            }
        }
    }

    
    
    
    
    public function onsubmit()
    {
        global $s, $u, $q, $t;


        if ($_REQUEST['back_from_preview']) {
            $this->has['compulsory_sign']= false;
            return;
        }
        
        
        //------------------
        
        if (($_REQUEST['form_name'] == $this->i_var['form_name'])
                && $this->is_validated()) {
        

        //--- make body_letter	 from parts
        
            $body_letter= array();
            $num= 1;
        
            while ($num <= $s->max_letter_num_pages) {
                $_REQUEST["body_letter".$num]= isset($_REQUEST["body_letter".$num]) ? trim($_REQUEST["body_letter".$num]) : "";
        
                if (!empty($_REQUEST["body_letter".$num])) {
                    $body_letter[]= $_REQUEST["body_letter".$num];
                } else {
                    break;
                }
                
                $num++;
            }
        
        
            $_REQUEST["body_letter"]= implode($s->letter_page_break, $body_letter);
        
        
            //------------------
        
        
            if (is_numeric($_REQUEST['status'])) {
                $temp= $this->shelf['status'][($_REQUEST['status'])];
                $temp = explode("_", $temp);
            
                $_REQUEST['status']= $temp[0];
            }
        
        
            $this->var_to_queries($_REQUEST);
        
                                        
            if ($_REQUEST["create_".$this->subject]) {
                $q->set_var("id_user", $u->id);
                    
                if (!$q->sql_action("insert_letter1")) {
                    $this->throw_msg(
                        "error",
                        "create_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_created",
                                    "#met #onsubmit"
            );
            }
            
            
            if ($_REQUEST["save_".$this->subject]) {
                $q->set_var("id_letter", $this->id);
                $q->set_var("id_user", $u->id);
            
                if (!$q->sql_action("delete_from_letter1") || !$q->sql_action("save_letter1")) {
                    $this->throw_msg(
                        "error",
                        "save_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_saved",
                                    "#met #onsubmit"
            );
            }
            
            
            if ($_REQUEST["yes_delete_".$this->subject]) {
                $q->set_var("id_letter", $this->id);
                    
                if (!$q->sql_action("delete_from_letter1")) {
                    $this->throw_msg(
                        "error",
                        "delete_failed",
                                    "#met #onsubmit"
                    );
                    
                    $this->is['submitted']= true;
                    $this->set_has("update_data_from_global", true);
                    return;
                }

                $this->throw_msg(
                "confirm",
                "record_deleted",
                                    "#met #onsubmit"
            );
                $this->is['new']= true;
            }
        } elseif (($_REQUEST['form_name'] == $this->i_var['form_name']) && !$this->in_cancel_mode()) {
            $this->is['submitted']= true;
            $this->set_has("update_data_from_global", true);
        }
    }
    
    
    
    
    public function set_filter()
    {
        global $q;
    
        if ($this->id) {
            $q->set_filter("id_letter='".$this->id."'");
        }
    }
    

    
    
    
    public function set_data()
    {
        global $q;

        
        parent::set_data();
                
        $q->clear("all");
        $this->selector->set_data();

        if ($this->data['id_dept']) {
            $this->selector->set_selected($this->data['id_dept']);
        }
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;


        parent::display_submit();

        if (!$this->is['new']) {
            echo <<<HTML

<input type="submit"  class="submit_button" name="preview" value="{$t->preview}"/>

HTML;
        }
    }
    
    
    
    
    
    
    public function display()
    {
        global $t;


        if (!$_REQUEST['preview'] && !$_REQUEST['process_preview']) {
            echo "<div class=\"set_params\">";

            $this->open_form("max_num_pages", "GET", $this->i_var['current_url']);

            $this->select_number("max_num_pages");

            if ($_REQUEST['create_letter']) {
                echo "<input type=\"hidden\" name=\"create_letter\" value=\"true\" /> ";
            } elseif ($_REQUEST['edit_letter']) {
                echo "<input type=\"hidden\" name=\"edit_letter\" value=\"true\" /> ";
            }
        
            //--------------
        
            if ($_REQUEST['id_letter']) {
                echo "<input type=\"hidden\" name=\"id_letter\" value=\"{$_REQUEST['id_letter']}\" /> ";
            }
        

            echo <<<HTML

<input class="set_params_submit" type="submit" name="submit" value="{$t->submit}" /> 

</form> 

</div>

HTML;
        }

    
        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
        if ($_REQUEST['preview']) {
            $obj= new letter_preview_handler();
            $obj->initialize();
            $obj->config();
            $obj->set_has("form", false);
            $obj->set_has("save", false);
            $obj->set_has("print", false);
            $obj->set_data();
            $obj->start();
            $obj->display();
        } else {
            echo "<div class=\"letter\">";
            $this->display_title();
                        
            echo $t->use_letter_style_tags;

            if ($this->has['select_department']) {
                echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_dept}:</p>
HTML;

                $this->selector->display();

                echo "</{$this->sections_tag}>";
            }

            parent::display();
            echo "</div>";
        }
        
        echo "</form>";
    }
}
