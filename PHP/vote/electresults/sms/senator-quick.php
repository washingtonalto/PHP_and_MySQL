<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; }; ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP	
$sortorder = " ORDER BY candsenators.numvotesunof DESC, candsenators.lastname";
$query = "SELECT candsenators.lastname, candsenators.numvotesunof, candsenators.numvotesunof
          FROM candsenators ".$sortorder." LIMIT 20";
$candsenators = getqueryresults($query);
?>
<?PHP require ("$votehome/vote/admin/electresults/electresultssenatorunoff.txt"); ?>
<?PHP echo "\n\n"; ?>
<?PHP while ($candsenatorsrow = mysql_fetch_array($candsenators)) { ?>
	<?PHP echo $candsenatorsrow['lastname']."  "; ?>
	<?PHP echo number_format($candsenatorsrow['numvotesunof']).";\n"; ?>
<?PHP } ?>

