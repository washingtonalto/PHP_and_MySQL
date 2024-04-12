<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$filter = " (LEFT(candrepresentatives.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(candrepresentatives.lastname,1) = '".$option."') ";
}	
$query = "SELECT  candrepresentatives.representative_id As representative_id,candrepresentatives.lastname As lastname, candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial, legdistricts.dist_num As districtnum, provinces.name As province, legdistricts.legdist_id As legdist_id, party.acronym As acronym, party.party_id As party_id, party.name As partyname
  FROM candrepresentatives,legdistricts,provinces,party
  WHERE (candrepresentatives.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND (candrepresentatives.party_id = party.party_id)
  AND ".$filter."
  ORDER BY candrepresentatives.lastname";
$provrep =  getqueryresults($query);

$query = "SELECT  candrepresentatives.representative_id As representative_id,candrepresentatives.lastname As lastname, candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial, legdistricts.dist_num As districtnum, nationalcapitalregion.name As municity, legdistricts.legdist_id As legdist_id, party.acronym As acronym, party.party_id As party_id, party.name As partyname
  FROM candrepresentatives,legdistricts,nationalcapitalregion,party
  WHERE (candrepresentatives.legdist_id = legdistricts.legdist_id) AND (legdistricts.ncrmunicity_id = nationalcapitalregion.municity_id) AND (candrepresentatives.party_id = party.party_id)
  AND ".$filter."
  ORDER BY candrepresentatives.lastname";
$ncrrep =  getqueryresults($query);

$query = "SELECT  candrepresentatives.representative_id,candrepresentatives.lastname As lastname, candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial, party.acronym As acronym, party.name As partyname, party.party_id As party_id
  FROM candrepresentatives,party
  WHERE (candrepresentatives.party_id = party.party_id) AND (candrepresentatives.legdist_id = '')
  AND ".$filter."
  ORDER BY candrepresentatives.lastname";
$sectrep =  getqueryresults($query);


?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : House of Representatives Candidates</TITLE>
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
<B>House of Representatives Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>HOUSE OF REPRESENTATIVES CANDIDATES</B></DIV>
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
<BR>
<H2 CLASS="HIGHLIGHTS">NCR</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Legislative District</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
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
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$ncrreprow['representative_id']; ?>><?PHP echo $ncrreprow['lastname'].", ".$ncrreprow['firstname']; ?>	
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
	<TD><SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$ncrreprow['party_id']; ?>>
		<?PHP if (!empty($ncrreprow['acronym'])) { ?>
	     	<?PHP echo $ncrreprow['acronym']; ?>
		<?PHP } else { ?>
	     	<?PHP echo $ncrreprow['partyname']; ?>		
		<?PHP } ?>	
		</A></SPAN></TD>
	</TR>
<?PHP } ?>
</TABLE>
<H2 CLASS="HIGHLIGHTS">Provincial</H2>	
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Legislative District</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
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
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$provreprow['representative_id']; ?>><?PHP echo $provreprow['lastname'].", ".$provreprow['firstname']; ?>	
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
	<TD><SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$provreprow['party_id']; ?>>
		<?PHP if (!empty($provreprow['acronym'])) { ?>
	     	<?PHP echo $provreprow['acronym']; ?>
		<?PHP } else { ?>
	     	<?PHP echo $provreprow['partyname']; ?>		
		<?PHP } ?>	
		</A></SPAN></TD>	
	</TR>
<?PHP } ?>
</TABLE>
<BR>
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
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$sectreprow['representative_id']; ?>><?PHP echo $sectreprow['lastname'].", ".$sectreprow['firstname']; ?>	
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
