<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$filter = " (LEFT(candcouncilors.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(candcouncilors.lastname,1) = '".$option."') ";
}	
$query = "SELECT  candcouncilors.councilor_id As councilor_id,candcouncilors.lastname As lastname, candcouncilors.firstname As firstname, candcouncilors.middleinitial As middleinitial, nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity, party.party_id As party_id, party.acronym As acronym, party.name As partyname  
  FROM candcouncilors, nationalcapitalregion, party
  WHERE (candcouncilors.ncrmunicity_id = nationalcapitalregion.municity_id) AND (candcouncilors.party_id = party.party_id)  
  AND ".$filter." ORDER BY candcouncilors.lastname";
$ncrcandcouncilors =  getqueryresults($query);

$query = "SELECT  candcouncilors.councilor_id As councilor_id,candcouncilors.lastname As lastname, candcouncilors.firstname As firstname, candcouncilors.middleinitial As middleinitial, municity.municity_id As municity_id, municity.name As municity, provinces.name As province, provinces.province_id As province_id, party.party_id As party_id, party.acronym As acronym, party.name As partyname
  FROM candcouncilors, municity, provinces, legdistricts, party
  WHERE (candcouncilors.municity_id = municity.municity_id) AND (municity.legdist_id = legdistricts.legdist_id) AND (provinces.province_id = legdistricts.province_id) AND (candcouncilors.party_id = party.party_id) 
  AND ".$filter." ORDER BY candcouncilors.lastname";
$provcandcouncilors =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidates for Councilor </TITLE>
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
<B>Candidates for Councilor</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>CANDIDATES FOR COUNCILOR</B></DIV>
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
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($ncrcandcouncilorsrow = mysql_fetch_array($ncrcandcouncilors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$ncrcandcouncilorsrow['councilor_id']; ?>><?PHP echo $ncrcandcouncilorsrow['lastname'].", ".$ncrcandcouncilorsrow['firstname']; ?>	
	<?PHP if(!empty($ncrcandcouncilorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $ncrcandcouncilorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrcandcouncilorsrow['municity_id']; ?>><?PHP echo $ncrcandcouncilorsrow['municity']; ?></A></SPAN>
	</TD>
	<TD><SPAN CLASS="LISTBOXFONT">
	    <A HREF=<?PHP echo "/vote/partydet.php?partyid=".$ncrcandcouncilorsrow['party_id']; ?>>
		    <?PHP 
			   if (!empty($ncrcandcouncilorsrow['acronym'])) {
			   		echo $ncrcandcouncilorsrow['acronym']; 
			   } else {
			   		echo $ncrcandcouncilorsrow['partyname']; 			   
			   }		
			?>
		</A></SPAN></TD>
	</TR>
<?PHP } ?>
</TABLE>

<BR>
<H2 CLASS="HIGHLIGHTS">Provincial</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Municipality/City</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Province</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($provcandcouncilorsrow = mysql_fetch_array($provcandcouncilors)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN></TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$provcandcouncilorsrow['councilor_id']; ?>><?PHP echo $provcandcouncilorsrow['lastname'].", ".$provcandcouncilorsrow['firstname']; ?>	
	<?PHP if(!empty($provcandcouncilorsrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $provcandcouncilorsrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provcandcouncilorsrow['municity_id']; ?>><?PHP echo $provcandcouncilorsrow['municity']; ?></A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provcandcouncilorsrow['province_id']; ?>>
	<?PHP echo $provcandcouncilorsrow['province']; ?>	
	</A></SPAN>
	</TD>
	<TD><SPAN CLASS="LISTBOXFONT">
	    <A HREF=<?PHP echo "/vote/partydet.php?partyid=".$provcandcouncilorsrow['party_id']; ?>>
		    <?PHP 
			   if (!empty($provcandcouncilorsrow['acronym'])) {
			   	 echo $provcandcouncilorsrow['acronym']; 
			   } else {
			   	 echo $provcandcouncilorsrow['partyname'];			   
			   }	 
			?>
	    </A></SPAN></TD>	
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
