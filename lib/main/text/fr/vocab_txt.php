<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



//------accents: � � � � �

class vocab_txt extends text_settor
{
    protected function set_text(&$t)
    {
        $t['error']= "erreur";
    
        $t['limit']= "Limite";

        $t['import_to_dbase']= "Importer dans la base de donn&eacute;es";
        $t['reset']= "R&eacute;initialiser";

        $t['results']= "R&eacute;sultats";
        $t['results_for']= "R&eacute;sultats pour: ";

    
        $t['line']= "Ligne";
    
        $t['pause']= "Pause";
        $t['start']= "Continuer";

        $t['letter']= "Lettre";
    
        $t['print_page']= "Impression d'une page";
    
    
        $t['print']= "Imprimer";

        $t['print_all']= "Imprimer tout";

        $t['top_of_page']= "Haut de page";
    
        $t['dates']= "Dates";

        $t['user_status']="Type d'usager";
    
        $t['navigation']="Navigation";

        $t['close']="Fermer";
    
        $t['manage']="Gestion";
    
        $t['users']="Usagers";

        $t['edit_create']="Cr&eacute;er, modifier";
    
        $t['yes']="Oui";
        $t['no']="Non";
                
    
        $t['type_id']="Type";
        $t['month']= "Mois";
        $t['p_month']="par mois";
        $t['p_week']="par semaine";
        $t['p_year']="par ann&eacute;e";

        $t['last_update']= "Derni&egrave;re mise &agrave; jour";
        $t['accomodation']= "Logement";
        $t['register_accom']= "Enregistrer un logement";
        $t['rent']= "Loyer";
        $t['rent_min']= "Loyer minimum";
        $t['rent_maximum']= "Loyer maximum";
        $t['studio']= "Studio";
        $t['flat']= "Appartement";
        $t['house']= "Maison";
        $t['floor']= "&Eacute;tage";

        $t['lift']= "Ascenseur";

        $t['insert_photo']="Ins&egrave;rer une photo";
    
        $t['room']= "Chambre";
        $t['kitchen']= "Cuisine";
        $t['shower']= "Douche";
        $t['toilet']= "Toilette";

        $t['share_shower']= "Douche commune";
        $t['share_toilet']= "Toilette commune";
        $t['share_ctyard']= "Cour commune";
        $t['modern_toilet']= "toilettes modernes";
        
        $t['guest']= "invit&eacute;";
    
        $t['history']= "Historique";

        $t['open_history']= "Historique";

        $t['private_search']= "Recherche priv&eacute;e";

        $t['public_search']= "Recherche publique";
    
        $t['search_parameters']= "Param&egrave;tres de recherche";
    
        $t['origin']= "Provenance";

        $t['start_date']= "D&eacute;but";
        $t['end_date']= "Fin";
    
        $t['month']= "Mois";
    
        $t['year']= "Ann&eacute;e";
    
        $t['list_months']= array("janvier", "f&eacute;vrier", "mars", "avril", "mai", "juin", "juillet", "ao&ucirc;t",
                            "septembre", "octobre", "novembre", "d&eacute;cembre");

        $t['list']= "Liste";
                            
        $t['service']= "Service";

        $t['client_reference']= "Matricule";

        $t['clients_abbr']= "Inter.";
                
        $t['clients']= "Interess&eacute;s";
        
        $t['libmvt']= "Motif";
    
        $t['numprojet']= "Num&eacute;ro du projet";
        $t['etatprojet']= "Etat du projet";

        $t['numlettre']= "R&eacute;f&eacute;rence";
        $t['naturecourrier']= "Nature du courrier";
    
        $t['search_results']= "R&eacute;sultats de la recherche";
    
        $t['subject']= "Objet";
    
        $t['link']= "Lien";

        $t['url']="Lien Internet";

        $t['send_user_info']= "Envoyer les informations des usagers";
    
        $t['your_user_info']="Confirmation de vos profil";

        $t['user_info_sent']= "Les informations des usagers ont &eacute;t&eacute; envoy&eacute;es";

        $t['simple_file_view']= "Vue simple";
        
        $t['registers']= "Registres";
    
        $t['list_search_accounts']= "Rechercher un registre";

        $t['make_archive']= "Archiver";
        $t['archive']= "Archive";

        $t['new']= "Nouveau";
        $t['read_file']= "Mode de lecture";
        $t['comment_saved']= "Texte enregistr&eacute;";
        $t['edit_comment'] = "&Eacute;diter";
        $t['edit_this_file'] = "&Eacute;diter";
        $t['all']= "Tous";
        $t['reference']= "R&eacute;f&eacute;rence externe du courrier";
        $t['organization']= "Origine | Organisation";
        $t['position']= "Poste";

        $t['types']= "Types";
    
        $t['close_session']= "Fermer la session";

        $t['user_files']= "Liste de vos courriers";

        $t['insert_id']= "Ins&egrave;rer votre ID";

        $t['access']= "Acc&egrave;s";

        $t['adref']= "R&eacute;f&eacute;rence administrative";

        $t['user_adref']= "R&eacute;f&eacute;rence administrative de l'usager";

        $t['level']= "Niveau";


        $t['import']="Importer";
        $t['export']="Exporter";

        $t['import_dbase']="Importer";
        $t['export_dbase']="Exporter";
        
        $t['update_dbase']="Mise &agrave jour";
    
        $t['num_transferred']= "Nombres de courriers transferr&eacute;s";

        $t['other_names']="Autres noms";
    
        $t['file_types']= "Types de courriers";


        $t['find_keyword']="Utiliser des mots cl&eacute;s";
        $t['regis_id']= "Num&eacute;ro d'enregistrement";
        $t['find_registration_id']= "Utiliser un num&eacute;ro d'enregistrement";
        $t['bordereau_id']= "Num&eacute;ro de bordereau";
        $t['find_bordereau_id']= "Utiliser un num&eacutero de bordereau";


        $t['import']="Importer";
        $t['export']="Exporter";

        $t['mgr_comment']= "Instructions du manager";
        $t['edit_mgr_comment']= "&Eacute;diter les instructions du manager";
        $t['sup_comment']= "Observations du superviseur";
        $t['edit_sup_comment']= "&Eacute;diter les Observations du superviseur";
        $t['op_comment']= "Observations des OP&Eacute;RATEURS";

        $t['operator_comment']= "Observations des op&eacute;rateurs";
        $t['supervisor_comment']= "Commentaire du Dir. Cab";

                            
        $t['update_dbase']="Mise &agrave jour";
                            
        $t['change_log']="Historique de ce courrier";

        $t['today']="Aujourd'hui";
        $t['yesterday']="Hier";
        $t['last7']="7 derniers jours";
        $t['last15']="15 derniers jours";
        $t['last30']="30 derniers jours";

        $t['edit_file_not_found']= "Le courrier que vous voulez modifier n'a pas &eacute;t&eacute; trouv&eacute;";
        $t['invalid_date']= "La date est incorrecte.";
        $t['file_saved']= "Le courrier a &eacute;t&eacute; enregistr&eacute;.";
        $t['new_file']= "Nouveau courrier";
        $t['create_file']= "Enregistrer un courrier";
        $t['find_file']= "Recherche";
        $t['file_not_found']= "courrier inconnu";
        $t['find']= "Chercher";
        $t['find_edit']= "Chercher et &eacute;diter";
        $t['edit_file']= "&Eacute;diter un courrier";
        $t['file_found']= "courrier trouv&eacute;";

        $t['status']= $t['status_name']= "Statut";

        $t['sp']= "Mots cl&eacute;s";
        $t['regis_id']= "Num&eacute;ro d'enregistrement";
        $t['bordereau_id']= "Num&eacute;ro de bordereau";
        $t['client_firstname']= "Pr&eacute;nom";
        $t['client_surname']= "Nom";
        $t['firstname']= "Pr&eacute;nom";
        $t['surname']= "Nom";
        $t['fullname']= "Nom";
        $t['client_dob']= "Date de naissance";
        $t['description']= $t['body_description']= "D&eacute;scription";
    
        $t['submit']= "Soumettre";
        $t['save']= "Enregistrer";

        $t['website_slogan']= "Slogan du site";
            
        $t['postal_address']= "Adresse postale";

        $t['projects']= "Projets";

        $t['our_projects']= "Nos projets";

        $t['text_images']= "Texte et images ";

        $t['powered_with']= "Site cr&eacute;e avec";

        $t['go_bottom_bar']= "Haut de page";

        $t['all_rights_reserved']= "tous droits r&eacute;serv&eacute;s";

        $t['product']= "Produit";

        $t['products']= "Produits";

        $t['cpanel'] = "CPanel";

        $t['partners_cpanel'] = "CPanel des partenaires";

        $t['top_page'] = "Haut de page";

        $t['home'] = "Acceuil";

        $t['member_page'] = "Page de membre";

        $t['partner_page'] = "Page de partenaire";

        $t['photo']= "Photos";

        $t['login']= "Nouvelle session";

        $t['register']= "Nouveau compte";

        $t['about_us']= "A propos";

        $t['contact_us']= "Nous contacter";

        $t['ask_information']= "Demande d'information";

        $t['explore'] = "Explorer";

        $t['privacy_policy'] = "Confidentialit&eacute;";

        $t['terms_conditions'] = "Termes et conditions d'usage";

        $t['mail_msg']= "Messages";

        $t['biz'] = "Entreprises";

        $t['member'] = "Membres";

        $t['finance'] = "Finance";

        $t['author']= "Auteur";

        $t['partner']= "Partenaires";

        $t['basic_member']= "Membres Basic";

        $t['booking']= "R&eacute;servations";

        $t['hotel_booking']= "R&eacute;servations d'h�tel";

        $t['demo_bar']= "D&eacute;monstration";

        $t['show_demo']= "Voir une d&eacute;monstration";

        $t['keywords']= "Mos cl&eacute;s";

        //-------------Comments---------------------------------

        $t['comments'] = "Commentaires";

        $t['add_new_comment']= "Ajouter un commentaire";

        $t['posted_on']= "Enregistr&eacute; le ";
        $t['comment_posted_on']= "Commentaire enregistr&eacute; le ";
        $t['reply_posted_on']= "R&eacute;ponse enregistr&eacute;e le ";


        $t['posted_by']= "par ";
        $t['reply']= "R&eacute;ponse";
        $t['respond']= "R&eacute;pondre";
        $t['replies_to']= "R&eacute;ponse(s) �";

        $t['edit_reply']= "Editer votre r&eacute;ponse";

        $t['recent_comments'] = "Commentaires r&eacute;cents";

        $t['no_comment'] = "Soyez la premi&egrave;re personne � faire un commentaire";

        //---------------score comments------

        $t['bad']= "M&eacute;diocre";

        $t['average']= "Moyen";

        $t['good']= "Bien";

        $t['very_good']= "Tr&egrave;s bien";

        $t['articles']= "Articles";

        $t['none'] = "Aucun(e)";

        $t['title'] = "Titre";

        $t["last_edited"]= "Derni&egrave;re &eacute;dition";

        $t["by"]= "par";

        $t['text'] = "Texte";

        $t['paragraph'] = "Paragraphe";

        $t['add_paragraph'] = "Ajouter un paragraphe";

        $t['add_article'] = "Ajouter un article";

        $t['top_page_text'] = "Texte en haut de page (optionel)";

        //Login

        $t['username'] = "Nom d'usager";

        $t['password'] = "Mot de passe";

        $t['log_out'] = "Fermer la session";

        $t['create_account'] = "Cr&eacute;er un nouveau compte";

        $t['image_title'] = "Titre de l'image";

        $t['image_deleted'] = "L&rsquo;image a &eacute;t&eacute; effac&eacute;e";

        $t['new_image'] = "Nouvelle image";

        $t['add_image'] = "Ajouter une image";

        $t['per_day'] = "par jour";

        //---------Email & messages-------------------------

        $t['send_mail'] = "Envoyer un email";

        $t['email_to_list'] = "Envoyer un email &agrave; cette liste";

        $t['email_list'] = "Liste des adresses emails";

        $t['contact_us'] = "Nous contacter";

        $t['name'] = "Nom";

        $t['message'] = "Message";

        $t['new_msg'] = "Nouveaux Messages";

        $t['mail_was_sent'] = "Votre message a &eacute;t&eacute; envoy&eacute;! Merci.";

        $t['contact_method'] = "Meilleur moyen de vous contacter";

        $t['star_form_requires'] = "Indique les informations obligatoires";

        $t['write_message'] = "Envoyer un message � ".$this->i_var['username'];

        $t['wait_next_mail_2'] = "Attendez 2 minutes pour envoyer un autre message";

        $t['wait_next_mail_3'] = "Attendez 3 minutes pour envoyer un autre message";


        //-------------------Area--------------------------------------------

        $t['country_town_subtown'] = "Pays, ville et secteur";

        $t['address'] = "Adresse";

        $t['all_countries'] = "Tous les pays";

        $t['all_towns'] = "Toutes les villes";

        $t['all_subtowns'] = "Toutes les zones";

        $t['country'] = "Pays";

        $t['country_town']= "Ville et pays";

        $t['countries'] = "Pays";

        $t['town'] = "Ville";

        $t['towns'] = "Villes";

        $t['zones'] = "Zones";

        $t['subtown'] = $t['subtown_name']= "Arrondissement";

        $t['town_country'] = "Ville et pays";



        //------------Blog------------------------------


        $t['blog'] = "Blog";
        $t['blog_channel'] = "Blog Channel";



        //-------------Date---------------------------------------

        $t['date']= "Date";
        $t['date_format']= "dd/mm/yyyy";


        //--------------Feedback----------------------------------------
        //-------------------------------------------------------------

        $t['ready_biz_feedbacks']= "Lire les appr&eacute;ciations activ&eacute;es";
        $t['ready_empty_biz_feedbacks']= "Nouvelles appr&eacute;ciations � soumettre";
        $t['ready_partner_feedbacks']= "Lire les appr&eacute;ciations activ&eacute;es";
        $t['suspended_biz_feedbacks']= "Appr&eacute;ciations suspendues";
        $t['suspended_partner_feedbacks']= "Appr&eacute;ciations suspendues";
        $t['empty_biz_feedbacks']= "Nouvelles appr&eacute;ciations � soumettre";
        $t['empty_partner_feedbacks']= "Nouvelles appr&eacute;ciations � soumettre";
    
        $t['reference']= "R&eacute;ference";
    
        $t['partner'] = "Partenaire";

        $t['add_new'] = "Ajouter";

        $t['all_cat'] = "Toutes les cat&eacute;gories";

        $t['arrow'] = "fl&egrave;che";

        $t['ask_confirm_delete_img']= "Voulez-vous vraiment effacer cette image?";

        $t['p_day'] = " p/jour";

        $t['apply'] = "Candidature";

        $t['bye'] = "A bient�t!";

        $t['d_'] = "d'";

        $t['category'] = "Cat&eacute;gorie";

        $t['categories'] = "Cat&eacute;gories";

        $t['subcategory'] = "Cat&eacute;gorie";

        $t['subcat_name'] = "Cat&eacute;gorie";

        $t['careful'] = "Attention!";

        $t['cancel'] = "Annuler";

        $t['change'] = "Changer";

        $t['change_image'] = "Changer l'image";

        $t['change_edit'] = "Changer ou modifier";

        $t['close_session'] = "Fermer la session";

        $t['close_edit'] = "Fermer le mode d'&eacute;dition";

        $t['currency'] = "Monnaie";

        $t['forward'] = "Continuer";

        $t['contract'] = "Contrats";

        $t['create_profile'] = "Cr&eacute;er un profile";

        $t['fax'] = "Fax";

        $t['ask_booking'] = "Demander une r&eacute;servation";

        $t['comment_members'] = "Poster des commentaires et discuter avec d&rsquo;autres membres";

        $t['write_msg'] = "Ecrire des messages";

        $t['post_photos'] = "Poster des photos";

        $t['hotel'] = "h�tel";

        $t['hotels'] = "h�tels";

        $t['introduction'] = "Introduction";

        $t['min_price'] = "Tarif minimum";

        $t['min_price'] = "Tarif minimum";

        $t['name_address'] = "Nom et adresse";

        $t['no'] = "Non";

        $t['next'] = "Suivante";

        $t['open_page'] = "Ouvrir ma page";

        $t['page'] = "page";

        $t['pages'] = "pages";

        $t['password'] = "Votre mot de passe";

        $t['photo'] = "photo";

        $t['photos'] = "photos";

        $t['presentation'] = "Pr&eacute;sentation";

        $t['procurement'] = "Appels d'offres";

        $t['partners'] = "Partenaires";

        $t['do_search'] = "Faire une recherche";

        $t['send'] = "Envoyer";

        $t['select'] = "S&eacute;lectionner";

        $t['select_image'] = "Choisir une image";

        $t['service'] = "Service";

        $t['services'] = "Services";

        $t['supply_services'] = "Prestations de services";

        $t['star'] = "&eacute;toile";

        $t['stars'] = "&eacute;toiles";

        $t['start_ss'] = "Commencer une session";

        $t['telephone'] = "T&eacute;l&eacute;phone";

        $t['thanks'] = "Merci";

        $t['yes'] = "Oui";

        $t['years'] = "ans";

        $t['years2'] = "ann&eacute;es";

        $t['your_age'] = "Votre &acirc;ge";

        $t['your_selection'] = "Votre s&eacute;l&eacute;ction";

        $t['unknown']= "Inconnu(e)";
    }
}
