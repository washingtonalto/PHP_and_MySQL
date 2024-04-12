<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT candvicemayors.vicemayor_id, candvicemayors.lastname, candvicemayors.firstname, candvicemayors.middleinitial, candvicemayors.numvotes, candvicemayors.is_proclaimed
          FROM candvicemayors
		  WHERE (candvicemayors.ncrmunicity_id = ".$municityid.") AND ((candvicemayors.numvotes > 0) OR (candvicemayors.is_proclaimed = 'Y')) 
		  ORDER BY candvicemayors.numvotes DESC, candvicemayors.lastname";
$candvicemayors = getqueryresults($query);
 
$query = "SELECT nationalcapitalregion.name As municity, vmayresultcomment
          FROM nationalcapitalregion
		  WHERE nationalcapitalregion.municity_id = ".$municityid; 	 
$ncrmunicity = getqueryresults($query);
$ncrmunicityrow = mysql_fetch_array($ncrmunicity);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Vice Mayoral Candidates of <?PHP echo $ncrmunicityrow['municity']; ?></TITLE>
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
<B>Election Results on Vice Mayoral Candidates of <?PHP echo $ncrmunicityrow['municity']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON VICE MAYORAL CANDIDATES OF <?PHP echo strtoupper($ncrmunicityrow['municity']); ?></B></DIV>
<BR>
<?PHP if (!empty($ncrmunicityrow['vmayresultcomment'])) { ?>
	<?PHP echo $ncrmunicityrow['vmayresultcomment']; ?>
<?PHP } ?>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Votes</B></TD><TD ALIGN="left" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candvicemayorsrow = mysql_fetch_array($candvicemayors);
		while ($candvicemayorsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorsrow['vicemayor_id']; ?>>
			<?PHP echo $candvicemayorsrow['lastname'].", ".$candvicemayorsrow['firstname'] ?>	
			<?PHP if(!empty($candvicemayorsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candvicemayorsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD><?PHP echo number_format($candvicemayorsrow['numvotes']); ?></TD>
	<TD>
		<?PHP if ($candvicemayorsrow['is_proclaimed'] == "Y") {
		      	echo "<B>Proclaimed</B>";
			  } else {
			  	echo "&nbsp;";
			  }
		?>
	</TD>		
	</TR>
	<?PHP $candvicemayorsrow = mysql_fetch_array($candvicemayors); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candvicemayors); ?>
</TABLE>
<BR>
Click <A HREF=<?PHP echo $HTTP_REFERER; ?>>here</A> to go back to the page you last visited.
<BR>	
<BR>						
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
