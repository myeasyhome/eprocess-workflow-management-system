<?php




class stats_engine
{
    public function mk_average($list, $decimals)
    {
        $number= count($list);
        $total= 0;

        if ($number > 0) {
            for ($i=0; $i < count($list); $i++) {
                $total += $list[$i];
            }

            $average= $total / $number;
            
            return (number_format($average, $decimals));
        }

        return "0";
    }
    
    
    
    
    public function mk_percent($sample, $total, $decimals)
    {
        if ($total) {
            return (number_format((($sample / $total) * 100), $decimals)." %");
        } else {
            return 0;
        }
    }
}
