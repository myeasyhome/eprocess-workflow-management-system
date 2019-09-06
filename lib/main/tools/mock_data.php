<?php



class mock_data extends website_object
{
    public function config()
    {
        global $s, $q;


        $this->i_var['date_keys']= array("start_work");
        $this->i_var['futur_date_keys']= array();

        //------------------------------------------
    
        $list= $q->get_queries();
        $list_queries= array();

        foreach ($list as $name => $query) {
            if (strpos($name, "insert_") !== false) {
                $list_queries[]= $name;
            }
        }
        
        $this->data_source= $list_queries;

        $list_var= $s->set_db_variables();

        $this->data= $this->mk_mock_data($list_var);
    }
    
    
    
    
    
    public function set_data()
    {
        global $q;
    
        foreach ($this->data as $key=>$value) {
            $q->set_var($key, $value);
        }
        
        foreach ($this->data_source as $value) {
            $result= $q->sql_action($value);

            if (!$result) {
                f1::echo_error("invalid query in met#onsubmit, cls#mock_data");
                exit;
            }
        }
    }
    
    
    
    
    
    public function mk_mock_data($list)
    {
        $strings= array("Lorem", "ipsum", "'", " 2 ", "dolor", "sit", "\"", "", "amet", "@", "consectetur", "", "adipisicing", "?", "elit", "sed", "", ": ", "%", "$","do", "eiusmod", "!", "tempor", "incididunt", "+", "ut", "labore", ";", " | ", " ", "et", "", "dolore", "magna", ", ", "aliqua", "", " ", "", " - ");

        foreach ($list as  $key => $value) {
            if (is_numeric($value)) {
                $list[$key]= rand(1, 9999999999);
            } elseif (is_string($value) && ((strpos($key, "date") === false) || in_array($key, $this->i_var['date_keys']))) {
                $one= rand(0, count($strings)-1);
                $two= rand(0, count($strings)-1);
                $three= rand(0, count($strings)-1);
                $four= rand(0, count($strings)-1);
                $five= rand(0, count($strings)-1);
                $list[$key]=  $strings[$one].$strings[$two].$strings[$three].$strings[$four].$strings[$five];
            } elseif (strpos($key, "date") !== false) {
                if (in_array($key, $this->i_var['futur_date_keys'])) {
                    $list[$key]= rand(date("Y"), ((int)date("Y"))+5)."-".rand(1, 12)."-".rand(1, 28);
                } else {
                    $list[$key]= rand(date("Y")-80, ((int)date("Y"))-20)."-".rand(1, 12)."-".rand(1, 28);
                }
            } else {
                f1::echo_error("invalid #value in met#mk_mock_data, cls#mock_data");
                exit;
            }
        }
        
        return $list;
    }
    
    
    
    
    
    public function display()
    {
        echo "<div class=\"confirm\">Mock data created!</div>";
    }
}
