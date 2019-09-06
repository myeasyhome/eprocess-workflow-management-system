<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class stat_methods extends stat_methods_datatype
{
    public function clients_dept_recruit()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(true);
        $this->display_title();

    
        //----------------

        $this->data_source= "stat_files_origin";
        $this->display_list= array("id_client", "date_created", "surname", "firstname", "date_birth", "town_birth", "name_work", "num_file", "name_dept");

        $this->set_data();

        if ($this->numrows >= 1) {
            while ($this->data= mysql_fetch_assoc($this->res)) {
                if ($this->start_datetime) {
                    $q->set_filter("file1.date_created >= ".$this->start_datetime);
                }
                
                if ($this->end_datetime) {
                    $q->set_filter("file1.date_created <= ".$this->end_datetime);
                }
                
            
                $q->set_filter("transfer1.dept_comingfrom='".$this->data['id_dept']."' AND transfer1.status_trans='0'");
                $q->sql_select("stat_clients_file", $numrows, $res, "all");
            
                if ($numrows >= 1) {
                    echo "<h2>{$this->data['name_dept']}</h2>";
                
                    $keep= $this->data;
            
                    echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
                
                    $this->display_headings();
                
                    while ($data= mysql_fetch_assoc($res)) {
                        $this->data= $data;
                
                        $q->set_filter("client_class1.id_client='".$this->data['id_client']."'");
                        $this->data['name_work']= $this->set_data_from_id("stat_num_clients_3", "", "name_work");
                    
                        $this->data['name_work']= $this->data['name_work'] ? $this->data['name_work'] : "---";
                                    
                        $this->data['num_file']= &$this->data['id_file'];
                        $this->data['date_created']= f1::custom_date($this->data['date_created']);
                    
                        $this->data['date_birth']= f1::custom_date($this->data['date_birth']);
                    
                        $this->data['name_dept']= $keep['name_dept'];
                    
                        $this->view_data();
                    }
                    
                    echo "</table></div>"; // closes main table
                
                    // in case we need those values again...
                    $this->data= $keep;
                }
            }
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }
    
    
    
    
    
    public function clients_class()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(true);
        $this->display_title();

    
        //----------------


        if ($this->start_datetime) {
            $q->set_filter("file1.date_created >= ".$this->start_datetime);
        }
                
        if ($this->end_datetime) {
            $q->set_filter("file1.date_created <= ".$this->end_datetime);
        }
                
        $this->data_source= "stat_clients_class";

        $this->display_list= array("id_client_class", "name_serv", "name_work", "name_rank", "name_work_cat", "scale", "echelon", "work_class", "work_index", "name_qual", "qual_level");

        $this->set_data();

        if ($this->numrows >= 1) {
            $work_categories= $s->work_categories;
        
            $current_id =0;

        
            while ($this->data= mysql_fetch_assoc($this->res)) {
                $work_cat= $work_categories[$this->data['work_cat']];
                $this->data['name_work_cat']= $t->$work_cat;
            
                $qual_level= &$this->data['qual_level'];
                $this->data['qual_level']= $t->$qual_level;

                        
                if ($current_id !=  $this->data['id_client']) {
                    if ($current_id > 0) {
                        echo "</table></div>";
                    } // closes main table

                    
                    echo "<h2>{$this->data['id_client']}: {$this->data['surname']} {$this->data['firstname']} </h2>";
                
                    echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
                
                    $this->display_headings();
                }
                
                $this->view_data();
            
                $current_id= $this->data['id_client'];
            }
            
            echo "</table></div>"; // closes main table
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }

    
    
    

    public function clients_age_groups()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(false);
    
        $this->display_title();

        //----------------

        $filters= array();

        $filters['18_19']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 18 AND 19";
        $filters['20_29']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 20 AND 29";
        $filters['30_39']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 30 AND 39";
        $filters['40_49']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 40 AND 49";
        $filters['50_59']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 50 AND 59";
        $filters['60_64']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 60 AND 64";
        $filters['65_69']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 65 AND 69";
        $filters['70_74']= "YEAR(NOW()) -YEAR(client1.date_birth) BETWEEN 70 AND 74";
    
        $this->data_source= "stat_num_clients_1";


        foreach ($filters as $key => $value) {
            $q->set_filter($value);
        
            $this->set_data();

            $ref="num_group_".$key;
            
            echo "<h2><span class=\"label\">{$t->$ref}: </span><span class=\"data\">{$this->numrows}</span></h2>";
        }
    }
    
    

    
    
    
    public function clients_qual_level_groups()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(false);
    
        $this->display_title();

        //----------------


        $levels= $s->qual_levels;


        $this->data_source= "stat_num_clients_2";

        for ($i=0; $i < count($levels); $i++) {
            $q->set_filter("qualification1.qual_level='".$levels[$i]."'");
        
            $this->set_data();
        
            $ref=$levels[$i];
        
            echo "<h2><span class=\"label\">{$t->$ref}: </span><span class=\"data\">{$this->numrows}</span></h2>";
        }
    }
    
    

    
    
    public function clients_work_groups()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(false);

        $this->display_title();
    
        //----------------

        $this->data_source= "select_work1";

        $this->set_data();


        if ($this->numrows >= 1) {
            while ($this->data= mysql_fetch_assoc($this->res)) {
                $q->set_filter("work1.id_work='".$this->data['id_work']."'");
            
                $q->sql_select("stat_num_clients_3", $numrows, $res, "all");

                echo "<h2><span class=\"label\">{$this->data['name_work']}: </span><span class=\"data\">{$numrows}</span></h2>";
            }
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }

    
    
    
    
    public function start_clients_recruited_retired()
    {
        $recruit_type= $s->recruit_proj_type;
        $retire_type= $s->retire_proj_type;


        if (!($recruit_type && is_numeric($recruit_type))
            || !($retire_type && is_numeric($retire_type))) {
            $this->throw_msg("error", "incomplete_report_parameters", "some value required for the report 
				are missing, in met#clients_recruited_retired,
				 cls#".get_class($this));
        
            return;
        }
        
        $this->has['clients_recruited_retired']= true;
    }
    
    


    
    public function clients_recruited_retired()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(false);

        $this->display_title();
    
        //----------------


        if (!$this->has['clients_recruited_retired']) {
            return;
        }
        
        
        $recruit_type= $s->recruit_proj_type;
        $retire_type= $s->retire_proj_type;


        if ($recruit_type && is_numeric($recruit_type)) {
            $q->set_filter("project1.proj_type='".$recruit_type."'");
            $recruit= $this->set_data_from_id("stat_num_clients_3");
        }
        
        if ($retire_type && is_numeric($retire_type)) {
            $q->set_filter("project1.proj_type='".$retire_type."'");
            $retire= $this->set_data_from_id("stat_num_clients_3");
        }
    
        if ($recruit) {
            echo "<h2><span class=\"label\">{$t->num_recruit}:</span><span class=\"data\">{$recruit['num_client']}</span></h2>";
        }
        
        if ($retire) {
            echo "<h2><span class=\"label\">{$t->num_retire}:</span><span class=\"data\">{$retire['num_client']}</span></h2>";
        }
    }
    
    
    
    
    
    public function dgb_trans()
    {
        global $u, $q, $s, $t, $c;


        $this->set_title($this->title_text." | ".$u->name_dept, "h2");

        $this->can_use_period(true);
        $this->display_title();

    
        //----------------

        $q->set_filter("name_dept LIKE '%*#dgb#%'");
        $id_dgb_dept= $this->set_data_from_id("select_department1", "", "id_dept");

        if (!$id_dgb_dept) {
            echo "<div class=\"error\">".$t->no_id_dgb_dept."</div>";
        
            return;
        } else {
            if ($u->is_super_admin()) {
                $q->set_filter("transfer1.dept_comingfrom='".$id_dgb_dept."' OR transfer1.dept_goingto='".$id_dgb_dept."'");
            } else {
                $q->set_filter("(transfer1.dept_comingfrom='".$id_dgb_dept."' AND transfer1.dept_goingto='".$u->id_dept."') 
								OR (transfer1.dept_comingfrom='".$u->id_dept."' AND transfer1.dept_goingto='".$id_dgb_dept."') ");
            }
        
        
            $this->data_source= "stat_select_project1";

            $this->display_list= array("date_trans", "id_proj", "id_bordereau", "to_dgb", "from_dgb");

            $this->set_data();

            if ($this->numrows >= 1) {
                echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
            
                $this->display_headings();
                            
                while ($this->data= mysql_fetch_assoc($this->res)) {
                    $this->data['date_trans']= f1::custom_datetime($this->data['date_trans']);
                
                    $this->data['to_dgb']= ($this->data['dept_goingto'] == $id_dgb_dept) ? "OK" : "---";
                
                    $this->data['from_dgb']= ($this->data['dept_comingfrom'] == $id_dgb_dept) ? "OK" : "---";
                
                    $this->view_data();
                }
                
                echo "</table></div>"; // closes main table
            } else {
                echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
            }
        }
    }
    
    
    
    
    
    public function clients_sms_subscribed()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(true);
        $this->display_title();

    
        //----------------

        $this->data_source= "stat_sms_subscribed";
        $this->display_list= array("id_client", "date_subscribed", "surname", "firstname", "num_phone", "num_file", "num_proj", "last_sent");
            
            
        if ($this->start_datetime) {
            $q->set_filter("AND sms_user1.date_saved >= ".$this->start_datetime);
        }
        
        if ($this->end_datetime) {
            $q->set_filter("AND sms_user1.date_saved  <= ".$this->end_datetime);
        }
        

        $this->set_data();


        if ($this->numrows >= 1) {
            echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
            $this->display_headings();

        
            while ($this->data= mysql_fetch_assoc($this->res)) {
                $this->data['num_file']= &$this->data['id_file'];
                $this->data['num_file']= $this->data['num_file'] ? $this->data['num_file'] : "---";
            
                $this->data['num_proj']= &$this->data['id_proj'];
                $this->data['num_proj']= $this->data['num_proj'] ? $this->data['num_proj'] : "---";
            
                $this->data['date_subscribed']= f1::custom_date($this->data['date_saved']);
                $this->data['date_birth']= f1::custom_date($this->data['date_birth']);
            
                $this->data['last_sent']= f1::custom_datetime($this->data['last_sent']);
                                
                $this->view_data();
            }
                    
            echo "</table></div>"; // closes main table
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }
    
    
    
    
    
    
    
    public function clients_sms_replies()
    {
        global $q, $s, $t, $c;


        $this->can_use_period(true);
        $this->display_title();

    
        //----------------

        $this->data_source= "stat_sms_replies";
        $this->display_list= array("id_client", "date_sent", "surname", "firstname", "num_phone", "num_file", "num_proj");
            
            
        if ($this->start_datetime) {
            $q->set_filter("AND sms_user1.date_saved >= ".$this->start_datetime);
        }
        
        if ($this->end_datetime) {
            $q->set_filter("AND sms_user1.date_saved  <= ".$this->end_datetime);
        }
        

        $this->set_data();


        if ($this->numrows >= 1) {
            echo "<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
            $this->display_headings();

        
            while ($this->data= mysql_fetch_assoc($this->res)) {
                $this->data['num_file']= &$this->data['id_file'];
                $this->data['num_file']= $this->data['num_file'] ? $this->data['num_file'] : "---";
            
                $this->data['num_proj']= &$this->data['id_proj'];
                $this->data['num_proj']= $this->data['num_proj'] ? $this->data['num_proj'] : "---";
            
                $this->data['date_sent']= f1::custom_date($this->data['date_saved']);
                $this->data['date_birth']= f1::custom_date($this->data['date_birth']);
                            
                $this->view_data();
            }
                    
            echo "</table></div>"; // closes main table
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    }
}
