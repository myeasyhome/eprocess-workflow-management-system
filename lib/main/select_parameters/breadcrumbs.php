<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class breadcrumbs extends website_object
{
    protected $separator;


    public function config()
    {
        global $s, $m;

        $this->has['data']= false;

        $this->separator= " | ";
    
        $this->list= array();

        $this->list[]= $m->cat_name;
        $this->list[]= $m->subcat_name1;

        $this->list[]= $m->language_name;

        $this->list[]= $m->country_name;
        $this->list[]= $m->town_name;
        $this->list[]= $m->subtown_name;
    }
    
    
    
    
    
    public function display()
    {
        $n= count($this->list);
    
        for ($i=0; $i < $n-1; $i++) {
            if (!empty($this->list[$i])) {
                echo $this->list[$i].$this->separator;
            }
        }

        if (!empty($this->list[$n-1])) {
            echo $this->list[$n-1];
        }
    }
}
