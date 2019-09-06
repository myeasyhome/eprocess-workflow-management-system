<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class list_search_results extends list_items
{
    protected $search_param;
    protected $search_cat_list; // search categories




    
    public function initialize()
    {
        global $c, $s, $m, $t, $q, $u;


        parent::initialize();

        $this->search_cat_list= $_SESSION['search_cat_list'] ? $_SESSION['search_cat_list'] : array();
    }
    
    
    
    
    


    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        parent::config();

        $this->has['search_num_results']= true;
        $this->has['filter'] = true;
        $this->has['skeleton'] = true;
        $this->has['title']= true;
        $this->has['filter_by_period']= false;
        $this->has['file_data_query']= false;
        $this->i_var['query_has_conditions']= false;

        
        if ($_GET['sp']) {
            $this->i_var['query_has_conditions']= true;
    
            $this->search_param= search_keywords_controller::delete_accents($_GET['sp']);

            if ($this->has['wrapper']) {
                $this->set_title("");
            } else {
                $this->set_title($t->search);
            }

            $this->data_source= "search";
        
            $t->set_var("keywords", $this->search_param, true);
        }
        
        $this->no_result_msg= "<div class=\"no_result_msg\">".$t->no_result."</div>";
    }
    
    
    
    

    
    public function display_skeleton()
    {
        $this->display_basic_skeleton();
    }
    
    
    
    
    
    

    public function display()
    {
        global $c, $s, $m, $t, $q, $u;



        buttons::back();

        $_REQUEST['bkb']=null; // hide back button


        if ($this->numrows >= 0) {
            $this->display_title();
        }
                
        if ($this->has['search_num_results'] && $this->search_param && ($this->numrows > 0)) {
            $t->set_var("numrows", $this->numrows, true);

            echo "<div class=\"num_results\">{$t->search_num_results}</div>";
        }
        
        parent::display();
    }
}  //closes: class list============================================================
