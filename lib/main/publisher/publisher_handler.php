<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class publisher_handler extends website_object
{
    protected $pointer;
    protected $pagesize;
    protected $pages;

    protected $transfers;
    protected $clients;

    protected $page_counter;
    protected $num_documents;



    public function config()
    {
        global $s, $m;


        $m->window_shadow_id="pub_window_shadow";
        $m->window_id="pub_window";


        if (!is_object($this->pages[$this->pointer])) {
            $this->is['new']= true;
        } else {
            $this->is['new']= false;
        }

        
        //----------------------------------
    
        if ($this->is['new']) {
            $this->num_documents= $s->publisher_num_documents;
            $this->pages= array();
            $this->pagesize= $s->publisher_pagesize;
            $this->pointer= 0;
            $this->page_counter= 0;
        
            $this->transfers= array();
            $this->clients= array();
        }
    }
    

    
    
    
    private function set_transfers_res($option)
    {
        global $q;

        $q->set_limit("LIMIT ".$this->num_documents);
        $q->sql_select("last_".$option."_transfers", $this->transfers['numrows'], $this->transfers['res'], "all");
    }
    


    
    
    
    private function set_clients_res(&$transfer)
    {
        global $q;


        
        if ($transfer['t_id_proj'] > 0) {
            $q->set_filter("id_proj='".$transfer['t_id_proj']."'");
        } elseif ($transfer['t_id_file'] > 0) {
            $q->set_filter("id_file='".$transfer['t_id_file']."' AND id_proj='0' ");
        }
                
        $q->sql_select("select_client1", $this->clients['numrows'], $this->clients['res'], "all");
    }

    
    
    
    
    public function set_data($option="")
    {
        if (!$option) {
            $this->set_data("file");
            $this->set_data("project");
        
            return;
        }
        
        //--------------------------------------------------------
    
        if ($this->is['new'] && $option) {
            $this->set_transfers_res($option);
        
            $page_counter= &$this->page_counter;
            $document_counter= 0;
            $num_part= array();

            if ($this->transfers['numrows'] >= 1) {
                while ($transfer= mysql_fetch_assoc($this->transfers['res'])) {
                    $document_counter++;
                
                    if (($transfer['t_id_file'] >= 1) xor ($transfer['t_id_proj'] >= 1)) {
                        $this->set_clients_res($transfer);
                                                        
                        if ($this->clients['numrows'] >= 1) {
                            while ($client= mysql_fetch_assoc($this->clients['res'])) {
                                if (!$this->has['page']) {
                                    $this->has['page']= true;
                                
                                    $this->pages[$page_counter]= new publisher();
                                    $page= &$this->pages[$page_counter];
                                    $page->initialize();
                                    $page->config();
                                
                                    $page_counter++;
                                    $clients_counter= 0;
                                
                                    $page->set_document_data($transfer);
                                }
                                    
                                $page->add_client($client);
                                $clients_counter++;
                                                            
                                if (($clients_counter == $this->pagesize)
                                        && ($this->clients['numrows'] > $this->pagesize)) {
                                    if (empty($num_part[$document_counter])) {
                                        $num_part[$document_counter]= 0;
                                    }
                                    
                                    $num_part[$document_counter]++;
                                
                                    $page->set_num_part($num_part[$document_counter]);
                                    $page->set_total_parts($num_part[$document_counter]);
                                
                                                        
                                
                                    $this->has['page']= false;
                                    $clients_counter= 0;
                                }
                            }
                        }
                    }

                    
                    if ($this->has['page']) {
                        $this->has['page']= false;
                    }
                }
            }
            
            unset($this->numrows);
            unset($this->res);
        }
    }

        
    
    

    public function display()
    {
        if (is_object($this->pages[$this->pointer])) {
            $this->pages[$this->pointer]->display();
        
            $this->pointer++;
        }
    }
        
    
    
    
    
    public function __destruct()
    {
        $_SESSION['publisher_handler']= $this;
    }
}
