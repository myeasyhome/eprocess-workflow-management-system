<?php


class list2 extends list_items
{
    public function config()
    {
        parent::config();

        $this->set_title("list2", "h2");

        $this->data_source="list2";

        $this->has['paging']=false;
    }

    
    
    
    

    public function display_skeleton()
    {
        $this->display_basic_skeleton();
    }
}
