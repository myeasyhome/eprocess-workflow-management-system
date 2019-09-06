<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class website_msg extends website_object
{
    protected $msg;


    public function get_msg($type="")
    {
        $this->msg="";


        if ($type) {
            $this->msg= website_msg_controller::get_msg($this, $type);
        
            return $this->msg;
        }
        
        $this->msg= website_msg_controller::get_msg($this, "fatal_error");

        if (!$this->msg) {
            $this->msg= website_msg_controller::get_msg($this, "error");
        }
    
        if (!$this->msg) {
            $this->msg= website_msg_controller::get_msg($this, "confirm");
        }

        return $this->msg;
    }
    
    
    
    
    
    public function get_type()
    {
        if (!empty($this->msg)) {
            return $this->msg['type'];
        } else {
            f1::echo_error("empty #msg in #cls#website_msg, #met#get_type");
        }
    }
    
    
    
    
    
    
    
    
    
    public function display()
    {
        global $c, $s, $m, $t, $q, $u;



        if (empty($this->msg)) {
            return;
        }
        
        
    
        $class= $this->msg['type'];

        $reference= $this->msg['reference'];

        $body= $t->$reference;

        //-------------------------

        if ($body) {
            echo <<<HTML

<div class="msg_{$class}" >

<span class="msg_img_wrap">
<img src="images/msg_img_{$class}.png">
</span>

<span class="msg_margin">

{$body}

</span>

</div>

HTML;
        }
    }
}
