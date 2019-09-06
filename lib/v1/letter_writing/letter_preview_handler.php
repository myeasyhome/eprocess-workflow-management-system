<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class letter_preview_handler extends edit_letter
{
    protected $letter;
    protected $project;
    protected $clients;
    protected $data_obj;



    public function config()
    {
        global $m, $t;


        parent::config("child");

        $this->has['title_letter']= false;

        $this->set_title($t->letter_preview, "h2");


        $this->data_obj= new letter_data();
    
        $this->separator= "*#";

        $this->has['select_department']= false;
        $this->has['form']= true;
        $this->has['submit']= true;
        $this->has['processed_letter']= false;
        $this->has['save']= true;

        $this->i_var['target_url']= $this->i_var['current_url'];
        $this->i_var['form_name']= "letter_preview";
        $this->i_var['form_method']= "POST";


        if (!$_REQUEST['preview']) {
            $this->define_form();
        }
        
        //-----------------------------------------------------------

        $_REQUEST['total_cc']= ($_REQUEST['save_print_letter'] && is_numeric($_REQUEST['total_cc'])) ? $_REQUEST['total_cc'] : null;
    }
    
    
    
    
    public function set_id_proj($id)
    {
        if (!is_object($this->data_obj)) {
            f1::echo_error("#data_obj not ready in met#set_id_proj,
				cls#letter_preview_handler");
            return;
        }
        
    
        if (is_numeric($id)) {
            $this->data['id_proj']= $id;
            $this->data_obj->set_id_proj($id);
        }
    }
    
    
    
    
    
    public function set_id_letter($id)
    {
        if (!is_object($this->data_obj)) {
            f1::echo_error("#data_obj not ready in met#set_id_letter,
				cls#letter_preview_handler");
            return;
        }
        
    
        if (is_numeric($id)) {
            $this->data['id_letter']= $id;
            $this->data_obj->set_id_letter($id);
        }
    }

    
    
    
    
    public function set_letter($value)
    {
        if (is_array($value) && $value['id_letter']) {
            $this->letter= $value;
            $this->set_id_letter($value['id_letter']);
        } else {
            f1::echo_error("#letter not an array in met#setletter,
				cls#letter_preview_handler");
        }
    }
    
    
    
    
    
    public function set_project($value)
    {
        if (is_array($value) && $value['id_proj']) {
            $this->project= $value;
            $this->set_id_proj($value['id_proj']);
        } else {
            f1::echo_error("#project not an array in met#set_project,
				cls#letter_preview_handler");
        }
    }
    
    
    
    
    
    
    public function set_clients($value)
    {
        if (is_array($value)) {
            $this->clients= $value;
        } else {
            f1::echo_error("#clients not an array in met#set_clients,
				cls#letter_preview_handler");
        }
    }
    
    
    
    
    public function remove_page_div(&$value)
    {
        $value= str_replace("<div class=\"page_a4\">", "", $value);
        $value= str_replace("<div class=\"wrap_page_a4\">", "", $value);
        $value= str_replace("</div>", "", $value);
    }
    
    
    
    
    
    public function set_data()
    {
        global $s, $q, $m, $t;


        if ($this->data['id_letter'] || $this->data['id_proj']) {
            $data= &$this->data;
        } else {
            $data= $m->letter_data;
        }
                
        //---------------------------------------------
        
        if ($_REQUEST['preview'] && $_REQUEST['body_letter1']) { // coming from edit form
        
            $num= 1;
        
            while ($num <= $s->max_letter_num_pages) {
                $_REQUEST["body_letter".$num]= isset($_REQUEST["body_letter".$num]) ? trim($_REQUEST["body_letter".$num]) : "";
        
                if (!empty($_REQUEST["body_letter".$num])) {
                    $_REQUEST["body_letter".$num]= "<div class=\"wrap_page_a4\"><div class=\"page_a4\">".
                    $_REQUEST["body_letter".$num]."</div></div>";
                
                    $this->fields["body_letter".$num]= &$_REQUEST["body_letter".$num];
                    $this->letter["body_letter".$num]= &$this->fields["body_letter".$num];
                } else {
                    break;
                }
                
                $num++;
            }
        } elseif ($_REQUEST['preview'] && $this->letter['body_letter1']) { // coming from a handler or database

            $num= 1;
        
            while ($num <= $s->max_letter_num_pages) {
                if (!empty($this->letter["body_letter".$num])) {
                    $this->fields["body_letter".$num]= &$this->letter["body_letter".$num];
                } else {
                    break;
                }

                $num++;
            }
        } elseif ($_REQUEST['back_from_preview'] && $_REQUEST['body_letter1']) {
            $num= 1;
        
            while ($num <= $s->max_letter_num_pages) {
                $_REQUEST["body_letter".$num]= trim($_REQUEST["body_letter".$num]);
            
                if (!empty($_REQUEST["body_letter".$num])) {
                    $this->remove_page_div($_REQUEST["body_letter".$num]);
                
                    $this->fields["body_letter".$num]= &$_REQUEST["body_letter".$num];
                    $this->letter["body_letter".$num]= &$this->fields["body_letter".$num];
                } else {
                    break;
                }

                $num++;
            }
        } elseif (empty($this->letter) && !empty($data['id_proj']) && !empty($data['id_letter'])) {
            $this->letter= $this->data_obj->get_letter();

            if ($this->letter['date_letter']) {
                $this->i_var['date_letter']= $this->letter['date_letter'];
                $this->letter['date_letter']= null;
            }
        } elseif (empty($this->letter) && empty($data['id_proj'])) {
            $this->no_result_msg= <<<HTML

<div class="msg_info">

<span class="msg_img_wrap">
<img src="images/msg_img_info.png">
</span>

<span class="msg_margin">

{$t->select_a_project}

</span>

</div>

HTML;
        
            $this->is['displayable']= false;
            return;
        } elseif (empty($this->letter) && empty($data['id_letter'])) {
            $this->no_result_msg= <<<HTML

<div class="msg_info">

<span class="msg_img_wrap">
<img src="images/msg_img_info.png">
</span>

<span class="msg_margin">

{$t->select_a_letter}

</span>

</div>

HTML;
            $this->is['displayable']= false;
            return;
        }
        
        //----------------------------------------------------
        
        if (empty($this->letter)) {
            $t->set_var("id_letter", $data['id_letter'], true);
        
            $this->throw_msg("error", "letter_not_found", "the letter was not found, in met#set_data
							, cls#letter_preview_handler");
            $this->is['displayable']= false;
        }
    
        
        if (!$_REQUEST['preview'] && $this->letter) {
        
        
            //---#project and #clients values can come from a handler
        
            if (empty($this->project)) {
                $this->project= $this->data_obj->get_project();
            }
            
            if (empty($this->clients)) {
                $this->clients= $this->data_obj->get_clients();
            }
        
            
            if ($this->i_var['date_letter'] && $this->project) {
                $this->project['date_letter']= $this->i_var['date_letter'];
                $this->i_var['date_letter']= null;
            }
                    
                
            if (!$this->project) {
                $t->set_var("id_letter", $data['id_proj'], true);
            
                $this->throw_msg("error", "project_not_found", "the project was not found, in met#set_data
								, cls#letter_preview_handler");
                $this->is['displayable']= false;
            }
            
            
            if (!$this->clients || !is_array($this->clients)) {
                $t->set_var("id_proj", $data['id_proj'], true);
            
                $this->throw_msg("error", "invalid_clients", "var#clients not found or not valid, in met#set_data
								, cls#letter_preview_handler");
                $this->is['displayable']= false;
            }
        }
        
        
        $this->fields['title_letter']= $this->letter['title_letter'];
        $this->fields['id_letter']= $this->letter['id_letter'];

        $this->letter['body_letter']="";

    
        $this->project['total_cc']= is_numeric($_REQUEST['total_cc']) ? $_REQUEST['total_cc'] :
                                    (isset($this->project['total_cc']) ? $this->project['total_cc'] : 0);
                                

        $num= 1;
        
        while ($num <= $s->max_letter_num_pages) {
            if (!empty($this->letter["body_letter".$num])) {
                $this->fields["body_letter".$num]= &$this->letter["body_letter".$num];
                $this->letter['body_letter'] .= $this->letter["body_letter".$num];
            } else {
                break;
            }

            $num++;
        }
    }
    
    

    
    
    
    public function start()
    {
        global $s;

    
        if (!$_REQUEST['preview'] && $this->letter && $this->project && $this->clients) {
            $num= 1;
        
            while ($num <= $s->max_letter_num_pages) {
            
            // reference of letter passed to method
                $this->has['processed_letter']= process_letter::process(
                $this->letter["body_letter".$num],
                $this->project,
            $this->clients,
                $this->separator
            );
            
                $num++;
            }
            
        
            if ($_REQUEST['process_preview']) {
                $this->letter['body_letter']="";
            
                $num= 1;
        
                while ($num <= $s->max_letter_num_pages) {
                    if (!empty($this->letter["body_letter".$num])) {
                        $this->letter["body_letter".$num]= "<div class=\"wrap_page_a4\"><div class=\"page_a4\">".
                        $this->letter["body_letter".$num]."</div></div>";
                    
                        $this->letter['body_letter'] .= $this->letter["body_letter".$num];
                    } else {
                        break;
                    }
                    
                    $num++;
                }
            }
        }
    }

    
    
    
    
        
    public function display_submit()
    {
        global $s, $m, $u, $t;


        echo "<div class=\"submit_section\">";

        if ($this->has['submit']) {
            $post_id_print_letter= $m->post_id_print_letter;


            if ($_REQUEST['preview']) {
                echo <<<HTML

<input type="submit" class="back_submit_button" name="back_from_preview" value="{$t->back}"/>

<input type="hidden" name="id_letter" value="{$_REQUEST['id_letter']}"/>
<input type="hidden" name="id_proj" value="{$_REQUEST['id_proj']}"/>

HTML;

                $num= 1;
        
                while ($num <= $s->max_letter_num_pages) {
                    if (!empty($_REQUEST["body_letter".$num])) {
                        echo <<<HTML

<textarea style="display:none;" name="body_letter{$num}">{$_REQUEST["body_letter".$num]}</textarea>

HTML;
                    } else {
                        break;
                    }
                    
                    $num++;
                }
            } elseif ($_REQUEST['process_preview']) {
                buttons::back(true);
            }
            
        
        
            if ($this->has['save']) {
                $total_cc= is_numeric($_REQUEST['total_cc']) ? $_REQUEST['total_cc'] : 0;
        
                echo <<<HTML

<div class="wrap_save_print_letter">

<span class="letter_params">

<span class="form_label">{$t->total_cc}:</span>
<input name="total_cc" value="{$total_cc}"
	type="text" size="3" maxlength="3"/>

</span>

<input type="submit" class="submit_button" name="save_print_letter" value="{$t->add_to_print_list}"/>

</div>

HTML;
            }
            
            
            if (!$_REQUEST['preview'] && !$_REQUEST['process_preview']) {
                if (is_array($post_id_print_letter) && (count($post_id_print_letter) > 1)) {
                    echo <<<HTML

<input type="submit" class="submit_button" name="next_edit" value="{$t->next}"/>

HTML;
                }
                            
        
                echo <<<HTML

<input type="submit" class="submit_button" name="preview" value="{$t->preview}"/>

HTML;
            } elseif ($_REQUEST['process_preview']) {
                if (is_array($post_id_print_letter) && (count($post_id_print_letter) > 1)) {
                    echo <<<HTML

<input type="submit" class="submit_button" name="next_process_preview" value="{$t->next}"/>

HTML;
                }
            }
    
        
        
            if ($u->is_admin() && $this->has['print']) {
                echo <<<HTML

<input type="submit" class="submit_button" name="print_selected" value="{$t->print}"/>

HTML;
        
                if (is_array($post_id_print_letter) && (count($post_id_print_letter) > 1)) {
                    echo <<<HTML

<input type="submit" class="submit_button" name="memory_print_all" value="{$t->print_all}"/>

HTML;
                }
            }
        }
        
        echo "</div>";
    }
    
    
    
    
    
    
    public function display_letter_preview()
    {
        global $u, $m;


        if ($u->dept_has_write_letter && $u->has_print_letter) {
            $class="letter";
        } else {
            $class="not_admin_letter";
        }
        
    
        $m->window_shadow_id="prt_window_shadow";
        $m->window_id="prt_window";
    
        $this->letter['body_letter']= process_letter::translate_style_tags($this->letter['body_letter']);
    
        echo <<<HTML

<div class="cleared">&nbsp;</div>

<div class="{$class}">{$this->letter['body_letter']}</div>

HTML;
    }
    
    
    
    
    
    
    public function display()
    {
        global $t;
    
        if ($this->is['displayable']) {
            if ($_REQUEST['preview'] || $_REQUEST['process_preview']) {
                if ($this->has['form']) {
                    $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
                }
                    
                if ($this->has['submit']) {
                    $this->display_submit();
                }
                    
                $this->display_letter_preview();
                                
                if ($this->has['form']) {
                    echo "</form>";
                }
            } elseif (!$_REQUEST['preview'] && !$this->has['processed_letter']) {
                $this->display_title();
            
                $error_regis= process_letter::get_error_regis();
            
                if ($error_regis) {
                    buttons::back(true);
                
                    echo $error_regis;
                } else {
                    f1::echo_error("Unexpected, in met#display, cls#letter_preview_handler");
                }
            } else {
                $this->display_title();
            
                parent::display();
            }
        } else {
            $this->display_title();
        
            echo $this->no_result_msg;
        }
    }
}
