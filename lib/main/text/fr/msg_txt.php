<?php


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



//------accents: � � � � �

class msg_txt extends text_settor
{
    protected function set_text(&$t)
    {
        global $s, $u;

        $t['param_must_be_numeric']= "Le param&egrave;tre de recherche doit &ecirc;tre un nombre";


        $t['print_letter_without_total_cc']= "Il faut le nombre total d'ampliations pour utiliser la lettre";

        $t['file_reached_max_clients']= "Le courrier a atteint le nombre maximum d'interess&eacute;s. Enregistrez l'interess&eacute; dans un autre courrier";

        $t['import_files_first']= "Importez d'abord les courriers";
        $t['import_projects_first']= "Importez d'abord les projets";

        $t['no_obj_to_import']= "Aucun objet s&eacute;lectionn&eacute;";

        $t['no_id_dgb_dept']= "Aucun d&eacute;partement dont le nom contient \"*#dgb#\" ";


        $t['no_javascript']= "Javascript est d&eacute;sactiv&eacute;! Vous avez besoin de Javascript pour utiliser toutes les fonctionalit&eacute;s de l'application";

        
        $t['use_sms_style_tags']= <<<TXT

<div class="info">

Utilisez cette balise pour ins&egrave;rer une variable:

<br/><br/>

<span class="item strong">
*#*VARIABLE*#
</span>

<br/><br/>

</div>

TXT;



        $t['set_printed_done']= "Le statut \"lettre imprim&eacute;e\" a &eacute;t&eacute; donn&eacute; &agrave; la s&eacute;l&egrave;ction";

        $t['set_not_printed_done']= "Le statut \"lettre n'est pas imprim&eacute;e\" a &eacute;t&eacute; donn&eacute; &agrave; la s&eacute;l&egrave;ction";

        $t['foreign_project_not_editable']= "Vous ne pouvez pas modifier un projet qui se trouve dans un autre d&eacute;partement";

        $t['foreign_project_not_usable']= "Vous ne pouvez pas utiliser un projet qui se trouve dans un autre d&eacute;partement";


        $t['foreign_client_not_editable']= "Vous ne pouvez pas modifier un interess&eacute; qui se trouve dans un autre d&eacute;partement";

        $t['new_bordereau_confirm'] = "Vous avez attribu&eacute; un num&eacute;ro de bordereau &agrave; cette s&eacute;l&egrave;ction de projets";

        $t['ask_delete_print_letters'] = "Voulez-vous vraiment enlever cette s&eacute;l&egrave;ction de la liste?";

        $t['period_not_used']= "Ce rapport n'utilise pas de date de d&eacute;but ou de fin de p&egrave;riode";

        $t['already_minister']= "Action annul&eacute;e! L'usager est le ministre";
        $t['already_gen_dir']= "Action annul&eacute;e! L'usager est le Directeur G&eacute;n&eacute;ral";

        $t['new_minister_saved']= "L'usager est enregistr&eacute; en tant que ministre";
        $t['new_gen_dir_saved']= "L'usager est enregistr&eacute; en tant que Directeur G&eacute;n&eacute;ral";


        $t['incomplete_report_parameters']= "Il manque des param&egrave;tres pour g&eacute;n&egrave;rer ce rapport, contactez un administrateur du syst&egrave;me";


        $t['no_admin_edit_admin']= "Un administrateur ne peut pas &eacute;diter les donn&eacute;es d'un administrateur";



        $t['no_stat_method']= "La m&eacute;thode qui g&eacute;n&egrave;re le rapport n'a pas &eacute;t&eacute; trouv&eacute;e; veuillez v&eacute;rifier son orthographe ou contacter un administrateur du syst&egrave;me";

        $t['print_letter_project_saved']= "Le projet a &eacute;t&eacute; ajout&eacute; &agrave; la liste des lettres &agrave; imprimer";


        $t['print_letter_project_used']= "Le projet no. \"{$this->i_var['id_proj']}\" est d&eacute;j&agrave; dans la liste des projets &agrave; imprimer";

        $t['invalid_clients']= "Les donn&eacute;es des interess&eacute;s de ce projet sont incompl&egrave;tes ou n'ont pas &eacute;t&eacute; trouv&eacute;es.<br/> Assurez-vous que chaque interess&eacute; a une classification.";

        $t['letter_project_selected']= "Vous avez s&eacute;l&eacute;ctionn&eacute; un projet pour la cr&eacute;ation d'une lettre";
        $t['letter_template_selected']= "Vous avez s&eacute;l&eacute;ctionn&eacute; un mod&egrave;le pour la cr&eacute;ation d'une lettre";
        $t['fill_letter_cancelled']= "Vous avez annul&eacute; la cr&eacute;ation d'une lettre";


        $t['no_service']= "S&eacute;lectionnez un service";
        $t['no_work']= "S&eacute;lectionnez une profession";
        $t['no_rank']= "S&eacute;lectionnez un grade";


        $t['no_service_selected']= "Aucun service enregistr&eacute;";
        $t['no_work_selected']= "Aucune profession enregistr&eacute;es";
        
        $t['use_letter_style_tags']= <<<TXT

<div class="info">

Utilisez ces balises pour pr&eacute;senter la lettre:<br/> <strong>Attention, fermez correctement chaque balise &agrave l'exception de &lt;esp&gt; et &lt;pesp&gt;</strong><br/>

<br/><br/>

<div class="col1">

<span class="level1">

<span class="item">
Ins&egrave;rer une variable: *#*VARIABLE*#<br/><br/>
</span>

<span class="item">
Appeler une fonction: *##FONCTION*#<br/><br/>
</span>

</span>

<span class="level2">

<span class="item">
Nouvelle ligne dans la section des articles: #Vu ...<br/><br/>
</span>

<span class="item">
Petit texte en haut de page: &lt;hpe&gt;TEXTE&lt;/hpe&gt;<br/><br/>
</span>

<span class="item">
Le titre ou l'objet de la lettre: &lt;ti&gt;TEXTE&lt;/ti&gt;<br/><br/>
</span>

<span class="item">
Paragraphe: &lt;pa&gt;TEXTE&lt;/pa&gt;<br/><br/>
</span>
<span class="item">
Bloc de texte &agrave; droite: &lt;dr&gt;TEXTE&lt;/dr&gt;<br/><br/>
</span>

<span class="item">
Bloc de texte &agrave; gauche: &lt;ga&gt;TEXTE&lt;/ga&gt;<br/><br/>
</span>

</span>

</div>

<div class="col2">

<span class="level2">

<span class="item">
Bloc de texte en haut &agrave; droite: &lt;hdr&gt;TEXTE&lt;/hdr&gt;<br/><br/>
</span>

<span class="item">
Bloc de texte &agrave; droite et centr&eacute;: &lt;drc&gt;TEXTE&lt;/drc&gt;<br/><br/>
</span>

<span class="item">
Bloc de texte &agrave; gauche et centr&eacute;: &lt;gac&gt;TEXTE&lt;/gac&gt;<br/><br/>
</span>

<span class="item">
Caract&egrave;re en gras: &lt;gr&gt;TEXTE&lt;/gr&gt;<br/><br/>
</span>
<span class="item">
Caract&egrave;re soulign&eacute;: &lt;so&gt;TEXTE&lt;/so&gt;<br/><br/>
</span>
<span class="item">
Bloc de texte encadr&eacute;: &lt;enc&gt;TEXTE&lt;/enc&gt;<br/><br/>
</span>

<span class="item">
Espace: &lt;esp&gt;<br/><br/>
</span>

<span class="item">
Petit espace: &lt;pesp&gt;
</span>

</span>

</div>

</div>

<div class="cleared">&nbsp;</div>

TXT;

        $t['sms_variable_not_exist']= "La variable *#*{$this->i_var['letter_var']}*# n'existe pas!";


        $t['letter_variable_not_exist']= "La variable *#*{$this->i_var['letter_var']}*# n'existe pas!";


                                            
        $t['letter_method_not_exist']= "La fonction *##{$this->i_var['letter_var']}*# n'a pas &eacute;t&eacute; trouv&eacute;e!";
                                            
    
        $t['letter_not_found']= "La lettre num&eacute;ro \"{$this->i_var['id_letter']}\" n'a pas &eacute;t&eacute; trouv&eacute;e";
        $t['project_not_found']= "Le projet num&eacute;ro \"{$this->i_var['id_proj']}\" n'a pas &eacute;t&eacute; trouv&eacute;";
        
        $t['proj_min_one_client']= "Un projet doit avoir au moins un interess&eacute;";
    
        $t['not_your_dept']= "Ceci n'est pas votre d&eacute;partement.";
        
        $t['select_id_class']= "S&eacute;lectionnez une classification";
    
        $t['selection_received_confirmed']= "La s&eacute;lection de documents n'est plus en transit, elle a &eacute;t&eacute; re&ccedil;ue";

        $t['confirm_selection_received']= "Avez vous re&ccedil;u cette s&eacute;lection de documents?";


        $t['confirm_cancel_transfer']= "Voulez-vous annuler cette s&eacute;lection de transferts?";
        
        $t['cancel_transfer_confirmed']= "La s&eacute;lection de documents n'est plus en transit vers votre d&eacute;partement, le transfert a &eacute;t&eacute; annul&eacute;";
    
    
        $t['document_transferred']= "La s&eacute;lection de documents est en transit vers un autre d&eacute;partement";

        $t['no_document_transfer']= "Aucun document autoris&eacute; &agrave; &ecirc;tre transfer&eacute;";


        $t['no_document']= "S&eacute;lectionnez un document";

        $t['no_department']= "S&eacute;lectionnez un d&eacute;partement";

        $t['no_proj_type']= "S&eacute;lectionnez un type de projet";

        $t['no_proj_type_to_select']= "Aucun type de projet &agrave; s&eacute;l&egrave;ctionner";

        $t['no_carrier']= "S&eacute;lectionnez l'agent charg&eacute; du transfert";
        
        $t['no_describe_trans']= "Soumettez la raison du transfert";
        
        $t['not_numeric_input']= "La valeur \"{$this->i_var['not_numeric']}\" n'est pas num&eacute;rique";

        $t['not_delete_file_with_project']= "Le courrier s&eacute;lectionn&eacute; a au moins un projet. Vous ne pouvez pas l'&eacute;ffacer";

        $t['create_project_select_client']= "S&eacute;lectionnez au moins un int&eacute;ress&eacute; pour cr&eacute;er un projet";
    
        $t['not_edit_dormant_file']= "Le courrier s&eacute;lectionn&eacute; est inactif; vous ne pouvez pas &eacute;diter ses donn&eacute;es";
    
        $t['create_project_dormant_file']= "Le courrier s&eacute;lectionn&eacute; est inactif; il n'est pas possible de cr&eacute;er un projet";
        
    
        $t['already_in_course']= "L'etudiant(e) est d&eacute;j&agrave; dans ce cours";

        $t['user_info_sent']= "Les informations des usagers ont &eacute;t&eacute; envoy&eacute;es";

        $t['no_change_found']= "Vous n'avez pas modifi&eacute; les donn&eacute;es de ce formulaire";

        $t['please_login']= "Vous devez ouvrir une session d'utilisateur pour acc&egrave;der &agrave; cette page";
    
        $t['num_transferred']= "Nombres de courriers transferr&eacute;s";

        $t['no_import']= "Aucun courrier &agrave; importer";

        $t['no_export']= "Aucun courrier &agrave; exporter";
    
        $t['old_num_temp_import']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">temporaire</span> <br/> 
								<span class=\"focus2\">&Agrave; TRANSF&Egrave;RER</span>";
                                
        $t['new_num_temp_import']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">temporaire</span> <br/> 
								<span class=\"focus2\">RESTANT &Agrave; TRANSF&Egrave;RER</span>";
                                            
        $t['old_num_main_import']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">principale</span> <br/> 
								<span class=\"focus2\">AVANT L'OP&Eacute;RATION</span>";
                                
        $t['new_num_main_import']="Nombres de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">principale</span> <br/> 
								<span class=\"focus2\">APR&Egrave;S L'OP&Eacute;RATION</span>";
                                
        $t['old_num_temp_export']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">temporaire</span> <br/> 
								<span class=\"focus2\">AVANT L'OP&Eacute;RATION</span>";
                                
        $t['new_num_temp_export']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">temporaire</span> <br/> 
								<span class=\"focus2\">APR&Egrave;S L'OP&Eacute;RATION</span>";
                                            
        $t['old_num_main_export']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">principale</span> <br/> 
								<span class=\"focus2\">&Agrave; TRANSF&Egrave;RER</span>";
                                
        $t['new_num_main_export']="Nombre de courriers dans <br/> la base de donn&eacute;es
								<span class=\"focus1\">principale</span> <br/> 
								<span class=\"focus2\">RESTANT &Agrave; TRANSF&Egrave;RER</span>";
                            

        $t['file_exists']= "Un courrier existant a le m&ecirc;me num&eacute;ro d'enregistrement";
        $t['record_not_found']= "Les donn&eacute;es que vous voulez modifier n'ont pas &eacute;t&eacute; trouv&eacute;s";


        $t['record_saved']= "Donn&eacute;es enregistr&eacute;es";
        $t['record_created']= "Nouvelles donn&eacute;es cr&eacute;es.";

        $t['no_result'] = "D&eacute;sol&eacute; nous n'avons pas trouv&eacute; de donn&eacute;es";
                                                
        //$t['search_num_results'] = "Nombre de r&eacute;sultats de la recherche:
        //							<span class=\"numrows\">{$this->i_var['numrows']}</span>";

        $t['undefined_error']= "D&eacute;sol&eacute;, il y a une erreur...";

        $t['invalid_request'] = <<<TXT

<h1>Votre requ&ecirc;te n&rsquo;est pas valable.</h1>

Une erreur a emp&ecirc;ch&eacute; l&rsquo;ex&eacute;cution de votre requ&ecirc;te.<br/>

TXT;

        $t['action_failed']= "Une erreur a emp&ecirc;ch&eacute; l&rsquo;ex&eacute;cution de cette proc&egrave;dure";
    
        $t['no_image']= "L'image n'est pas disponible";

        $t['image_superior']= "Les dimensions de l'image sont inacceptables. Il faut diminuer la hauteur ou la largeur.";
        $t['image_inferior']= "Les dimensions de l'image sont inacceptables. Il faut agrandir la hauteur ou la largeur.";

        $t['image_resize_failed']= "L'image n'a pas pu &ecirc;tre r&eacute;duite.";

        $t['create_failed']= "Les nouvelles donn&eacute;es n'ont pas pu &ecirc;tre enregistr&eacute;es.";
        $t['save_failed']= "Les donn&eacute;s n'ont pas pu &ecirc;tre enregistr&eacute;es.";
        $t['delete_failed']= "Les donn&eacute;es n'ont pas pu &ecirc;tre &eacute;ffa&ccedil;&eacute;es.";

        $t['jpeg_create_failed']= "L'image n'a pas pu &ecirc;tre enregistr&eacute;e, assurez vous que l'image est de type JPEG.";

        $t['undefined_error']= "D&eacute;sol&eacute;, il y a une erreur...";

        $t['invalid_date_format']= "\"{$this->i_var['not_date']}\" est une date, son format est incorrecte...";

        $t['correct_date_format']= "jj/mm/AAAA";

        $t['invalid_month_format']= "\"{$this->i_var['not_month']}\" est un mois, son format est incorrecte...";

        $t['invalid_year_format']= "Le format de l'ann&eacute;e est incorrecte...";

        $t['correct_month_format']= "mm/AAAA";

        $t['correct_year_format']= "AAAA";

        $t['access_denied'] = <<<TXT

<h1>Acc&egrave;s non-autoris&eacute;</h1>

Vous n'&ecirc;tes pas autoris&eacute;  &agrave; acc&egrave;der  &agrave; cette page.<br/>

TXT;


        $t['section_not_displayable'] = <<<TXT

Cette section n'est pas disponible.

TXT;


        $t['page_not_available'] = <<<TXT

<h1>D&eacute;sol&eacute;, la page que vous avez demand&eacute;e n'est pas disponible</h1>

Essayez une autre s&eacute;l&eacute;ction<br/>

TXT;


        $t['page_not_found'] = <<<TXT

<h1>D&eacute;sol&eacute;, la page que vous avez demand&eacute;e n'a pas &eacute;t&eacute; trouv&eacute;e</h1>

Essayez une autre s&eacute;l&eacute;ction<br/>

TXT;


        $t['form_not_validated'] = <<<TXT

<h1>D&eacute;sol&eacute;, une erreur emp&egrave;che la validation du formulaire.</h1>

Contactez un administrateur du site<br/>

TXT;


        $t['sorry_empty_section']= <<<TXT

<div class="empty_result">

<h1>D&eacute;sol&eacute;, cette section est vide</h1>

Essayez une autre s&eacute;l&eacute;ction<br/>

</div>

TXT;



        $t['please_use_form_to_contactus']= <<<TXT

Vous pouvez nous envoyer un email &agrave; l&rsquo;aide de ce formulaire &eacute;l&eacute;ctronique.

<br/>

TXT;


        $t['form_info_with_sign']= <<<TXT

Les sections marqu&eacute;es avec ce symbole sont obligatoires: <span class="compulsory_sign">*</span>

<br/>

TXT;


        $t['empty_section'] = "Cette section est vide";


        $t['empty_selected'] = "S&eacute;lectionnez un &eacute;l&eacute;ment de la liste";


        $t['no_page'] = "<div>Aucune page enregistr&eacute;e dans cette section</div>";


        $t['no_photo'] = "<div>Aucune photo enregistr&eacute;e dans cette section</div>";


        $t['empty_input'] = <<<TXT

Vous n&rsquo;avez pas rempli toutes les fen&ecirc;tres<br/>

Vous devez remplir toutes les fen&ecirc;tres obligatoires, marqu&eacute;es avec ce symbole:
 <span class="compulsory_sign">*</span>

TXT;

        $t['short_msg'] = <<<TXT

<h1>Le message est trop court</h1>

Vous devez envoyer un message plus long.<br/>

TXT;

        $t['empty_first_input'] = "La premiere fen&ecirc;tre ne peut pas &ecirc;tre vide";


        $t['already_sent'] = "Vous avez d&eacute;j� envoy&eacute; ce formulaire� Veuillez attendre notre r&eacute;ponse";



        $t['invalid_email'] = "Le format de l'adresse email n'est pas valable";


        $t['email_mismatch'] = "L'adresse email n'a pas &eacute;t&eacute; correctement confirm&eacute;e";


        $t['password_mismatch'] = "Le mot de passe n'a pas &eacute;t&eacute; correctement confirm&eacute;";


        $t['submit_title_text']= "Vous devez soumettre un titre et un texte!";

        $t['submit_text']= "Vous devez soumettre un texte!";


        $t['invalid_selected_date']= "Cette date est incorrecte!";


        $t['greater_start_date']= "La date d'arriv&eacute;e doit pr&eacute;ceder la date de d&eacute;part!";


        $t['same_start_end_date']= "Les dates d'arriv&eacute;e et de d&eacute;part doivent &ecirc;tre diff&eacute;rentes!";


        $t['february_ends_on_28']= "La date <strong>{$this->i_var['day']} f&eacute;vrier {$this->i_var['year']}</strong> n'existe pas!";


        $t['month_ends_before']= "La date <strong>{$this->i_var['day']} / {$this->i_var['month']}".
                                    " / {$this->i_var['year']}</strong> n'existe pas!";


        $t['changes_updated'] = "Les changements ont &eacute;t&eacute; enregistr&eacute;s";

        $t['image_deleted'] = "L'image a &eacute;t&eacute; effac&eacute;e";
        $t['record_deleted'] = "Les donn&eacute;es ont &eacute;t&eacute; effac&eacute;es";

        $t['fav_biz_added'] = "Cette page vient d&rsquo;&ecirc;tre ajout&eacute;e � votre liste de pages favorites";

        $t['new_image_uploaded'] = "La nouvelle image a &eacute;t&eacute; enregistr&eacute;e";

        $t['logout_completed'] = <<<HTML

Votre session a &eacute;t&eacute; termin&eacute;e.<br/>

Merci d'avoir utilis&eacute; <span class="global_name">{$s->global_name}</span>

HTML;


        $body = <<<HTML

Si vous n&rsquo;avez pas de compte, cr&eacute;ez un compte pour utiliser tous nos services<br/>

Cr&eacute;er un compte prend moins d&rsquo;une minute!<br/>

HTML;


        $t['login_to_access_page'] = <<<HTML

<h2 class="title">{$this->i_var['request_denied_title']}.</h2>

Ouvrez une session pour acc&eacute;der � cette page.<br/>

{$body}

HTML;


        $t['login_to_access_feature'] = <<<HTML

<h2 class="title">{$this->i_var['request_denied_title']}.</h2>

Ouvrez une session pour acc&eacute;der � cette option.<br/>

{$body}

HTML;

        $title= "";
        $body= "";


        $t['create_account'] = "Cr&eacute;er un nouveau compte";


        $t['confirm_activation'] =<<<HTML

<div>

<h1>F&eacute;licitations! Votre compte vient d&rsquo;&ecirc;tre activ&eacute;</h1>

Vous pouvez ouvrir une session en utilisant votre nom d&rsquo;usager et votre mot de passe<br/>

</div>

HTML;


        $t['username_taken'] = "Le nom d'usager \"{$this->i_var['username']}\" &agrave; d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute;.".
                        "Veuillez utiliser un autre nom d&rsquo;usager.";
                        
                        
        $t['email_taken'] = "L&rsquo;adresse email a d&eacute;j� &eacute;t&eacute; enregistr&eacute;e par un membre.".
                        " Veuillez utiliser une autre adresse email.";

                        
        //-----successful registration

        $t['successful_register']= <<<HTML

{$this->i_var['username']},<br/>


Vous avez &eacute;t&eacute; enregistr&eacute; en tant que membre.<br/>
Nous vous souhaitons la bienvenue parmi nos abonn&eacute;s.
<br/>

HTML;

        //----successful login

        $options=array();

        $options['operator']= "Votre session est ouverte en tant qu'<span class=\"status\">op&eacute;rateur</span>";
        $options['observer']= "Votre session est ouverte en tant que <span class=\"status\">superviseur des op&eacute;rations</span>";
        $options['admin']= "Votre session est ouverte en tant qu'<span class=\"status\">administrateur du syst&egrave;me</span>";
        $options['super_admin']= "Votre session est ouverte en tant que <span class=\"status\">Super administrateur du syst&egrave;me</span>";

        $key= $u->status_name;

        $body= $options[$key];


        $t['successful_login']= <<<HTML
<span class="successful_login">

Bienvenu sur <span class="global_name">{$s->global_name}</span>, 
<span class="username">{$this->i_var['username']}:</span><br/>

<span class="body">{$body}</span>

</span>
HTML;


        //----login_failed------

        $t['login_failed']= <<<HTML

<h1>Nous n&rsquo;avons pas pu vous identifier</h1>

Si vous n&rsquo;avez pas de compte, contactez un administrateur du syst&egrave;me
pour cr&eacute;er un compte<br/>

HTML;


        $t['login_failed_booking_admin']=  <<<HTML

Nous n&rsquo;avons pas pu vous identifier en tant qu'administrateur des r&eacute;servations

HTML;


        $t['login_failed_admin']=  <<<HTML

Nous n&rsquo;avons pas pu vous identifier en tant qu'administrateur

HTML;

        $t['mail_was_sent'] = "Votre message a &eacute;t&eacute; envoy&eacute;! Merci.";

        $t['contact_method'] = "Meilleur moyen de vous contacter";

        $t['star_form_requires'] = "Indique les informations obligatoires";

        $t['write_message'] = "Envoyer un message � ".$this->i_var['username'];

        $t['wait_next_mail_2'] = "Attendez 2 minutes pour envoyer un autre message";

        $t['wait_next_mail_3'] = "Attendez 3 minutes pour envoyer un autre message";

        $t['no_item_selected']= "Aucun &eacute;l&eacute;ment n'a &eacute;t&eacute; s&eacute;l&eacute;ctionn&eacute; dans la liste";

        $t['ask_delete'] = "Voulez-vous vraiment effacer ces donn&eacute;es?";

        $t['close_edit'] = "Fermer le mode d'&eacute;dition";

        $t['confirm_apply'] = "Votre candidature vient d&rsquo;&ecirc;tre enregistr&eacute;e";
    }
}
