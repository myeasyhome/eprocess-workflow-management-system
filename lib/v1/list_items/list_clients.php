<?php


class list_clients extends list_items_adapter
{
    public function config()
    {
        global $c, $u, $t;



        parent::config();


        $this->subject= "client";

        $this->reference="list_clients";
        $this->i_var['form_name']= $this->reference;
        $this->id_tag="id_client";
        $this->set_title($t->clients, "h2");
        $this->data_source="select_client1";

        $this->has['filter']=true;
    
        $this->has['create']= false;
        $this->has['ask_delete']= false;
        $this->has['edit']= false;
        $this->has['delete']= false;
        $this->has['ask_delete']= false;
        $this->has['radio']= false;
        $this->has['checkboxes']= false;


        $id;

        if ($_REQUEST['id_file'] && ($this->option == "file")) {
            $this->numeric_id_from_array($_REQUEST['id_file']);

        
            $this->i_var['target_url']= $s->root_url."?v=file_clients&id_file=".$_REQUEST['id_file'];

            $id= &$_REQUEST['id_file'];
        } elseif ($_REQUEST['id_proj'] && ($this->option == "project")) {
            $this->numeric_id_from_array($_REQUEST['id_proj']);


            $this->i_var['target_url']= $s->root_url."?v=project_clients&id_proj=".$_REQUEST['id_proj'] ;

                
            $id= &$_REQUEST['id_proj'];
        
            $this->has['submit']= true;
            $this->has['edit']= true;
            $this->has['radio']= true;
        } elseif ($_REQUEST['parent_id_proj'] && ($this->option == "proj_project")) {
            $id= &$_REQUEST['parent_id_proj'];
        } elseif ($_REQUEST['id_proj'] && ($this->option == "new_project")) {
            $this->has['paging']= false;
            $id= &$_REQUEST['id_proj'];
        } elseif ($_REQUEST['id_client'] && ($this->option == "view_one")) {
            $this->has['share_data']= true;
            $this->i_var['readable_data_list'][]="id_file";
            $this->i_var['readable_data_list'][]="id_proj";

            $this->i_var['target_url']= $this->i_var['current_url']=
                $s->root_url."?v=client_class&id_client=".$_REQUEST['id_client'] ;

            $id= &$_REQUEST['id_client'];
        
            $this->set_title($t->client, "h2");
        }

        $this->id= $this->require_id("numeric", $id);


        if (!$u->is_logged_in("zn_observer") && !$u->is_logged_in("zn_operator")) {
            $this->display_list= array("id_client", "surname", "firstname");
        } elseif ($this->option == "file") {
            $this->display_list= array("id_client", "surname", "firstname", "has_project","id_agent",  "num_proj", "date_birth", 			"town_birth", "name_client_type", "sex", "num_phone", "email", "has_class");
        } else {
            $this->display_list= array("id_client", "surname", "firstname", "has_project", "id_agent", "date_birth", "town_birth",
            "name_client_type", "sex", "num_phone", "email", "has_class");
        }

        $this->i_var['primary_name_tag']= "surname";
    }
    
    
    
    
    
    public function set_filter()
    {
        global $m, $q;


        if ($_REQUEST['id_file'] && ($this->option == "file")) {
            if (($m->view_ref == "create_project") || ($m->view_ref == "add_to_project")) {
                $q->set_filter("id_file='".$this->id."' AND id_proj='0' ");
            } else {
                $q->set_filter("id_file='".$this->id."' ");
            }
        } elseif (($_REQUEST['id_proj'] && (($this->option == "project") || ($this->option == "new_project"))) ||
                    ($_REQUEST['parent_id_proj'] && ($this->option == "proj_project"))) {
            $q->set_filter("id_proj='".$this->id."'");
        } elseif ($_REQUEST['id_client'] && ($this->option == "view_one")) {
            $q->set_filter("id_client='".$this->id."'");
        }
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;


        if (is_numeric($_REQUEST['id_file'])) {
            echo "<input type=\"hidden\" name=\"id_file\" value=\"{$_REQUEST['id_file']}\" />";
    
            if (is_numeric($_REQUEST['file_status'])) {
                echo "<input type=\"hidden\" name=\"file_status\" value=\"{$_REQUEST['file_status']}\" />";
            } else {
                f1::echo_error("No file status, cls#".get_class($this));
            }
        }

        if (is_numeric($_REQUEST['id_proj'])) {
            echo "<input type=\"hidden\" name=\"id_proj\" value=\"{$_REQUEST['id_proj']}\" />";
        }

        
        parent::display_submit();


        if ($this->has['edit'] && ($this->numrows >= 1)) {
            echo <<<HTML

<input type="submit" class="submit_button" name="client_class" value="{$t->classification}"/>

HTML;
        }
    }
    

    
    
    
    
