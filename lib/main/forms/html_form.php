<?php





/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/





class html_form extends website_object
{
    protected $fields;
    protected $fields_list;
    protected $field_param;
    protected $sections_class;
    protected $sections_tag;
    protected $compulsory_notice;
    protected $global_var; // $_POST or $_GET
    protected $shelf;

    
    public function initialize()
    {
        parent::initialize();

        self::$instance_counter++;

        $this->global_var= array();

        $this->is_numeric= array();

        $this->ignore= array();

        $this->is['form']= true;

        $this->has['update_data_from_global']= false;

        $this->i_var['form_name']= "form".self::$instance_counter;
        $this->i_var['writable_var_list'][]="form_name";

        $this->i_var['form_method']= "POST";

        $this->initialize_global_var($this->i_var['form_method']);

        $this->i_var['target_url']= $this->i_var['current_url'];
        $this->i_var['submit_name']= "submit";
        $this->i_var['submit_value']= $t->submit;
        $this->i_var['update_password_from_global']= false;
        $this->i_var['category_name']= $t->category_name;
        $this->i_var['select_day_list']= array();
        $this->i_var['submit_wrap_tag']= "div";

        $this->i_var['input_size']="90";
        $this->i_var['input_maxlength']="90";

        $this->i_var['textarea_rows']="6";
        $this->i_var['textarea_cols']="30";

        $this->i_var['select_orientation']="right";

        $this->has['one_data_row']= true;
        $this->has['compulsory_sign']= true;
        $this->has['form']= true;
        $this->has['submit']= true;
        $this->has['validate_email']= true;
        $this->has['confirm_email']= true;

        $this->has['display_skeleton_up']= true;
        $this->has['display_skeleton_down'];

        $this->is['always_validated']= false;

        $this->data= array();
        $this->fields= array();
        $this->ignore= array();
        $this->fields_list= array();
        $this->field_param= array();
        $this->sections_tag="div";
        $this->sections_class= $this->i_var['sections_class']= "form_section";
        $this->compulsory_notice= "";
        $this->main_sections= array();
        $this->shelf=array();
    }
    
    
    
    
    
    
    public function config()
    {
    }
    
    
    
    
    
    
    
    protected function define_form($option="")
    {
        $fields= array();
        $this->ignore=array();

        $this->make_sections("text_input", 0);

        $this->set_fields($fields);
    }

    
    
    
    
    
    
    public function set_fields($_var)
    {
        global $c, $s, $m, $t, $q, $u;


        if (is_array($_var)) {
            foreach ($_var as $name) {
                $this->fields_list[]= $name;
                $this->fields[$name]= "";
                $this->field_param[$name]=array();
            }
        } elseif (is_string($_var)) {
            $this->fields_list[]= $_var;
            $this->fields[$_var]= "";
            $this->field_param[$_var]=array();
        } else {
            f1::echo_error("#func \"set_fields\" failed, in html_form");
        }
    }
    
    
    

    
    public function get_fields()
    {
        return $this->fields;
    }
    
    
    
    
    
    
    public function add_select_array($name, $list)
    {
        if (is_array($list)) {
            $this->shelf[$name]= $list;
        } else {
            f1::echo_error("no array in cls#html_form, met#add_select_array");
        }
    }
    
    
    
    
    
    
    public function add_select_object($name, &$obj)
    {
        if (!isset($this->i_var['count_select_objects'])) {
            $this->i_var['count_select_objects']= 0;
        }
        
        
        if ($obj->is_data_ready()) {
            $this->i_var['count_select_objects']++;
        
            $this->fields_list[]= $name;
            $this->fields[$name]= "";
            $this->field_param[$name]=array();
        
            $this->shelf[$name]= &$obj;
        } else {
            f1::echo_warning("object not data ready in cls#html_form, met#add_select_object");
        }
    }
    
    
    
        
    
    
    public function set_ignore($name)
    {
        $this->ignore[]= $name;
    }
    
    
    
    
    
