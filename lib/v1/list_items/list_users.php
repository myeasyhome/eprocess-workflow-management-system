<?php


class list_users extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_users";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_user";
        $this->id_tag="id_user";
        $this->set_title($t->users, "h2");
        $this->data_source="select_user1";
        $this->has['create']= true;
        $this->has['filter']= true;

        $this->display_list= array("mf_username", "surname", "firstname", "name_dept", "status_name", "has_create_file", "has_create_project", "has_create_bordereau", "has_print_letter", "has_stats");


        $this->i_var['primary_name_tag']= "username";
    }
    
    
    
    
    
    
    public function set_filter()
    {
        global $s, $u, $q;
    
        $status_list= $s->user_status;
    
        if (!$u->is_super_admin()) {
            $q->set_filter("user1.user_status <> '".$status_list['super_admin']."'");
        }
        
        $q->set_order("ORDER BY id_dept ASC");
    }

    
    

    
    
    

    public function display_skeleton()
    {
        global $s, $u, $q, $t;

        $list= $s->user_status;

        foreach ($list as $name => $status) {
            if ($status == $this->data['user_status']) {
                $status_name= $name;
            }
        }
        
        $this->data['status_name']= $t->$status_name;
        
        if (($u->id != 1) && ($this->data['status_name'] == "super_admin")
                    && ($this->data['id_user'] == 1)) {
            return;
        }
        
        $q->set_filter("id_dept='".$this->data['id_dept']."'");
        $this->data['name_dept']= $this->set_data_from_id("select_department1", "", "name_dept");

        $this->data['status_id_user']= $this->data['user_status']."_".$this->data['id_user'];

        $keep= $this->id_tag;
        $this->id_tag= "status_id_user";


        $this->data['mf_username']= $this->data['username'];

        if ($this->data['is_gen_dir']) {
            $this->data['mf_username']= "<span class=\"blue_bold\">".$t->gen_dir.":</span> ".$this->data['username'];
        }

        if ($this->data['is_minister']) {
            $this->data['mf_username']= "<span class=\"blue_bold\">".$t->minister.":</span> ".$this->data['username'];
        }
        
        
        $list= array("has_create_file", "has_create_project", "has_create_bordereau", "has_print_letter", "has_stats");

        for ($i=0; $i < count($list);  $i++) {
            $name= &$list[$i];
                
            $ref= $s->no_yes[$this->data[$name]];
            $string= $t->$ref;
        
            $this->data[$name]= $this->data[$name] ? "<span class=\"blue\">".$string."</span>" :
            "<span class=\"red\">".$string."</span>";
        }
        
        
        $this->view_data();

        $this->id_tag= $keep;
    }
    
    
    
    
    public function display_submit()
    {
        global $t;
    
        parent::display_submit();

        echo <<<HTML

<input type="submit" class="submit_button" name="is_minister" value="{$t->minister}"/>

HTML;

        echo <<<HTML

<input type="submit" class="submit_button" name="is_gen_dir" value="{$t->gen_dir}"/>

HTML;
    }
}
