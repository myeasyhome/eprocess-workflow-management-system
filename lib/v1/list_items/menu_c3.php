<?php


class menu_c3 extends menu
{
    public function config()
    {
        global $u;
    
        parent::config();

        //--------------------------------------------------------

        $this->i_var['wrap_subitems_tag']="";
        $this->i_var['wrap_item_tag']="";

        //--------------------------------------------------------

        // ref: reference of item
        // status: 0 (menu item without subitems)|  1 (menu item with subitems) | 2 (subitems)
        // parent: ref of parent item, root means none
        //type: display type

        if ($u->is_logged_in("zn_operator") || $u->is_logged_in("zn_supervisor")) {
            $this->menu_items[]= array("ref" => "home", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
        
            $this->menu_items[]= array("ref" => "files", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "projects", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        } else {
            $this->menu_items[]= array("ref" => "home", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            $this->menu_items[]= array("ref" => "public_search", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        }
    }
    
    
    
    
    
    protected function define_item_type($item, $label)
    {
        $class="";

        switch ($item['type']) {
        
        case "1":
        
        if (($item['ref'] == $_GET['v'])
                || (!$_GET['v'] && ($item['ref'] == "home"))) {
            $class="class=\"active\" ";
        }

echo <<<HTML
<li>
<a {$class} href="{$s->root_url}?v={$item['ref']}"><span class="l"></span><span class="r"></span><span class="t">{$label}</span></a>
</li>
HTML;

        break;
                
        }
    }
}
