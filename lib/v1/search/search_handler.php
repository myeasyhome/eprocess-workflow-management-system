<?php




class search_handler extends form_handler
{
    protected $selectors;




    public function initialize()
    {
        global $m, $c, $t;


        parent::initialize();

        $this->option = $m->search_option;
        $m->destroy_data("search_option");

        $search_form= $this->option."_form";

        $this->forms[0]= new $search_form();
        $this->forms[1]= new $search_form();
        $this->forms[2]= new $search_form();
        $this->forms[3]= new $search_form();

        $this->selectors[0]= new select_file_type();
        $this->selectors[1]= new select_department();
        $this->selectors[2]= new select_department();

        $this->selectors[0]->initialize();
        $this->selectors[1]->initialize();
        $this->selectors[2]->initialize();

        $this->initialize_forms();

        $this->selectors[1]->set_option("all");

        $this->forms[0]->set_option("file");
        $this->forms[1]->set_option("client");
        $this->forms[2]->set_option("dates");
        $this->forms[3]->set_option("project");
    }
    
    
    
    
    public function config()
    {
        global $m, $s, $t;
    
        parent::config();

        //-----------------------------

        $this->set_title($t->search, "h2");

        $this->selectors[0]->config();
        $this->selectors[1]->config();
        $this->selectors[2]->config();

        $this->selectors[0]->set_default($t->unknown);
        $this->selectors[1]->set_select_name("dept_comingfrom");
        $this->selectors[2]->set_select_name("id_dept");


        // spread to form members with method
        $this->i_var['form_name']= "search";
        $this->i_var['form_method']= "GET";
        $this->initialize_global_var($this->i_var['form_method']);
        $this->i_var['target_url']= $s->root_url."?v=search";

        $m->no_print_button= true;
    }
    
    
    
    
    
    public function is_validated()
    {
        global $s;


        if ($this->option == "private_search") {
            $fields= $s->private_search_fields;
        } elseif ($this->option == "public_search") {
            $fields= $s->public_search_fields;
        }
        
        //--------------------
        
        $is_empty= true;

        for ($i=0; $i < count($fields); $i++) {
            if ($_GET[$fields[$i]]) {
                $is_empty= false;
            }
        }

        if (!$is_empty && parent::is_validated()) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    public function onsubmit()
    {
        global $m;

    
        $_REQUEST['id_file']= isset($_REQUEST['num_file']) ? $_REQUEST['num_file'] : null;
        $_GET['id_file']= isset($_REQUEST['id_file']) ? $_REQUEST['id_file'] : null;

        if (($_GET['form_name'] == $this->i_var['form_name'])
        && $this->is_validated()) {
            $this->results= new list_search_results_c1();
            $this->results->initialize();
            $this->results->set_option($this->option);
            $this->results->config();
            $this->results->set_data();
            $this->results->start();
        
            $this->has['results']= true;
            
            $m->no_print_button= false;
        } elseif (($_REQUEST['form_name'] == $this->i_var['form_name']) && !$this->in_cancel_mode()) {
            $this->is['submitted']= true;
            $this->set_has("update_data_from_global", true);
        }
    }
    
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        parent::set_data();

        $this->selectors[0]->set_data();
        $this->selectors[1]->set_data();
        $this->selectors[2]->set_data();
    }
    
    
    
    
    
    public function display_submit()
    {
        global $t;
        
        echo <<<HTML

<input type="hidden" name="v" value="{$this->option}" />

<input type="submit" class="search_button" name="submit" value="{$t->search}"/>

HTML;
    }
    
    
    
    
    public function display_skeleton()
    {
        global $t;

        $this->display_title();

        echo <<<HTML

<div class="col">

<div class="form_group"><div class="margin">
<h3 class="title">{$t->file}:</h3>
HTML;

        if ($this->option == "private_search") {
            echo <<<HTML
<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->file_type}:</p>
HTML;

            $this->selectors[0]->display();

            echo "</{$this->sections_tag}>";

            echo <<<HTML
<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_dept_comingfrom}:</p>
HTML;

            $this->selectors[1]->display();

            echo "</{$this->sections_tag}>";
        }

        $this->forms[0]->display();

        if ($this->option == "private_search") {
            echo <<<HTML
<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->name_dept}:</p>
HTML;

            $this->selectors[2]->display();

            echo "</{$this->sections_tag}>";
        }

        echo "</div></div>"; // closes margin and group

        //------------------------------------

        if ($this->option == "private_search") {
            echo <<<HTML
<div class="form_group"><div class="margin">
<h3 class="title">{$t->date}:</h3>
HTML;

            $this->forms[2]->display();

            echo "</div>"; // closes margin
        }

        echo "</div></div>"; // closes  group and col

        //-----------------------------------------

        echo <<<HTML

<div class="col">

<div class="form_group"><div class="margin">
<h3 class="title">{$t->client}:</h3>
HTML;

        $this->forms[1]->display();

        echo "</div></div>";

        //----------------------------------------------

        echo <<<HTML
<div class="form_group"><div class="margin">
<h3 class="title">{$t->project}:</h3>
HTML;

        $this->forms[3]->display();

        echo "</div></div></div>";  // closes margin, group and col
    }
    
    
    
    
    
    public function display()
    {
        global $m;
    
        if ($this->has['results']) {
            $this->results->display();
        } else {
            echo "<div class=\"wrap_search_form\">";
        
            parent::display();
        
            echo "</div>";
        }
    }
}
