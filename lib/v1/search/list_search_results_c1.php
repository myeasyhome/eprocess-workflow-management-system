<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

All rights reserved

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class list_search_results_c1 extends list_search_results
{
    protected $display_objs;



    public function initialize()
    {
        parent::initialize();
    

        $this->display_objs= array();
        $this->display_objs[0]= new list_files();
        $this->display_objs[1]= new list_projects();

        $this->initialize_display_objs();

        $this->display_objs[0]->set_option("view_one");
        $this->display_objs[1]->set_option("view_one");
    }
    
    


    
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;


        parent::config();

        //----------------------------

        $this->display_objs[0]->set_is("search_result", true);
        $this->display_objs[1]->set_is("search_result", true);


        $this->display_objs[0]->config();
        $this->display_objs[1]->config();


        $this->has['filter'] = true;
        $this->has['skeleton'] = true;
        $this->has['title']= false;

        $this->has['create']= false;
        $this->has['ask_delete']= false;
        $this->has['edit']= false;
        $this->has['delete']= false;
        $this->has['ask_delete']= false;

        $this->i_var['form_method']= "search_result";
        $this->i_var['form_method']= "GET";
        $this->i_var['target_url']= $this->i_var['current_url'];
        $this->has['submit']= true;


        $this->i_var['search_project_fields']= $s->search_project_fields;


        $this->i_var['max_res_project']= $s->max_file_client;
        $this->i_var['max_res_client']= $s->max_file_client;

        $this->has['show_selected_client_only']= true;


        //---------------------

        if ($this->option == "private_search") {
            $search_fields= $s->private_search_fields;
        } elseif ($this->option == "public_search") {
            $search_fields= $s->public_search_fields;
        }
    
        //-----------------------
        
        
        $keywords= array();

        if ($_GET) {
            foreach ($_GET as $key => &$value) {
                if (in_array($key, $search_fields) && $value) {
                    $this->search_param[$key]= $value;
                    $keywords[]= &$this->search_param[$key];
                }
            }
        }

        if ($this->require_id("array", $this->search_param)) {
        
        // values of  #search_params updated by reference to keywords
            $keywords= search_keywords_controller::delete_accents($keywords);

            $this->validate_data();
        
            $this->data_source= search_engine::select_files_data_source();

            $this->set_title($t->search_results, "h2");
        }
    
        $this->no_result_msg= "<div class=\"no_result_msg\">".$t->no_result."</div>";

        $this->has['close_main_table']= true;
        $this->has['auto_display_paging']= false;
    }
    
    
    
    
    
    public function config_paging()
    {
        $this->i_var['paging_open_nav']="<div class=\"paging_div\">";
        $this->i_var['paging_close_nav']="</div>";
    }

    
    
    public function initialize_display_objs()
    {
        global $c, $s, $m, $u, $q, $t;

        //----------------------------------------------------------------

        for ($i=0; $i < count($this->display_objs); $i++) {
            $this->display_objs[$i]->initialize();
            $this->display_objs[$i]->config();
        }
    }
    

    
    
    
    
    public function get_search_param($name)
    {
        return (empty($this->search_param[$name]) ? "" : $this->search_param[$name]);
    }
    
    
    
    
    
    public function validate_data()
    {
        if ($this->search_param['month']) {
            $list= explode("/", $this->search_param['month']);
        
            $this->search_param['month']= $list[0];
            $this->search_param['year']= $list[1];
        }
    }
    
    
    
    
    
    
    public function set_filter($string="")
    {
        global $s, $c, $t, $q;

        foreach ($this->search_param as $key => $value) {
            $list= explode(" ", trim($value));

            for ($i=0; $i < count($list); $i++) {
                $this->search_param[$key]= $list[$i];
                $filters= $this->set_filter_list();
                $string .= " AND ".$filters[$key];
            }

            $this->search_param[$key]= $value;
        }

        $q->set_filter($string);
    }
    
    
    
    
    
    public function set_project_filter($id_file)
    {
        global $s, $c, $t, $q;


        $string="project1.id_file='".$id_file."'";

        foreach ($this->search_param as $key => $value) {
            $list= explode(" ", trim($value));

            for ($i=0; $i < count($list); $i++) {
                $this->search_param[$key]= $list[$i];
                $filters= $this->set_filter_list();
            
                if (in_array($key, $this->i_var['search_project_fields'])) {
                    $string .= " AND ".$filters[$key];
                }
            }

            $this->search_param[$key]= $value;
        }

        $q->set_filter($string);
    }

    
    
    
    
    
    public function set_filter_list()
    {
        $filters= array();

        $filters['id_file']= "file1.id_file='".$this->get_search_param("id_file")."'";
        $filters['id_file_type']= "file1.file_type='".$this->get_search_param("id_file_type")."'";
        $filters['dept_comingfrom']= "transfer1.dept_comingfrom='".$this->get_search_param("dept_comingfrom")."'";
        $filters['title']= "file1.title LIKE ('%".$this->get_search_param("title")."%')";
        $filters['file_ref']= "file1.file_ref LIKE ('%".$this->get_search_param("file_ref")."%')";
        $filters['id_dept']= "file1.file_dept='".$this->get_search_param("id_dept")."'";
        $filters['surname']= "client1.surname LIKE ('%".$this->get_search_param("surname")."%')";
        $filters['firstname']= "client1.firstname LIKE ('%".$this->get_search_param("firstname")."%')";
        $filters['date_birth']= "client1.date_birth='".f1::undo_custom_date($this->get_search_param("date_birth"))."'";
        $filters['date_created']= "DATE(file1.date_created)='".f1::undo_custom_date($this->get_search_param("date_created"))."'";
        $filters['month']= "MONTH(file1.date_created)='".$this->get_search_param("month")."' 
					 AND YEAR(file1.date_created)='".$this->get_search_param("year")."'";
        $filters['year']= "YEAR(file1.date_created)='".$this->get_search_param("year")."'";
        $filters['file_date']= "file1.file_date='".f1::undo_custom_date($this->get_search_param("file_date"))."'";
        $filters['id_proj']= "project1.id_proj='".$this->get_search_param("id_proj")."'";
        $filters['proj_ref']= "project1.proj_ref='".$this->get_search_param("proj_ref")."'";
        $filters['id_bordereau']= "project1.id_bordereau='".$this->get_search_param("id_bordereau")."'";
        
        return $filters;
    }
    

    
    
    
    public function set_data()
    {
        parent::set_data();


        if ($this->numrows == 1) {
            $this->has['one_file']= true;
        }
    }
    
    
    
    
    
    public function display_skeleton()
    {
        global $s, $u, $q, $t;

        $this->has['close_main_table']= true;

        $t->set_var("id_file", $this->data['id_file'], true);
        echo "<h2>{$t->file_num}</h2>";


        if (!isset($this->i_var['count_down_files'])) {
            $this->i_var['count_down_files']= $this->num_displayed;
        }
        

        $this->display_objs[0]->set_data("all_data", $this->data);

        //-----------------


        $this->display_search_parameters();

        $this->display_objs[0]->display_skeleton();


        //-----------search projects

        $this->set_project_filter($this->data['id_file']);

        $q->set_limit("LIMIT ".$this->i_var['max_res_project']);
        $q->sql_select(search_engine::select_projects_data_source(), $numrows, $res, "all");


        if ($numrows >= 1) {
            echo "</table></div>"; // closes main table - file
            $first_table_closed= true;
            $this->has['close_main_table']= false;
            
            
            
            $t->set_var("id_file", $this->data['id_file'], true);
        
            $project_title= $t->projects_of_file;
        
            if ($this->option == "private_search") {
                $project_title .=" <span class=\"res_limit\">(".
                                $t->limit." : ".$this->i_var['max_res_project'].")</span>";
            }
        
            $this->display_objs[1]->set_title($project_title, "h2");
                                
            $this->display_objs[1]->display_title();
        
            $this->display_search_parameters();

        
            echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag; - project
        
    
            $this->display_objs[1]->display_headings();
        
            while ($data= mysql_fetch_assoc($res)) {
                if ($numrows == 1) {
                    $has_one_project= true;
                    $id_proj= $data['id_proj'];
                    $proj_dept= $data['proj_dept'];
                }
            
                $this->display_objs[1]->set_data("all_data", $data);
                $this->display_objs[1]->display_skeleton();
            }

            echo "</table></div>"; // closes main table - project
        }
    
    
        if ($this->has['close_main_table']) {
            echo "</table></div>"; // closes main table
            $first_table_closed= true;
            $this->has['close_main_table']= false;
        }
        

        
        
        //-------------------------------

        if ((isset($has_one_project) && $has_one_project)
                || (isset($this->has['one_file']) && $this->has['one_file'])) {

        //-----------
        
            $this->has['one_file']= isset($has_one_project) ? false : true;
                
            //-----------
        
            $temp_id_file= isset($_REQUEST['id_file']) ? $_REQUEST['id_file'] : null;
            $temp_file_status= isset($_REQUEST['file_status']) ? $_REQUEST['file_status'] : null;
            $temp_id_proj= isset($_REQUEST['id_proj']) ? $_REQUEST['id_proj'] : null;
        
            //------------
                    
            $_REQUEST['id_file']= $this->data['id_file'];
            $_REQUEST['file_status']= $this->data['file_status'];
            $_REQUEST['id_proj']= isset($has_one_project) ?  $id_proj : null;
        
            $clients= new list_clients();
            $clients->initialize();
        
            $clients->set_option(isset($has_one_project) ? "project" : "file");
            $clients->config();
        
        
            $clients->set_has("paging", false);
            $clients->set_has("radio", false);
            $clients->set_has("submit", false);
            $clients->set_has("form", false);
            
            
            if ((isset($has_one_project) && ($proj_dept == $u->id_dept))
                or (!isset($has_one_project) && ($this->data['file_dept'] == $u->id_dept))) {
                $clients->set_has("data_hyperlinks", true);
            }
        
        
            $t->set_var("id_doc", isset($has_one_project) ?  $id_proj : $this->data['id_file'], true);
                                        
                                
            $clients_title= isset($has_one_project) ? $t->clients_of_project : $t->clients_of_file;
        
            if ($this->option == "private_search") {
                $clients_title .= "<span class=\"res_limit\"> (".$t->limit." : ".$this->i_var['max_res_client'].")</span>";
            }
        
            $clients->set_title($clients_title, "h2");
        
        
            if ($this->has['show_selected_client_only'] && ($this->option == "private_search") &&
            ($_GET['surname'] || $_GET['firstname'] || $_GET['date_birth'])) {
                $client_string="";
                $client_params= array("surname", "firstname", "date_birth");
                $filters= $this->set_filter_list();
                
                for ($i=0; $i < count($client_params); $i++) {
                    if ($_GET[$client_params[$i]]) {
                        $q->set_filter($filters[$client_params[$i]]);
                    }
                }
            }
        
        
            $q->set_order("ORDER BY client1.surname ASC");
            $q->set_limit("LIMIT ".$this->i_var['max_res_client']);
        
            $clients->set_data();
            $clients->start();
    
            if (($clients->get_numrows() >= 1) && !isset($first_table_closed)) {
                echo "</table></div>"; // closes main table
                $this->has['close_main_table']= false;
            }
        
        
            $clients->display_title();
        
            $this->display_search_parameters();

            $clients->display();
    
            //-----------
            
            $_REQUEST['id_file']= isset($temp_id_file) ? $temp_id_file : null;
            $_REQUEST['file_status']= isset($temp_file_status) ? $temp_file_status : null;
            $_REQUEST['id_proj']= isset($temp_id_proj) ? $temp_id_proj : null;
        
            //------------
        }

        //------------------------------

        if ($this->i_var['count_down_files'] > 1) {
            if (!isset($first_table_closed)) {
                echo "</table></div>";
            } // closes main table - project or clients
    
            echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag; - file
                
            $this->display_objs[0]->display_headings();
        }

        //-----------------------
        
        $this->i_var['count_down_files']--;
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;


        if ($this->numrows >= 1) {
            if ($this->option == "private_search") {
                echo <<<HTML

<input type="submit" class="submit_button" name="clients_from_search" value="{$t->clients}"/>

HTML;
            }

            echo <<<HTML

<input type="submit" class="submit_button" name="document_history" value="{$t->history}"/>

HTML;
        }
    }
    
    
    
    
    
    
    
    public function display_search_parameters()
    {
        global $q, $t;


        echo <<<HTML

<div class="search_param" >

<span class="title">{$t->search_parameters}:</span>

HTML;


        foreach ($this->search_param as $name => $value) {
            if ($name == "id_file") {
                $name= "num_file";
            } elseif (($name == "id_file_type") && is_numeric($value)) {
                $name= "file_type";
            
                $q->set_filter("id_file_type='".$value."'");
                $value= $this->set_data_from_id("select_file_type1", "", "name_type");
            } elseif ((($name == "id_dept") || ($name == "dept_comingfrom")) && is_numeric($value)) {
                $name= ($name == "id_dept") ? "name_dept" : $name;
                $q->set_filter("id_dept='".$value."'");
                $value= $this->set_data_from_id("select_department1", "", "name_dept");
            }

            if (empty($string)) {
                $string= "<span>".$t->$name." ( <strong>".$value."</strong> ) </span>";
            } else {
                $string .= " | <span>".$t->$name." ( <strong>".$value."</strong> ) </span> ";
            }
        }
        

        echo "{$string}</div>";
    }
    
    
        
    
    
    
    public function display()
    {
        global $s, $t;


        if ($this->has['search_num_results'] && $this->search_param && ($this->numrows >= 1)) {
            $t->set_var("numrows", $this->numrows, true);

            echo "<div class=\"num_results\">{$t->search_num_results}</div>";
        
            $this->has['search_num_results']= false;
        }
    
        if ($this->numrows >= 1) {
            $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
        
            echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        
            $this->display_objs[0]->display_headings();
        
            parent::display();
        
            if ($this->has['close_main_table']) {
                echo "</table></div>";
            } // closes main table
        
            $this->paging->display();
        
            if (!$_GET['print_page'] && $this->has['submit']) {
                $this->display_submit();
            }
        
            echo "</form>";
        } else {
            echo "<h2>{$t->search}</h2>";
                
            $this->display_search_parameters();
        
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }
}  //closes: class list============================================================
