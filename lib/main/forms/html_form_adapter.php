<?php



abstract class html_form_adapter extends html_form
{
    protected $selected;



    public function config()
    {
        global $c;
    
        parent::config();

        $this->has['delete']= true;
        $this->has['ask_delete']= true;

        $this->i_var['form_method']= "POST";

        $this->i_var['current_url']= $c->update_current_url(array("ask_delete_".$this->subject));
        $this->i_var['target_url']= $this->i_var['current_url'];
    }

    
    
    


    public function display_submit()
    {
        global $u, $t;


        if (!$u->is_logged_in("zn_operator")) {
            return;
        }
        

        if ($this->is['new']) {
            echo <<<HTML


<input type="submit" class="submit_button" name="create_{$this->subject}" value="{$t->create}"/>



HTML;
        } else {
            echo <<<HTML


<input type="submit" class="submit_button" name="save_{$this->subject}" value="{$t->save}"/>



HTML;
        }

        if (($this->has['delete'] && !$this->is['new'])
        || ($this->has['delete'] && !$this->is['new'] && !$_REQUEST["ask_delete_".$this->subject])) {
            echo <<<HTML

<input type="submit" class="submit_button" name="ask_delete_{$this->subject}" value="{$t->delete}"/>

HTML;
        }
        
        if ($this->has['cancel']) {
            echo <<<HTML


<input type="submit" class="submit_button" name="cancel" value="{$t->cancel}"/>



HTML;
        }
    }
    
    
    
    
    
    
    public function display()
    {
        if (!$this->is['displayable']) {
            return;
        }

        parent::display();
    }
}
