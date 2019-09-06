<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



//------accents: � � � � �

class specific_txt extends text_settor
{
    protected function set_text(&$t)
    {
        global $s;

        $t['waiting']= "En attente";

        $t['search_id_file']= $t['num_of_file']= "N&deg; de courrier";
        $t['search_id_proj']= $t['num_of_project']= "N&deg; de projet";

        $t['num_print_letter']= "N&deg; de la lettre";


        $t['total_cc']= "Ampliations";

        $t['username'] = $t['mf_username'] ="Nom d'usager";

        $t['is_printed']= "Imprim&eacute;";
        $t['linked_to_letter']= "Li&eacute; &agrave; une lettre";

        $t['date_sent']= "Date d'envoi";
        $t['last_sent']= "Dernier envoi";

        $t['date_subscribed']= "Date de souscription";

        $t['print_trial_p1']= "un (1) mois";
        $t['print_trial_p2']= "deux (2) mois";
        $t['print_trial_p3']= "trois (3) mois";
        $t['print_trial_p4']= "quatre (4) mois";
        $t['print_trial_p5']= "cinq (5) mois";
        $t['print_trial_p6']= "six (6) mois";
        $t['print_trial_p7']= "sept (7) mois";
        $t['print_trial_p8']= "huit (8) mois";
        $t['print_trial_p9']= "neuf (9) mois";
        $t['print_trial_p10']= "dix (10) mois";
        $t['print_trial_p11']= "onze (11) mois";
        $t['print_trial_p12']= "douze (12) mois";


        $t['trial_period']= "P&eacute;riode d'essai";

        $t['max_num_pages']= "Nombre de pages";

        $t['file']= "Courrier";
    
        $t['v_summary']= <<<TXT
S
o
m
m
a
i
r
e
TXT;

        $t['to_dgb']= "D&eacute;part DGB";
        $t['from_dgb']= "Retour DGB";
    
        $t['rejected']= "Rejets";
    
        $t['has_class']= "Classification";

        $t['has_project']= "Projet";
    
    
        $t['receiver']= "Num&eacute;ro de tel du destinataire";
        $t['sender']= "Num&eacute;ro de tel de l'exp&eacute;diteur";


        $t['clients_subscribed']= "Nouveaux abonn&eacute;s";
    
        $t['request_sms_sent']= "SMS | Envois: R&eacute;ponses";
        $t['subscribers_sent']= "SMS | Envois: Souscriptions";

        $t['sms_failed']= "SMS | Echecs: Erreurs li&eacute;es aux donn&eacute;es du sms";
        $t['document_failed']= "SMS | Echecs: Erreurs li&eacute;es aux donn&eacute;es du document";
        $t['client_failed']= "SMS | Echecs: Erreurs li&eacute;es aux donn&eacute;es du client";

        $t['send_failed']= "SMS | Echecs: Erreurs li&eacute;es &agrave; l'envoi du sms";


        $t['sms']= "SMS";

        $t['action']= "Action";
    
        $t['manage_sms']= "SMS: Gestion";

        $t['send_receive_sms']= "SMS: envoyer | recevoir";
    
        $t['has_stats']= "Acc&egrave;s aux statistiques";

        $t['date_printed']= "Date d'impression";
    
        $t['set_printed']= "Statut:imprim&eacute;e";
        $t['set_not_printed']= "Statut:pas imprim&eacute;e";

        $t['option_qual']= "Option du dipl&ocirc;me";

        $t['origin_qual']= "Lieu d'obtention du dipl&ocirc;me";

        $t['masc_cardinal_suffixes']= array("", "er", "&egrave;me");
        $t['fem_cardinal_suffixes']= array("", "&egrave;re", "&egrave;me");

        $t['determ_client']= $t['determ_dept']= $t['determ_serv']= $t['determ_rank']= $t['determ_scale']= $t['determ_work']=
$t['determ_qual']= "D&eacute;terminants | mots suppl&eacute;mentaires";
    
        $t['selected_start_date']= "A partir du";
        $t['and_selected_end_date']= "et jusqu'au";
        $t['selected_end_date']= "Jusqu'au";
    
        $t['add_to_print_list']= "Ajouter aux lettres &agrave; imprimer";

        $t['search_num_results'] = "Nombre de courriers trouv&eacute;s:
							<span class=\"numrows\">{$this->i_var['numrows']}</span>";
                            
                            
        $t['projects_of_file']= "Projets du courrier n&deg; {$this->i_var['id_file']}";
    
        $t['file_projects']= "Projets d'un courrier";
        $t['the_file_projects']= "Projets du courrier";
    
        $t['registration']= "Enregistrement";

        $t['minister']= "Ministre";
        $t['gen_dir']= "Dir. G&eacute;n&eacute;ral";

        $t['new_bordereau_list']= "Liste des nouveaux num&eacute;ros de bordereau";
        $t['create_bordereau']="Num&eacute;ro de bordereau";
        $t['has_create_file']= "Peut cr&eacute;er un courrier";
        $t['has_create_bordereau']= "Peut attribuer un num&eacute;ro de bordereau";
        $t['has_create_project']= "Peut cr&eacute;er un projet";
        $t['has_search']= "Module de recherche";

        $t['has_print_letter']= "Droit d'imprimer des lettres";
        $t['has_write_letter']= "Module d'impression des lettres";
        $t['has_send_sms']= "Peut envoyer des sms";

        $t['all_files_transit']= "Tous les courriers en transit";
        $t['all_files_rejected']= "Transferts: tous les courriers rejet&eacute;s";
        $t['all_other_files']= "Autres courriers";

        $t['all_proj_transit']= "Tous les projets en transit";
        $t['all_proj_rejected']= "Transferts: tous les projets rejet&eacute;s";
        $t['all_other_proj']= "Autres projets";
    
        $t['describe_trans']= "Raison du transfert";
        
        $t['num_group_18_19']= "groupe d'&acirc;ge 18 &agrave; 19 ans";
        $t['num_group_20_29']=  "groupe d'&acirc;ge 20 &agrave; 29 ans";
        $t['num_group_30_39']=  "groupe d'&acirc;ge 30 &agrave; 39 ans";
        $t['num_group_40_49']=  "groupe d'&acirc;ge 40 &agrave; 49 ans";
        $t['num_group_50_59']=  "groupe d'&acirc;ge 50 &agrave; 59 ans";
        $t['num_group_60_64']=  "groupe d'&acirc;ge 60 &agrave; 64 ans";
        $t['num_group_65_69']=  "groupe d'&acirc;ge 65 &agrave; 69 ans";
        $t['num_group_70_74']=  "groupe d'&acirc;ge 70 &agrave; 74 ans";

        $t['bepc']= "BEPC";
        $t['bac']= "Baccalaur&eacute;at";
        $t['bac2']= "Bac+2";
        $t['bac3']= "Bac+3";
        $t['bac4']= "Bac+4";
        $t['bac5']= "Bac+5";
        $t['doc']= "Doctorat";
    

        $t['qual_level']= $t['name_qual_level']= "Niveau d'&eacute;tudes";

        $t['no_qual']= "Sans dipl&ocirc;me homologu&eacute;";
        $t['cepe']= "CEPE";
        $t['bepc']= "BEPC";
        $t['bac']= "Baccalaur&eacute;at";
        $t['bac2']= "Bac+2";
        $t['bac3']= "Bac+3";
        $t['bac4']= "Bac+4";
        $t['bac5']= "Bac+5";
        $t['doc']= "Doctorat";
        $t['prof']= "Professorat";

        $t['stat_method']= "M&eacute;thode";

        $t['title_report']= "Titre du rapport";

        $t['describe_report']= "D&eacute;scription";

        $t['stat_report']= "Rapport de statistiques";

        $t['view_stat_report']= "Afficher";

        $t['stat_report_of']= "Rapport de statistiques du";
    
        $t['stat_reports']= $t['manage_stat_reports']= "Statistiques";

        $t['publish']= "Publier";

        $t['add_clients']= "Ajouter";
        $t['clients_of_file']= "Interess&eacute;(s) d'un courrier";
        $t['clients_of_project']= "Interess&eacute;(s) d'un projet";

        $t['actions']= "Journal";

        $t['proj_no_letter']= "Projets sans lettre";

        $t['transfer_file']= "Transfert | courriers";
        $t['transfer_project']= "Transfert | projets";
    
        $t['fill_letter']= "Cr&eacute;ation d'une lettre";


        $t['selected_project']= "Projet s&eacute;l&eacute;ctionn&eacute;";
        $t['selected_letter']= "Lettre s&eacute;l&eacute;ctionn&eacute;e";

        $t['letter_preview']= "Aper&ccedil;u avant impression";

        $t['select_a_project']= "S&eacute;l&eacute;ctionnez un projet";
        $t['select_a_letter']= "S&eacute;l&eacute;ctionnez une lettre";


        $t['letter_use']= "Lettre: utiliser";
    
        $t['work_cat_1']= "I";
        $t['work_cat_2']= "II";
        $t['work_cat_3']= "III";
            
        $t['town_birth']= "Lieu de naissance";

        $t['print_letters']= "Lettres &agrave; imprimer";
        $t['printed_letters']= "Lettres imprim&eacute;es";

        $t['title_letter']= "Titre de la lettre";

        $num= 1;

        while ($num <= $s->max_letter_num_pages) {
            $t["body_letter".$num]= "Corps de la lettre, page ".$num;
        
            $num++;
        }
    
        $t['letters']=$t['manage_letters']= "Lettres";
    
        $t['file_history']= "Historique d'un courrier";
        $t['project_history']= "Historique d'un projet";

        $t['transfer_cancelled']= "Transfert annul&eacute;";
    
        $t['dept_type']= "Type de d&eacute;partement";
        $t['external']= "Externe";
        $t['internal']= "Interne";
        
        $t['proj_ref']= "R&eacute;f&eacute;rence du projet";
    
        $t['create_proj_project']="Diviser en projets";
    
        $t['cancel_transfer']="Annuler le transfert";

        $t['carriers']= "Charg&eacute;s de transfert";
        $t['file_created']= "Enregistrement du courrier";
        $t['project_created']= "Cr&eacute;ation du projet";

        $t['active_files']= "Courriers actifs";
        $t['inactive_files']= "Courriers inactifs";

        $t['sp_file']= "Courrier";
        $t['file_status']= $t['name_status']= "Statut";
        $t['dormant_with_projects']= "Inactif | Avec interess&eacute;(es) | Avec projet";
        $t['active_no_client']= "Actif | Sans interess&eacute;(es) | Sans projet";
        $t['active_no_project']= "Actif | Avec interess&eacute;(es) | Sans projet";
        $t['active_with_project']= "Actif | Avec interess&eacute;(es) | Avec projet(s)";
        
        $t['male']="Homme";
        $t['female']="Femme";
        
        $t['edit_project_type']= "&Eacute;diter un type de projet";
        $t['edit_user']= "&Eacute;diter un usager";
        $t['create_user']= "Cr&eacute;er un usager";

        $t['9_super_admin']= $t['super_admin']= "Super Administrateur";
        $t['7_admin']= $t['admin']= "Administrateur";
        $t['6_supervisor']= $t['supervisor']= "Superviseur";
        $t['5_operator']= $t['operator']= "Op&eacute;rateur";

        $t['client_class']="Classification d'un interess&eacute;";
        $t['the_client_class']="Classification de l'interess&eacute;";

        $t['files']="Courriers";
        $t['file_num']="Courrier n&deg; {$this->i_var['id_file']}";
        $t['departments']="D&eacute;partements";
        $t['projects']="Projets";
        $t['file_categories']="Cat&eacute;gories de courriers";
        $t['file_types']="Types de courriers";
        $t['project_types']="Types de projets";
        $t['project_status']="Statuts des projets";
        $t['class']= "Classification standard";
        $t['edit_client_class']= "Classification de l'interess&eacute;(e)";
        $t['qualifications']="Dipl&ocirc;mes";
        $t['client_dates']="Dates de la classification de l'interess&eacute;(e)";
        $t['client_qualification']="Dipl&ocirc;me de l'interess&eacute;(e)";
        $t['createmail']="Cr&eacute;er un courrier";
        $t['create_project']="Cr&eacute;er un projet";
        $t['create_project_from_mail']="Cr&eacute;er un projet &aacute; partir d'un courrier";
        $t['create_project_from_project']="Cr&eacute;er un projet &aacute; partir d'un projet";
        $t['edit_mail']="&Eacute;diter un courrier";
        $t['edit_project']="&Eacute;diter un projet";
        $t['client']="Interess&eacute;";
        $t['clients']="Interess&eacute;s";
    
        $t['clients_of_file']= "Interess&eacute;s du courrier n&deg; {$this->i_var['id_doc']}";
        $t['clients_of_project']= "Interess&eacute;s du projet n&deg; {$this->i_var['id_doc']}";

        $t['the_file_clients']="Interess&eacute;s du courrier";
        $t['the_project_clients']="Interess&eacute;s du projet";
        $t['file_clients']="Interess&eacute;s d'un courrier";
        $t['project_clients']="Interess&eacute;s d'un projet";

        $t['new_project_clients']="Interess&eacute;s du nouveau projet";
        $t['transfer_vb']="Orienter";
        $t['transfer_nm']="Orientation";
        $t['department']="D&eacute;partement";
        $t['name_dept_type']="Type";
        $t['name_coming_from']="Provenance";
        $t['going_to']="Destination";
        $t['reason']="Motif";
        $t['classification']="Classification";
        $t['services']="Services";
        $t['service']=$t['name_serv']="Service";
        $t['ranks']="Grades";
        $t['rank']=$t['name_rank']="Grade";
        $t['work_cat']= $t['name_work_cat']="Cat&eacute;gorie";
        $t['work_class']="Classe";
        $t['scale']="&Eacute;chelle";
        $t['start_scale']="Insertion dans l'&eacute;chelle";
        $t['start_work']="Prise de service";
        $t['works']="Corps professionnels";

        $t['work']= $t['name_work']= "Corps professionnel";
        $t['qualification']= $t['name_qual']= "Dipl&ocirc;me";
        $t['qualifications']="Dipl&ocirc;mes";
        $t['tracability']="tra&ccdil;abilit&eacute;";
        $t['transfer']="Transfert";
        $t['carrier']= $t['info_carrier']="D&eacute;charg&eacute; par";
        $t['document_received']="Document re&ccedil;u";
        $t['document_sent']="Documents envoy&eacute;s";
        $t['document_in_transit']="Document en transit";

        $t['files_transit']="Courriers en transit";
        $t['projects_transit']="Projets en transit";

        $t['file_trans_rejected']="Courriers - transfert annul&eacute;";
        $t['proj_trans_rejected']="Projets - transfert annul&eacute;";

        $t['file_trans_rejected_br']="Courriers <br/>- transfert annul&eacute;";
        $t['proj_trans_rejected_br']="Projets <br/>- transfert annul&eacute;";


        $t['selection_received']="S&eacute;lection re&ccedil;u";
        $t['files_sent']="Courriers envoy&eacute;";
        $t['files_in_transit']="Courriers en transit";
        $t['project_received']="Projet re&ccedil;u";
        $t['project_sent']="Projets envoy&eacute;";
        $t['project_in_transit']="Projets en transit";
        $t['transit']="Transit";
        $t['received']="Re&ccedil;u";
        $t['not_received']="Non re&ccedil;u";
        $t['open_history']= "Historique";
        $t['search_parameters']= "Param&egrave;tres de recherche";
        $t['not_found']= "Aucun document trouv&eacute;";
        $t['mail_abbr']= "Courr.";
        $t['project_abbr']= "Proj.";
        $t['file_type']= "Type de courrier";
        $t['file_category']= "Cat&eacute;gorie du courrier";
        $t['top_surname']= "Nom en t&ecirc;te";
        $t['top_firstname']= "Pr&eacute;nom en t&ecirc;te";
        $t['file_reference']= "R&eacute;f&eacute;rence externe du document";
        $t['list']= "Liste";
        $t['service']= "Service";
        $t['clients_abbr']= "Inter.";
        $t['status']= "Etat du projet";
        $t['reference']= "R&eacute;f&eacute;rence";
        $t['mail_type']= "Nature du courrier";
        $t['search_results']= "R&eacute;sultats de la recherche";
        $t['subject']= "Objet";
        $t['num']= "N&deg;";
        $t['number']= "Num&eacute;ro";
        $t['num_phone']= "N&deg; de t&eacute;l&eacute;phone";
        $t['id_client']= "N&deg; de l'interess&eacute;(e)";
        $t['id_proj']= "N&deg; du projet";
        $t['date_birth']= "Date de naissance";
        $t['client_type']= $t['name_client_type']= "Type";

        $t['candidate']= "candidat";
        $t['c_vlteer']= "b&eacute;n&eacute;vole";
        $t['c_dcs']= "d&eacute;cisionnaire";
        $t['c_ctt']= "prestataire";

        $t['candidate_smp']= "Cddat simple";
        $t['candidate_vlteer']= "Cddat b&eacute;n&eacute;vole";
        $t['candidate_dcs']= "Cddat d&eacute;cisionnaire";
        $t['candidate_ctt']= "Cddat prestataire";

        $t['employee']= "Employ&eacute;";

        $t['client_type']= "Type";
        $t['id_agent']= "Matricule";
        $t['sex']= "Sexe";
        $t['email']= "E-mail";
        $t['name_dept']= "D&eacute;partement";
        $t['date_created']= "Date d'enregistrement";
        $t['is_active']= "Actif";
        $t['not_active']= "Dormant";
        $t['file_ref']= "R&eacute;f&eacute;rence du courrier";
        $t['file_date']= "Date de cr&eacute;ation du document";
        $t['name_cat']= "Cat&eacute;gorie de courrier";
        $t['name_type']= "Type de courrier";
        $t['move']= "Transfert";
        $t['date_trans']= "Date du transfert";
        $t['mail_abbr']= "Courr.";
        $t['project_abbr']= "Proj.";
        $t['project']= "Projet";
        $t['dept_comingfrom']= $t['name_dept_comingfrom']= "Provenance";
        $t['dept_goingto']= $t['name_dept_goingto']="Destination";

        $t['describe']= $t['dept_describe']= "Description";
        $t['describe_trans']= "Raison du transfert";
        $t['status_trans']= $t['name_status_trans']= "Statut du transfert";
        $t['name_carrier']= "Charg&eacute; de transport";
        $t['name_proj_type']= "Type de projet";
        $t['no_id_bordereau']= "N&deg; de bordereau<br/> non attribu&eacute;";
        $t['id_bordereau']= $t['num_bordereau']= "N&deg; de bordereau";
        $t['name_proj_status']= "Statut du projet";
        $t['class_name']= "Classification";
        $t['scale']= "&Eacute;chelle";
        $t['echelon']= "&Eacute;chelon";
        $t['work_index']= "Indice";
        $t['proj_type']= "Type de projet";
        $t['user_type']= "Type d'utilisateur";

        $t['num_file']= "N&deg; du courrier";
        $t['num_proj']= "N&deg; du projet";

        $t['id_file']= $t['status_id_file']= $t['id_file_cat']= $t['id_class']= $t['id_client_class']= $t['id_proj_type']= $t['id_dept']= $t['id_file_type']= $t['id_carrier']= $t['id_work']=$t['id_proj_status']= $t['id_qual']= $t['id_rank']= $t['id_stat_report']= $t['id_letter']= $t['id_print_letter']=$t['id_sms']="N&deg;";
    }
}
