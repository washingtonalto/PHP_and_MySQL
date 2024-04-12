<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT candcouncilors.councilor_id, candcouncilors.lastname, candcouncilors.firstname, candcouncilors.middleinitial, candcouncilors.numvotes, candcouncilors.counlegdist, candcouncilors.is_proclaimed
          FROM candcouncilors
		  WHERE (candcouncilors.municity_id = ".$municityid.") AND ((candcouncilors.numvotes > 0) OR (candcouncilors.is_proclaimed = 'Y'))
		  ORDER BY candcouncilors.numvotes DESC, candcouncilors.lastname";
$candcouncilors = getqueryresults($query);
 
$query = "SELECT municity.name As municity, counresultcomment
          FROM municity
		  WHERE municity.municity_id = ".$municityid; 	 
$municity = getqueryresults($query);
$municityrow = mysql_fetch_array($municity);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Councilor Candidates of <?PHP echo $municityrow['municity']; ?></TITLE>
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
<B>Election Results on Councilor Candidates of <?PHP echo $municityrow['municity']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON COUNCILOR CANDIDATES OF <?PHP echo strtoupper($municityrow['municity']); ?></B></DIV>
<BR>
<?PHP if (!empty($municityrow['counresultcomment'])) { ?>
	<?PHP echo $municityrow['counresultcomment']; ?>
<?PHP } ?>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>District</B></TD><TD ALIGN="left" VALIGN="top"><B>Votes</B></TD><TD ALIGN="left" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candcouncilorsrow = mysql_fetch_array($candcouncilors);
		while ($candcouncilorsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorsrow['councilor_id']; ?>>
			<?PHP echo $candcouncilorsrow['lastname'].", ".$candcouncilorsrow['firstname'] ?>	
			<?PHP if(!empty($candcouncilorsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candcouncilorsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD>
		<?PHP if ($candcouncilorsrow['counlegdist'] <> 0) { ?>
	    	<?PHP echo numtoordinal($candcouncilorsrow['counlegdist']); ?>
		<?PHP } else { ?>
			&nbsp;	
		<?PHP } ?>	
	</TD>	
	<TD><?PHP echo number_format($candcouncilorsrow['numvotes']); ?></TD>
	<TD>
		<?PHP if ($candcouncilorsrow['is_proclaimed'] == "Y") {
		      	echo "<B>Proclaimed</B>";
			  } else {
			  	echo "&nbsp;";
			  }
		?>
	</TD>	
	</TR>
	<?PHP $candcouncilorsrow = mysql_fetch_array($candcouncilors); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candcouncilors); ?>
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

