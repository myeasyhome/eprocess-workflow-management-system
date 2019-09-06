<?php


class obj_handler_member extends website_object
{
    public function config()
    {
        parent::config();

        $this->has['title']=false;

        $this->i_var['writable_data_list']= array("all_data");
    }
}
