<?php


class list_departments extends list_items_adapter
{
    public function config()
    {
        global $t;

        parent::config();

        $this->reference="list_departments";
        $this->i_var['form_name']= $this->reference;
        $this->i_var['target_url']= $s->root_url."?v=edit_department";
        $this->id_tag="id_dept";
        $this->set_title($t->departments, "h2");
        $this->data_source="select_department1";
        $this->has['create']= true;

        $this->display_list= array("id_dept", "name_dept", "dept_describe", "name_dept_type", "has_search", "has_write_letter", "has_send_sms");

        $this->i_var['primary_name_tag']= "name_dept";
    }
    
    
    

    
    public function display_skeleton()
    {
        global $s, $u, $t;

        $list= $s->department_type;
        $name= $list[$this->data['dept_type']];
        $this->data['name_dept_type']= $t->$name;


        $list= array("has_write_letter", "has_search", "has_send_sms");

        for ($i=0; $i < count($list);  $i++) {
            $name= &$list[$i];
                
            $ref= $s->no_yes[$this->data[$name]];
            $string= $t->$ref;
        
            $this->data[$name]= $this->data[$name] ? "<span class=\"blue\">".$string."</span>" :
            "<span class=\"red\">".$string."</span>";
        }


        $this->view_data();
    }
}
