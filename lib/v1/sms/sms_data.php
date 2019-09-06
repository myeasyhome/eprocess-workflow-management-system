<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class sms_data extends website_object
{
    protected $id_sms;
    protected $id_doc;



    public function set_id_doc($id)
    {
        if (is_numeric($id)) {
            $this->id_doc= $id;
        }
    }
    
    
    
    
    
    public function set_id_sms($id)
    {
        if (is_numeric($id)) {
            $this->id_sms= $id;
        }
    }
    
    
    



    public function set_data()
    {
    }
    
    
    
    

    
    
    public function get_sms()
    {
        global $m, $q;


        $q->set_filter("id_sms='".$this->id_sms."'");
    
        $sms= $this->set_data_from_id("select_sms1", "", "", $numrows);
        $q->clear("filter");

        if ($numrows == 1) {
            return $sms;
        }
    }
    
    
    
    
    
    public function get_document()
    {
        global $m, $q;
    }

    
    
    
    
    public function get_clients()
    {
        global $s, $m, $q, $t;
    }
}
