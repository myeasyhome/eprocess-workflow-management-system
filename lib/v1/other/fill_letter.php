<?php



class fill_letter extends website_object
{
    protected $id_proj;
    protected $id_letter;




    public function config()
    {
        global $c, $t, $m;
    
        parent::config();

        $this->has['data']= false;
        $this->is['displayable']= false;

        $this->set_title($t->fill_letter, "h3");

        $data= $m->letter_data;

        if ($data && !empty($data['id_proj'])) {
            $this->id_proj= $data['id_proj'];
            $this->is['displayable']= true;
        }

        if ($data && !empty($data['id_letter'])) {
            $this->id_letter= $data['id_letter'];
            $this->is['displayable']= true;
        }
    }

    
    
    
    
    public function initialize_letter_data()
    {
        global $m;

        if (empty($m->letter_data)) {
            $m->letter_data= array();
        }
    }
    
    
    
    
    
    public function save_letter_data()
    {
        global $m;

        $this->initialize_letter_data();
        
        $data= $m->letter_data;

        $data['id_proj']= $this->id_proj;
        $data['id_letter']= $this->id_letter;

        $m->letter_data= $data;
    }
    
    
    
    
    
    public function get_project()
    {
        return $this->id_proj;
    }
    
    
    
    
    
    public function get_letter()
    {
        return $this->id_letter;
    }
    
    

    
    
    public function onsubmit()
    {
        global $q, $m, $t, $u;


        if ($m->view_ref == "logout") {
            $this->is['displayable']= false;
            $m->letter_data= array();
            return;
        }
        
        //-----------------------------
        
        if ($_REQUEST['cancel_fill_letter']) {
            $this->throw_msg("confirm", "fill_letter_cancelled", "make letter cancelled");
            $this->is['displayable']= false;
            $m->letter_data= array();
            return;
        }
        
    
        if ($_REQUEST['letter_use_project'] && is_numeric($_REQUEST['letter_id_proj'])) {
            $q->set_filter("project1.id_proj='".$_REQUEST['letter_id_proj']."'");
            $proj_dept= $this->set_data_from_id("select_project1", "", "proj_dept");
        
            if ($proj_dept && ($proj_dept != $u->id_dept)) {
                $this->throw_msg("error", "foreign_project_not_usable", "met#onsubmit, 
			cls#".get_class($this).", foreign project");
                $this->is['displayable']= false;
            
                return;
            } elseif (!$proj_dept) {
                $this->throw_msg("error", "action_failed", "met#onsubmit, 
			cls#".get_class($this).", ref#dept_not_found");
                $this->is['displayable']= false;
            }
            

            $this->id_proj= $_REQUEST['letter_id_proj'];
            $this->is['displayable']= true;
            $this->throw_msg("confirm", "letter_project_selected", "projet_selected");
            $this->save_letter_data();
            return;
        }

        
        if ($_REQUEST['letter_use_template'] && $_REQUEST['letter_id_letter']) {
            $this->id_letter= $_REQUEST['letter_id_letter'];
            $this->is['displayable']= true;
            $this->throw_msg("confirm", "letter_template_selected", "projet_selected");
            $this->save_letter_data();
            return;
        }
        
        
        if ($_REQUEST['save_print_letter'] && is_numeric($_REQUEST['total_cc'])
        && $this->id_proj && $this->id_letter) {
            $q->set_filter("AND print_letter1.id_proj='".$this->id_proj."'");
            $this->set_data_from_id("select_print_letter1", "", "", $numrows);
            $q->clear("filter");

            if (isset($numrows) && ($numrows >= 1)) {
                $t->set_var("id_proj", $this->id_proj, true);
                $this->throw_msg(
                        "confirm",
                        "print_letter_project_used",
                                    "#met #onsubmit, class#".get_class($this)
                    );
                    
                $_REQUEST['total_cc']= null;
                $_POST['total_cc']= null;
                    
                return;
            }
        
            $q->set_var("id_user", $u->id);
            $q->set_var("total_cc", $_REQUEST['total_cc']);
            $q->set_var("id_proj", $this->id_proj);
            $q->set_var("id_letter", $this->id_letter);
        
            if (!$q->sql_action("insert_print_letter1")) {
                $this->throw_msg(
                "error",
                "create_failed",
                            "#met #onsubmit, class#".get_class($this)
            );
            
                return;
            }

            $this->throw_msg(
                "confirm",
                "print_letter_project_saved",
                                    "#met #onsubmit"
            );
        } elseif ($_REQUEST['save_print_letter'] && !is_numeric($_REQUEST['total_cc'])) {
            $this->throw_msg(
            "error",
            "print_letter_without_total_cc",
                                    "#met #onsubmit, class#".get_class($this)
        );
        }
    }
    
    
    
    
    public function display()
    {
        global $t, $m, $u;
    
        if ($this->is['displayable']) {
            echo "<div class=\"fill_letter\"><div class=\"wrap_top\">";

        
            $this->display_title();

        
            if ($this->id_proj) {
                echo <<<HTML

<div class="selected_project">
{$t->selected_project}:
<a href="{$s->root_url}?v=project_clients&id_proj={$this->id_proj}">{$this->id_proj}</a>
</div>

HTML;
            } else {
                echo <<<HTML

<div class="select_project">
<a href="{$s->root_url}?v=projects"> >> {$t->select_a_project} << </a>
</div>

HTML;
            }
            
            
            if ($this->id_letter) {
                echo <<<HTML

<div class="select_letter">
{$t->selected_letter}:
<a href="{$s->root_url}?v=preview_letter&id_letter={$this->id_letter}">{$this->id_letter}</a>
</div>

HTML;
            } else {
                echo <<<HTML

<div class="selected_letter">
<a href="{$s->root_url}?v=letters"> >> {$t->select_a_letter} << </a>
</div>

HTML;
            }
            
            echo "</div><div class=\"wrap_down\"><div class=\"wrap_right\">"; // closes #wrap_top
            
            
            if ($this->id_proj && $this->id_letter) {
                echo <<<HTML

<div class="go_to">
<a href="{$s->root_url}?v=letter_preview"> >> {$t->letter_preview} >> </a>
</div>

HTML;
            }
            
    
            echo <<<HTML

<form name="cancel_fill_letter" method="POST" action="{$this->i_var['current_url']}">
<input type="submit" class="submit_button" name="cancel_fill_letter" value="{$t->cancel}"/>
</form>

HTML;
        
            echo "</div></div></div>"; // closes #fill_letter, wrap_down and and #wrap_right
        }
    }
}
