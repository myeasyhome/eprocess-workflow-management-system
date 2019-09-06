<?php


abstract class form_handler_member extends html_form
{
    public function config()
    {
        parent::config();

        $this->has['title']=false;
        $this->has['submit']=false;
        $this->has['form']=false;

        $this->i_var['writable_data_list']= array("all_data");
        $this->i_var['writable_var_list']= array("update_data_from_global");

        $this->has['delete']= false;
    }
}
