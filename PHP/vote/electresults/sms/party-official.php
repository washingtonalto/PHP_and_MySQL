<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; }; ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP	
$sortorder = " ORDER BY candpartylist.numvotes DESC, party.acronym";
$query = "SELECT party.party_id, party.name, party.acronym, candpartylist.numvotes, candpartylist.numvotesunof
          FROM candpartylist, party
		  WHERE candpartylist.party_id = party.party_id ".$sortorder." LIMIT 20";
$candsenators = getqueryresults($query);
?>
<?PHP require ("$votehome/vote/admin/electresults/electresultspartylistoff.txt"); ?>
<?PHP echo "\n\n"; ?>
<?PHP while ($candsenatorsrow = mysql_fetch_array($candsenators)) { ?>
	<?PHP echo trim($candsenatorsrow['acronym'])."  "; ?>
	<?PHP echo number_format($candsenatorsrow['numvotes']).";\n"; ?>
<?PHP } ?>
