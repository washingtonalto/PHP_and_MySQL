<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$sortorder = " ORDER BY candsenators.numvotes DESC, candsenators.lastname";
if (!empty($submit)) {
	switch($optiontype) {
		case 1: $sortorder = " ORDER BY candsenators.numvotes DESC, candsenators.lastname";
				break;
		case 2: $sortorder = " ORDER BY candsenators.numvotesunof DESC, candsenators.lastname";
				break;
		case 3: $sortorder = " ORDER BY candsenators.lastname";
				break;		
	}
}

$query = "SELECT candsenators.senator_id, candsenators.lastname, candsenators.firstname, candsenators.middleinitial, candsenators.numvotes, candsenators.numvotesunof, candsenators.is_proclaimed
          FROM candsenators ".$sortorder;
$candsenators = getqueryresults($query);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Senatorial Candidates</TITLE>
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
<B>Election Results on Senatorial Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON SENATORIAL CANDIDATES</B></DIV>
<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by official votes</OPTION>	
		<OPTION VALUE="2">Sorted by quick count votes</OPTION>
		<OPTION VALUE="3">Sorted by last name</OPTION>
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
				case 3: echo "Sorted by last name";
						break;		
			}
		}	
	?>
	<BR>	
</FORM>
<B>Quick Count Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultssenatorunoff.txt"); ?>
<BR>
<BR>
<B>Comelec Count Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultssenatoroff.txt"); ?>
<BR>
<BR>
You may also view election results by <A HREF="/vote/electresults/candsenatorlistbreakdown.php">regional breakdown</A> <B>(warning: may or may not be as updated as this page)</B><BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Comelec Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="center" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candsenatorsrow = mysql_fetch_array($candsenators);
		while ($candsenatorsrow) {
	?>
	<?PHP if (($ctr % 2 == 0) AND ($ctr <= 13 )) { ?>
		<TR BGCOLOR="#FFD5D5">
	<?PHP } else if ($ctr % 2 == 0) { ?>	
		<TR BGCOLOR="#C5E0FE">	
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorsrow['senator_id']; ?>>
			<?PHP echo $candsenatorsrow['lastname'].", ".$candsenatorsrow['firstname'] ?>	
			<?PHP if(!empty($candsenatorsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candsenatorsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD ALIGN="right"><?PHP echo number_format($candsenatorsrow['numvotes']); ?></TD>
	<TD ALIGN="right"><?PHP echo number_format($candsenatorsrow['numvotesunof']); ?></TD>	
	<TD ALIGN="right">
	    <?PHP 
			if ($candsenatorsrow['is_proclaimed'] == "Y") {
		      echo "<B>Proclaimed</B>";
			} else {
		      echo "";			
			}   
		?>
	</TD>	
	</TR>
	<?PHP $candsenatorsrow = mysql_fetch_array($candsenators); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candsenators); ?>
</TABLE>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