    public function get_ignore()
    {
        return $this->ignore;
    }
    
    
    
    
    
    public function set_data($name="", $value=null)
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$this->is['new'] || $this->is['submitted']) {
            if (($name == "all_data") && in_array($name, $this->i_var['writable_data_list'])) {
                $this->data= $value;
            } elseif ($name) {
                f1::echo_error("met#set_data, to #arg \"{$name}\", failed in #cls ".get_class($this));
                return;
            }
            
            //-------------------------------

            if ($this->has['update_data_from_global'] && $this->global_var) {
                $this->update_data_from_global();
            } elseif ($this->data_source) {
                $this->set_data_from_database();
            }

            //--Update fields and session memory from local memory
            if (!empty($this->data)) {
                $this->validate_data();
                $this->update_from_data_source();
            }
        }
    }

        
        
        
        
        
        
    public function update_data_from_global()
    {

    // Update local memory from global ($_POST or $_GET)
        $this->data= array_merge($this->data, $this->global_var);
    }
        
        
        
        
        
        
    protected function update_from_data_source()
    {
        global $c, $s, $m, $t, $q, $u;

        foreach ($this->fields as $name => $value) {
            if (isset($this->data[$name])) {
                $this->fields[$name]= $this->data[$name];
            }
        }
    }

    
    
    
    
    
    
    public function get_fields_list()
    {
        return $this->fields_list;
    }
    
    
    
    
    
    public function mk_skeleton()
    {
        foreach ($this->fields_list as $name) {
            echo <<<HTML

<div id="dt_{$name}" class="data">
<span class="label">{\$t->{$name}}:</span>
<span class="value">{\$this->data['{$name}']}</span>
</div>

HTML;
        }
    }
    
    
    
    
    
        
    public function set_field_default($name, $value)
    {
        $this->field_param[$name]['default']= $value;
    }

    
    
    
    
    
    
    public function use_field_default($name)
    {
        if ($this->field_param[$name]['default']) {
            $this->fields[$name]= $this->field_param[$name]['default'];
        }
    }
    
    
    
    
    
    
    public function set_selected_field($name, $value)
    {
        $this->field_param[$name]['selected']=  $value;
    }

    
    
        
    
    
    
    
    public function make_sections($string, $number= -1)
    {
        if (!isset($this->i_var['section_counter'])) {
            $this->i_var['section_counter']= 0;
        }
    
    
        switch ($string) {
        
case "date_select":
case "select_number":
case "object_section":
case "input_text":
case "password":
case "textarea":
case "select_country":
case "file":
case "combo":
case "checkbox":
case "radio":
case "input_address":
case "hidden":


            if (!$this->main_sections[$string]) {
                $this->main_sections[$string]= $number;
                $this->i_var['section_counter']++;
            } else {
                $string .= $this->i_var['section_counter'];
                $this->main_sections[$string]= $number;
                $this->i_var['section_counter']++;
            }
break;
            
        }
    }


    
    
    
    public function onsubmit()
    {
    }
    
    
    
    
    public function display_skeleton()
    {
    }
    
    
    
    
    
    public function display()
    {
        if (!$this->is['displayable']) {
            return;
        }
        
        
        if ($this->title) {
            $this->display_title();
        }
                
        
        if (!$this->main_sections) {
            $this->main_sections= array("input_text" => 1);
        }
        
        if ($this->has['form']) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        }
        

        if (($this->selected || $this->id) && $this->has['delete'] && $_REQUEST["ask_delete_".$this->subject]) {
            $this->ask_delete();
        }
        
                
                        
        if ($this->has['display_skeleton_up']) {
            $this->display_skeleton();
        }

    
    
        reset($this->fields);

        foreach ($this->main_sections as $type=>$number) {
            if ($number <= 0) {
                $number= 1;
            }
            
            while (($number > 0) && (list($key, $value)=each($this->fields))) {
                if (strpos($type, "input_text") !== false) {
                    $this->input_text_section($key);
                } elseif (strpos($type, "textarea") !== false) {
                    $this->textarea_section($key);
                } elseif (strpos($type, "file") !== false) {
                    $this->upload_file_section($key);
                } elseif (strpos($type, "select_number") !== false) {
                    $this->select_number($key);
                } elseif (strpos($type, "date_select") !== false) {
                    $this->date_select($key);
                } elseif (strpos($type, "object_section") !== false) {
                    $this->object_section($key);
                } elseif (strpos($type, "select_country") !== false) {
                    $this->select_country($key);
                } elseif (strpos($type, "combo") !== false) {
                    $this->combo_section($key);
                } elseif (strpos($type, "checkbox") !== false) {
                    $this->checkbox_section($key);
                } elseif (strpos($type, "radio") !== false) {
                    $this->radio_section($key);
                } elseif (strpos($type, "hidden") !== false) {
                    $this->input_hidden($key);
                } elseif (strpos($type, "address") !== false) {
                    $this->input_address($key);
                } elseif (strpos($key, "password") !== false) {
                    $this->input_password($key);
                    $number--;
                    continue;
                } else {
                    $this->input_text_section($key);
                }
                
                //------------------------------------------------------------------
                
                $this->i_var['sections_class']= $this->sections_class;	// reset
                $number--;
            }
        }
        
        
                
        if ($this->has['display_skeleton_down']) {
            $this->display_skeleton();
        }
            
            
        if ($this->has['submit']) {
            $this->display_submit($this->i_var['submit_name'], $this->i_var['submit_value'], $this->i_var['submit_wrap_tag']);
        }
        
        
        if ($this->has['form']) {
            echo "</form>";
        }
    }
    
    
    
    
    
    
    
    public function input_text_section($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->use_field_default($name);

        $this->set_compulsory_notice($name);


        //-------------------
        $comment="";

        if ($this->field_param[$name]['format'] == "date") {
            $comment=$t->correct_date_format;
        } elseif ($this->field_param[$name]['format'] == "month") {
            $comment=$t->correct_month_format;
        } elseif ($this->field_param[$name]['format'] == "year") {
            $comment=$t->correct_year_format;
        }

        //---------------------------------


        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>
<input name="{$name}" value="{$this->fields[$name]}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
	<span class="form_comment">{$comment}</span>	
</{$this->sections_tag}>

HTML;
    }






    
    public function input_password($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->set_compulsory_notice($name);

        //--------------------

        $value= "";


        if ($this->i_var['update_password_from_global']) {
            $value= $this->fields[$name];
        }
        
        //----------------------------
                
        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}{$this->compulsory_notice}</p>
