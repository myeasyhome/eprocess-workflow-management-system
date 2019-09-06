<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class list_sms extends list_items_adapter
{
    public function config()
    {
        global $u, $t;

        parent::config();

        $this->subject= "sms";

        $this->reference="sms";
        $this->i_var['form_name']= $this->reference;

        $this->i_var['target_url']= $s->root_url."?v=edit_sms";
        
        $this->id_tag="id_sms";
        $this->set_title($t->sms, "h2");
        $this->data_source="select_sms1";
        $this->has['create']= true;
    
        $this->display_list= array("id_sms", "action", "sms");
    }
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u;

        $this->view_data();
    }
}
