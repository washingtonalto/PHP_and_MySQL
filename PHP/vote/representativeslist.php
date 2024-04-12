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
$query = "SELECT  representatives.representative_id As representative_id,representatives.lastname As lastname, representatives.firstname As firstname, representatives.middleinitial As middleinitial, legdistricts.dist_num As districtnum, provinces.name As province, legdistricts.legdist_id As legdist_id
  FROM representatives,legdistricts,provinces
  WHERE (representatives.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND (YEAR(representatives.term_begin) = ".$repterm.") AND (representatives.is_deceased = 'N') AND (representatives.is_unfinishedterm = 'N')
  ORDER BY representatives.lastname";
$provrep =  getqueryresults($query);

$query = "SELECT  representatives.representative_id As representative_id,representatives.lastname As lastname, representatives.firstname As firstname, representatives.middleinitial As middleinitial, legdistricts.dist_num As districtnum, nationalcapitalregion.name As municity, legdistricts.legdist_id As legdist_id
  FROM representatives,legdistricts,nationalcapitalregion
  WHERE (representatives.legdist_id = legdistricts.legdist_id) AND (legdistricts.ncrmunicity_id = nationalcapitalregion.municity_id) AND (YEAR(representatives.term_begin) = ".$repterm.")  AND (representatives.is_deceased = 'N') AND (representatives.is_unfinishedterm = 'N')
  ORDER BY representatives.lastname";
$ncrrep =  getqueryresults($query);

$query = "SELECT  representatives.representative_id As representative_id,representatives.lastname As lastname, representatives.firstname As firstname, representatives.middleinitial As middleinitial, party.acronym As acronym, party.name As partyname, party.party_id As party_id
  FROM representatives,party
  WHERE (representatives.party_id = party.party_id) AND (representatives.legdist_id = '') AND (YEAR(representatives.term_begin) = ".$repterm.")
  ORDER BY representatives.lastname";
$sectrep =  getqueryresults($query);


?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Incumbent House Representatives </TITLE>
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
<B>Incumbent House Representatives</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INCUMBENT HOUSE REPRESENTATIVES</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="99%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column -->
<H2 CLASS="HIGHLIGHTS">NCR</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Legislative District</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($ncrreprow = mysql_fetch_array($ncrrep)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$ncrreprow['representative_id']; ?>><?PHP echo $ncrreprow['lastname'].", ".$ncrreprow['firstname']; ?>	
	<?PHP if(!empty($ncrreprow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $ncrreprow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/ncrlegdistdet.php?legdistid=".$ncrreprow['legdist_id']; ?>>
	<?PHP if ($ncrreprow['districtnum'] == 1) { ?>
		1st/Lone
	<?PHP } else { ?>	
		<?PHP echo numtoordinal($ncrreprow['districtnum']); ?>
	<?PHP } ?>
	District of&nbsp;<?PHP echo $ncrreprow['municity']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($ncrrep); ?>
</TABLE>
<H2 CLASS="HIGHLIGHTS">Provincial</H2>	
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Legislative District</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($provreprow = mysql_fetch_array($provrep)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$provreprow['representative_id']; ?>><?PHP echo $provreprow['lastname'].", ".$provreprow['firstname']; ?>	
	<?PHP if(!empty($provreprow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $provreprow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/legdistdet.php?legdistid=".$provreprow['legdist_id']; ?>>
	<?PHP if ($provreprow['districtnum'] == 1) { ?>
		1st/Lone
	<?PHP } else { ?>	
		<?PHP echo numtoordinal($provreprow['districtnum']); ?>
	<?PHP } ?>
	District of&nbsp;<?PHP echo $provreprow['province']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($provrep); ?>
</TABLE>
<H2 CLASS="HIGHLIGHTS">PARTY LIST</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($sectreprow = mysql_fetch_array($sectrep)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$sectreprow['representative_id']; ?>><?PHP echo $sectreprow['lastname'].", ".$sectreprow['firstname']; ?>	
	<?PHP if(!empty($sectreprow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $sectreprow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$sectreprow['party_id']; ?>>
	<?PHP echo $sectreprow['acronym']; ?>	
	</A></SPAN>
	</TD>
	</TR>
<?PHP } ?>
<?PHP mysql_free_result($sectrep); ?>
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
