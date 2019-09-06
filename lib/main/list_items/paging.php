<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class paging extends website_object
{
    protected $pagenum_tag; // url tag (example 'pg') of pages created by paging
protected $pagesize; // number of items on page
protected $maxpages; // number of pages displayed in navigation
protected $activepage= 1; // page that is being displayed (active)
private $offset; //------amount of data skipped from the beginning to where active page starts
protected $numpages; // total number of pages available protected
protected $numrows; // number of results

protected $url_anchor;  // reference of part of page where browser should go...
    protected $all_data_res;




    public function __construct($pagenum_tag="pg", $data_source, $pagesize=20)
    {
        global $c, $s, $m, $t, $q, $u;

        $this->initialize();

        $this->start($pagenum_tag, $data_source, $pagesize);

        $this->i_var['writable_var_list']= array("current_url", "open_nav", "close_nav");

        $this->i_var['part_name']; // name of parts created by paging (default is 'page')
$this->i_var['open_nav']; // open the navigation bar
$this->i_var['close_nav']; // close the navigation bar
    }

    
    
    
    
    
    public function start($pagenum_tag, $data_source, $pagesize)
    {
        global $c, $s, $m, $t, $q, $u;


    

        $this->pagenum_tag= $pagenum_tag;

        $this->pagesize= $pagesize;


        if ($_GET[$this->pagenum_tag]
             && is_numeric($_GET[$this->pagenum_tag])) {
            $this->activepage = $_GET[$this->pagenum_tag];
        }
    

        //----number of records of previous pages-------------------

        $this->offset = ($this->activepage - 1) * $this->pagesize;

        //----find number of pages from number of records----------------


        //--------Get records------------------------------------------

        if (!empty($data_source)) {
            $q->sql_select($data_source, $numrows, $res);
        }

        $this->numrows= $numrows;
        $this->all_data_res= &$res;

        //----------------Pass paging values------------

        $q->set_limit(" LIMIT ".$this->offset.", ".$pagesize);



        //------------GET number of pages--------------------------------------

        $this->numpages = (int) ceil($numrows / $this->pagesize);


        if ($numrows === 0) {
            $this->numpages= 1;
        }
        //make sure that $this->numpages is always superior or equal to 1.
    }
    
    
    
    
    
    
    public function get_offset()
    {
        if ($this->offset) {
            return $this->offset;
        } elseif ($this->numrows) {
            return 1;
        }
    }
    
    
    
    
    
    
    
    public function get_pagesize()
    {
        if ($this->pagesize) {
            return $this->pagesize;
        } elseif ($this->numrows) {
            return $this->numrows;
        }
    }
    
    
    
    
    
    public function get_all_data()
    {
        $all_data_rows= array();
        
        if ($this->numrows > 0) {
            while ($data= mysql_fetch_assoc($this->all_data_res)) {
                $all_data_rows[]= $data;
            }
            
            return $all_data_rows;
        }
    }
    
    
    
    
    
    public function set_maxpages($value)
    {
        $this->maxpages= $value;
    }
    
    
    
    


    public function display($open_nav="", $close_nav="")
    {
        global $c, $s, $m, $t, $q, $u;


        if ($open_nav) {
            $this->i_var['open_nav']= $open_nav;
        }

        
        if ($close_nav) {
            $this->i_var['close_nav']= $close_nav;
        }
        
        
        $current_url= $this->i_var['current_url'];


        if ($this->numpages > 1) {
            if (empty($this->i_var['part_name'])) { // display name of folios / pages | default is 'page'
                $this->i_var['part_name']= $t->page;
            }

            
            if (empty($this->i_var['open_nav'])) { // navigation element opens
                $this->i_var['open_nav']= "<div>";
            }
            
            if (empty($this->i_var['close_nav'])) { // navigation element closes
                $this->i_var['close_nav']= "</div>";
            }


            echo $this->i_var['open_nav'];
            

            echo "<span>{$this->i_var['part_name']}:</span>";


            $firstpage= 1;

            $lastpage= $this->numpages;

            //--------------------------------


            if (isset($this->maxpages)) {
                if ($this->numpages <= $this->maxpages) {
                    $this->maxpages= $this->numpages;
                }
        

                if (($this->activepage <= $this->numpages) && ($this->activepage >= 1)) {
                    $firstpage= (int) (floor($this->activepage/$this->maxpages) * $this->maxpages);


                    if ($this->activepage <= $this->maxpages) {
                        $firstpage= 1;
                    }


                    if ($this->activepage > $this->maxpages) {
                        $firstpage++;
                    }


                    $lastpage= $firstpage + $this->maxpages - 1;


                    if ($lastpage > $this->numpages) {
                        $lastpage= $this->numpages;
                    }
                } else {
                    exit("runtime_error, pg_mxpg1");
                }
            

                //----------------Previous lambda pages----------------------------


                if ($firstpage > $this->maxpages) {
                    $x_link= $current_url;

                    $x_link .= ("&".$this->pagenum_tag."=".($firstpage - $this->maxpages));

                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    $more_pages= "previous_pages";

                    echo "<a class=\"more_pages\" href=\"{$x_link}\"> 
				&lt; &lt; ".$t->$more_pages." |</a>";
                }
            } // closes: if (isset($this->maxpages))----------------------


            //------------------List page numbers----------------------------------------------


            for ($i=$firstpage; $i <= $lastpage; $i++) {
                if ($i === (int)$this->activepage) {
                    echo "<span> | ".$i." </span> ";
                } else {
                    $x_link= $current_url;
                    $x_link .= ("&".$this->pagenum_tag."=".$i);

                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    echo "<a href=\"{$x_link}\" > &gt; {$i}</a>";
                }
            }


            //--------Next page--------------------------------------------------------


            if ($this->activepage < $this->numpages && $this->numpages > 1) {
                $x_link= $current_url;
                $x_link .= ("&".$this->pagenum_tag."=".($this->activepage + 1));

                if (!empty($this->url_anchor)) {
                    $x_link .= $this->url_anchor;
                }

                echo "<a class=\"next_page\" href=\"{$x_link}\"> 
				&gt; ".$t->next." </a>";
            }

            //----------------Next lambda pages--------------------------------------------

            if (isset($this->maxpages)) {
                if ($lastpage < $this->numpages) {
                    $x_link= $current_url;
                    $x_link .= ("&".$this->pagenum_tag."=".($lastpage + 1));

                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    $more_pages= "next_pages";

                    echo "<a class=\"more_pages\" href=\"{$x_link}\"> 
				| ".$t->$more_pages." &gt; &gt;</a>";
                }

                echo $this->i_var['close_nav'];
            } // closes: if (isset($this->maxpages))
        } // closes if $this->numpages > 1------
    }
}