    public function display_skeleton()
    {
        global $s, $t, $q;


        $this->data['num_proj']= $this->data['id_proj'];


        $this->set_data_hyperlinks($s->root_url."?v=edit_client&id_file={$this->data['id_file']}", array("id_client"));


        if ($this->option == "file") {
            $this->set_data_hyperlinks($s->root_url."?v=project_clients&id_proj=".$this->data['id_proj'], array("num_proj"), false);
        }
        
        
        //------------------

        $keep_tr_class= $this->i_var['tr_class'];


        $this->custom_date(array("date_birth"));


        
        if ($_GET['surname'] || $_GET['firstname']) {
            $this->data['surname']= str_replace("  ", " ", $this->data['surname']);
            $this->data['firstname']= str_replace("  ", " ", $this->data['firstname']);

            if (($_GET['surname'] && (strpos(strtolower($this->data['surname']), strtolower($_GET['surname'])) !== false))
                    || ($_GET['firstname'] && (strpos(strtolower($this->data['firstname']), strtolower($_GET['firstname']))
                    !== false))
                    || ($_GET['date_birth'] && ($_GET['date_birth'] == $this->data['date_birth']))
                    ) {
                $this->i_var['tr_class']= "selected";
            }
        }

        
        $client_types= $s->client_types;
        $string= $client_types[$this->data['client_type']];
        $this->data['name_client_type']= $t->$string;

        $gender= $s->gender;
        $string= $gender[$this->data['sex']];
        $this->data['sex']= $t->$string;

        $this->data['num_phone']= substr(chunk_split($this->data['num_phone'], 3, "-"), 0, -1);


        if (($this->option == "proj_project") && empty($this->has['first_item'])) {
            echo <<<HTML

<div class="msg_prompt">

<span class="msg_img_wrap">
<img src="images/msg_img_info.png">
</span>

<span class="msg_margin">

{$t->proj_min_one_client}

</span>

</div>

HTML;
        
            $this->has['empty_td_element']= true;
            $this->has['checkboxes']= false;
        }
        
        if (empty($this->data['id_agent']) && ($this->data['client_type'] == 0)) {
            $this->data['id_agent']= $t->candidate;
        }
        
        $this->data['surname']= strtoupper($this->data['surname']);
        
        //----------------------
        
        $q->set_filter("client_class1.id_client='".$this->data['id_client']."'");
        $this->set_data_from_id("select_client_class1", "", "", $numrows);


        
        $no= $s->no_yes[0];
        $yes= $s->no_yes[1];
        
        
    
        $this->data['has_class']= ($numrows >= 1) ?
            "<span class=\"blue\">".$t->$yes."</span>" : "<span class=\"red\">".$t->$no."</span>";
            
                        
        
        $this->data['has_project']= (!empty($this->data['id_proj'])) ?
            "<span class=\"blue\">".$t->$yes."</span>" : "<span class=\"red\">".$t->$no."</span>";
            
        

        //--------------------------

        
        $this->view_data();


        if (($this->option == "proj_project") && empty($this->has['first_item'])) {
            $this->has['first_item']= true;
            $this->has['checkboxes']= true;
        }
        
        $this->i_var['tr_class']= $keep_tr_class;
    }
}
