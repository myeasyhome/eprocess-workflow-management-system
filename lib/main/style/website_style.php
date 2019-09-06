<?php



class website_style extends website_style_datatype
{
    public function config()
    {
        $list= array();


        $list[]="style/templates/blue1/custom_style_all";

        //-----------------------------

        $this->list= $list;
    }
}
