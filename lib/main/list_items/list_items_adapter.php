<?php



abstract class list_items_adapter extends list_items
{
    protected $selected;



    public function config()
    {
        parent::config();

        $this->i_var['form_method']= "GET";

        $this->has['headings']= true;
        $this->has['submit']= true;
        $this->has['ask_delete']= true;
        $this->has['edit']= true;
        $this->has['delete']= true;
        $this->has['form']= true;
        $this->has['radio']= true;

        $this->has['open_main_table']= true;
        $this->has['close_main_table']= true;
    }
    
    
    
    
    
    public function config_paging()
    {
        $this->i_var['paging_open_nav']="<tr class=\"paging_tr\"><td colspan=".(count($this->display_list)+1).">";
        $this->i_var['paging_close_nav']="</td></tr>";
    }
    
    
    


    public function display_checkbox()
    {
        global $t, $u;

        if (is_array($this->selected)
                && in_array($this->data[($this->id_tag)], $this->selected)) {
            echo "<input type=\"checkbox\" name=\"{$this->id_tag}[]\" 
		value=\"{$this->data[($this->id_tag)]}\" checked=\"yes\" />";
        } else {
            echo "<input type=\"checkbox\" name=\"{$this->id_tag}[]\"	value=\"{$this->data[($this->id_tag)]}\" />";
        }
    }
    
    
    
    
    
    
    public function display_radio()
    {
        global $t, $u;


        if ($this->selected
                && ($this->data[($this->id_tag)] == $this->selected)) {
            echo "<input type=\"radio\" name=\"{$this->id_tag}\" 
		value=\"{$this->data[($this->id_tag)]}\" checked=\"yes\" />";
        } else {
            echo "<input type=\"radio\" name=\"{$this->id_tag}\"	value=\"{$this->data[($this->id_tag)]}\" />";
        }
    }

    
    


    public function display_submit()
    {
        global $u, $t;

        
        if (!$u->is_logged_in("zn_operator")) {
            return;
        }
        
        
        if ($this->is_data_ready() && ($this->numrows >= 1)) {
            $data_ready= true;
        }

        
        if ($this->has['save'] && $data_ready) {
            echo <<<HTML

<input type="submit" class="submit_button" name="save_{$this->subject}" value="{$t->save}"/>

HTML;
        }
        


        if ($this->has['edit'] && $data_ready) {
            echo <<<HTML


<input type="submit" class="submit_button" name="edit_{$this->subject}" value="{$t->edit}"/>



HTML;
        }

        
        
        if ($this->has['create']) {
            echo <<<HTML

<input type="submit" class="submit_button" name="create_{$this->subject}" value="{$t->create}"/>

HTML;
        }
        
        
        if ($data_ready && ($this->has['delete'] && (!$this->is['new'] || (!$this->is['new']
            && !($_REQUEST["ask_delete_".$this->subject] && $this->selected))))) {
            echo <<<HTML


<input type="submit" class="submit_button" name="ask_delete_{$this->subject}" value="{$t->delete}"/>



HTML;
        }
    }
    
    
    
    
    
    public function display_extra()
    {
    }
    
    
    
    
    
    public function display_filter_box()
    {
        global $m, $t;


        if ($_GET['print_page'] || ($m->view_ref == "transfer_file") || ($m->view_ref == "transfer_project")
            || ($m->view_ref == "file_history") || ($m->view_ref == "project_history")) {
            return;
        }
        

        $id_tag= isset($this->i_var['filter_id_tag']) ? $this->i_var['filter_id_tag'] : $this->id_tag;

        $label= "search_".$id_tag;

        $submitted= (is_numeric($_REQUEST["filter_".$id_tag])) ? $_REQUEST["filter_".$id_tag] : null;


        $this->open_form("filter_box", "GET", $this->i_var['current_url']);
    
        echo <<<HTML

<div class="wrap_filter_box">

<span class="filter_params">

<span class="form_label">{$t->$label}:</span>
<input name="filter_{$id_tag}" value="{$submitted}" type="text" size="20" maxlength="20"/>

</span>

<input type="submit" class="submit_button" name="submit" value="{$t->search}"/>

</div>

</form>

HTML;

        if (is_numeric($_REQUEST["filter_".$id_tag])) {
            $name= $this->i_var['id_tag'];
        
            $value= &$_REQUEST["filter_".$id_tag];
        
            echo <<<HTML

<div class="search_param" >

<span class="title">{$t->search_parameters}:</span>
<span>{$t->$name} ( <strong>{$value}</strong> ) </span>

</div>

HTML;
        }
    }
    
    
    
    
    
    public function display()
    {
        global $s;
    
    
        if (!$this->is['displayable']) {
            return;
        } elseif ($this->is['empty']) {
            echo "<div class=\"no_result_msg\">{$this->no_result_msg}</div>";
            return;
        }
        
        //-------------------------------
        
        $this->display_title();
        
        //----------------------------
        
        if ($this->has['form']) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        }

        if ($this->has['ask_delete'] && ($this->selected || $this->id) && $_REQUEST["ask_delete_".$this->subject]) {
            $this->ask_delete();
        }


        if ($this->has['open_main_table']) {
            echo "<div class=\"wrap_main_table\">".$s->open_main_table;
        } //---div with html table tag


        if ($this->has['headings'] && ($this->numrows >= 1)) {
            $this->display_headings();
        }
        
        parent::display();

        if ($this->has['close_main_table']) {
            echo "</table></div>";
        } // closes main table


        $this->display_extra();
    
        
        if ($this->has['submit']) {
            $this->display_submit();
        }
    
        if ($this->has['form']) {
            echo "</form>";
        }
    }
}