<input name="{$name}" value="{$value}"
	type="password" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
	
</{$this->sections_tag}>

HTML;
    }
    
    
    
    
    
    
    public function textarea_section($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->use_field_default($name);
        $this->set_compulsory_notice($name);


        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

<textarea name="{$name}" rows="{$this->i_var['textarea_rows']}" cols="{$this->i_var['textarea_cols']}">
{$this->fields[$name]}
</textarea>

</{$this->sections_tag}>

HTML;
    }
    
        
    
    
    public function combo_section($name)
    {
        global $c, $s, $m, $t, $q, $u;

        if (is_array($this->shelf[$name])) {
            $this->set_compulsory_notice($name);

            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

<select name="{$name}">
HTML;

            for ($i=0; $i < count($this->shelf[$name]); $i++) {
                $ref= $this->shelf[$name][$i];
             
             
                if (!empty($this->field_param[$name]['default'])) {
                    $default= $this->field_param[$name]['default'];
                    echo "<option value=\"-1\" >{$t->$default}</option>";
                    unset($this->field_param[$name]['default']);
                }
                
             
                if (isset($this->field_param[$name]['selected'])
                    && ($this->field_param[$name]['selected'] == $this->shelf[$name][$i])) {
                    echo "<option value=\"{$i}\" selected >{$t->$ref}</option>";
                } else {
                    echo "<option value=\"{$i}\" >{$t->$ref}</option>";
                }
            }

            echo "</select></{$this->sections_tag}>";
        }
    }
    
    
    
    
    
    
    public function checkbox_section($name)
    {
        global $c, $s, $m, $t, $q, $u;

        if (is_array($this->shelf[$name])) {
            $this->set_compulsory_notice($name);

            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

HTML;

            for ($i=0; $i < count($this->shelf[$name]); $i++) {
                $ref= $this->shelf[$name][$i];
             
                if ($this->i_var['select_orientation'] == "left") {
                    echo "<span class=\"check_option\">{$t->$ref}</span>";
                }
                
                if (is_array($this->field_param[$name]['selected'])
                    && in_array($this->shelf[$name][$i], $this->field_param[$name]['selected'])) {
                    echo "<input type=\"checkbox\" name=\"{$name}\" value=\"{$i}\" checked=\"yes\" />";
                } else {
                    echo "<input type=\"checkbox\" name=\"{$name}\"	value=\"{$i}\" />";
                }
                
                if ($this->i_var['select_orientation'] == "right") {
                    echo "<span class=\"check_option\">{$t->$ref}</span>";
                }
            }

            echo "</{$this->sections_tag}>";
        }
    }
    
    
    
    
    
    
    
    public function radio_section($name)
    {
        global $c, $s, $m, $t, $q, $u;

        if (is_array($this->shelf[$name])) {
            $this->set_compulsory_notice($name);

            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<{$this->sections_tag} class="wrap_form_radio">
<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

HTML;


            for ($i=0; $i < count($this->shelf[$name]); $i++) {
                $ref= $this->shelf[$name][$i];
             
                if ($this->i_var['select_orientation'] == "left") {
                    echo "<span class=\"radio_option\">{$t->$ref}</span>";
                }
                
                if (isset($this->field_param[$name]['selected'])
                    && ($this->field_param[$name]['selected'] == $this->shelf[$name][$i])) {
                    echo "<input type=\"radio\" name=\"{$name}\" value=\"{$i}\" checked=\"yes\" />";
                } elseif (isset($this->field_param[$name]['default'])
                    && ($this->field_param[$name]['default'] == $this->shelf[$name][$i])) {
                    echo "<input type=\"radio\" name=\"{$name}\" value=\"{$i}\" checked=\"yes\" />";
                } else {
                    echo "<input type=\"radio\" name=\"{$name}\" value=\"{$i}\" />";
                }
                
                if ($this->i_var['select_orientation'] == "right") {
                    echo "<span class=\"radio_option\">{$t->$ref}</span>";
                }
            }

            echo "</{$this->sections_tag}></{$this->sections_tag}>";
        }
    }
    
    
    
    
    
    
    public function object_section($name)
    {
        global $c, $s, $m, $t, $q, $u;

        if ($this->shelf[$name]) {
            $this->set_compulsory_notice($name);

            echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">
<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

HTML;

            $this->shelf[$name]->display();

            echo "</{$this->sections_tag}>";
        } else {
            f1::echo_warning("no object to display in 
							met#object_section, cls#html_form");
        }
    }
    
    
    
    
    
    
    public function select_country($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $file= "lib/main/countries/countries_".$s->language_ref.".txt";

        $this->use_field_default($name);

        $this->set_compulsory_notice($name);


        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

<select name="{$name}">

HTML;

        $c->insert_file($file);

        echo "</select></{$this->sections_tag}>";
    }
    
    
    
    
    
    
    public function upload_file_section($name)
    {
        global $c, $s, $m, $t, $q, $u;

        $input_size= $this->i_var['input_size'] + 10;
        $input_maxlength= $this->i_var['input_maxlength'] + 10;


        $this->set_compulsory_notice($name);


        // display image -- disabled because of cache problem...
        //if ( $this->has['image'] && $this->data['file_id'] )
        //$this->display_image ($this->data['file_id'], "edit_image");

        
        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>
<input name="{$name}" value="{$this->fields[$name]}"
	type="file" size="{$input_size}" maxlength="{$input_maxlength}"/>
	
</{$this->sections_tag}>

HTML;
    }
    
    
    
    
    

    public function input_hidden($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->use_field_default($name);
    
        echo <<<HTML

<input name="{$name}" value="{$this->fields[$name]}"
	type="hidden" />

HTML;
    }






    
    public function select_number($name)
    {
        global $c, $s, $m, $t, $q, $u;

        if (!$this->field_param[$name]['max']) {
            $this->config_select_number($name, 1, 10);
        } // default



        $min= $this->field_param[$name]['min'];
        $max= $this->field_param[$name]['max'];


        //-------------

        if (isset($this->fields[$name])) {
            $selected= $this->fields[$name];
        }

        //-------------------


        echo "<div id=\"\" class=\"\" >".
    "<p class=\"form_label\">{$t->$name}</p>";
    
    
        echo "<select name=\"".$name."\">";

        for ($i=$min;$i<=$max;$i++) {
            if ($i == $selected) {
                echo "<option value=\"".$i."\" selected >".$i."</option>";
            } else {
                echo "<option value=\"".$i."\">".$i."</option>";
            }
        }

        echo "</select>";

        echo "</div>";
    }

    
    
    
    
        
    
    public function config_select_number($name, $min, $max)
    {
        global $c, $s, $m, $t, $q, $u;

        $this->field_param[$name]['min']= $min;
        $this->field_param[$name]['max']= $max;
    }
    
    
    
    
    
    
    
    
    public function get_date_select($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->fields['day']= $this->fields['day'] ? $this->fields['day'] : date("j", time());
        $this->fields['month']= $this->fields['month'] ? $this->fields['month'] : date("n", time());
        $this->fields['year']= $this->fields['year'] ? $this->fields['year'] : date("Y", time());
    
    
        //-------- select day

        echo "<div id=\"\" class=\"\" >".
    "<p class=\"form_label\">{$t->$name}</p>";
    
    
        if ($this->field_param[$name]['invalid']) {
            echo "<span class=\"form_warning\">{$t->invalid_selected_date}</span>";
        }
    
    
        if ($name == "day") {
            echo "<span class=\"date_select\"><select name=\"day\" >";
        
            for ($i=1;$i<=31;$i++) {
                if ($i == $this->fields['day']) {
                    echo "<option value=\"".$i."\" selected >".sprintf("%02d", $i)."</option>";
                } else {
                    echo "<option value=\"".$i."\">".sprintf("%02d", $i)."</option>";
                }
            }
            
            echo "</select></span>";
        }
    
        //-----------------Select a month------------------------------------------------------------

        if ($name == "month") {
            echo "<span class=\"date_select\"><select name=\"month\">";

            $months= $t->list_months;
        
            echo "<option value=\"\" selected >------------------------------</option>";

            for ($i=1;$i <= 12;$i++) {
                if ($i == $this->fields['month']) {
                    echo "<option value=\"".$months[($i-1)]."\" selected >".$months[($i-1)]."</option>";
                } else {
                    echo "<option value=\"".$months[($i-1)]."\">".$months[($i-1)]."</option>";
                }
            }
            
            echo "</select></span>";
        }

        //--------Select a year

        if ($name == "year") {
            echo "<span class=\"date_select\"><select name=\"year\">";
        
            echo "<option value=\"\" selected >------------------------------</option>";
            
            if ($this->i_var['years_select'] == "after") {
                $years = date("Y", strtotime(("+ ".$this->i_var['max_years_select'])." year"));

                for ($i=date("Y");$i<=$years;$i++) {
                    if ($i == $this->fields['year']) {
                        echo "<option value=\"".$i."\" selected >".$i."</option>";
                    } else {
                        echo "<option value=\"".$i."\" >".$i."</option>";
                    }
                }
            } elseif ($this->i_var['years_select'] == "before") {
                $years = date("Y", strtotime(("- ".$this->i_var['max_years_select'])." year"));

                for ($i=$years;$i<=date("Y");$i++) {
                    if ($i == $this->fields['year']) {
                        echo "<option value=\"".$i."\" selected >".$i."</option>";
                    } else {
                        echo "<option value=\"".$i."\" >".$i."</option>";
                    }
                }
            }
            
            echo "</select></span>";
        }

        echo "</div>";
    }

    
    
    
    
    public function input_address($name)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->use_field_default($name);

        $this->set_compulsory_notice($name);


        echo <<<HTML

<{$this->sections_tag} class="{$this->i_var['sections_class']}">

<p class="form_label">{$t->$name}: {$this->compulsory_notice}</p>

<input name="addr1" value="{$this->fields[$name]['addr1']}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
		
<input name="addr2" value="{$this->fields[$name]['addr2']}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
	
HTML;

        $this->i_var['input_size'] -= 20;

        echo <<<HTML

<input name="subtown" value="{$this->fields[$name]['country']}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
	
<input name="town" value="{$this->fields[$name]['town']}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>

<input name="country" value="{$this->fields[$name]['subtown']}"
	type="text" size="{$this->i_var['input_size']}" maxlength="{$this->i_var['input_maxlength']}"/>
	
	
</{$this->sections_tag}>

HTML;
    }
    
    
    
    
    
    
    
    
    public function set_compulsory_notice($name)
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$this->is['active']) {
            return;
        }
        
        
        if (!$this->has['compulsory_sign']) {
            return;
        }
        
        
        if ($_REQUEST["ask_delete_".$this->subject] || $_REQUEST["yes_delete_".$this->subject] || $_REQUEST['cancel']) {
            return;
        }
            
    
        $this->compulsory_notice= "";
        
        
        if (isset($this->global_var[$name])) {
            $this->global_var[$name]= trim($this->global_var[$name]);
        }

        if (in_array($name, $this->ignore)) {
            return;
        } elseif (in_array($name, $this->fields_list)
                    && ($this->global_var['form_name'] == $this->i_var['form_name'])
                        && (empty($this->global_var[$name]) && !is_numeric($this->global_var[$name]))) {
            $this->compulsory_notice= "<span class=\"form_warning\">{$t->fill_form_field}".
                                    "(<span class=\"compulsory_sign\">*</span>)</span>";
        
            $this->i_var['sections_class']="empty_form_section";
        } else {
            $this->compulsory_notice= "<span class=\"compulsory_sign\">*</span>";
        }
    }
    
    
    
    
    
    
    public function is_validated()
    {
        global $c, $s, $m, $t, $q, $u;



        if ($this->is['always_validated']) {
            return true;
        }

        //--------------------------------------------------------------
        
        if ($this->global_var) {
            $form_name= $this->i_var['form_name'];
        
            
            //---Empty form name

            if (empty($form_name)) {
                f1::echo_error("A form without name cannot be validated, set form_name");
            
                return false;
            }
            

            //- Not the same form

            if ($form_name !== $this->global_var['form_name']) {
                $this->i_var['form_not_activated']= true;

                f1::echo_warning("Not the same form, validation failed in #html_form#is_validated");
                
                return false;
            }
                    
            
                        
            if ($_REQUEST["yes_delete_".$this->subject]) {
                return true;
            }
            
            
            if ($_REQUEST["ask_delete_".$this->subject] || $_REQUEST['cancel']) {
                return false;
            }
            
            
                        
            $submitted= array();
            
            foreach ($this->global_var as $name => $value) {
                if (in_array($name, $this->fields_list)) {
                    $value= trim($value);
                    $submitted[]= $name;
                
                
                    // Empty form, not numeric
        
                    if ((empty($value) && !is_numeric($value))
                        && (in_array($name, $this->ignore) === false)) {
                        $this->throw_msg("error", "empty_input");
                    
                        f1::echo_warning("empty input, ref #1, validation failed in #html_form#is_validated");
                    
                        return false;
                    }
                    
                
                    // Empty first array member
                    
                    if (is_array($value) && empty($value[0])) {
                        $this->throw_msg("error", "empty_first_input");
                    
                        f1::echo_warning("empty_first_input, ref #2, validation failed in #html_form#is_validated");
                    
                        return false;
                    }
                
                
                    //---not numeric, numeric required
                    
                    if (in_array($name, $this->is_numeric) && !is_numeric($value) && !empty($value)) {
                        $t->set_var("not_numeric", $t->$name, true);
                        $this->throw_msg("error", "not_numeric_input");
                        
                        f1::echo_warning("not numeric input, validation failed in #html_form#is_validated");
                    
                        return false;
                    }
                
                
                    //---Message too short
                                
                    if (($this->field_param[$name]['format'] == "message")
                        && (strlen($this->global_var[$name]) < 20)) {
                        $this->throw_msg("error", "short_msg");
                    
                        f1::echo_warning("short msg, validation failed in #html_form#is_validated");

                        return false;
                    }
            
            
            
                    if (($this->field_param[$name]['format'] == "date") && !empty($this->global_var[$name])
                            && (!ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $this->global_var[$name])
                            ||	(strlen($this->global_var[$name]) > 10))) {
                        $this->has[$name]= "rejected";
                        $t->set_var("not_date", $t->$name, true);
                        $this->throw_msg("error", "invalid_date_format");
                        return false;
                    }
                
            
            
            
                    if (($this->field_param[$name]['format'] == "month") && !empty($this->global_var[$name])
                        && !ereg("([0-9]{1,2})/([0-9]{4})", $this->global_var[$name])) {
                        $this->has[$name]= "rejected";
                        $t->set_var("not_month", $t->$name, true);
                        $this->throw_msg("error", "invalid_month_format");
                        return false;
                    }
                    
                    
                    
                    if (($this->field_param[$name]['format'] == "year") && !empty($this->global_var[$name])
                        && !ereg("[0-9]{4}", $this->global_var[$name])) {
                        $this->has[$name]= "rejected";
                        $this->throw_msg("error", "invalid_year_format");
                        return false;
                    }
                }
            }

            
            // required but not submitted

            for ($i=0; $i < count($this->fields_list); $i++) {
                $name= $this->fields_list[$i];
            
                if (!in_array($name, $submitted) && !in_array($name, $this->ignore)) {
                    $this->throw_msg("error", "empty_input");
                        
                    f1::echo_warning("empty input, ref #3, validation failed in #html_form#is_validated");
                
                    return false;
                }
            }
            
        
            //----Email address not confirmed properly
                
            if ($this->has['confirm_email'] && $this->global_var['email'] && isset($this->fields['email'])
                    &&	($this->global_var['email'] !== $this->global_var['confirm_email'])) {
                $this->throw_msg("error", "email_mismatch");
            
                f1::echo_warning("email mismatch, validation failed in #html_form#is_validated");

                return false;
            }



            //---Invalid email address
        
            if ($this->has['validate_email'] && $this->global_var['email'] && isset($this->fields['email'])
            && (filter_var($this->global_var['email'], FILTER_VALIDATE_EMAIL) === false)) {
                $this->throw_msg("error", "invalid_email");
            
                f1::echo_warning("invalid email, validation failed in #html_form#is_validated");

                return false;
            }
    
            return true;
        } else {
            return false;
        }
    }
}
