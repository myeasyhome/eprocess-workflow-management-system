<?php


class db_variables extends list_items
{
    public function config()
    {
        global $q;

        parent::config();


        if ($_GET['db']) {
            $this->select_database(f1::fix_slashes($_GET['db']));
        
            $this->data_source="show_tables";
            $q->set_var("database", f1::fix_slashes($_GET['db']));
            $this->set_title("VARIABLES OF ".$_GET['db'], "h2");
        }


        $this->has['paging']=false;
    }
    
    
    
    
    
    public function display_queries()
    {
        global $q;
    
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                $table= $value;
            
                $q->set_var("table", $table);
            
                $q->sql_select("show_columns", $numrows, $res);
            
                if ($numrows === 0) {
                    f1::echo_error("no columns for table ".$table);
                } else {
                    $fields=array();
                
                    while ($data= mysql_fetch_assoc($res)) {
                        $fields[]= $data;
                    }
                    
                    $this->display_variables($table, $fields);
                }
            }
        } else {
            f1::echo_error("not array, in cls#list2, met#display_queries");
        }
    }
    
    
    
    
    
    public function display_variables($table, $fields)
    {
        for ($i=0; $i < count($fields); $i++) {
            if ((strpos($fields[$i]['Type'], "varchar") !== false)
                        || (strpos($fields[$i]['Type'], "text") !== false)
                        || (strpos($fields[$i]['Type'], "date") !== false)) {
                echo "<br/>\$i_var['".$fields[$i]['Field']."']=\"\";";
            } else {
                echo "<br/>\$i_var['".$fields[$i]['Field']."']=\"0\";";
            }
        }
    }
    
    
    
    
    
    public function display_delete($table, $fields)
    {
        $id_name= $fields[0]['Field'];
    
        echo <<<TXT

\$queries['delete_{$table}']="DELETE * FROM {$table};";

<br/><br/><br/>

\$queries['delete_from_{$table}']="DELETE FROM {$table} WHERE {$id_name}='".\$i_var['{$id_name}']."';";

TXT;
    }
    
    
    
    
    
    public function display_select($table, $fields)
    {
        echo <<<TXT

\$queries['select_{$table}']="SELECT * FROM {$table} ".\$filter.\$order.\$limit.";";

TXT;
    }
    
    
    
    
    

    public function display_skeleton()
    {
        $this->display_queries();
    }
}
