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

$query = "SELECT  vicemayors.vicemayor_id As vicemayor_id,vicemayors.lastname As lastname, vicemayors.firstname As firstname, vicemayors.middleinitial As middleinitial, nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity  
  FROM vicemayors, nationalcapitalregion
  WHERE (vicemayors.ncrmunicity_id = nationalcapitalregion.municity_id)  AND (YEAR(vicemayors.term_begin) = ".$vmayterm.") AND (vicemayors.is_deceased = 'N') AND (vicemayors.is_unfinishedterm = 'N') 
  ORDER BY vicemayors.lastname";
$ncrvicemayors =  getqueryresults($query);

$filter = " (LEFT(vicemayors.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(vicemayors.lastname,1) = '".$option."') ";
}	
$query = "SELECT  vicemayors.vicemayor_id As vicemayor_id,vicemayors.lastname As lastname, vicemayors.firstname As firstname, vicemayors.middleinitial As middleinitial, municity.municity_id As municity_id, municity.name As municity, provinces.name As province, provinces.province_id As province_id
  FROM vicemayors, municity, provinces, legdistricts
  WHERE (vicemayors.municity_id = municity.municity_id) AND (municity.legdist_id = legdistricts.legdist_id) AND (provinces.province_id = legdistricts.province_id) AND (YEAR(vicemayors.term_begin) = ".$vmayterm.")  AND (vicemayors.is_deceased = 'N') AND (vicemayors.is_unfinishedterm = 'N') 
         AND ".$filter." ORDER BY vicemayors.lastname";
$provvicemayors =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Incumbent Vice Mayors </TITLE>
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
<B>Incumbent Vice Mayors</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INCUMBENT VICE MAYORS</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="99%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column -->
<H2 CLASS="HIGHLIGHTS">NCR</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($ncrvicemayorsrow = mysql_fetch_array($ncrvicemayors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$ncrvicemayorsrow['vicemayor_id']; ?>><?PHP echo $ncrvicemayorsrow['lastname'].", ".$ncrvicemayorsrow['firstname']; ?>	
	<?PHP if(!empty($ncrvicemayorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $ncrvicemayorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrvicemayorsrow['municity_id']; ?>><?PHP echo $ncrvicemayorsrow['municity']; ?></A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($ncrvicemayors); ?>
</TABLE>

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
<H2 CLASS="HIGHLIGHTS">Provincial</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Province</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($provvicemayorsrow = mysql_fetch_array($provvicemayors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$provvicemayorsrow['vicemayor_id']; ?>><?PHP echo $provvicemayorsrow['lastname'].", ".$provvicemayorsrow['firstname']; ?>	
	<?PHP if(!empty($provvicemayorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $provvicemayorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provvicemayorsrow['municity_id']; ?>><?PHP echo $provvicemayorsrow['municity']; ?></A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provvicemayorsrow['province_id']; ?>>
	<?PHP echo $provvicemayorsrow['province']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($provvicemayors); ?>
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
