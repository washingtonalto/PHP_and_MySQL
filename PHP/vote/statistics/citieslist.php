<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT municity.municity_id, municity.name As municity, provinces.province_id, provinces.name As province
	FROM municity, legdistricts , provinces
	WHERE (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND (InStr(municity.name,'CITY') And Not InStr(municity.name,'DISTRICT'))
	ORDER BY municity.name, provinces.name";
$cityprovince =  getqueryresults($query);

$query = "SELECT nationalcapitalregion.municity_id, nationalcapitalregion.name AS municity, 'NCR' As province
	FROM nationalcapitalregion
	WHERE InStr(nationalcapitalregion.name,'CITY')
	ORDER BY nationalcapitalregion.name";
$cityncr =  getqueryresults($query);	

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : List of Cities in the Philippines</TITLE>
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
<B>List of Cities in the Philippines</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>LIST OF CITIES IN THE PHILIPPINES</B></DIV>
<BR>
<?PHP $ctr = 0; ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>NO.</B></TD><TD><B>NAME OF NCR CITY</B></TD></TR>
	<?PHP while ($cityncrrow = mysql_fetch_array($cityncr)) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		   <TD><?PHP echo $ctr; ?></TD>	
		   <TD><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$cityncrrow['municity_id']; ?>><?PHP echo $cityncrrow['municity']; ?></A></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<BR>
<?PHP $ctr = 0; ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>NO.</B></TD><TD><B>NAME OF CITY</B></TD><TD><B>PROVINCE</B></TD></TR>
	<?PHP while ($cityprovincerow = mysql_fetch_array($cityprovince)) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		   <TD><?PHP echo $ctr; ?></TD>	
		   <TD><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$cityprovincerow['municity_id']; ?>><?PHP echo $cityprovincerow['municity']; ?></A></TD>
		   <TD><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$cityprovincerow['province_id']; ?>><?PHP echo $cityprovincerow['province']; ?></A></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
