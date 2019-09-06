<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class list_letters extends list_items_adapter
{
    public function config()
    {
        global $u, $t;

        parent::config();

        $this->subject= "letter";

        $this->reference="letters";
        $this->i_var['form_name']= $this->reference;

        $this->i_var['target_url']= $s->root_url."?v=edit_letter";
        
        $this->id_tag="id_letter";
        $this->set_title($t->letters, "h2");
        $this->data_source="select_letter1";
        $this->has['create']= true;
    
        $this->display_list= array("id_letter", "title_letter");


        if ($u->is_super_admin()) {
            $this->display_list[]= "name_dept";
        }
        
        
        if (!$u->is_admin()) {
            $this->has['create']= false;
            $this->has['edit']= false;
            $this->has['ask_delete']= false;
            $this->has['delete']= false;
        }
    }
    
    
    
    
    
    public function set_filter()
    {
        global $s, $u, $q;
    
        if (!$u->is_super_admin()) {
            $q->set_filter("(letter1.id_dept='".$u->id_dept."' OR letter1.id_dept='0')");
        }
    }
    

    
    
    public function display_skeleton()
    {
        global $s, $u, $q, $t;


        if ($u->is_super_admin()) {
            $q->set_filter("id_dept='".$this->data['id_dept']."'");
            $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");
        }

        $this->data['name_dept']= $this->data['name_dept'] ? $this->data['name_dept'] : $t->all;
        $this->view_data();
    }
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;

        parent::display_submit();
        
        echo <<<HTML

<input type="submit" class="submit_button" name="letter_use_template" value="{$t->letter_use}"/>

HTML;
    }
}
