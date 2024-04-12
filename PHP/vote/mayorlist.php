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

$query = "SELECT  mayors.mayor_id As mayor_id,mayors.lastname As lastname, mayors.firstname As firstname, mayors.middleinitial As middleinitial, nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity  
  FROM mayors, nationalcapitalregion
  WHERE (mayors.ncrmunicity_id = nationalcapitalregion.municity_id) AND (YEAR(mayors.term_begin) = ".$mayterm.") AND (mayors.is_deceased = 'N') AND (mayors.is_unfinishedterm = 'N') 
  ORDER BY mayors.lastname";
$ncrmayors =  getqueryresults($query);

$filter = " (LEFT(mayors.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(mayors.lastname,1) = '".$option."') ";
}	
$query = "SELECT  mayors.mayor_id As mayor_id,mayors.lastname As lastname, mayors.firstname As firstname, mayors.middleinitial As middleinitial, municity.municity_id As municity_id, municity.name As municity, provinces.name As province, provinces.province_id As province_id
  FROM mayors, municity, provinces, legdistricts
  WHERE (mayors.municity_id = municity.municity_id) AND (municity.legdist_id = legdistricts.legdist_id) AND (provinces.province_id = legdistricts.province_id) AND (YEAR(mayors.term_begin) = ".$mayterm.") AND (mayors.is_deceased = 'N') AND (mayors.is_unfinishedterm = 'N') 
        AND ".$filter." ORDER BY mayors.lastname";
$provmayors =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Incumbent Mayors </TITLE>
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
<B>Incumbent Mayors</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INCUMBENT MAYORS</B></DIV>
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
  while ($ncrmayorsrow = mysql_fetch_array($ncrmayors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$ncrmayorsrow['mayor_id']; ?>><?PHP echo $ncrmayorsrow['lastname'].", ".$ncrmayorsrow['firstname']; ?>	
	<?PHP if(!empty($ncrmayorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $ncrmayorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrmayorsrow['municity_id']; ?>><?PHP echo $ncrmayorsrow['municity']; ?></A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($ncrmayors); ?>
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
  while ($provmayorsrow = mysql_fetch_array($provmayors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$provmayorsrow['mayor_id']; ?>><?PHP echo $provmayorsrow['lastname'].", ".$provmayorsrow['firstname']; ?>	
	<?PHP if(!empty($provmayorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $provmayorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provmayorsrow['municity_id']; ?>><?PHP echo $provmayorsrow['municity']; ?></A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provmayorsrow['province_id']; ?>>
	<?PHP echo $provmayorsrow['province']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($provmayors); ?>
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
