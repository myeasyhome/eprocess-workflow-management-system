<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class common_queries
{
    public function get_queries($i_var, $filter, $order, $limit, &$queries= array())
    {


//============tools, delete====================
    
        $queries['show_tables']= "SHOW TABLES FROM ".$i_var['database'].";";
                        
                        
        $queries['show_columns']= "SHOW COLUMNS FROM ".$i_var['table'].";";
    }
}
