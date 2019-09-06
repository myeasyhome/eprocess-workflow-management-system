<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



//------accents: � � � � �

class list_txt extends text_settor
{
    protected function set_text(&$t)
    {
        $t['list_months']= array("janvier", "f&eacute;vrier", "mars", "avril", "mai", "juin", "juillet", "ao&ucirc;t",
                            "septembre", "octobre", "novembre", "d&eacute;cembre");
    
        $t['list_search_accounts']= "Rechercher un registre";

        $t['demo1']= "D&eacutemo 1: Courrier";
        $t['demo2']= "D&eacutemo 2: Revenus et D&eacute;penses";
        $t['demo3']= "D&eacutemo 3: Archives";
        $t['demo4']= "D&eacutemo 4: Librairie";
                        
        $t['list_new_files']= "Nouveaux courriers";
        $t['list_archive']= "Archives";

        $t['all']= "Tous";

        $t['list_user_files']= "Liste de vos courriers";


        $t['today']="Aujourd'hui";
        $t['yesterday']="Hier";
        $t['last7']="7 derniers jours";
        $t['last15']="15 derniers jours";
        $t['last30']="30 derniers jours";


        //------------------------Paging---------------------------------------------------

        $t['last']= "Fin";
        $t['part']= "Partie";
        $t['next']= "Suivante";
        $t['previous']= "Pr&eacute;c&eacute;dente";
        $t['page']= "Page";

        $t['next_pages']= "Suivantes";
        $t['previous_pages']= "Pr&eacute;c&eacute;dentes";

        $t['next_2']= "2 pages suivantes";
        $t['previous_2']= "2 pages pr&eacute;c&eacute;dentes";

        $t['next_5']= "5 pages suivantes";
        $t['previous_5']= "5 pages pr&eacute;c&eacute;dentes";

        //---------Select---------------

        $t['all_categories'] = "Toutes les cat&eacute;gories";
        $t['all_subcategories'] = "Toutes les cat&eacute;gories";
        $t['selected_categories'] = "Cat&eacute;gories s&eacute;l&egrave;ctionn&eacute;es";

        $t['all_zones'] = "Tous les arrondissements";

        $t['all_rights'] = "Tous droits r&eacute;serv&eacute;s";

        $t['all_countries'] = "Tous les pays";

        $t['all_towns'] = "Toutes les villes";

        $t['all_subtowns'] = "Toutes les zones";


        //-----------------------------------------------

        $t['no_item_selected']= "Aucun &eacute;l&eacute;ment n'a &eacute;t&eacute; s&eacute;l&eacute;ctionn&eacute; dans la liste";

        $options= array();
        $options['one']= "Voulez-vous vraiment effacer cet &eacute;l&eacute;ment?";
        $options ['many']= "Voulez vous vraiment effacer ces &eacute;l&eacute;ments?";

        $key= $this->i_var['num_selected_items'];
        $t['ask_confirm_delete'] = $options[$key];
    }
}
