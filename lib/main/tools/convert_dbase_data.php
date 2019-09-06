<?php



class convert_dbase_data
{
    public static function config_old_values()
    {
        $list= array();
    
        $list['idob'][]= array("1", "2");
        $list['idob'][]= array("2", "3");
        $list['idob'][]= array("3", "2");

        return $list;
    }
    
    
    
    
    
    
    
    
    public static function config_keys()
    {
    

//$list['id_user']= "iduser";
        $list['surname']= "nom";
        $list['firstname']= "prenom";
        $list['town_birth']= "lieunais";
        $list['determ_client']= "civilite";
        $list['proj_type']= "idob";
        //$list['name_qual']= "diplome";
        //$list['origin_qual']= "lieuobtention";
        //$list['option_qual']= "options";
        //$list['start_work']= "datepriservice";
        //$list['scale']= "echelle";


        return $list;
    }

    
    

    
    
    public static function convert_old_values($list, &$data)
    {
        foreach ($list as $old_key => $values) {
            if (isset($data[$old_key])) {
                if (is_array($values)) {
                    for ($i=0; $i < count($values); $i++) {
                        $pair= $values[$i];
                    
                        if (is_array($pair)) {
                            $old_value= trim(strtolower($pair[0]));
                            $new_value= trim(strtolower($pair[1]));
                                                
                            if ($old_value == $data[$old_key]) {
                                $data[$old_key]= $new_value;
                            }
                        } else {
                            f1::echo_warning("No pair of values at index \"{$i}\", in met#convert_old_values, cls#".get_class($this));
                        }
                    }
                } else {
                    f1::echo_warning("Invalid format for values list, index is \"{$old_key}\", 
				in met#convert_old_values, cls#".get_class($this));
                }
            } else {
                f1::echo_warning("old key \"{$old_key}\" not set, in met#convert_old_values, cls#".get_class($this));
            }
        }
    }
    
    
    
    
    
    
    
    public static function convert_keys($list, &$data)
    {
        foreach ($list as $new_key => $old_key) {
            if (isset($data[$old_key])) {
                $data[$new_key]= $data[$old_key];
                unset($data[$old_key]);
            }
        }
    }
    
    
    
    
    
    
    public static function convert_id($converter1, $converter2, $converter3=array(), &$data)
    {
        if ($_REQUEST['obj'] == "project") {
            if ($converter1[$data['idarr']]) {
                $data['id_file']= $converter1[$data['idarr']];
            } elseif ($converter2[$data['file_ref']]) {
                $data['id_file']= $converter2[$data['file_ref']];
            } else {
                $data['id_file']= 1;
            }
        } elseif ($_REQUEST['obj'] == "id_bordereau") {
            if ($converter3[$data['idarr']]) {
                $data['id_proj']= $converter3[$data['idarr']];
            } else {
                $data['id_proj']= 0;
            }
        } elseif ($_REQUEST['obj'] == "client") {
            if ($converter1[$data['idarr']]) {
                $data['id_file']= $converter1[$data['idarr']];
            } elseif ($converter2[$data['file_ref']]) {
                $data['id_file']= $converter2[$data['file_ref']];
            } else {
                $data['id_file']= 1;
            }
            
            //-----------------
        
            if ($converter3[$data['idarr']]) {
                $data['id_proj']= $converter3[$data['idarr']];
            } else {
                $data['id_proj']= 0;
            }
        }
    }
    
    
    
    
    
    
    public function convert_file_data(&$data)
    {
        global $t;
    
        $string= trim($data['NumArret']);

        $string= str_replace(" ", "", $string);

        $string= str_replace("L:00", "L.00", $string);
        $string= str_replace("L;00", "L.00", $string);
        $string= str_replace("L-00", "L.00", $string);
        $string= str_replace("L00", "L.00", $string);

        $string= str_replace("L0", "L.0", $string);
        $string= str_replace("L:0", "L.0", $string);
        $string= str_replace("L;0", "L.0", $string);
        $string= str_replace("L-0", "L.0", $string);

        $string= str_replace("L:", "L.", $string);
        $string= str_replace("L;", "L.", $string);
        $string= str_replace("L-", "L.", $string);

        $string= str_replace("LDS", "DS", $string);


        $list= explode("/", $string);

        $count= count($list);

        if ($count > 2) {
            unset($list[$count-1]);
            unset($list[$count-2]);
        }
        
        
        for ($i=0; $i < count($list); $i++) {
            $list[$i]= strtoupper($list[$i]);
        }

        
        $data['file_ref']= implode("/", $list);
    }
    
    
    
    
    
    
    public function convert_project_data(&$data)
    {
        $string= trim($data['NumArret']);

        $string= str_replace(" ", "", $string);

        $string= str_replace("L:00", "L.00", $string);
        $string= str_replace("L;00", "L.00", $string);
        $string= str_replace("L-00", "L.00", $string);
        $string= str_replace("L00", "L.00", $string);

        $string= str_replace("L0", "L.0", $string);
        $string= str_replace("L:0", "L.0", $string);
        $string= str_replace("L;0", "L.0", $string);
        $string= str_replace("L-0", "L.0", $string);

        $string= str_replace("L:", "L.", $string);
        $string= str_replace("L;", "L.", $string);
        $string= str_replace("L-", "L.", $string);

        $string= str_replace("LDS", "DS", $string);

        $string= strtoupper($string);
    
        $data['proj_ref']= $string;
    }
    
    
    
    
    
    public function convert_id_bordereau_data(&$data)
    {
        $string= trim($data['NumBordT']);

        $list= explode("/", $string);

        $year= date("Y", time());
        $data['year_id_bordereau']= $year."-".$list[0];
    }
    
        
    
    
    
    public function convert_client_data(&$data)
    {
        $data['civilite']= trim($data['civilite']);
        $data['civilite']= strtolower($data['civilite']);

        if ($data['civilite'] == "monsieur") {
            $data['sex']= 0;
        } else {
            $data['sex']= 1;
        }
            
        $data['civilite']= ucfirst($data['civilite']);
    
        $string= trim($data['datenais']);
        $list= explode("-", $string);
        $data['date_birth']= $list[2]."-".$list[1]."-".$list[0];

        /*$string= trim($data['datepriservice']);
        $list= explode("-", $string);
        
                    if (!is_numeric($list[0]))
                    $list[0]= 1;
        
                    if (is_numeric($list[1]) && is_numeric($list[2]))
                    $data['start_work']= $list[2]."-".$list[1]."-".$list[0];*/
    }
}
