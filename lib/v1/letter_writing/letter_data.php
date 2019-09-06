<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class letter_data extends website_object
{
    protected $id_letter;
    protected $id_proj;



    public function set_id_proj($id)
    {
        if (is_numeric($id)) {
            $this->id_proj= $id;
        }
    }
    
    
    
    
    
    public function set_id_letter($id)
    {
        if (is_numeric($id)) {
            $this->id_letter= $id;
        }
    }
    
    
    



    public function set_data()
    {
    }
    
    
    
    

    
    
    public function get_letter()
    {
        global $s, $m, $q, $t;


        if (empty($this->id_letter)) {
            $data= $m->letter_data;
            $this->id_letter= $data['id_letter'];
        }

        $q->set_filter("letter1.id_letter='".$this->id_letter."'");
    
        $data= $this->set_data_from_id("select_letter_toprint", "", "", $numrows);
        $q->clear("filter");


        if ($numrows == 1) {
            $pages= explode($s->letter_page_break, $data['body_letter']);
        
            for ($i=0; $i < count($pages); $i++) {
                $pages[$i]= trim($pages[$i]);
            
                if (!empty($pages[$i])) {
                    $letter["body_letter".($i+1)]= $pages[$i];
                }
            }
        
            $letter['date_letter']= $data['date_letter'] ? f1::custom_long_date($data['date_letter']) : "00 xxxx 0000";

            return $letter;
        }
    }
    
    
    
    
    
    public function get_project()
    {
        global $m, $q, $t;


        if (empty($this->id_proj)) {
            $data= $m->letter_data;
            $this->id_proj= $data['id_proj'];
        }

        $q->set_filter("project1.id_proj='".$this->id_proj."'");
            
        $project= $this->set_data_from_id("select_project_to_print", "", "", $numrows0);
        $q->clear("filter");
    
        if ($numrows0 == 1) {
        
        // Get name of minister
            $q->set_filter("is_minister='1'");
            $minister= $this->set_data_from_id("select_user1", "", "", $numrows1);

            if ($numrows1 >= 1) {
                $project['minister']= $minister['firstname']." ".$minister['surname'];
            }
            
            // Get name of general director
            $q->set_filter("is_gen_dir='1'");
            $gen_dir= $this->set_data_from_id("select_user1", "", "", $numrows2);

            if ($numrows2 >= 1) {
                $project['gen_dir']= $gen_dir['firstname']." ".$gen_dir['surname'];
            }
            
            //--------------
        
            $project['today']= f1::custom_long_date(date("Y-m-d", time()));
        
            //--------------
        
            if ($project['plt_date']) {
                $project['plt_date']= f1::custom_long_date($project['plt_date']);
            } else {
                $project['plt_date']= "XX XX XX";
            }
        
            //--------------
        

            // make operator initials
        
            $project['init_user']= "";
            
            $q->set_filter("id_user='".$project['plt_id_user']."'");
            $user_data= $this->set_data_from_id("select_user1");
        
            if ($user_data) {
                $name= $user_data['surname']." ".$user_data['firstname'];
                    
                $project['init_user']= $this->make_initials($name)." ".$project['plt_id_user'];
            }
        
            //--------------
        
            return $project;
        }
    }

    
    
    
    
    
    private function add_client_determiners(&$data, $numrows)
    {
        global $t;


        $masc_cardinal_suffix= $t->masc_cardinal_suffixes;
        $fem_cardinal_suffix= $t->fem_cardinal_suffixes;


        $data['d_name_client']= $data['determ_client']." ".$data['firstname']." ".$data['surname'];
        $data['d_surname']= $data['determ_client']." ".$data['surname'];
        $data['d_name_serv']= $data['determ_serv']." ".$data['name_serv'];
        $data['d_name_work']= $data['determ_work']." ".$data['name_work'];
        $data['d_name_rank']= $data['determ_rank']." ".$data['name_rank'];
        $data['d_name_qual']= $data['determ_qual']." ".$data['name_qual'];
        $data['d_dept_origin']= $data['determ_dept']." ".$data['dept_origin'];
    
        $data['d_work_cat']= $data['num_work_cat'].$fem_cardinal_suffix[$data['num_work_cat']];
        $data['d_work_class']= $data['work_class'].$fem_cardinal_suffix[$data['work_class']];
        $data['d_scale']= $data['scale'].$fem_cardinal_suffix[$data['scale']];
        $data['d_echelon']= $data['echelon'].$masc_cardinal_suffix[$data['echelon']];
    
    
        //--------------------------
    
        if (is_numeric($data['client_type']) && ($data['client_type'] == 0)) {
            $data['type_client']= $t->candidate;
        } elseif ($data['client_type'] == 1) {
            $data['type_client']= $t->c_vlteer;
        } elseif ($data['client_type'] == 2) {
            $data['type_client']= $t->c_dcs;
        } elseif ($data['client_type'] == 3) {
            $data['type_client']= $t->c_ctt;
        } else {
            $data['type_client']= "";
        }
        
        //---------------------------
        
        if ($numrows == 1) {
            $data['s']= "";
            $data['c_s']= "";
        
            if ($data['sex'] == 0) {
                $data['e']= "";
                $data['c_e']= "";
                $data['le']= "";
            } elseif ($data['sex'] == 1) {
                $data['e']= "e";
                $data['c_e']= "E";
                $data['le']= "le";
            }
        }
    }
    
    
    
    
    
    public function has_male_client(&$clients)
    {
        if (is_array($clients)) {
            for ($i=0; $i < count($clients); $i++) {
                if (is_numeric($clients[$i]['sex']) && ($clients[$i]['sex'] == 0)) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    
    
    
    
    
    public function get_origin_acronym($string)
    {
        global $t;
    
        $separator= "*1#";
    
        if (strpos($string, $separator) !== false) {
            $chunks= explode($separator, $string);
    
            return strtoupper($chunks[1]);
        } else {
            return strtoupper("**".$t->error."!**");
        }
    }
    
    
    
    
    
    public function get_clients()
    {
        global $s, $m, $q, $t;

        $clients_class= array();
        $client_pointer= 0;

        if ($this->id_proj) {
            $q->set_filter("client1.id_proj='".$this->id_proj."'");
            $q->sql_select("client_all", $numrows0, $res0, "filter");
        
            if ($numrows0 >= 1) {
                $work_categories= $s->work_categories;
            
                while ($row0= mysql_fetch_assoc($res0)) {
                
                
                // record client_class
                    if (!$client_pointer) {
                        $client_pointer= $row0['id_client'];
                        $clients_class[$client_pointer][]= $row0;
                    } elseif ($client_pointer == $row0['id_client']) {
                        $clients_class[$client_pointer][]= $row0;
                        continue;
                    } else {
                        $client_pointer= $row0['id_client'];
                        $clients_class[$client_pointer][]= $row0;
                    }
                    
                
                    // client_origin
                    $q->set_filter("AND client1.id_client='".$row0['id_client']."'");
                    $data1= $this->set_data_from_id("client_origin", "", "", $numrows1);
                
                    $row0['dept_origin']= "** ".$t->unknown." **";
                    $row0['ac_origin']= "** ".$t->unknown." **";
                
                    if ($numrows1 >= 1) {
                        $row0['dept_origin']= $data1['dept_origin'];
                        $row0['ac_origin']= $this->get_origin_acronym($data1['dept_describe']);
                    }
                
                    //----------
                
                    $row0['num_work_cat']= $row0['work_cat'];
                
                    // get work cat name
                    $work_cat= $work_categories[$row0['work_cat']];
                    $row0['work_cat']= $t->$work_cat;
                
                    //--------------------
                
                    $date_birth= $row0['date_birth'];
                    $row0['date_birth']= f1::custom_long_date($date_birth);
                    $row0['short_date_birth']=  date("d-m-Y", strtotime($date_birth));
                
                    $date_birth=null;
                
                    $name_trial= "print_trial_p".$row0['trial_period'];
                    $row0['trial']= $t->$name_trial;
                
                    //-------------------
                
                    // add determiners
                    $this->add_client_determiners($row0, $numrows0);
                
                    $clients[]= $row0;
                }
                                
                
                if ($numrows0 > 1) {
                    $clients[0]['s']= "s";
                    $clients[0]['c_s']= "S";
                    $clients[0]['e']= "e";
                    $clients[0]['c_e']= "E";
                    $clients[0]['le']= "le";
                                
                    if ($this->has_male_client($clients)) {
                        $clients[0]['s']= "s";
                        $clients[0]['c_s']= "S";
                        $clients[0]['e']= "";
                        $clients[0]['c_e']= "";
                        $clients[0]['le']= "";
                    }
                }

                
                $clients[0]['total_client']= $numrows0; // number  of clients in project
                $clients[0]['total_doc']= $numrows0 * 3; // number of document files provided by client
                $clients[]= $clients_class;
                                
                return $clients;
            }
        } else {
            f1::echo_error("#id_proj not found in met#get_clients, cls#letter_data");
        }
    }
}
