<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




abstract class list_items extends website_object
{
    protected $counter; // number of items displayed (when paging)

    protected $list;

    protected $label_tag;

    protected $link_tag;

    protected $value_tag;

    protected $id_tag;

    protected $category_tag;

    protected $url_tag;

    protected $paging;

    protected $list_id;

    protected $separator;

    protected $num_displayed;


    public function config()
    {
        global $c, $s, $t;

        $this->has['no_result_msg']= true;
        $this->is['list']= true;
        $this->has['skeleton']= true;
        $this->has['filter']= true;

        
        //--------Paging
        $this->i_var['paging_open_nav'];
        $this->i_var['paging_close_nav'];
        $this->has['paging']= true;
        $this->i_var['paging_mode']= "paging";

        $this->i_var['paging_max_items']= $s->paging_max_items;
        $this->i_var['paging_maxpages']= $s->paging_maxpages;

        $this->i_var['pagenum_tag']= $s->pagenum_tag; // url tag to use for page numbers
$this->has['auto_display_paging']= true; // default

$this->i_var['current_url']= $c->update_current_url($this->i_var['pagenum_tag']);
    }


    
    
    
    public function config_paging()
    {
        $this->i_var['paging_open_nav']="";
        $this->i_var['paging_close_nav']="";
    }
    
    
    
    
    public function set_no_result_msg($value)
    {
        $this->no_result_msg= $t->$value;
    }
    
    

    
    
    

    public function set_data($name="", $value=null)
    {
        global $c, $s, $m, $t, $q, $u;

    
        if (!$this->is['active']) {
            return;
        } elseif ($this->list) {
            return;
        }
        
        //----------------------------------
    
        
        //--------------------------------
        
        if ($name) {
            parent::set_data($name, $value);
        } elseif ($this->has['update_data_from_global'] && !empty($this->global_var)) {
            $this->data= &$this->global_var;
            f1::echo_warning("data taken from global_var, in met#set_data, cls#".get_class($this));
            return;
        } elseif ($this->data_source) {
            if ($this->has['filter']) {
                $this->set_filter();
            }
                
        
            if ($this->has['paging'] || $this->has['reverse_paging']) {
                if ($this->has['paging']) {
                    $this->paging= new paging(
                    $this->i_var['pagenum_tag'],
                                    $this->data_source,
                    $this->i_var['paging_max_items']
                );
                } elseif ($this->has['reverse_paging']) {
                    $this->paging= new paging_reverse(
                    $this->i_var['pagenum_tag'],
                                $this->data_source,
                    $this->i_var['paging_max_items']
                );
                }

                if (!$this->i_var['paging_maxpages']) {
                    $this->i_var['paging_maxpages']= 10;
                }
            
                //------------------------
            
                $this->config_paging();
                    
                $this->paging->set_maxpages($this->i_var['paging_maxpages']);
        
                $this->paging->set_var("current_url", $this->i_var['current_url']);
            
                $this->paging->set_var("open_nav", $this->i_var['paging_open_nav']);
            
                $this->paging->set_var("close_nav", $this->i_var['paging_close_nav']);
            }
        
            //------------------------------------

            $q->sql_select($this->data_source, $this->numrows, $res, "all");
        
            $this->num_displayed= $this->numrows;
        
            if (is_object($this->paging) && $res) {
                $this->numrows= $this->paging->get_numrows();
            }
    
            //----------------------

            if ($this->numrows >= 1) {
                $this->res= &$res;
            }
        } // closes if data source
        elseif ($this->has['data']) {
            $this->throw_msg("fatal_error", "invalid_request", "#met #set_data, 
				cls#".get_class($this).", #set_data not possible");
        }
        
        if ($this->data) {
            $this->validate_data();
        }
    }
    
    
    
    

    
    
    public function display_skeleton($counter=null)
    {
    }
    
    
    
    
    
    public function display_basic_skeleton()
    {
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                echo <<<HTML

{$key} => {$value} |


HTML;
            }
            echo "<hr/>";
        } else {
            f1::echo_error("not array, in cls#".get_class($this).", met#display_basic_skeleton");
        }
    }
        
    
    
    
    
    public function set_list($list)
    {
        if (is_array($list)) {
            $this->list= $list;
        } else {
            $this->list= array();
        }
    }

    
    
    
    
    
    public function display()
    {
        global $c, $s, $m, $t, $q, $u;



        if ($this->is['displayable']) {

        
            //-----if a title is required----------------

            if ($this->has['title'] && $this->title) {
                $this->display_title();
            }
           
           
           
            //-----If data comes from an array---------------------------------------------


            if ($this->list) {
                for ($i= 0; $i < count($this->list); $i++) {
                    if ($this->has['skeleton']) {
                        $this->index= $i;
                    
                        $this->data= $this->list[$i];
                
                        $this->display_skeleton();
                    } else {
                        echo "<a href=\"".$this->list[$i][$this->link_tag]."\">".
                    $this->list[$i][$this->label_tag]."</a>";
                    }

                    if ($this->separator && ($i < (count($this->list) - 1))) {
                        echo "<span class=\"separator\">".$this->separator."</span>" ;
                    }
                }
            }

            //-------If data comes from a SQL resource

            if ($this->res) {
            
            // rewind sql resource
                mysql_data_seek($this->res, 0);
            
                while ($this->data = mysql_fetch_assoc($this->res)) {
                    $this->display_item_from_database();
                }
                
                // rewind sql resource
                mysql_data_seek($this->res, 0);

                //---------------
        
                if ($this->has['paging'] && $this->has['auto_display_paging'] && is_object($this->paging)) {
                    $this->paging->display();
                }
            } //closes: if isset $this->res


            //-----------------------------

            if ($this->has['no_result_msg'] && empty($this->list) && !($this->numrows > 0)) {
                echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
            }
        }
    }
    
    
    
    
    

    public function display_item_from_database()
    {
        global $c, $s, $m, $t, $q, $u;
    
        $this->validate_data();
    
        if ($this->has['skeleton']) {
            $this->display_skeleton();
        } elseif ($this->id_tag && $this->label_tag) {
            echo "<span id=\"item".$this->data[$this->id_tag]."\">&nbsp;</span>";
        
            echo "<a  href=\"".$this->link_tag.$this->data[$this->id_tag]."\" >";
            echo $this->data[$this->label_tag];
            echo "</a>";
        } else {
            f1::echo_error("Unable to display data in cls#".get_class($this).", #met#display_item_from_database");
        }
    }
}  //closes class===============
