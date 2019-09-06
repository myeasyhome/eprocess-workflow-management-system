<?php

class f1
{

    /**
    *urrent date in the selected language
    *
    */
    public static function currentDate($languageId)
    {
        $day= date('d');

        $month = date('n');

        $year= date('Y');

        $date= sprintf("%02d %s %04d", $day, self::monthDisplay($languageId, $month), $year);

        return $date;
    }






    //-------------------------Format a date for MySQL--------------------------------------------


    public static function mysql_date_format($day, $month, $year)
    {
        if (!empty($day) && !empty($month) && !empty($year)) {
            $date = sprintf("%04d", $year)."-".sprintf("%02d", $month)."-".sprintf("%02d", $day);

            return $date;
        } else {
            return "00-00-00";
        }
    }






    public static function mysql_datetime_format($day, $month, $year, $hour, $minute)
    {
        if (!empty($day) && !empty($month) && !empty($year) && !empty($hour) && !empty($minute)) {
            $datetime = sprintf("%04d", $year)."-".sprintf("%02d", $month)."-".sprintf("%02d", $day)." ".sprintf("%02d", $hour).":".sprintf("%02d", $minute).":00";

            return $datetime;
        } else {
            return "0000-00-00 00:00:00";
        }
    }



    //-------------Make MySQL date-----------------------------------------

    public static function mysql_date($seconds)
    {
        $date= date("Y-d-m", $seconds);

        return $date;
    }






    //-------------Make MySQL datetime-----------------------------------------

    public static function mysql_datetime($seconds)
    {
        $date= date("Y-d-m 00:00:00", $seconds);

        return $date;
    }




    //-------------Custom date from MySQL date-----------------------------------------


    public static function custom_date($mysql_datetime, $separator="/")
    {
        if (($mysql_datetime == "0000-00-00") || ($mysql_datetime == "0000-00-00 00:00:00")) {
            return "";
        }

        $string= "d{$separator}m{$separator}Y";

        $date= date($string, strtotime($mysql_datetime));

        return $date;
    }



    //-------------Custom date from MySQL date-----------------------------------------


    public static function undo_custom_date($date, $separator="/")
    {
        $list= explode($separator, $date);

        if (count($list) == 3) {
            $date= trim($list[2])."-".trim($list[1])."-".trim($list[0]);

            return $date;
        }
    }




    //----------Custom long date

    public function custom_long_date($mysql_datetime)
    {
        global $t;

        if (($mysql_datetime == "0000-00-00") || ($mysql_datetime == "0000-00-00 00:00:00")) {
            return "";
        }

        $day= date("j", strtotime($mysql_datetime));


        $months= $t->list_months;
        $month_index= date("m", strtotime($mysql_datetime)) - 1;
        $month= $months[$month_index];

        $year= date("Y", strtotime($mysql_datetime));

        $date= $day." ".$month." ".$year;

        return $date;
    }




    //------------------Custom date and time

    public static function custom_datetime($datetime, $separator1="/", $separator2=" | ")
    {
        if ($datetime == "0000-00-00 00:00:00") {
            return "";
        }

        $string= date("d{$separator1}m{$separator1}Y{$separator2}H:i", strtotime($datetime));

        return $string;
    }



    public static function undo_custom_datetime($datetime, $separator1="/", $separator2=" | ")
    {
        $string= date("d{$separator1}m{$separator1}Y{$separator2}H:i", strtotime($datetime));

        $work1= explode($separator2, $datetime);

        $group2= explode($separator1, $work1[0]);

        $date= trim($group2[2])."-".trim($group2[1])."-".trim($group2[0]);

        $string= $date." ".$work1[1];

        return $string;
    }



    //-------------Custom time from MySQL date-----------------------------------------

    public static function custom_time($mysql_datetime)
    {
        $string= "H : i";

        $time= date($string, strtotime($mysql_datetime));

        return $time;
    }






    //--------------Get the month from period in requests3 table-------------------------


    public static function monthPeriod($a)
    {
        $b = explode("-", $a);

        return $b[0];
    }





    //-----------------calculate expiration date--------------------------------------------


    public static function expireDate($dateposted, $days)
    {
        $duration = $days * 24 * 60 * 60;

        $expire_date = strtotime($dateposted) + $duration;

        return $expire_date;
    }


    //----- Add slashes to a string------------

    public static function fix_slashes($string)
    {
        if (get_magic_quotes_gpc() === 1) {
            return($string);
        } else {
            return(addslashes($string));
        }
    }





    //-Raise flag

    public static function x_flag($message="")
    {
        echo <<<HTML

<span style="font-size:1.3em;font-weight:bold;color:red;border: none;">

<br/><br/>

Flag! {$message}

<br/><br/>

</span>

HTML;
    }







    //----check variables-------------------------------------------------------

    public static function display_main_variables()
    {
        global $c, $s, $m, $t, $q, $u;




        if (!is_object($c)) {
            f1::echo_error("main_controller object not set in #func #show_main_variables");
            return;
        }



        if ($s->show_variables) {
            echo "<span style=\"font-weight:bold; color:brown; border: none;\">";

            echo "<br/><br/>";


            echo "\$_REQUEST contains:";

            print_r($_REQUEST);

            echo "<br/><br/>";


            echo "\$_POST contains:";

            print_r($_POST);

            echo "<br/><br/>";


            echo "\$_GET contains:";

            print_r($_GET);

            echo "<br/><br/>";


            echo "\$_SESSION contains:";

            print_r($_SESSION);

            echo "<br/><br/>";


            echo "\$_COOKIE contains:";

            print_r($_COOKIE);

            echo "<br/><br/>";

            echo "\$_FILES contains:";

            print_r($_FILES);

            echo "<br/><br/>";


            //----Uncomment request to show $_REQUEST
            /*
            echo "\$_REQUEST contains:";

            print_r ($_REQUEST);

            echo "<br/><br/>";
            */


            //------uncomment to show $w variables
            /*
            echo "\$c->i_var contains:";

            print_r ($c->get_inner_var());

            echo "<br/><br/>";

            echo "\$c->x_var contains:";

            print_r ($c->x_var);

            echo "<br/><br/>";
            */

            echo "</span>";
        }
    }



    //-----------report errors---------------

    public static function echo_error($message)
    {
        echo <<<HTML

<span style="font-size:1.3em;font-weight:bold;color:red;border: none;">

<br/><br/>

Error! {$message}

<br/><br/>

</span>

HTML;
    }





    //-----------report warnings---------------

    public static function echo_warning($message)
    {
        global $s;


        if ($s->show_messages) {
            echo <<<HTML

<span style="font-size:1em;font-weight:bold;color:blue;border: none;">

<br/>
Warning:<br/> {$message}
<br/>

</span>

HTML;
        }
    }




    public static function echo_comment($message)
    {
        global $s;


        if ($s->show_messages) {
            echo <<<HTML

<span style="font-size:1em;font-weight:bold;color:gray;border: none;">

<br/>
Comment:<br/> {$message}
<br/>

</span>

HTML;
        }
    }






    //-----------Variable dump---------------

    public static function x_dump($var)
    {
        echo "<span style=\"font-weight:bold;color:purple;border: none;\">";

        echo "<br/><br/>";

        var_dump($var);

        echo "<br/><br/>";

        echo "</span>";
    }
}
