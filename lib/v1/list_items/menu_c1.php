<?php


class menu_c1 extends menu
{
    public function config()
    {
        global $u;
    
        parent::config();


        //--------------------------------------------------------

        $this->i_var['wrap_subitems_tag']="";
        $this->i_var['wrap_item_tag']="";

        //----------------------------

        // ref: reference of item
        // status: 0 (menu item without subitems)|  1 (menu item with subitems) | 2 (subitems)
        // parent: ref of parent item, root means none
        //type: display type

        if ($u->is_admin()) {
            $this->menu_items[]= array("ref" => "users", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "departments", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            $this->menu_items[]= array("ref" => "file_types", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
            $this->menu_items[]= array("ref" => "file_categories", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        
            $this->menu_items[]= array("ref" => "project_types", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
            $this->menu_items[]= array("ref" => "project_status", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        
            $this->menu_items[]= array("ref" => "services", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "works", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "ranks", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            $this->menu_items[]= array("ref" => "qualifications", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
            $this->menu_items[]= array("ref" => "class", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        
            $this->menu_items[]= array("ref" => "manage_letters", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            $this->menu_items[]= array("ref" => "carriers", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            $this->menu_items[]= array("ref" => "all_files_transit", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "all_files_rejected", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "all_other_files", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "all_proj_transit", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "all_proj_rejected", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
            $this->menu_items[]= array("ref" => "all_other_proj", "parent" => "root", "type" => 1, "status" => 0, "active" => 1 );
        
            if ($u->is_super_admin() || (!$u->is_super_admin() && $u->has_stats)) {
                $this->menu_items[]= array("ref" => "manage_stat_reports", "parent" => "root",
            "type" => 1, "status" => 0, "active" => 1 );
            }
            
            $this->menu_items[]= array("ref" => "manage_sms", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
            
            $this->menu_items[]= array("ref" => "send_receive_sms", "parent" => "root", "type" => 1, "status" => 0, "active" => 1);
        } else {
            $this->has['data']= false;
        }
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