//================






class paging_reverse extends paging
{
    public function __construct($pagenum_tag, $sql, $pagesize)
    {
        global $c, $s, $m, $t, $q, $u;


        $this->i_var['writable_var_list']= array("current_url", "open_nav", "close_nav");

        $this->i_var['part_name']; // name of parts created by paging (default is 'page')
$this->i_var['open_nav']; // open the navigation bar
$this->i_var['close_nav']; // close the navigation bar


$this->start($pagenum_tag, $sql, $pagesize);

        if (!isset($_GET[$this->pagenum_tag])) {
            $q->set_var("offset", ($this->numpages - 1) * $pagesize);

            $this->activepage= $this->numpages;
        }
    }

    
    
    
    
    
    public function display($open_nav="", $close_nav="")
    {
        global $c, $s, $m, $t, $q, $u;


        if ($open_nav) {
            $this->i_var['open_nav']= $open_nav;
        }

        
        if ($close_nav) {
            $this->i_var['close_nav']= $close_nav;
        }


        $current_url= $this->i_var['current_url'];


        if ($this->numpages > 1) {
            if (empty($this->i_var['part_name'])) {
                $this->i_var['part_name']= $t->page;
            }

            if (empty($this->i_var['open_nav'])) { // open navigation
                $this->i_var['open_nav']= "<div>";
            }

            if (empty($this->i_var['close_nav'])) { // close navigation
                $this->i_var['close_nav']= "</div>";
            }


            echo $this->i_var['open_nav'];

            //---------------------------------------------------------------------------------

            echo "<span>".$this->i_var['part_name'].": </span>";


            //-------------------------


            if (isset($this->maxpages)) {
                if ($this->numpages <= $this->maxpages) {
                    unset($this->maxpages);
                }
            }

            //----------------------


            $firstpage= $this->numpages;

            $lastpage= 1;



            if (isset($this->maxpages)) {
                if (($this->activepage <= $this->numpages) && ($this->activepage >= 1)) {
                    $firstpage= (int) (ceil($this->activepage/$this->maxpages) * $this->maxpages);


                    if ($firstpage > $this->numpages) {
                        $firstpage = $this->numpages;
                    }


                    $lastpage= $firstpage - $this->maxpages + 1;


                    if ($lastpage < 1) {
                        $lastpage = 1;
                    }
                } else {
                    die("runtime_error, paging, mxpg2");
                }


                //----------------Last and next pages--------------------------


                if ($firstpage < $this->numpages) {
                    if (($firstpage + $this->maxpages) <= $this->numpages) {
                        $x_link= $current_url;
                    
                        //-------------------Last page---------------
                        $x_link .= ("&".$this->pagenum_tag."=".$this->numpages);

                        if (!empty($this->url_anchor)) {
                            $x_link .= $this->url_anchor;
                        }

                        $more_pages= "next_pages";

                        echo "<a class=\"last_page\" href=\"{$current_url}\"> 
							|| {$t->last} | </a>";
                    }


                    //------------------Next lambda pages-------------------

                    if (($firstpage + $this->maxpages) > $this->numpages) {
                        $this->pagenum_tag .= ("=".$this->numpages);
                    } else {
                        $this->pagenum_tag .= ("=".($firstpage + $this->maxpages));
                    }

                    $x_link= $current_url;
                    $x_link .= $this->pagenum_tag;


                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    $more_pages= "next_pages";

                    echo "<a class=\"more_pages\" href=\"{$x_link}\"> 
					&lt; &lt; ".$t->$more_pages." |</a>";
                } // closes:  if ($firstpage < $this->numpages)
            } // closes: if (isset($this->maxpages))


            //-----------------------List page numbers--------------------------------


            for ($i= $firstpage; $i >= $lastpage; $i--) {
                if ($i === $this->activepage) {
                    echo "<span> | ".$i." </span> ";
                } else {
                    $x_link= $current_url;
                    $x_link .= ("&".$this->pagenum_tag."=".$i);

                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    echo "<a href=\"{$x_link}\" > &gt; {$i}</a>";
                }
            }


            //----------------------Previous page--------------------------------------------

            if ($this->activepage < $this->numpages && $this->activepage > 1) {
                $x_link= $current_url;
                $x_link .= ("&".$this->pagenum_tag."=".($this->activepage - 1));

                if (!empty($this->url_anchor)) {
                    $x_link .= $this->url_anchor;
                }

                echo "<a class=\"previous_page\" href=\"{$x_link}\">
				&gt; ".$t->previous." </a>";
            }

            //----------------Previous lambda pages----------------------------


            if (isset($this->maxpages)) {
                if ($lastpage > 1) {
                    echo "<a class=\"more_pages\" href=\"".$current_url;

                    $diff= $firstpage - $this->maxpages;
                
                    $x_link= $current_url;

                    if ($diff < 1) {
                        $diff= 1;
                    }

                    $x_link .= ("&".$this->pagenum_tag."=".$diff);

                    if (!empty($this->url_anchor)) {
                        $x_link .= $this->url_anchor;
                    }

                    $more_pages= "previous_pages";
            
                    echo "<a class=\"more_pages\" href=\"{$x_link}\"> 
					| ".$t->$more_pages." &gt; &gt;</a>";
                }
            } // closes: if (isset($this->maxpages))

            //----------------------------------------------------------------

            echo $this->i_var['close_nav'];
        } // closes: if ($this->numpages > 1)
    }


    
    
    
    
    public function __destruct()
    {
        parent::__destruct();
    }
}




//===================




class paging_from_array extends paging
{
    public function __construct($pagenum_tag, $numrows, $pagesize)
    {
        $this->pagenum_tag= $pagenum_tag; // url tag (example 'pg') of pages created by paging

        $this->numrows= $numrows;

        $this->pagesize= $pagesize; // number of items on page

        //----------------------------------------------------

        if ($_GET[$this->pagenum_tag] && is_numeric($_GET[$this->pagenum_tag])) {
            $this->activepage = $_GET[$this->pagenum_tag];
        }

        //-------------------------------------------------------------

        $this->numpages = (int) ceil($numrows / $this->pagesize);


        if ($numrows === 0) {
            $this->numpages= 1;
        }			//make sure that $this->numpages is always superior or equal to 1.
    }
}
