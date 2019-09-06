<?php


abstract class menu extends list_items
{
    protected $menu_items;



    public function config()
    {
        parent::config();

        //------------------

        $this->has['no_result_msg']= false;

        $this->menu_items=array();
        $this->list= &$this->menu_items;

        //--------------------------------------------------------

        $this->i_var['wrap_subitems_tag']="span";
        $this->i_var['wrap_item_tag']="span";
    }
    
    

    public function display_skeleton()
    {
        if ($this->data['active'] && ($this->data['status'] < 2)) {
            if ($this->i_var['wrap_item_tag']) {
                echo "<{$this->i_var['wrap_item_tag']}>";
            }
        
            $this->display_item();

            if ($this->data['status'] == 1) {
                $this->display_subitems();
            }
            
            if ($this->i_var['wrap_item_tag']) {
                echo "</{$this->i_var['wrap_item_tag']}>";
            }
        }
    }
    
    
    
    protected function display_subitems()
    {
        if ($this->list && $this->data) {
            if ($this->i_var['wrap_subitems_tag']) {
                echo "<{$this->i_var['wrap_subitems_tag']}>";
            }
        
            for ($i= 0; $i < count($this->list); $i++) {
                if ($this->list[$i]['parent'] == $this->data['ref']) {
                    $this->display_item($this->list[$i]);
                }
            }
            
            if ($this->i_var['wrap_subitems_tag']) {
                echo "</{$this->i_var['wrap_subitems_tag']}>";
            }
        }
    }
    
    
    
    
    protected function display_item($item=array())
    {
        global $t;
        
        if (empty($item) && $this->data) {
            $item= &$this->data;
        }
        
        $label= $t->$item['ref'];
        
        $this->define_item_type($item, $label);
    }
    
    
    

    
    
    protected function define_item_type($item_type)
    {
    }
}
