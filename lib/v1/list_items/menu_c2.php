<?php


class menu_c2 extends menu
{
    public function config()
    {
        global $m, $u;
    
        parent::config();

        //--------------------------------------------------------

        $this->i_var['wrap_subitems_tag']="";
        $this->i_var['wrap_item_tag']="";

        //----------------------------

        // ref: reference of item
        // status: 0 (menu item without subitems)|  1 (menu item with subitems) | 2 (subitems)
        // parent: ref of parent item, root means none
        //type: display type


        if ($u->dept_has_search) {
            $this->menu_items[]= array("ref" => "private_search", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        }
                
        $this->menu_items[]= array("ref" => "files", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        $this->menu_items[]= array("ref" => "projects", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
    
        if ($u->dept_has_write_letter) {
            $this->menu_items[]= array("ref" => "proj_no_letter", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        }
        
        
        $this->menu_items[]= array("ref" => "files_transit", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        $this->menu_items[]= array("ref" => "projects_transit", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        $this->menu_items[]= array("ref" => "file_trans_rejected", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        $this->menu_items[]= array("ref" => "proj_trans_rejected", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
    
        $this->menu_items[]= array("ref" => "letter_preview", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
    
        if ($u->dept_has_write_letter) {
            $this->menu_items[]= array("ref" => "print_letters", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        }
        
        $this->menu_items[]= array("ref" => "printed_letters", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        
    
        if ($u->has_stats) {
            $this->menu_items[]= array("ref" => "stat_reports", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        }

        $this->menu_items[]= array("ref" => "publish", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
    }
    
    
    
    
    
    protected function define_item_type($item, $label)
    {
        $class="";

        switch ($item['type']) {
        
        case "1":
        
        if ($item['ref'] == $_GET['v']) {
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
