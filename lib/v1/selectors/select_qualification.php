<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class select_qualification extends selector
{ // creates a select list from an sql query resource



    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->set_title($t->qualifications, "h2");

        $this->select_name= "id_qual";

        $this->data_source="select_qualification1";

        $this->id_tag= "id_qual"; // default
$this->label_tag= "name_qual"; // default

$this->has['submit']= false;
        $this->has['form']= false;
    }
    
    
    
    
    
    public function onsubmit()
    {
    }
    
    
    
    
    
    
    public function start()
    {
        global $s;

        $this->selected= isset($this->data[$this->id_tag]) ? $this->data[$this->id_tag] :
                                                    (isset($_REQUEST[$this->id_tag]) ? $_REQUEST[$this->id_tag] : null);
    }
}
