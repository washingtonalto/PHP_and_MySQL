<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT candboardmem.provboardmember_id, candboardmem.lastname, candboardmem.firstname, candboardmem.middleinitial, candboardmem.numvotes, candboardmem.is_proclaimed
          FROM candboardmem
		  WHERE (candboardmem.legdist_id = ".$legdistid.") AND ((candboardmem.numvotes > 0) OR (candboardmem.is_proclaimed = 'Y'))
		  ORDER BY candboardmem.numvotes DESC, candboardmem.lastname";
$candboardmem = getqueryresults($query);
 
$query = "SELECT provinces.province_id, legdistricts.dist_num, provinces.name As provincename, provresultcomment
          FROM legdistricts, provinces
		  WHERE (legdistricts.province_id = provinces.province_id) 
		         AND  (legdistricts.legdist_id = ".$legdistid.")"; 	 
$legdistricts = getqueryresults($query);
$legdistrow = mysql_fetch_array($legdistricts);
  
$query = "SELECT legdistricts.dist_num As dist_num
	FROM legdistricts 
 	WHERE (legdistricts.province_id = ".$legdistrow['province_id'].") 
	ORDER BY legdistricts.dist_num";
$districtcount = getqueryresults($query);	
$numdistricts = mysql_num_rows($districtcount);
mysql_free_result($districtcount);
  
if ($numdistricts > 1) {
	$districtnum = numtoordinal($legdistrow['dist_num'])." District of ";
} else {
	$districtnum = "Lone District of ";
}	
?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Provincial Board Member Candidates of <?PHP echo $districtnum.$legdistrow['provincename']; ?></TITLE>
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
<B>Election Results on Provincial Board Member Candidates of <?PHP echo $districtnum.$legdistrow['provincename']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON PROVINCIAL BOARD MEMBER CANDIDATES OF <?PHP echo strtoupper($districtnum.$legdistrow['provincename']); ?></B></DIV>
<BR>
<?PHP if (!empty($legdistrow['provresultcomment'])) { ?>
	<?PHP echo $legdistrow['provresultcomment']; ?>
<?PHP } ?>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Votes</B></TD><TD ALIGN="left" VALIGN="top"><B>Status</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candboardmemrow = mysql_fetch_array($candboardmem);
		while ($candboardmemrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<A HREF=<?PHP echo "/vote/candboardmemdet.php?candprovboardmemid=".$candboardmemrow['provboardmember_id']; ?>>
			<?PHP echo $candboardmemrow['lastname'].", ".$candboardmemrow['firstname'] ?>	
			<?PHP if(!empty($candboardmemrow['middleinitial'])) { ?>
      			&nbsp;<?PHP echo $candboardmemrow['middleinitial']."."; ?>
			<?PHP } ?>	    
		</A>
	</TD>
	<TD><?PHP echo number_format($candboardmemrow['numvotes']); ?></TD>
	<TD>
		<?PHP if ($candboardmemrow['is_proclaimed'] == "Y") {
		      	echo "<B>Proclaimed</B>";
			  } else {
			  	echo "&nbsp;";
			  }
		?>
	</TD>	
	</TR>
	<?PHP $candboardmemrow = mysql_fetch_array($candboardmem); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candboardmem); ?>
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




