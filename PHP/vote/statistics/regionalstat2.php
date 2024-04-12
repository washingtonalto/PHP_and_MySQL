<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$sortorder = "";
if (!empty($submit)) {
	switch($optiontype) {
		case 1: $sortorder = "";
				break;
		case 2: $sortorder = " ORDER BY numprecincts DESC";
				break;
		case 3: $sortorder = " ORDER BY numregvoters DESC";
				break;		
	}
}

$query = "SELECT regions.regionname, regions.fullname, regions.region_id, Sum(provinces.numprecincts) AS numprecincts, Sum(provinces.numregvoters) AS numregvoters
	FROM regions,provinces
	WHERE regions.region_id = provinces.region_id 
	GROUP BY regions.regorder".$sortorder;
$provstat =  getqueryresults($query);

$query = "SELECT 'NCR' As regionname, 'National Capital Region' As fullname,Sum(nationalcapitalregion.numprecincts) AS numprecincts, Sum(nationalcapitalregion.numregvoters) AS numregvoters
	FROM nationalcapitalregion";
$ncrstat =  getqueryresults($query);	
$ncrstatrow = mysql_fetch_array($ncrstat); 

$query = "SELECT municity.municity_id, municity.name As municity, municity.numregvoters, municity.numprecincts
          FROM municity
		  WHERE municity.name = 'MARAWI CITY'";
$marawidet = getqueryresults($query);
$marawidetrow = mysql_fetch_array($marawidet); 		 

$query = "SELECT municity.municity_id, municity.name As municity, municity.numregvoters, municity.numprecincts
          FROM municity
		  WHERE municity.name = 'COTABATO CITY'";
$cotabatodet = getqueryresults($query);
$cotabatodetrow = mysql_fetch_array($cotabatodet); 		  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : No. of Precincts and Registered Voters per Region</TITLE>
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
<A HREF="/vote/statistics"><B>Statistics</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B> No. of Precincts and Registered Voters per Region</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>NO. OF PRECINCTS AND REGISTERED VOTERS PER REGION</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by region</OPTION>	
		<OPTION VALUE="2">Sorted by no. of precincts</OPTION>
		<OPTION VALUE="3">Sorted by no. of registered voters</OPTION>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go">
</FORM>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center"><B>Region</B></TD>
		<TD ALIGN="center"><B>Region Name</B></TD>		
		<TD ALIGN="center"><B>No. of Precincts</B></TD>		
		<TD ALIGN="center"><B>No. of Registered Voters</B></TD>		
	</TR>
	<?PHP $rsumprecincts = 0;
		  $rsumregvoters = 0;
	?>
	<?PHP while ($provstatrow = mysql_fetch_array($provstat)) { ?>
		<TR>
			<?PHP if ($provstatrow['regionname'] == 'Region XII') { 
					  $region12numprecincts = $provstatrow['numprecincts'];
					  $region12numregvoters = $provstatrow['numregvoters']; 	
				      $provstatrow['numprecincts'] = $provstatrow['numprecincts'] + $marawidetrow['numprecincts'] + $cotabatodetrow['numprecincts'];
				      $provstatrow['numregvoters'] = $provstatrow['numregvoters'] + $marawidetrow['numregvoters'] + $cotabatodetrow['numregvoters'];					  
			       } 
			?> 
			<TD><A HREF=<?PHP echo "/vote/statistics/regionalstat2det.php?regionid=".$provstatrow['region_id']; ?>><?PHP echo $provstatrow['regionname']; ?></A></TD>
			<TD><?PHP echo $provstatrow['fullname']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['numprecincts']); $rsumprecincts = $rsumprecincts + $provstatrow['numprecincts']; ?></TD>
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['numregvoters']); $rsumregvoters = $rsumregvoters + $provstatrow['numregvoters']; ?></TD>			
		</TR>
	<?PHP } ?>
		<TR>
			<TD><?PHP echo $ncrstatrow['regionname']; ?></TD>
			<TD><?PHP echo $ncrstatrow['fullname']; ?></TD>
			<TD ALIGN="right"><?PHP echo number_format($ncrstatrow['numprecincts']); $rsumprecincts = $rsumprecincts + $ncrstatrow['numprecincts']; ?></TD>
			<TD ALIGN="right"><?PHP echo number_format($ncrstatrow['numregvoters']); $rsumregvoters = $rsumregvoters + $ncrstatrow['numregvoters']; ?></TD>			
		</TR>
	<TR>
		<TD><B><I>TOTAL</I></B></TD>
		<TD>&nbsp;</TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsumprecincts); ?></I></B></TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsumregvoters); ?></I></B></TD>		
	</TR>	
</TABLE>	
<BR>
<BR>
<B>Note:</B> <SPAN STYLE="color: Red;">For Region XII, the statistics of Marawi City (<?PHP echo "no. of precincts:&nbsp;".number_format($marawidetrow['numprecincts'])."&nbsp;no. of registered voters:&nbsp;".number_format($marawidetrow['numregvoters']); ?>) and
 the statistics of Cotabato City (<?PHP echo "no. of precincts:&nbsp;".number_format($cotabatodetrow['numprecincts'])."&nbsp;no. of registered voters:&nbsp;".number_format($cotabatodetrow['numregvoters']); ?>) is included in the 
 statistics for that region. Though these two cities belong to Lanao del Sur and Maguindanao respectively, both of which are ARMM provinces, these two cities remain in Region XII.</SPAN>


<BR><BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
