<?php


class search_keywords_controller
{
    public function delete_accents($keywords)
    {
        $accent_string= "אגהיטךכןמפצשתüח";
        $accent_array= str_split($accent_string);

        $plain_string= "aaaeeeeiioouuuc";
        $plain_array= str_split($plain_string);

        if (count($accent_array) != count($plain_array)) {
            echo_error("#met#delete_accents failed in #cls#search_keywords_manager, fix arrays length");
            return;
        }
        
        $translate= array();

        for ($i=0; $i < count($accent_array); $i++) {
            $translate[(utf8_encode($accent_array[$i]))]= utf8_encode($plain_array[$i]);
        }


        $translate[(utf8_encode(''))]= "&oe;";
        $translate[(utf8_encode('@'))]= "&e_at;";
        $translate[(utf8_encode('%'))]= "&pct;";
        $translate[(utf8_encode('©'))]= "&copr;";

        for ($i=0; $i < count($keywords); $i++) {
            $keywords[$i]= strtr($keywords[$i], $translate);
        }
        
        return $keywords;
    }
}
