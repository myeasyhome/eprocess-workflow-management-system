<?php


class mk_select extends website_object
{
    protected $fields;
    protected $query;

    public function config()
    {
        $this->has['data']= false;

        $this->query="select";
    
        $this->tables= array();

        $this->tables[]="participations";
        $this->tables[]="etudiants";
        $this->tables[]="cours";

        //------------------------------------------

        $this->fields= array();

        $this->fields[]="etudiant";
        $this->fields[]="idetu";
        $this->fields[]="idcours";
    }
    
    
    
    
    
    public function display()
    {
        $tables= $this->tables;
        $fields= $this->fields;


        echo "\$queries['{$this->query}']=\"SELECT * FROM";

        echo " ".$tables[0];
        
        for ($i=1; $i < count($tables); $i++) {
            echo " INNER JOIN ".$tables[$i]." ON ".$tables[0].".".$fields[0]."=".$tables[$i].".".$fields[$i];
        }
        
        echo "\".\$filter.\$order.\$limit.\";\";";
        
        echo "<br/><br/><br/>";
        
        echo "\$queries['{$this->query}2']=\"SELECT ".$tables[0].".*";
        
        for ($i=1; $i < count($tables); $i++) {
            echo ", ".$tables[$i].".*";
        }
        
        echo " FROM ".$tables[0];
        
        for ($i=1; $i < count($tables); $i++) {
            echo ", ".$tables[$i];
        }
        
        echo "\".\$filter.\$order.\$limit.\";\";";
    }
}
