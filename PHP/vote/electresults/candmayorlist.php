<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT candmayors.mayor_id, candmayors.lastname, candmayors.firstname, candmayors.middleinitial, candmayors.numvotes, candmayors.is_proclaimed
          FROM candmayors
		  WHERE (candmayors.municity_id = ".$municityid.") AND ((candmayors.numvotes > 0) OR (candmayors.is_proclaimed = 'Y'))
		  ORDER BY candmayors.numvotes DESC, candmayors.lastname";
$candmayors = getqueryresults($query);
 
$query = "SELECT municity.name As municity, mayresultcomment
          FROM municity
		  WHERE municity.municity_id = ".$municityid; 	 
$municity = getqueryresults($query);
$municityrow = mysql_fetch_array($municity);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Mayoral Candidates of <?PHP echo $municityrow['municity']; ?></TITLE>
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
<B>Election Results on Mayoral Candidates of <?PHP echo $municityrow['municity']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON MAYORAL CANDIDATES OF <?PHP echo strtoupper($municityrow['municity']); ?></B></DIV>
<BR>
<?PHP if (!empty($municityrow['mayresultcomment'])) { ?>
	<?PHP echo $municityrow['mayresultcomment']; ?>
<?PHP } ?>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Votes</B></TD><TD ALIGN="left" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candmayorsrow = mysql_fetch_array($candmayors);
		while ($candmayorsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorsrow['mayor_id']; ?>>
			<?PHP echo $candmayorsrow['lastname'].", ".$candmayorsrow['firstname'] ?>	
			<?PHP if(!empty($candmayorsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candmayorsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD><?PHP echo number_format($candmayorsrow['numvotes']); ?></TD>
	<TD>
		<?PHP if ($candmayorsrow['is_proclaimed'] == "Y") {
		      	echo "<B>Proclaimed</B>";
			  } else {
			  	echo "&nbsp;";
			  }
		?>
	</TD>			
	</TR>
	<?PHP $candmayorsrow = mysql_fetch_array($candmayors); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candmayors); ?>
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
