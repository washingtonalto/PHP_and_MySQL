<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$sortorder = " ORDER BY candpresidents.numvotes DESC, candpresidents.lastname";
if (!empty($submit)) {
	switch($optiontype) {
		case 1: $sortorder = " ORDER BY candpresidents.numvotes DESC, candpresidents.lastname";
				break;
		case 2: $sortorder = " ORDER BY candpresidents.numvotesunof DESC, candpresidents.lastname";
				break;
		case 3: $sortorder = " ORDER BY candpresidents.lastname";
				break;		
	}
}

$query = "SELECT candpresidents.president_id, candpresidents.lastname, candpresidents.firstname, candpresidents.middleinitial, candpresidents.numvotes, candpresidents.numvotesunof, candpresidents.is_proclaimed
          FROM candpresidents ".$sortorder;
$candpresidents = getqueryresults($query);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Presidential Candidates</TITLE>
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
<B>Election Results on Presidential Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON PRESIDENTIAL CANDIDATES</B></DIV>
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
<?PHP require ("$votehome/vote/admin/electresults/electresultspresidentunoff.txt"); ?>
<BR>
<BR>
<B>Comelec Count Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultspresidentoff.txt"); ?>
<BR>
<BR>
You may also view election results by <A HREF="/vote/electresults/candpresidentlistbreakdown.php">regional breakdown</A> <B>(warning: may or may not be as updated as this page)</B><BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Comelec Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="center" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candpresidentsrow = mysql_fetch_array($candpresidents);
		while ($candpresidentsrow) {
	?>
	<?PHP if (($ctr % 2 == 0) AND ($ctr <= 1 )) { ?>
		<TR BGCOLOR="#FFD5D5">
	<?PHP } else if ($ctr % 2 == 0) { ?>	
		<TR BGCOLOR="#C5E0FE">	
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentsrow['president_id']; ?>>
			<?PHP echo $candpresidentsrow['lastname'].", ".$candpresidentsrow['firstname'] ?>	
			<?PHP if(!empty($candpresidentsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candpresidentsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD ALIGN="right"><?PHP echo number_format($candpresidentsrow['numvotes']); ?></TD>
	<TD ALIGN="right"><?PHP echo number_format($candpresidentsrow['numvotesunof']); ?></TD>	
	<TD ALIGN="right">
	    <?PHP 
			if ($candpresidentsrow['is_proclaimed'] == "Y") {
		      echo "<B>Proclaimed</B>";
			} else {
		      echo "";			
			}   
		?>
	</TD>	
	</TR>
	<?PHP $candpresidentsrow = mysql_fetch_array($candpresidents); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candpresidents); ?>
</TABLE>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

