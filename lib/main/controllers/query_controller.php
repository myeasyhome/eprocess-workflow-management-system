<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class query_controller
{
    protected $i_var;
    protected $queries_shelf;
    protected $queries;
    protected $limit;
    protected $filter;
    protected $order;


    //--------------------------



    public function __construct()
    {
        $this->initialize();
    }
    
    
        
    
    
    
    protected function initialize()
    {
        global $s;

        $this->queries_shelf= array();

        $this->queries= array();

        $this->i_var= array();

        //--------------------

        $this->limit= "";

        $this->filter= ""; // set to empty

        $this->order= "";
    }
    
    
    
    
    
    
    public function set_queries()
    {
        global $c, $s, $m, $t, $q, $u;


        //--------------

        $error_msg=FATAL_MSG." Error qrc_nqu";

        //-----------------------------

        $prefix= array();

        $this->queries_shelf= $s->set_queries_classes();

        for ($i=0; $i < count($this->queries_shelf); $i++) {
            $list= explode(">>", $this->queries_shelf[$i]);
        
            $this->queries_shelf[$i]= $list[0];
            $file= $list[0].".php";
            $prefix= $list[1];

        
            $c->insert_file($file, $prefix, $error_msg);
        }

        
        //--------------------------

        if (empty($this->queries_shelf)) {
            f1::echo_error("empty queries_shelf, in #met #set_queries, #cls #query_controller");
            exit;
        }
    }


    
    
    
    
    
    protected function load_queries()
    {
        global $c, $s, $m, $t, $q, $u;


        //----------------------

        $list= $s->set_db_variables();

        if (is_array($list)) {
            $this->i_var= array_merge($list, $this->i_var);
        }
        
        //------------------------------------------
        
        for ($i=0; $i < count($this->queries_shelf); $i++) {
            $obj= new $this->queries_shelf[$i]();
        
            $obj->get_queries(
            $this->i_var,
            $this->filter,
            $this->order,
                    $this->limit,
            $queries
        );

                    
            if (!empty($queries) && is_array($queries)) {
                $this->queries= array_merge($this->queries, $queries);
            } else {
                exit(FATAL_MSG." Error qco_loqu");
            }
        }
    }
    
    
    
    
    
    
    
    public function get_queries()
    {
        $this->load_queries();
    
        if ($this->queries) {
            return $this->queries;
        } else {
            f1::echo_error("queries array is empty, in #met #get_queries, #cls #query_controller");
        }
    }
    
    
    
    
    
    
    
    
    
    public function set_var($name, $value)
    {
        if ($name) {
            if ($value && is_string($value)) {
                $value= $this->format_string($value, true);
            }
            
            $this->i_var[$name]= $value;
        } elseif (empty($name) && is_array($value)) {
            foreach ($value as $x_name=>$x_value) {
                if ($x_value && is_string($x_value)) {
                    $x_value= $this->format_string($x_value, true);
                }
                
                $this->i_var[$x_name]= $x_value;
            }
        }
    }
        

    
    
    
    
    public function format_string($value, $fix_slashes=false)
    {
        $delete = array("'\"", "<script", "/>");
    
        $value = str_ireplace($delete, "", $value);
    
        $value= trim($value);
    
        if ($fix_slashes) {
            $value= f1::fix_slashes($value);
        }
    
        return $value;
    }

    
    
    
    
    public function get_var($name)
    {
        if (is_string($name)
                && isset($this->i_var[$name])) {
            return $this->i_var[$name];
        }
    }
    
    
    
    
    public function set_limit($value)
    {
        if (is_numeric($value)) {
            $this->limit= " LIMIT ".$value;
        } elseif (is_string($value)) {
            $this->limit= " ".f1::fix_slashes($value);
        } else {
            f1::echo_error("could not set limit in sql query");
        }
    }
    
    
    
    
    
    
    
    public function set_order($value)
    {
        if (is_string($value)) {
            $this->order= " ".f1::fix_slashes(trim($value));
        } else {
            f1::echo_error("could not set order in sql query");
        }
    }

    

    

    
    
    public function set_filter($string, $append= true)
    {
        if (empty($string)) {
            return;
        }
    
    
        $string= $this->format_string($string);


        $pos_string= strpos($this->filter, $string);

        if ($pos_string !== false) {
            return;
        }
        
        
        $pos_and= strpos($string, "AND");

        
        if (empty($this->filter)) {
            if (($pos_and !== false) && ($pos_and <= 5)) {
                $string= " ".$string;
            } else {
                $string= " WHERE ".$string;
            }
        } else {
            if (($pos_and !== false) && ($pos_and <= 5)) {
                $string= " ".$string;
            } else {
                $string= " AND ".$string;
            }
        }
        
        //----------------
        
        if ($append) {
            $this->filter .= $string;
        } else {
            $this->filter= $string;
        }
    }

    
    
    
    
    
    
    
    protected function print_query($data_source, $invalid= false, $index= -1)
    {
        $name_color= "green";
        $data_source_color= "brown";
        $size= "1em";
    
    
        if ($index >= 0) {
            $print_query= $this->queries[$data_source][$index];
        } else {
            $print_query= $this->queries[$data_source];
        }
    

        if ($invalid) {
            $name_color= "blue";
            $data_source_color= "red";
            $size= "1.2em";
                
            echo "<br/><br/><strong style=\"font-size:{$size};color:red;\">Invalid query:<br/> ".mysql_error()."</strong><br/><br/>";
        }
        
    
        echo "<br/><br/>Query name is:<strong style=\"font-size:{$size};color:{$name_color};\">{$data_source}</strong><br/><br/>";

        if ($index >= 0) {
            echo "<strong style=\"color:blue;\">index is {$index}</strong><br/><br/>";
        }

        
        echo "<strong style=\"font-size:{$size};color:{$data_source_color};\">SQL query is: {$print_query}</strong><br/><br/>";

        HTML;
    }

    
    
    
    


    

    public function sql_select($x, &$y, &$z, $clear_option="none")
    {
        global $c, $s, $m, $t, $q, $u;


        $this->load_queries();


        if ($s->show_queries) {
            $this->print_query($x);
        }

        
        
        $numrows= 0;
        
        
        try {
            $res= mysql_query($this->queries[$x]);
        
            if (!$res) {
                throw new Exception();
            }
            
            $numrows = mysql_num_rows($res);
        } catch (Exception $e) {
            $this->print_query($x, true);
        }


        
        $y= $numrows;
        
        
        
        if ($numrows >= 1) {
            $z= $res;
        }

        
        //-------------------Clear--------------------

        $this->clear($clear_option);
    }
    
    
    
    
    
    
    public function clear($option="all")
    {
        if ($option == "all") {
            $this->filter= "";
            $this->i_var= array();
            $this->limit= "";
            $this->order="";
        } elseif ($option == "filter") {
            $this->filter= "";
        } elseif ($option == "var") {
            $this->i_var= array();
        } elseif ($option == "limit") {
            $this->limit= "";
        } elseif ($option == "order") {
            $this->order="";
        }
    }
    
    

    
    
    

    public function sql_action($data_source)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->load_queries();


        if (is_array($this->queries[$data_source])) {
            if ($s->get_data("show_queries")) {
                $this->print_query($data_source, false, 0);
            }
            
        
            try {
                $res= mysql_query("START TRANSACTION;");
            
                if (!$res) {
                    throw new Exception();
                }
            } catch (Exception $e) {
                f1::echo_error("Could not start sql transaction!");
                return false;
            }
            
            
            try {
                $res= mysql_query($this->queries[$data_source][0]);
            
                if (!$res) {
                    throw new Exception();
                }
            
                $this->i_var['new_id'] = mysql_insert_id(); // get new id from last insert query, if any...
                
                $this->load_queries();
            } catch (Exception $e) {
                $this->print_query($data_source, true, 0);
                return false;
            }
            
                                
            for ($i=1; $i < count($this->queries[$data_source]); $i++) {
                try {
                    if ($s->get_data("show_queries")) {
                        $this->print_query($data_source, false, $i);
                    }
            
            
                    $res= mysql_query($this->queries[$data_source][$i]);
                
                    if (!$res) {
                        throw new Exception();
                    }
                } catch (Exception $e) {
                    $this->print_query($data_source, true, $i);
                    return false;
                }
            }
            
            
            try {
                $res= mysql_query("COMMIT;");
            
                if (!$res) {
                    throw new Exception();
                }
            } catch (Exception $e) {
                f1::echo_error("Could not commit sql transaction!");
                return false;
            }
        } //--------------------closes if (is_array($this->queries[$data_source]))

        elseif ($this->queries[$data_source]) {
            if ($s->get_data("show_queries")) {
                $this->print_query($data_source, false);
            }
        
        
            try {
                $res= mysql_query($this->queries[$data_source]);
            
                if (!$res) {
                    throw new Exception();
                }
                                    
                $this->i_var['new_id'] = mysql_insert_id(); // get new id  from insert query, if any...
            } catch (Exception $e) {
                $this->print_query($data_source, true);
                return false;
            }
        } else {
            f1::echo_error("Query with name \"{$data_source}\" was not found!");
            return false;
        }
        
        return true;
    }
    

    
    
    
    

    public function get_with_query($name_tag, $data_source)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->queries_select($data_source, $numrows, $res, "all");


        if ($numrows === 1) {
            $row = mysql_fetch_array($res);

            return $row[$name_tag];
        }
    }
}
