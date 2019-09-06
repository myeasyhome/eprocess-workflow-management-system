<?php


class list_actions extends list_items
{
    public function config()
    {
        global $c, $t;

        parent::config();


        $this->i_var['pagenum_tag']= "act_pg";
        $this->i_var['current_url']= $c->update_current_url($this->i_var['pagenum_tag']);
        $this->i_var['paging_max_items']= 4;
        $this->i_var['paging_maxpages']= 2;


        $this->reference="list_actions";
        $this->id_tag="id_action";

        $this->data_source="select_action_log1";

        $this->has['filter']= true;
    }
    
    
    
    
    
    public function config_paging()
    {
        $this->i_var['paging_open_nav']="<div class=\"paging\" >";
        $this->i_var['paging_close_nav']="</div>";
    }
    
    

    
    
    public function set_filter()
    {
        global $q;
    }

    
    
    public function display_skeleton()
    {
        global $s, $u, $q;


        echo <<<HTML

<div class="action_item">
{$this->data['describe_action']}
</div>


HTML;
    }
}
