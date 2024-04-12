<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<?PHP require ("$votehome/vote/terms.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$filter = " (LEFT(councilors.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(councilors.lastname,1) = '".$option."') ";
}	
$query = "SELECT  councilors.councilor_id As councilor_id,councilors.lastname As lastname, councilors.firstname As firstname, councilors.middleinitial As middleinitial, nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity  
  FROM councilors, nationalcapitalregion
  WHERE (councilors.ncrmunicity_id = nationalcapitalregion.municity_id) AND (YEAR(councilors.term_begin) = ".$counterm.") AND (councilors.is_deceased = 'N') AND (councilors.is_unfinishedterm = 'N') 
        AND ".$filter." ORDER BY councilors.lastname";
$ncrcouncilors =  getqueryresults($query);

$query = "SELECT  councilors.councilor_id As councilor_id,councilors.lastname As lastname, councilors.firstname As firstname, councilors.middleinitial As middleinitial, municity.municity_id As municity_id, municity.name As municity, provinces.name As province, provinces.province_id As province_id
  FROM councilors, municity, provinces, legdistricts
  WHERE (councilors.municity_id = municity.municity_id) AND (municity.legdist_id = legdistricts.legdist_id) AND (provinces.province_id = legdistricts.province_id) AND (YEAR(councilors.term_begin) = ".$counterm.")  AND (councilors.is_deceased = 'N') AND (councilors.is_unfinishedterm = 'N')
  		AND ".$filter." ORDER BY councilors.lastname";
$provcouncilors =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Incumbent Councilors </TITLE>
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
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<A HREF="/vote/byposition.php"><B>By Position</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Incumbent Councilors</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INCUMBENT COUNCILORS</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="99%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column -->

<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select first letter of last name:
	<SELECT NAME="option" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
		<?PHP for ($ctr=65; $ctr < 91; $ctr++) { ?>
			<OPTION VALUE=<?PHP echo chr($ctr); ?>><?PHP echo chr($ctr); ?></OPTION>
		<?PHP } ?>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go"><BR>
	<?PHP if(empty($option)) { $option = "A"; } ?>
	Selected letter: <B><?PHP echo $option; ?></B><BR>
</FORM>

<BR>
<H2 CLASS="HIGHLIGHTS">NCR</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($ncrcouncilorsrow = mysql_fetch_array($ncrcouncilors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$ncrcouncilorsrow['councilor_id']; ?>><?PHP echo $ncrcouncilorsrow['lastname'].", ".$ncrcouncilorsrow['firstname']; ?>	
	<?PHP if(!empty($ncrcouncilorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $ncrcouncilorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrcouncilorsrow['municity_id']; ?>><?PHP echo $ncrcouncilorsrow['municity']; ?></A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($ncrcouncilors); ?>
</TABLE>

<BR>
<H2 CLASS="HIGHLIGHTS">Provincial</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Province</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($provcouncilorsrow = mysql_fetch_array($provcouncilors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$provcouncilorsrow['councilor_id']; ?>><?PHP echo $provcouncilorsrow['lastname'].", ".$provcouncilorsrow['firstname']; ?>	
	<?PHP if(!empty($provcouncilorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $provcouncilorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provcouncilorsrow['municity_id']; ?>><?PHP echo $provcouncilorsrow['municity']; ?></A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provcouncilorsrow['province_id']; ?>>
	<?PHP echo $provcouncilorsrow['province']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($provcouncilors); ?>
</TABLE>
<!-- End of 1st Column -->
	</TD>
	<TD WIDTH="8">&nbsp;</TD>	
	<TD ALIGN="left" VALIGN="top">
<!-- Start of 3rd Column -->
<BR>
<!-- End of 3rd Column -->	
	</TD>
		</TR>
</TABLE>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
