<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$sortorder = " ORDER BY candpartylist.numvotes DESC, party.acronym";
if (!empty($submit)) {
	switch($optiontype) {
		case 1: $sortorder = " ORDER BY candpartylist.numvotes DESC, party.acronym";
				break;
		case 2: $sortorder = " ORDER BY candpartylist.numvotesunof DESC, party.acronym";
				break;
		case 3: $sortorder = " ORDER BY party.acronym";
				break;		
	}
} 

$query = "SELECT party.party_id, party.name, party.acronym, candpartylist.numvotes, candpartylist.numvotesunof, candpartylist.is_proclaimed
          FROM candpartylist, party
		  WHERE candpartylist.party_id = party.party_id ".$sortorder;
$candpartylist = getqueryresults($query);

$query = "SELECT Sum(numvotes) AS totnumvotes, Sum(numvotesunof) AS totnumvotesunof
          FROM candpartylist";  
$totvotes = getqueryresults($query);
$totvotesrow = mysql_fetch_array($totvotes);
$totnumvotes = $totvotesrow['totnumvotes'];
$totnumvotesunof = $totvotesrow['totnumvotesunof'];
 
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Party List Candidates</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF"> <!-- BGColor defines color of Web Page -->

<!--===================== Start of Banner Table ======================-->
<?PHP require("$votehome/vote/ssi/bannertable.inc"); ?>
<!--======================== End of Banner Table =======================-->

<!--================ Start of Breadcrumb Trails =======================-->		
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4">
<TR>
<TD WIDTH="100%" HEIGHT="12" COLSPAN="2" VALIGN="middle" BGCOLOR="#8DC1FC">
<A HREF="/vote/"><B>Home</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Election Results on Party List Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON PARTY LIST CANDIDATES</B></DIV>
<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by official votes</OPTION>	
		<OPTION VALUE="2">Sorted by quick count votes</OPTION>
		<OPTION VALUE="3">Sorted by party acronym</OPTION>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go"><BR>
	<B>Option Selected:</B>&nbsp;&nbsp;
	<?PHP
		if (!empty($submit)) {
			switch($optiontype) {
				case 1: echo "Sorted by official votes";
						break;
				case 2: echo "Sorted by quick count votes";
						break;
				case 3: echo "Sorted by party acronym";
						break;		
			}
		}	
	?>
	<BR>
</FORM>
<B>Quick Count Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultspartylistunoff.txt"); ?>
<BR>
<BR>
<B>Comelec Count Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultspartylistoff.txt"); ?>
<BR>
<BR>
You may also view election results by <A HREF="/vote/electresults/candpartylistbreakdown.php">regional breakdown</A>, for top 40 party-list candidates <B><BR>(warning: may or may not be as updated as this page)</B><BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Comelec Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Percentage (%)</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Percentage (%)</B></TD><TD ALIGN="center" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$percentot1 = 0;
		$percentot2 = 0;
		$candpartylistrow = mysql_fetch_array($candpartylist);
		while ($candpartylistrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candpartylistrow['party_id']; ?>>
			<?PHP if (!empty($candpartylistrow['acronym'])) { ?>
				<?PHP echo $candpartylistrow['acronym']; ?> 
			<?PHP } else { ?>	
				<?PHP echo $candpartylistrow['name']; ?> 			
			<?PHP } ?>
		</A>
	</TD>
	<TD ALIGN="right"><?PHP echo number_format($candpartylistrow['numvotes']); ?></TD>
	<TD ALIGN="right">
		<?PHP if ($totnumvotes > 0) { ?>
			<?PHP if ($candpartylistrow['numvotes']*100/$totnumvotes > 2) { ?>
					<B>
			<?PHP } ?>		
	      	<?PHP echo number_format($candpartylistrow['numvotes']*100/$totnumvotes,2); ?>
			<?PHP if ($candpartylistrow['numvotes']*100/$totnumvotes > 2) { ?>
					</B>
			<?PHP } ?>		
		<?PHP } else { ?>
	      	<?PHP echo number_format(0); ?>		
		<?PHP } ?>	
		<?PHP $percentot1 = $percentot1 + $candpartylistrow['numvotesunof']*100/$totnumvotesunof; ?>		
	</TD>	
	<TD ALIGN="right"><?PHP echo number_format($candpartylistrow['numvotesunof']); ?></TD>	
	<TD ALIGN="right">
		<?PHP if ($totnumvotesunof > 0) { ?>
			<?PHP if ($candpartylistrow['numvotesunof']*100/$totnumvotesunof > 2) { ?>
					<B>
			<?PHP } ?>		
	      	<?PHP echo number_format($candpartylistrow['numvotesunof']*100/$totnumvotesunof,2); ?>
			<?PHP if ($candpartylistrow['numvotesunof']*100/$totnumvotesunof > 2) { ?>
					</B>
			<?PHP } ?>		
		<?PHP } else { ?>
	      	<?PHP echo number_format(0); ?>		
		<?PHP } ?>	
		<?PHP $percentot2 = $percentot2 + $candpartylistrow['numvotesunof']*100/$totnumvotesunof; ?>
	</TD>	
	<TD ALIGN="right">
		<?PHP if ($candpartylistrow['is_proclaimed'] == "Y") { 
				 echo "<B>Proclaimed</B>";
			  } else {	 
			     echo "";
			  } 
		?>	
	</TD>		
	</TR>
	<?PHP $candpartylistrow = mysql_fetch_array($candpartylist); ?>
	
	<?PHP } ?>
	<TD ALIGN="left" VALIGN="top"><B>&nbsp;</B></TD><TD ALIGN="left" VALIGN="top"><B>TOTAL</B></TD><TD ALIGN="right" VALIGN="top"><B><?PHP echo number_format($totnumvotes); ?></B></TD><TD ALIGN="right" VALIGN="top"><B><?PHP echo number_format($percentot1,2); ?></B></TD><TD ALIGN="right" VALIGN="top"><B><?PHP echo number_format($totnumvotesunof); ?></B></TD><TD ALIGN="right" VALIGN="top"><B><?PHP echo number_format($percentot2,2); ?></B></TD>
	<?PHP mysql_free_result($candpartylist); ?>
</TABLE>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
