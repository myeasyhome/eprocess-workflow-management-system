<?php


class menu1 extends menu
{
    public function config()
    {
        parent::config();

        //--------------------------------------------------------

        $this->i_var['wrap_subitems_tag']="";
        $this->i_var['wrap_item_tag']="";

        //----------------------------

        // ref: reference of item
        // status: 0 (menu item without subitems)|  1 (menu item with subitems) | 2 (subitems)
        // parent: ref of parent item, root means none
        //type: display type


        $this->menu_items[]= array("ref" => "item1", "parent" => "root", "type" => 1, "status" => 1, "active" => 1 );
        $this->menu_items[]= array("ref" => "item2", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        $this->menu_items[]= array("ref" => "item3", "parent" => "item1", "type" => 2, "status" => 2, "active" => 1);
        $this->menu_items[]= array("ref" => "item4", "parent" => "item1", "type" => 1, "status" => 2, "active" => 1);
    }
    
    
    
    
    
    protected function define_item_type($item, $label)
    {
        switch ($item['type']) {
        
        case "1":
        
        echo "<a href=\"{$s->root_url}?view={$item['ref']}\">{$label}</a>";
        
        break;
        
        case "2":
        
        echo "<a href=\"{$s->root_url}?view={$item['ref']}\">--->{$label}</a>";
        
        break;
                
        }
    }

    

        
        
    public function display()
    {
        echo "<div>";
        parent::display();
        echo "</div>";
    }
}
