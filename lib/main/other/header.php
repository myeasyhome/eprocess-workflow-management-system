<?php



class header extends website_object
{
    public function config()
    {
        $this->has['data']= false;
    }

    
    
    

    public function display()
    {
        global $c, $s, $m, $t, $q, $u;


        $logged_in="";

        
        
        if ($u->id) {
            $status_name= $u->status_name;

            $logged_in= <<<HTML

<div class="log_box">

<span class="name_dept">{$u->name_dept}</span> |

<span class="status_name">{$t->$status_name}</span> |

<span class="username">{$u->username}</span> |

<a class="action" href="{$s->root_url}?v=logout">

{$t->log_out}

</a>

</div>

HTML;
        }
    
    
        echo <<<HTML

{$logged_in}

HTML;
    }
}
