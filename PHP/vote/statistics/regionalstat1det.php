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
		case 2: $sortorder = " ORDER BY numcities DESC";
				break;		
		case 3: $sortorder = " ORDER BY nummunicipalities DESC";
				break;				
	}
}

$query = "SELECT regions.regionname, provinces.province_id, provinces.name As province, provinces.provincialcapital, Sum(If(InStr(municity.name,'CITY') AND NOT Instr(municity.name,'DISTRICT'),1,0)) AS numcities, Sum(If(InStr(municity.name,'CITY') AND NOT Instr(municity.name,'DISTRICT'),0,1)) AS nummunicipalities
	FROM regions,legdistricts,provinces,municity
	WHERE (regions.region_id = provinces.region_id) AND (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id)
	      AND (regions.region_id = ".$regionid.")
	GROUP BY provinces.name".$sortorder;
$provstat =  getqueryresults($query);
$provstatrow = mysql_fetch_array($provstat);

$regionname = $provstatrow['regionname'];
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : No. of Cities and Municipalities for <?PHP echo $provstatrow['regionname']; ?></TITLE>
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
<A HREF="/vote/statistics/regionalstat1.php"><B> No. of Provinces, Cities, Municipalities per Region</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<?PHP echo $provstatrow['regionname']; ?> Detail
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>NO. OF CITIES AND MUNICIPALITIES FOR <?PHP echo strtoupper($provstatrow['regionname']); ?></B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by province name</OPTION>	
		<OPTION VALUE="2">Sorted by no. of cities</OPTION>
		<OPTION VALUE="3">Sorted by no. of municipalities</OPTION>
	</SELECT>
	<INPUT TYPE="hidden" NAME="regionid" VALUE=<?PHP echo $regionid; ?>>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go">
</FORM>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center"><B>Provinces</B></TD>
		<TD ALIGN="center"><B>Capital</B></TD>		
		<TD ALIGN="center"><B>No. of Cities</B></TD>		
		<TD ALIGN="center"><B>No. of Municipalities</B></TD>		
	</TR>
	<?PHP $rsumcities = 0;
		  $rsummunicipalities = 0; 
	?>
	<?PHP while ($provstatrow) { ?>
		<TR>
			<?PHP if ($provstatrow['province'] == 'Maguindanao' OR $provstatrow['province'] == 'Lanao del Sur') {
						$provstatrow['numcities'] = $provstatrow['numcities'] - 1;
				  }	
			?>
			<TD><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provstatrow['province_id']; ?>><?PHP echo $provstatrow['province']; ?></A></TD>
			<TD><?PHP if (!empty($provstatrow['provincialcapital'])) { 
			       		echo $provstatrow['provincialcapital']; 
				      } else { 
					     echo "&nbsp;";
					  }
			    ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['numcities']); $rsumcities = $rsumcities + $provstatrow['numcities']; ?></TD>			
			<TD ALIGN="right"><?PHP echo number_format($provstatrow['nummunicipalities']); $rsummunicipalities = $rsummunicipalities + $provstatrow['nummunicipalities']; ?></TD>			
		</TR>
		<?PHP $provstatrow = mysql_fetch_array($provstat) ?>
	<?PHP } ?>
	<?PHP if ($regionname == 'Region XII') { ?>
		<TR>
			<TD><SPAN STYLE="color: Red;">MARAWI CITY</SPAN></TD>
			<TD>&nbsp;</TD>		
			<TD ALIGN="right">1</TD>		
			<TD ALIGN="right">0</TD>		
		</TR>	
		<TR>
			<TD><SPAN STYLE="color: Red;">COTABATO CITY</SPAN></TD>
			<TD>&nbsp;</TD>		
			<TD ALIGN="right">1</TD>		
			<TD ALIGN="right">0</TD>		
		</TR>	
	<?PHP  $rsumcities = $rsumcities + 2;
	       } ?>
	<TR>
		<TD><B><I>TOTAL</I></B></TD>
		<TD>&nbsp;</TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsumcities); ?></I></B></TD>		
		<TD ALIGN="right"><B><I><?PHP echo number_format($rsummunicipalities); ?></I></B></TD>		
	</TR>	
</TABLE>	
<?PHP if ($regionname == 'ARMM' OR $regionname == 'Region XII') { ?>
   <BR><BR>	
   <B>Note:</B> <SPAN STYLE="color: Red;">The cities of Marawi City and Cotabato City, both of 
   which are cities under Lanao del Sur and Maguindanao respectively, are considered part of Region XII and 
   not ARMM.</SPAN>
<BR><BR>	
<?PHP } ?>
<BR><BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
