<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class print_handler extends website_object
{
    private $shelf;
    private $pointer;


    public function config()
    {
        global $c, $m, $u;



        $this->has['form']= true;
        $this->has['submit']= true;

        $this->i_var['target_url']= $c->update_current_url("next_selected");
        $this->i_var['form_name']= "print_handler";
        $this->i_var['form_method']= "GET";


        $this->shelf= array();
        $memory_pointer= $m->print_handler_pointer;


        if ($_REQUEST['process_preview'] || ($_REQUEST['v'] == "process_preview")) {
            $this->is['process_preview']= true;
        }
        

        if (is_numeric($memory_pointer) && $_REQUEST['next_selected']) {
            $this->selected= $m->print_handler_selected;
        } elseif (is_array($_REQUEST['data_print_letter'])) {
            for ($i=0; $i < count($_REQUEST['data_print_letter']); $i++) {
                $list= explode("_", $_REQUEST['data_print_letter'][$i]);
                $this->selected[$i]= $this->require_id("numeric", $list[0]);
            }
        }

        //------------------------------
                    
        if ($u->dept_has_write_letter && $u->has_print_letter && ($_REQUEST['print_selected'] || $_REQUEST['print_all'])) {
            $this->is['printable']= true;
            $this->has['submit']= false;
        } else {
            $count= count($this->selected);

            if (($count > 1) && (!is_numeric($memory_pointer) || !$_REQUEST['next_selected'])) {
                $this->pointer= 0;
            } elseif (is_numeric($memory_pointer) && $_REQUEST['next_selected']) {
                $this->pointer= &$memory_pointer;
            
                $this->pointer= ($this->pointer == ($count-1)) ? 0 : ++$this->pointer;
            }
            
            if ($count > 1) {
                $this->has['many']= true;
            }
        }
    }
    
    
    
    
    
    private function initialize_object()
    {
        $obj= new letter_preview_handler();
        $obj->initialize();
        $obj->config();


        $obj->set_has("submit", false);
        $obj->set_has("form", false);
        $obj->set_has("save", false);


        return $obj;
    }
    
    
    
    
    

    public function onsubmit()
    {
    }
    
    
    
    
    
    
    public function set_data()
    {
        global $q;


        if (!empty($this->selected)) {
            $list= &$this->selected;

            for ($i=0; $i < count($list); $i++) {
                if (is_numeric($list[$i])) {
                    $q->set_filter("AND print_letter1.id_print_letter='".$list[$i]."'");
                    $q->sql_select("select_print_letter1", $numrows, $res, "all");
        
                    if ($numrows == 1) {
                        $this->make_object(mysql_fetch_assoc($res));
                    } else {
                        f1::echo_error("#data not found for letter with #id ".$list[$i].", 
							in met#manage_list, cls#print_handler");
                    }
                }
            }
        } elseif ($_REQUEST['print_all']) {
            $q->sql_select("select_print_letter1", $numrows, $res, "all");
        
            if ($numrows >= 1) {
                while ($data= mysql_fetch_assoc($res)) {
                    $this->make_object($data);
                }
            }
        }
    }
    
    
    
    
    
    private function make_object(&$data)
    {
        $obj= $this->initialize_object();
        $obj->set_id_letter($data['id_letter']);
        $obj->set_id_proj($data['id_proj']);

        $this->store_object($obj);
    }
        
    
    
    
    private function store_object(&$obj)
    {
        $_REQUEST['process_preview']= true;

        $obj->set_data();
        $obj->start();

        $this->shelf[]= $obj;
    }
    
    
    
    
    
    public function display_submit()
    {
        global $m, $u, $t;


        echo "<div class=\"submit_section\">";


        if (!$this->has['many']) {
            buttons::back(true);
        } elseif ($this->has['many']) {
            echo <<<HTML

<input type="submit" class="submit_button" name="print_letters" value="{$t->back}"/>


<input type="submit" class="submit_button" name="next_selected" value="{$t->next}"/>

HTML;
        }

        echo "</div>";
    }
    
    
    
    
    
    
    
    public function display()
    {
        if (count($this->shelf)) {
            if ($this->is['printable']) {
                echo <<<HTML

<script language="javascript" type="text/javascript">
//<!--

function print_page () {

window.print();

}

print_page();

//-->
</script>

HTML;

                for ($i=0; $i < count($this->shelf); $i++) {
                    $this->shelf[$i]->display();
                }
            } else {
                if ($this->has['form']) {
                    $this->open_form($this->i_var['form_name'], $this->i_var['form_method'], $this->i_var['target_url']);
                }
        
                //--------
                
                if ($this->has['submit']) {
                    $this->display_submit();
                }
            
                if ($this->has['many']) {
                    $this->shelf[$this->pointer]->display();
                } else {
                    $this->shelf[0]->display();
                }
                
                //------------------
            
                if ($this->has['form']) {
                    echo "</form>";
                }
            }
        }
        
        //--------------------------
        
        unset($this);
    }
    
    
    
    
    
    public function __destruct()
    {
        global $m;

        if ($this->has['many']) {
            $m->print_handler_selected= $this->selected;
            $m->print_handler_pointer= $this->pointer;
        }
    }
}
