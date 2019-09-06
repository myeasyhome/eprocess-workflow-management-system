<?php



abstract class website_style_datatype extends website_object
{
    protected $list;
    
    
    public function display()
    {
        global $s;

    
        $style= "";
        $list= array();


        //-------------------------


        if ($s->website_style_mode === "demo") {
            $style .= <<<HTML

<link rel="stylesheet" href="style/demo.css" type="text/css" />

HTML;
        }

        
        //--------------------------
        
        
        if ($s->website_style_mode === "basic") {
            $style .= <<<HTML

<link rel="stylesheet" href="style/basic.css" type="text/css" />

HTML;
        } elseif ($s->website_style_mode === "production") {
            $style .= <<<HTML

<link rel="stylesheet" href="style/basic_borders.css" type="text/css" />

HTML;
        }

        
        //--------------------

        for ($i=0; $i < count($this->list); $i++) {
            $style .= <<<HTML

<link rel="stylesheet" href="{$this->list[$i]}.css" type="text/css" />

HTML;
        }
        
        
        echo $style;
    }
}
