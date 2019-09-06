<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



abstract class view_handler_datatype
{
    protected $shelf;



    

    public function config()
    {
    }
    
    
    
    
    
    public function set_object_shelf(&$shelf)
    {
        $this->shelf= $shelf;
    }
    
    
    

    
    public function display(&$msg_obj)
    {
    }
    
    
    
    
    
    
    public function display_account_name()
    {
        global $c, $s, $m, $t, $q, $u;

        
        if ($m->account_name && $this->i_var['display_account_name']) {
            echo <<<HTML

<div class="art-header2">
	<div class="art-header-center2">
		<div class="art-header-png2"></div>
		<div class="art-header-jpeg2"></div>
	</div>
	<div class="art-logo2">
	 <h1 id="name-text2" class="art-logo-name2">{$m->account_name}</h1>
	</div>
</div>

HTML;
        } elseif ($c->is_logged_in() && !$m->account_name) {
            exit("fatal error, no account name!");
        }
    }
    
    
    
    
    
    
    public function display_selected_parameters()
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$this->i_var['display_selected_parameters']) {
            return;
        }
        

        if ($m->cat_name || $m->subcat_name || $m->type_name) {
            echo "<div class=\"selected_parameters\">";

            if ($category) {
                echo <<<HTML

<h1 class="title1">
{$m->cat_name}
</h1>

HTML;
            }
            
            if ($subcategory) {
                echo <<<HTML

<h1 class="title2">
{$m->subcat_name}
</h1>

HTML;
            }
            
            
            if ($type) {
                echo <<<HTML

<h1 class="title3">
{$m->type_name}
</h1>

HTML;
            }
            
            echo "</div>";
        }
    }
}
