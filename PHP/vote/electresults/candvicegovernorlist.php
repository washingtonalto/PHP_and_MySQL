<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT candvicegovernors.vicegovernor_id, candvicegovernors.lastname, candvicegovernors.firstname, candvicegovernors.middleinitial, candvicegovernors.numvotes, candvicegovernors.is_proclaimed
          FROM candvicegovernors
		  WHERE (candvicegovernors.province_id = ".$provinceid.") AND ((candvicegovernors.numvotes > 0) OR (candvicegovernors.is_proclaimed = 'Y'))
		  ORDER BY candvicegovernors.numvotes DESC, candvicegovernors.lastname";
$candvicegovernors = getqueryresults($query);
 
$query = "SELECT provinces.name As provincename, vicegovresultcomment
          FROM provinces
		  WHERE provinces.province_id = ".$provinceid; 	 
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Vice Governor Candidates of <?PHP echo $provincerow['provincename']; ?></TITLE>
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
<B>Election Results on Vice Governor Candidates of <?PHP echo $provincerow['provincename']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON VICE GOVERNOR CANDIDATES OF <?PHP echo strtoupper($provincerow['provincename']); ?></B></DIV>
<BR>
<?PHP if (!empty($provincerow['vicegovresultcomment'])) { ?>
	<?PHP echo $provincerow['vicegovresultcomment']; ?>
<?PHP } ?>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Votes</B></TD><TD ALIGN="left" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candvicegovernorsrow = mysql_fetch_array($candvicegovernors);
		while ($candvicegovernorsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorsrow['vicegovernor_id']; ?>>
			<?PHP echo $candvicegovernorsrow['lastname'].", ".$candvicegovernorsrow['firstname'] ?>	
			<?PHP if(!empty($candvicegovernorsrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candvicegovernorsrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD><?PHP echo number_format($candvicegovernorsrow['numvotes']); ?></TD>
	<TD>
		<?PHP if ($candvicegovernorsrow['is_proclaimed'] == "Y") {
		      	echo "<B>Proclaimed</B>";
			  } else {
			  	echo "&nbsp;";
			  }
		?>
	</TD>	
	</TR>
	<?PHP $candvicegovernorsrow = mysql_fetch_array($candvicegovernors); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candvicegovernors); ?>
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

