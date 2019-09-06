<?php


class list1 extends list_items
{
    public function config()
    {
        parent::config();

        $this->set_title("list1", "h2");
        $this->data_source="list1";
    }
    
    
    
    

    public function display_skeleton()
    {
        $this->display_basic_skeleton();
    }
}
