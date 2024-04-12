<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; }; ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP	
$sortorder = " ORDER BY candsenators.numvotes DESC, candsenators.lastname";
$query = "SELECT candsenators.lastname, candsenators.numvotes, candsenators.numvotesunof
          FROM candsenators ".$sortorder." LIMIT 20";
$candsenators = getqueryresults($query);
?>
<?PHP require ("$votehome/vote/admin/electresults/electresultssenatoroff.txt"); ?>
<?PHP echo "\n\n"; ?>
<?PHP while ($candsenatorsrow = mysql_fetch_array($candsenators)) { ?>
	<?PHP echo $candsenatorsrow['lastname']."  "; ?>
	<?PHP echo number_format($candsenatorsrow['numvotes']).";\n"; ?>
<?PHP } ?>
