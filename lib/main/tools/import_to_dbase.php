<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/





class import_to_dbase extends website_object
{
    protected $db;
    protected $counter;
    protected $file_ref_list;
    protected $qual_list;

    
    
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;


        $this->file_ref_list= array();
        $this->qual_list= array();


        $this->i_var['form_name']= "selector_form";
        $this->i_var['form_method']= "GET";

        $this->i_var['submit_name']= "import";
        $this->i_var['submit_value']= $t->submit;
        $this->i_var['submit_wrap_tag']="div";

        $this->has['compulsory_sign']= false;
        $this->reference= "import_to_dbase";


        $this->i_var['target_url']= $s->root_url."?v={$_GET['v']}";


        //---Default values---------------------

        $this->i_var['form_name']= "import_to_dbase";

        $this->has['form']= true; // default
$this->has['submit']= true; // default

//----------------------------------------

        $this->counter= 0;
    }
    
    
    
    

    
    public function select_query($dbase, $action)
    {
        if ($_REQUEST['import'] && !empty($_REQUEST['obj'])) {
            if ($dbase == "old_dbase") {
                $dbase_prefix= "old";
            } elseif ($dbase == "new_dbase") {
                $dbase_prefix= "new";
            }
            
        
            switch ($action) {
            
            case "get_dbase_data":
            
            return ($dbase_prefix."_"."select_".$_REQUEST['obj']);
            
            break;
            
            case "update_new_dbase":
            
            return ($dbase_prefix."_"."insert_".$_REQUEST['obj']);
            
            break;
        
            }
        } elseif ($_REQUEST['import']) {
            $this->throw_msg("error", "no_obj_to_import", "cls#".get_class($this).", #met #select_query");
        }
    }
    
    
    
    
    
    
    
    
    public function is_duplicate_file(&$data)
    {
        if (in_array($data['file_ref'], $this->file_ref_list)) {
            return true;
        } else {
            $this->file_ref_list[]= $data['file_ref'];
            return false;
        }
    }

    
    
    
    
    
    
    public function save_qual(&$data)
    {
        global $q;

        $data['diplome']= trim($data['diplome'], ":");
        $data['diplome']= strtolower($data['diplome']);
        $data['diplome']= ucfirst($data['diplome']);
    
        if (in_array($data['diplome'], $this->qual_list)) {
            return;
        } else {
            $this->qual_list[]= $data['diplome'];
            $q->set_var("name_qual", $data['diplome']);
            $q->sql_action("insert_qualification1");
        }
    }
    
    
    
    
    
    
    
    public function onsubmit()
    {
        global $m, $q;


        if ($_REQUEST['reset']) {
            $m->import_results= array();
            $m->id_file_converter1= array();
            $m->id_file_converter2= array();
            $m->id_proj_converter= array();
        }
        
        $import_results= $m->import_results ? $m->import_results : array();


        if (($_REQUEST['obj'] == "project") && !$import_results['file']) {
            $this->throw_msg("error", "import_files_first", "#met #onsubmit, 
								#cls #import_to_dbase, import files first");
            return;
        } elseif (($_REQUEST['obj'] == "id_bordereau") && !$import_results['project']) {
            $this->throw_msg("error", "import_projects_first", "#met #onsubmit, 
								#cls #import_to_dbase, import projects first");
            return;
        } elseif (($_REQUEST['obj'] == "client") && !$import_results['project']) {
            $this->throw_msg("error", "import_projects_first", "#met #onsubmit, 
								#cls #import_to_dbase, import projects first");
            return;
        }

        
        if ($_REQUEST['import'] && !empty($_REQUEST['obj']) && !isset($import_results[$_REQUEST['obj']])) {
        
        //------------------------
        
            $this->select_dbase("old_dbase");
        
            $this->has['one_data_row']= false;

            $this->data_source= $this->select_query("old_dbase", "get_dbase_data");

            $this->set_data_from_database();
        
            //-------------------
        
            $this->select_dbase("new_dbase");
        
            //------------------
        
            if ($this->numrows >= 1) {
                $old_values_corrector= convert_dbase_data::config_old_values();
                $keys_corrector= convert_dbase_data::config_keys();
            
            
                if ($_REQUEST['obj'] == "file") {
                    $id_file_converter1= array();
                    $id_file_converter2= array();
                } elseif ($_REQUEST['obj'] == "project") {
                    $id_file_converter1= $m->id_file_converter1;
                    $id_file_converter2= $m->id_file_converter2;
                    $id_proj_converter= array();
                } elseif ($_REQUEST['obj'] == "id_bordereau") {
                    $id_file_converter1= array();
                    $id_file_converter2= array();
                    $id_proj_converter= $m->id_proj_converter;
                } elseif ($_REQUEST['obj'] == "client") {
                    $id_file_converter1= $m->id_file_converter1;
                    $id_file_converter2= $m->id_file_converter2;
                    $id_proj_converter= $m->id_proj_converter;
                }
            
            
                while ($data= mysql_fetch_assoc($this->res)) {
                    if ($_REQUEST['obj'] == "file") {
                        convert_dbase_data::convert_file_data($data);
                    } elseif ($_REQUEST['obj'] == "project") {
                        convert_dbase_data::convert_project_data($data);
                    } elseif ($_REQUEST['obj'] == "id_bordereau") {
                        convert_dbase_data::convert_id_bordereau_data($data);
                    } elseif ($_REQUEST['obj'] == "client") {
                        convert_dbase_data::convert_client_data($data);
                    }
                    
                        
                    convert_dbase_data::convert_old_values($old_values_corrector, $data);
                    convert_dbase_data::convert_keys($keys_corrector, $data);
                    convert_dbase_data::convert_id($id_file_converter1, $id_file_converter2, $id_proj_converter, $data);

                    //----------------------
                
                    if (($_REQUEST['obj'] == "file") && $this->is_duplicate_file($data)) {
                        $id_file_converter1[$data['idarr']]= $id_file_converter2[$data['file_ref']];
                    
                        continue;
                    }
                                        
                    //----------------------
                    
                    if ($_REQUEST['obj'] == "client") {
                        $this->save_qual($data);
                    }
                    
                    //------------------------
                    
                    foreach ($data as $key => $value) {
                        $q->set_var($key, $value);
                    }
                    
                    
                    if (!$q->sql_action($this->select_query("new_dbase", "update_new_dbase"))) {
                        $this->throw_msg("fatal_error", "invalid_request", "#met #onsubmit_import_dbase, 
								#cls #update_dbase, update_dbase failed, #counter is {$this->counter},
								 #file_id is {$data['file_id']}");
                        return;
                    }
                    
                                        
                    if ($_REQUEST['obj'] == "file") {
                        $id_file= $q->get_var("new_id");
                        $q->set_var("id_file", $id_file);
                        $q->sql_action("new_insert_file_trans");
                    
                        $last_trans= $q->get_var("new_id");
                        $q->set_var("last_trans", $last_trans);
                        $q->sql_action("update_file_last_trans");
                                                            
                        $id_file_converter1[$data['idarr']]= $id_file;
                        $id_file_converter2[$data['file_ref']]= $id_file;
                    } elseif ($_REQUEST['obj'] == "project") {
                        $id_proj= $q->get_var("new_id");
                        $q->set_var("id_proj", $id_proj);
                        $q->sql_action("new_insert_proj_trans");
                        $last_trans= $q->get_var("new_id");
            
                        $q->set_var("last_trans", $last_trans);
                        $q->set_var("id_proj", $id_proj);
                        $q->sql_action("update_proj_last_trans");
                                    
                        $id_proj_converter[$data['idarr']]= $id_proj;
                    }
                
                    $this->counter++;
                }
                        
                $import_results[$_REQUEST['obj']]= $this->counter;
                $m->import_results= $import_results;
                        
                if ($_REQUEST['obj'] == "file") {
                    $m->id_file_converter1= $id_file_converter1;
                    $m->id_file_converter2= $id_file_converter2;
                } elseif ($_REQUEST['obj'] == "project") {
                    $m->id_proj_converter= $id_proj_converter;
                }
            }
        }
    }
    
    
    
    
    
    public function set_data()
    {
    }

    
    
    
    
    
    
    
        
    
    
    
    public function select_dbase($option)
    {
        if ($option == "old_dbase") {
            $db= "dbase1_old";
        } else {
            $db= "dbase2_new";
        }
        
        try {
            $select= mysql_select_db($db);
        
            if (!$select) {
                throw new Exception();
            }
        } catch (Exception $e) {
            exit("Could not find selected database in #met#select_dbase".
                " #cls#update_dbase".mysql_error());
        }
    }
    
        
    
    
    
    
    
    public function display()
    {
        global $m, $q, $t;


        $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
    
        echo <<<HTML

<h2>{$t->import_to_dbase}</h2>

<select name="obj">

<option value="0">{$t->none}</option>
<option value="file">{$t->file}</option>
<option value="project">{$t->project}</option>
<option value="id_bordereau">{$t->id_bordereau}</option>
<option value="client">{$t->client}</option>

</select>

HTML;

        $this->display_submit($this->i_var['submit_name'], $this->i_var['submit_value'], $this->i_var['submit_wrap_tag']);

        $this->display_submit("reset", $t->reset, $this->i_var['submit_wrap_tag']);
                
        echo "</form>";


        //---------------------------------------------


        $import_results= $m->import_results;

        if (is_array($import_results) && $import_results) {
            echo "<div class=\"results\"><h2>{$t->results}</h2>";

            foreach ($import_results as $key => $value) {
                echo $value." ".$t->results_for." ".$t->$key."<br/><br/>";
            }
        
            echo "</div>";
        }
    }
}
