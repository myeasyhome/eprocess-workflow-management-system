<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



//------accents: � � � � �

class action_txt extends text_settor
{
    protected function set_text(&$t)
    {
        global $s, $u;

                                
        $t['act_crea_id_file']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a cre&eacute; le courrier no. <span class=\"number\">\"{$this->i_var['new_id']}\"</span>, de titre: <span class=\"title\">\"{$this->i_var['title']}\"</span>, dans la cat&eacute;gorie <span class=\"name\">\"{$this->i_var['name_cat']}\"</span></span>";

        $t['act_crea_id_client']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a ajout&eacute; l'interess&eacute;(e) no. <span class=\"number\">\"{$this->i_var['new_id']}\"</span>: <span class=\"name\">{$this->i_var['surname']} {$this->i_var['firstname']}</span> au courrier no. <span class=\"number\">\"{$this->i_var['id_file']}\"</span></span>";

        $t['act_edit_id_file']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a modifi&eacute; les donn&eacute;es du courrier no. <span class=\"number\">\"{$this->i_var['id_file']}\"</span>. <span class=\"old\"><span class=\"label\">Anciennes donn&eacute;es:</span>\"{$this->i_var['old_data']}\"</span><span class=\"new\"><span class=\"label\">Nouvelles donn&eacute;es:</span>\"{$this->i_var['new_data']}\"</span></span>";


        $t['act_edit_id_proj']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a modifi&eacute; les donn&eacute;es du projet no. <span class=\"number\">\"{$this->i_var['id_proj']}\"</span>. <span class=\"old\"><span class=\"label\">Anciennes donn&eacute;es:</span>\"{$this->i_var['old_data']}\"</span><span class=\"new\"><span class=\"label\">Nouvelles donn&eacute;es:</span>\"{$this->i_var['new_data']}\"</span></span>";

        $t['act_edit_id_client']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a modifi&eacute; les donn&eacute;es de l'interess&eacute;(e) no. <span class=\"number\">\"{$this->i_var['id_client']}\"</span>. <span class=\"old\"><span class=\"label\">Anciennes donn&eacute;es:</span>\"{$this->i_var['old_data']}\"</span><br/><span class=\"new\"><span class=\"label\">Nouvelles donn&eacute;es:</span>\"{$this->i_var['new_data']}\"</span></span>";

        $t['act_trans_id_file']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a transf&egrave;r&eacute; le courrier no. <span class=\"number\">\"{$this->i_var['id_file']}\"</span> du d&eacute;partement <span class=\"name\">\"{$this->i_var['old_name_dept']}\"</span> vers le d&eacute;partement <span class=\"name\">\"{$this->i_var['new_name_dept']}\"</span></span>";

        $t['act_trans_id_proj']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a transf&egrave;r&eacute; le projet no. <span class=\"number\">\"{$this->i_var['id_proj']}\"</span> du d&eacute;partement <span class=\"name\">\"{$this->i_var['old_name_dept']}\"</span> vers le d&eacute;partement <span class=\"name\">\"{$this->i_var['new_name_dept']}\"</span></span>";

        $t['act_ccltr_id_file']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a annul&eacute; le transfert du courrier no. <span class=\"number\">\"{$this->i_var['id_file']}\"</span>. Ce courrier n'est pas au d&eacute;partement <span class=\"name\">\"{$this->i_var['old_name_dept']}\"</span>; il est au d&eacute;partement <span class=\"name\">\"{$this->i_var['new_name_dept']}\"</span></span>";


        $t['act_ccltr_id_proj']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a annul&eacute; le transfert du projet no. <span class=\"number\">\"{$this->i_var['id_proj']}\"</span>. Ce projet n'est pas au d&eacute;partement <span class=\"name\">\"{$this->i_var['old_name_dept']}\"</span>; il est au d&eacute;partement <span class=\"name\">\"{$this->i_var['new_name_dept']}\"</span></span>";


        $t['act_cfitr_id_file']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a confirm&eacute; la reception du courrier no. <span class=\"number\">\"{$this->i_var['id_file']}\"</span>. Ce courrier est au d&eacute;partement <span class=\"name\">\"{$this->i_var['name_dept']}\"</span></span>";


        $t['act_cfitr_id_proj']= "<span class=\"date\">{$this->i_var['date_time']}:</span> <span class=\"line\"><span class=\"username\">{$this->i_var['username']}</span> a confirm&eacute; la reception du projet no. <span class=\"number\">\"{$this->i_var['id_proj']}\"</span>. Ce projet est au d&eacute;partement <span class=\"name\">\"{$this->i_var['name_dept']}\"</span></span>";
    }
}
