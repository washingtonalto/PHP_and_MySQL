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
		case 2: $sortorder = " ORDER BY numprovinces DESC";
				break;
		case 3: $sortorder = " ORDER BY numcities DESC";
				break;		
		case 4: $sortorder = " ORDER BY nummunicipalities DESC";
				break;				
	}
}

$query = "SELECT regions.regionname, regions.fullname, regions.region_id, Sum(If(InStr(municity.name,'CITY') AND NOT Instr(municity.name,'DISTRICT'),1,0)) AS numcities, Sum(If(InStr(municity.name,'CITY') AND NOT Instr(municity.name,'DISTRICT'),0,1)) AS nummunicipalities,
	COUNT(DISTINCT provinces.name) As numprovinces
	FROM regions,legdistricts,provinces,municity
	WHERE (regions.region_id = provinces.region_id) AND (provinces.province_id = legdistricts.province_id) AND ( legdistricts.legdist_id = municity.legdist_id)
	GROUP BY regions.regorder".$sortorder;
$provstat =  getqueryresults($query);

$query = "SELECT 'NCR' As regionname, 'National Capital Region' As fullname, Sum(If(InStr(nationalcapitalregion.name,'CITY'),1,0)) AS numcities, Sum(If(InStr(nationalcapitalregion.name,'CITY'),0,1)) AS nummunicipalities,
	0 As numprovinces
	FROM nationalcapitalregion";
$ncrstat =  getqueryresults($query);	

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : No. of Provinces, Cities, Municipalities per Region</TITLE>
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
<B> No. of Provinces, Cities, Municipalities per Region</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>NO. OF PROVINCES, CITIES, MUNICIPALITIES PER REGION</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by region
		</OPTION>	
		<OPTION VALUE="2">Sorted by no. of provinces</OPTION>
		<OPTION VALUE="3">Sorted by no. of cities</OPTION>
		<OPTION VALUE="4">Sorted by no. of municipalities</OPTION>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go">
</FORM>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center"><B>Region</B></TD>
		<TD ALIGN="center"><B>Region Name</B></TD>		
		<TD ALIGN="center"><B>No. of Provinces</B></TD>
		<TD ALIGN="center"><B>No. of Cities</B></TD>		
		<TD ALIGN="center"><B>No. of Municipalities</B></TD>		
	</TR>
	<?PHP $rsumprovinces = 0;
		  $rsumcities = 0;
		  $rsummunicipalities = 0; 
	?>
	<?PHP while ($provstatrow = mysql_fetch_array($provstat)) { ?>
		<TR>
			<?PHP if ($provstatrow['regionname'] == 'Region XII') {
			             $provstatrow['numcities'] = $provstatrow['numcities'] + 2;
				  }
				  if ($provstatrow['regionname'] == 'ARMM') {
			             $provstatrow['numcities'] = $provstatrow['numcities'] - 2;
				  }
			?>
			<TD><A HREF=<?PHP echo "/vote/statistics/regionalstat1det.php?regionid=".$provstatrow['region_id']; ?>><?PHP echo $provstatrow['regionname']; ?></A></TD>
			<TD><?PHP echo $provstatrow['fullname']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['numprovinces']); $rsumprovinces = $rsumprovinces + $provstatrow['numprovinces']; ?></TD>
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['numcities']); $rsumcities = $rsumcities + $provstatrow['numcities']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['nummunicipalities']); $rsummunicipalities = $rsummunicipalities + $provstatrow['nummunicipalities']; ?></TD>			
		</TR>
	<?PHP } ?>
	<?PHP while ($ncrstatrow = mysql_fetch_array($ncrstat)) { ?>
		<TR>
			<TD><?PHP echo $ncrstatrow['regionname']; ?></TD>
			<TD><?PHP echo $ncrstatrow['fullname']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($ncrstatrow['numprovinces']); ?></TD>
			<TD ALIGN="right"><?PHP echo number_format($ncrstatrow['numcities']); $rsumcities = $rsumcities + $ncrstatrow['numcities']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($ncrstatrow['nummunicipalities']); $rsummunicipalities = $rsummunicipalities + $ncrstatrow['nummunicipalities']; ?></TD>			
		</TR>
	<?PHP } ?>	
	<TR>
		<TD><B><I>TOTAL</I></B></TD>
		<TD>&nbsp;</TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsumprovinces); ?></I></B></TD>
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsumcities); ?></I></B></TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsummunicipalities); ?></I></B></TD>		
	</TR>	
</TABLE>
<BR>
<BR>
<B>Note:</B> <SPAN STYLE="color: Red;">The cities of Marawi City and Cotabato City, both of 
   which are cities under Lanao del Sur and Maguindanao respectively, are considered part of Region XII and 
   not ARMM.</SPAN>
<BR><BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
