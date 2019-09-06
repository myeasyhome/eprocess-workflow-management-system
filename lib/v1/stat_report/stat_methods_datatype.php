<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


abstract class stat_methods_datatype extends list_items
{
    protected $start_datetime;
    protected $end_datetime;



    public function config()
    {
        global $m, $t;

    
        parent::config();

        $this->has['paging']= false;
        $this->no_result_msg= $t->no_result;

        
        $m->window_shadow_id="prt_window_shadow";
        $m->window_id="prt_window";
    }
    
    
    
    
    
    public function can_use_period($bool)
    {
        global $t;


        if (($_REQUEST['start_date'] || $_REQUEST['end_date']) && ($bool === false)) {
            $this->has['no_period_msg']= true;
        } else {
            $this->has['no_period_msg']= false;
        }
    }
    
    
    
    
    
    public function display_title()
    {
        global $s, $t;

        echo "<div class=\"stat_title_report\"><h1>".$s->global_name." | ".$t->stat_report_of." ".date("d/m/Y, H:s", time())."</h1>";

        parent::display_title();


        if (!$this->has['no_period_msg'] && ($_REQUEST['start_date'] || $_REQUEST['end_date'])) {
            echo "<div class=\"period\">";
        
            if ($_REQUEST['start_date']) {
                echo "<span class=\"label\">".$t->selected_start_date." </span><span class=\"data\">".$_REQUEST['start_date']."</span>";
            }
            
            if ($_REQUEST['end_date']) {
                $label= ($_REQUEST['start_date']) ? $t->and_selected_end_date : $t->selected_end_date;
            
                echo "<span class=\"label\"> ".$label." </span><span class=\"data\">".$_REQUEST['end_date']."</span>";
            }
        
            echo "</div>";
        }

        echo "</div>";


        //----------------
        
        if ($this->has['no_period_msg']) {
            echo "<div class=\"info\">".$t->period_not_used."</div>";
        }
    }
    
    
    
    


    public function set_start_date($datetime)
    {
        $this->start_datetime= $datetime;
    }
    
    
    
    public function set_end_date($datetime)
    {
        $this->end_datetime= $datetime;
    }
}
