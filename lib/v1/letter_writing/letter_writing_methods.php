<?php

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class letter_writing_methods extends website_object
{
    public function table_services(&$letter, &$project, &$clients)
    {
        $text= <<<HTML

<table class="table_serv" cellspacing="0" cellpadding="0" >

<tr>
<th class="col1">SERVICES DESTINATAIRES</th>		<th class="col2">DATES D'ARRIVEE</th>	<th class="col2">DATES DE RETOUR</th>
<th class="col3">OBSERVATIONS</th>
</tr>

<tr>
<td class="col1"><strong>DGB</strong></td>		<td class="col2">&nbsp;</td>		<td class="col3">&nbsp;</td>
<td class="col4">&nbsp;</td>
</tr>

<tr>
<td class="col1"><strong>DGCB</strong></td>		<td class="col2">&nbsp;</td>		<td class="col3">&nbsp;</td>
<td class="col4">&nbsp;</td>
</tr>

</table>

HTML;

        //---------------------------

        return $text;
    }
    
    
    
    
    
    public function table_clients1(&$letter, &$project, &$clients)
    {
        $counter= 1;

        $text= <<<HTML

<table class="table_clients1" cellspacing="0" cellpadding="0" >

<tr>
<th class="col0">N&deg;</th>

<th class="col1">Noms et pr&eacute;noms</th>		<th class="col2">Dates et lieux de naissance</th>	<th class="col3">Dipl&ocirc;mes et options</th>		<th class="col4">Lieux d'obtention</th>
</tr>	

HTML;

        for ($i=0; $i < (count($clients)-1); $i++) { // last member is clients_class array
        
            $client= &$clients[$i];
            $client['surname']= strtoupper($client['surname']);
            $client['origin_qual']= empty($client['origin_qual']) ? "---" : $client['origin_qual'];

            $name_qual= $client['name_qual'];

            if ($client['option_qual']) {
                $name_qual .= ": {$client['option_qual']}";
            }
        

            $text .= <<<HTML

<tr>

<td class="col0">{$counter}</td>
<td class="col1">{$client['surname']} {$client['firstname']}</td>
<td class="col2">{$client['date_birth']} &agrave; {$client['town_birth']}</td>
<td class="col3">{$name_qual}</td>
<td class="col4">{$client['origin_qual']}</td>

</tr>

HTML;

            $counter++;
        }
        
        $text .= "</table>";

        //-------------------

        return $text;
    }
    
    
    
    
    
    
    public function table_clients2(&$letter, &$project, &$clients)
    {
        $counter= 1;

        $text= <<<HTML

<table class="table_clients2" cellspacing="0" cellpadding="0" >

<tr>
<th class="col0">N&deg;</th>

<th class="col1">Noms et pr&eacute;noms</th>		<th class="col2">Dates et lieux de naissance</th>	<th class="col3">Dipl&ocirc;mes et options</th>		<th class="col4">Lieux d'obtention</th> 
<th class="col5">Date de prise de service</th>
</tr>	

HTML;

        for ($i=0; $i < (count($clients)-1); $i++) { // last member is clients_class array
        
            $client= &$clients[$i];
            $client['surname']= strtoupper($client['surname']);
            $client['origin_qual']= empty($client['origin_qual']) ? "---" : $client['origin_qual'];
            $client['start_work']= f1::custom_long_date($client['start_work']);

            $name_qual= $client['name_qual'];

            if ($client['option_qual']) {
                $name_qual .= ": {$client['option_qual']}";
            }
        

            $text .= <<<HTML

<tr>

<td class="col0">{$counter}</td>
<td class="col1">{$client['surname']} {$client['firstname']}</td>
<td class="col2">{$client['date_birth']} &agrave; {$client['town_birth']}</td>
<td class="col3">{$name_qual}</td>
<td class="col4">{$client['origin_qual']}</td>
<td class="col5">{$client['start_work']}</td>
</tr>

HTML;

            $counter++;
        }
        
        $text .= "</table>";

        //-------------------

        return $text;
    }
    
    
    
    
    
    public function table_clients3(&$letter, &$project, &$clients)
    {
        $counter= 1;

        $text= <<<HTML

<table class="table_clients3" cellspacing="0" cellpadding="0" >

<tr>
<th class="col0">N&deg;</th>

<th class="col1">Noms et pr&eacute;noms</th>		<th class="col2">Dates et lieux de naissance</th>
</tr>	

HTML;

        for ($i=0; $i < (count($clients)-1); $i++) { // last member is clients_class array
        
            $client= &$clients[$i];
            $client['surname']= strtoupper($client['surname']);
            $client['origin_qual']= empty($client['origin_qual']) ? "---" : $client['origin_qual'];
            $client['start_work']= f1::custom_long_date($client['start_work']);

            $text .= <<<HTML

<tr>

<td class="col0">{$counter}</td>
<td class="col1">{$client['surname']} {$client['firstname']}</td>
<td class="col2">{$client['date_birth']} &agrave; {$client['town_birth']}</td>

</tr>

HTML;

            $counter++;
        }
        
        $text .= "</table>";

        //-------------------

        return $text;
    }
    
    
    
    
    
    
    public function table_clients4(&$letter, &$project, &$clients)
    {
        $counter= 1;

        $text= <<<HTML

<table class="table_clients2" cellspacing="0" cellpadding="0" >

<tr>
<th class="col0">N&deg;</th>

<th class="col1">Noms et pr&eacute;noms</th>  <th class="col2">Grade</th> 	<th class="col3">Date de naissance</th>
	<th class="col4">matricule solde</th>		<th class="col5">Service</th> 
</tr>	

HTML;

        for ($i=0; $i < (count($clients)-1); $i++) { // last member is clients_class array
        
            $client= &$clients[$i];
            $client['surname']= strtoupper($client['surname']);

            $text .= <<<HTML

<tr>

<td class="col0">{$counter}</td>
<td class="col1">{$client['surname']} {$client['firstname']}</td>
<td class="col2">{$client['name_rank']}</td>
<td class="col3">{$client['date_birth']} &agrave; {$client['town_birth']}</td>
<td class="col4">{$client['id_agent']}</td>
<td class="col5">{$client['name_serv']}</td>

</tr>

HTML;

            $counter++;
        }
        
        $text .= "</table>";

        //-------------------

        return $text;
    }
}
