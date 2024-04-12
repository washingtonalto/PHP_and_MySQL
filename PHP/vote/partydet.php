<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/terms.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  party.party_id As party_id, party.acronym As acronym, party.name As partyname,party.yearfounded As yearfounded,
   party.mission As mission, party.vision As vision, party.platform As platform, party.party_history As partyhistory, party.partyorganization As partyorganization,
   party.address As address,party.telnumbers As telnumbers, party.email As email,party.faxnumbers As faxnumbers, party.programofgovt As programofgovt,
   party.standonissues As standonissues  
  FROM party
  WHERE (party.party_id = ".$partyid.")   
  ORDER BY party.acronym,party.partyname";
$parties = getqueryresults($query);
$partiesrow = mysql_fetch_array($parties);
$partiesrow = slashstripper($partiesrow);

$query = "SELECT presidents.president_id As president_id, presidents.lastname As lastname,presidents.firstname As firstname, presidents.middleinitial As middleinitial 
  FROM party, presidents
  WHERE (presidents.party_id = party.party_id) AND (party.party_id = ".$partyid.") AND (YEAR(presidents.term_begin) = ".$pterm.")   
  ORDER BY presidents.lastname,presidents.term_begin";
$presidentmem = getqueryresults($query);
$numpresidentmem = mysql_num_rows($presidentmem);

$query = "SELECT vicepresidents.vicepresident_id As vicepresident_id, vicepresidents.lastname As lastname,vicepresidents.firstname As firstname, vicepresidents.middleinitial As middleinitial 
  FROM party, vicepresidents
  WHERE (vicepresidents.party_id = party.party_id) AND (party.party_id = ".$partyid.") AND (YEAR(vicepresidents.term_begin) = ".$vpterm.")   
  ORDER BY vicepresidents.lastname,vicepresidents.term_begin";
$vicepresidentmem = getqueryresults($query);
$numvicepresidentmem = mysql_num_rows($vicepresidentmem);

$query = "SELECT senators.senator_id As senator_id, senators.lastname As lastname,senators.firstname As firstname, senators.middleinitial As middleinitial 
  FROM party, senators
  WHERE (senators.is_unfinishedterm = 'N') AND (senators.is_deceased = 'N') AND (senators.party_id = party.party_id) AND (party.party_id = ".$partyid.") AND ((YEAR(senators.term_begin) = ".$term1st.") OR (YEAR(senators.term_begin) = ".$term2nd."))  
  ORDER BY senators.lastname,senators.term_begin";
$senatormem = getqueryresults($query);
$numsenatormem = mysql_num_rows($senatormem);

$query = "SELECT representatives.representative_id As representative_id, representatives.lastname As lastname,representatives.firstname As firstname, representatives.middleinitial As middleinitial
  FROM party, representatives
  WHERE (representatives.party_id = party.party_id) AND (party.party_id = ".$partyid.") AND (YEAR(representatives.term_begin) = ".$repterm.")   
  ORDER BY representatives.lastname,representatives.term_begin";
$representativemem = getqueryresults($query);
$numrepresentativemem = mysql_num_rows($representativemem);

$query = "SELECT governors.governor_id As governor_id, governors.lastname As lastname,governors.firstname As firstname, governors.middleinitial As middleinitial 
  FROM party, governors
  WHERE (governors.party_id = party.party_id) AND (party.party_id = ".$partyid.") AND (YEAR(governors.term_begin) = ".$govterm.")   
  ORDER BY governors.lastname,governors.term_begin";
$governormem = getqueryresults($query);
$numgovernormem = mysql_num_rows($governormem);

$query = "SELECT vicegovernors.vicegovernor_id As vicegovernor_id, vicegovernors.lastname As lastname,vicegovernors.firstname As firstname, vicegovernors.middleinitial As middleinitial 
  FROM party, vicegovernors
  WHERE (vicegovernors.party_id = party.party_id) AND (party.party_id = ".$partyid.")AND (YEAR(vicegovernors.term_begin) = ".$vicegovterm.")   
  ORDER BY vicegovernors.lastname,vicegovernors.term_begin";
$vicegovernormem = getqueryresults($query);
$numvicegovernormem = mysql_num_rows($vicegovernormem);

$query = "SELECT provboardmembers.provboardmember_id As provboardmember_id, provboardmembers.lastname As lastname,provboardmembers.firstname As firstname, provboardmembers.middleinitial As middleinitial 
  FROM party, provboardmembers
  WHERE (provboardmembers.party_id = party.party_id) AND (party.party_id = ".$partyid.")AND (YEAR(provboardmembers.term_begin) = ".$provterm.")   
  ORDER BY provboardmembers.lastname,provboardmembers.term_begin";
$provboardmembermem = getqueryresults($query);
$numprovboardmembermem = mysql_num_rows($provboardmembermem);

$query = "SELECT mayors.mayor_id As mayor_id, mayors.lastname As lastname,mayors.firstname As firstname, mayors.middleinitial As middleinitial 
  FROM party, mayors
  WHERE (mayors.party_id = party.party_id) AND (party.party_id = ".$partyid.")AND (YEAR(mayors.term_begin) = ".$mayterm.")   
  ORDER BY mayors.lastname,mayors.term_begin";
$mayormem = getqueryresults($query);
$nummayormem = mysql_num_rows($mayormem);

$query = "SELECT vicemayors.vicemayor_id As vicemayor_id, vicemayors.lastname As lastname,vicemayors.firstname As firstname, vicemayors.middleinitial As middleinitial 
  FROM party, vicemayors
  WHERE (vicemayors.party_id = party.party_id) AND (party.party_id = ".$partyid.")AND (YEAR(vicemayors.term_begin) = ".$vmayterm.")   
  ORDER BY vicemayors.lastname,vicemayors.term_begin";
$vicemayormem = getqueryresults($query);
$numvicemayormem = mysql_num_rows($vicemayormem);

$query = "SELECT councilors.councilor_id As councilor_id, councilors.lastname As lastname,councilors.firstname As firstname, councilors.middleinitial As middleinitial 
  FROM party, councilors
  WHERE (councilors.party_id = party.party_id) AND (party.party_id = ".$partyid.")AND (YEAR(councilors.term_begin) = ".$counterm.")   
  ORDER BY councilors.lastname,councilors.term_begin";
$councilormem = getqueryresults($query);
$numcouncilormem = mysql_num_rows($councilormem);

$query = "SELECT candpresidents.president_id As president_id, candpresidents.lastname As lastname,candpresidents.firstname As firstname, candpresidents.middleinitial As middleinitial 
  FROM party, candpresidents
  WHERE (candpresidents.party_id = party.party_id) AND (party.party_id = ".$partyid.")    
  ORDER BY candpresidents.lastname";
$candpresidentmem = getqueryresults($query);
$numcandpresidentmem = mysql_num_rows($candpresidentmem);

$query = "SELECT candvicepresidents.vicepresident_id As vicepresident_id, candvicepresidents.lastname As lastname,candvicepresidents.firstname As firstname, candvicepresidents.middleinitial As middleinitial 
  FROM party, candvicepresidents
  WHERE (candvicepresidents.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candvicepresidents.lastname";
$candvicepresidentmem = getqueryresults($query);
$numcandvicepresidentmem = mysql_num_rows($candvicepresidentmem);

$query = "SELECT candsenators.senator_id As senator_id, candsenators.lastname As lastname,candsenators.firstname As firstname, candsenators.middleinitial As middleinitial 
  FROM party, candsenators
  WHERE (candsenators.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candsenators.lastname";
$candsenatormem = getqueryresults($query);
$numcandsenatormem = mysql_num_rows($candsenatormem);

$query = "SELECT candrepresentatives.representative_id As representative_id, candrepresentatives.lastname As lastname,candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial
  FROM party, candrepresentatives
  WHERE (candrepresentatives.party_id = party.party_id) AND (party.party_id = ".$partyid.")    
  ORDER BY candrepresentatives.lastname";
$candrepresentativemem = getqueryresults($query);
$numcandrepresentativemem = mysql_num_rows($candrepresentativemem);

$query = "SELECT candgovernors.governor_id As governor_id, candgovernors.lastname As lastname,candgovernors.firstname As firstname, candgovernors.middleinitial As middleinitial 
  FROM party, candgovernors
  WHERE (candgovernors.party_id = party.party_id) AND (party.party_id = ".$partyid.")    
  ORDER BY candgovernors.lastname";
$candgovernormem = getqueryresults($query);
$numcandgovernormem = mysql_num_rows($candgovernormem);

$query = "SELECT candvicegovernors.vicegovernor_id As vicegovernor_id, candvicegovernors.lastname As lastname,candvicegovernors.firstname As firstname, candvicegovernors.middleinitial As middleinitial 
  FROM party, candvicegovernors
  WHERE (candvicegovernors.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candvicegovernors.lastname";
$candvicegovernormem = getqueryresults($query);
$numcandvicegovernormem = mysql_num_rows($candvicegovernormem);

$query = "SELECT candboardmem.provboardmember_id As provboardmember_id, candboardmem.lastname As lastname,candboardmem.firstname As firstname, candboardmem.middleinitial As middleinitial 
  FROM party, candboardmem
  WHERE (candboardmem.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candboardmem.lastname";
$candboardmemmem = getqueryresults($query);
$numcandboardmemmem = mysql_num_rows($candboardmemmem);

$query = "SELECT candmayors.mayor_id As mayor_id, candmayors.lastname As lastname,candmayors.firstname As firstname, candmayors.middleinitial As middleinitial 
  FROM party, candmayors
  WHERE (candmayors.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candmayors.lastname";
$candmayormem = getqueryresults($query);
$numcandmayormem = mysql_num_rows($candmayormem);

$query = "SELECT candvicemayors.vicemayor_id As vicemayor_id, candvicemayors.lastname As lastname,candvicemayors.firstname As firstname, candvicemayors.middleinitial As middleinitial 
  FROM party, candvicemayors
  WHERE (candvicemayors.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candvicemayors.lastname";
$candvicemayormem = getqueryresults($query);
$numcandvicemayormem = mysql_num_rows($candvicemayormem);

$query = "SELECT candcouncilors.councilor_id As councilor_id, candcouncilors.lastname As lastname,candcouncilors.firstname As firstname, candcouncilors.middleinitial As middleinitial 
  FROM party, candcouncilors
  WHERE (candcouncilors.party_id = party.party_id) AND (party.party_id = ".$partyid.")   
  ORDER BY candcouncilors.lastname";
$candcouncilormem = getqueryresults($query);
$numcandcouncilormem = mysql_num_rows($candcouncilormem);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%Y') As date, activities.title As title
FROM activities, party
WHERE (activities.is_national='Y') AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (party.party_id = ".$partyid.")
ORDER BY activities.date";
$natactivities = getqueryresults($query);
$numnatactivities = mysql_num_rows($natactivities);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%Y') As date, provinces.province_id As province_id, provinces.name As province, activities.title As title
FROM activities, party, provinces
WHERE (activities.province_id = provinces.province_id) AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (party.party_id = ".$partyid.")
ORDER BY activities.date, provinces.name";
$provactivities = getqueryresults($query);
$numprovactivities = mysql_num_rows($provactivities);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%Y') As date, municity.municity_id As municity_id, municity.name As municity, activities.title As title
FROM activities, party, municity
WHERE (activities.municity_id = municity.municity_id) AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (party.party_id = ".$partyid.")
ORDER BY activities.date, municity.name";
$municityactivities = getqueryresults($query);
$nummunicityactivities = mysql_num_rows($municityactivities);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%Y') As date, nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity, activities.title As title
FROM activities, party, nationalcapitalregion
WHERE (activities.ncrmunicity_id = nationalcapitalregion.municity_id) AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (party.party_id = ".$partyid.")
ORDER BY activities.date, nationalcapitalregion.name";
$ncractivities = getqueryresults($query);
$numncractivities = mysql_num_rows($ncractivities);

$query = "SELECT links.url As url, links.title As title
  FROM party, links
  WHERE (party.party_id = links.party_id) AND (party.party_id = ".$partyid.")";
$partylink = getqueryresults($query);
$numpartylink = mysql_num_rows($partylink);
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Party - <?PHP echo $partiesrow['partyname']; ?>&nbsp;
<?PHP if(!empty($partiesrow['acronym'])) { ?>
    (<?PHP echo $partiesrow['acronym']; ?>)
<?PHP } ?>	
</TITLE>
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
<A HREF="/vote/byparty.php"><B>By Party</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $partiesrow['partyname']; ?>&nbsp;
<?PHP if(!empty($partiesrow['acronym'])) { ?>
    (<?PHP echo $partiesrow['acronym']; ?>)
<?PHP } ?></B>	
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="15%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column --->
<?PHP if ($numnatactivities > 0 OR $numprovactivities > 0 OR $nummunicityactivities > 0 OR	$numncractivities > 0) { ?>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
<TR>
	<TD ALIGN="center" VALIGN="top" BGCOLOR="RED">
	  <DIV ALIGN="center" STYLE="color: White;"><B>ACTIVITIES</B></DIV></TD>
</TR>
<TR>
	<TD ALIGN="left" VALIGN="top">
	<SPAN STYLE="color: Maroon; text-align: center;"><B>National</B></SPAN><BR>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="0" ALIGN="center">
		<?PHP while ($natactivitiesrow = mysql_fetch_array($natactivities)) { ?>
		<TR>
			<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $natactivitiesrow['date']; ?></SPAN></TD>
			<TD ALIGN="left" VALIGN="top"><SPAN CLASS="BROWSEBOXFONT">
			  <A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$natactivitiesrow['activity_id']; ?>><?PHP echo $natactivitiesrow['title']; ?></A>
			</SPAN></TD>			
		</TR>
		<?PHP } ?>
	</TABLE>
	<SPAN STYLE="color: Maroon; text-align: center;"><B>Provincial</B></SPAN><BR>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="3" ALIGN="center">
		<?PHP while ($provactivitiesrow = mysql_fetch_array($provactivities)) { ?>
		<TR>
			<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $provactivitiesrow['date']; ?></SPAN></TD>
			<TD ALIGN="left" VALIGN="top"><SPAN CLASS="BROWSEBOXFONT" STYLE="color: Navy; font-weight: bold;"><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provactivitiesrow['province_id']; ?>><?PHP echo $provactivitiesrow['province']; ?></A></SPAN><BR>
			<SPAN CLASS="BROWSEBOXFONT"> 
			  <A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$provactivitiesrow['activity_id']; ?>><?PHP echo $provactivitiesrow['title']; ?></A>
			</SPAN></TD>			
		</TR>
		<?PHP } ?>
	</TABLE>	
	<SPAN STYLE="color: Maroon; text-align: center;"><B>NCR</B></SPAN><BR>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="3" ALIGN="center">
		<?PHP while ($ncractivitiesrow = mysql_fetch_array($ncractivities)) { ?>
		<TR>
			<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $ncractivitiesrow['date']; ?></SPAN></TD>
			<TD ALIGN="left" VALIGN="top"><SPAN CLASS="BROWSEBOXFONT" STYLE="color: Navy; font-weight: bold;"><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncractivitiesrow['municity_id']; ?>><?PHP echo $ncractivitiesrow['municity']; ?></A></SPAN><BR>
			<SPAN CLASS="BROWSEBOXFONT">
			  <A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$ncractivitiesrow['activity_id']; ?>><?PHP echo $ncractivitiesrow['title']; ?></A>
			</SPAN></TD>			
		</TR>
		<?PHP } ?>
	</TABLE>		
	<SPAN STYLE="color: Maroon; text-align: center;"><B>Provincial Municpality/City</B></SPAN><BR>			
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="3" ALIGN="center">
		<?PHP while ($municityactivitiesrow = mysql_fetch_array($municityactivities)) { ?>
		<TR>
			<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $municityactivitiesrow['date']; ?></SPAN></TD>
			<TD ALIGN="left" VALIGN="top"><SPAN CLASS="BROWSEBOXFONT" STYLE="color: Navy; font-weight: bold;"><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$municityactivitiesrow['municity_id']; ?>><?PHP echo $municityactivitiesrow['municity']; ?></A></SPAN><BR>
			<SPAN CLASS="BROWSEBOXFONT">
			  <A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$municityactivitiesrow['activity_id']; ?>><?PHP echo $municityactivitiesrow['title']; ?></A>
			</SPAN></TD>			
		</TR>
		<?PHP } ?>
	</TABLE>	
	</TD>
</TR>
</TABLE>
	<?PHP 
		mysql_free_result($natactivities); 
		mysql_free_result($provactivities); 		
		mysql_free_result($ncractivities); 		
		mysql_free_result($municityactivities); 						
	?>
<?PHP } ?>


<?PHP if (!empty($partiesrow['address']) OR !empty($partiesrow['telnumbers']) OR !empty($partiesrow['faxnumbers']) OR !empty($partiesrow['email']) OR !empty($partiesrow['yearfounded'])) { ?>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD ALIGN="center" VALIGN="top" BGCOLOR="#7EBEBE"><DIV ALIGN="center"><B>Contact Information</B></DIV></TD>
</TR>
<TR>
	<TD ALIGN="left" VALIGN="top">
	<SPAN CLASS="BROWSEBOXFONT">
	<?PHP if (!empty($partiesrow['address'])) { ?>
		<B>Address:</B>&nbsp; <?PHP echo $partiesrow['address'] ?> <BR>
	<?PHP } ?>	
	<?PHP if (!empty($partiesrow['telnumbers'])) { ?>	
	<B>Tel. Nos.:</B>&nbsp; <?PHP echo $partiesrow['telnumbers'] ?> <BR>
	<?PHP } ?>		
	<?PHP if (!empty($partiesrow['faxnumbers'])) { ?>			
	<B>Fax Nos.:</B>&nbsp; <?PHP echo $partiesrow['faxnumbers'] ?> <BR>
	<?PHP } ?>		
	<?PHP if (!empty($partiesrow['email'])) { ?>
		<B>E-mail:</B>&nbsp; <A HREF=<?PHP echo "mailto:".$partiesrow['email']; ?>><?PHP echo $partiesrow['email'] ?></A><BR>		
	<?PHP } ?>
	<?PHP if (!empty($partiesrow['yearfounded'])) { ?>
		<B>Year Founded/Registered:</B>&nbsp; <?PHP echo $partiesrow['yearfounded'] ?><BR>		
	<?PHP } ?>	
	</SPAN>
	<?PHP if ($numpartylink > 0) { ?>
		<SPAN CLASS="BROWSEBOXFONT"><B>Links:</B></SPAN><BR>
			<?PHP while ($partylinkrow = mysql_fetch_array($partylink)) { ?>
			&nbsp;&nbsp;&middot;&nbsp;<SPAN CLASS="BROWSEBOXFONT"><A HREF=<?PHP echo $partylinkrow['url']; ?>><?PHP echo $partylinkrow['title']; ?></A></SPAN><BR>
			<?PHP } ?>
	<?PHP } ?>
	</TD>
</TR>
</TABLE>
<?PHP } ?>
<!-- End of 1st Column --->
	</TD>
	<TD WIDTH="1%">&nbsp;</TD> <!-- Spacer between 1st and 3rd column -->
	<TD WIDTH="30%" ALIGN="left" VALIGN="top">	
<!-- Start of 3rd Column --->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B><?PHP echo strtoupper($partiesrow['partyname']); ?></B></DIV>
<BR>

<?PHP if(!empty($partiesrow['vision'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Vision</H2>
	<?PHP echo $partiesrow['vision']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['mission'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Mission</H2>
	<?PHP echo $partiesrow['mission']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['platform'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Platform</H2>
	<?PHP echo $partiesrow['platform']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['programofgovt'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Program of Government</H2>
	<?PHP echo $partiesrow['programofgovt']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['standonissues'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Stand on Certain Issues</H2>
	<?PHP echo $partiesrow['standonissues']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['partyhistory'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Party History</H2>
	<?PHP echo $partiesrow['partyhistory']; ?>
<?PHP } ?>

<?PHP if(!empty($partiesrow['partyorganization'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Party Organization</H2>
	<?PHP echo $partiesrow['partyorganization']; ?>
<?PHP } ?>

<H2 CLASS="HIGHLIGHTS">Members of the Party in Government Positions<BR>
(Sorted Alphabetically by position, last name)</H2>
<OL>
	<?PHP while($presidentrow = mysql_fetch_array($presidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['president_id']; ?>>
				Pres. <?PHP echo $presidentrow['firstname']; ?>	
				<?PHP if(!empty($presidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $presidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $presidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
	<?PHP while($vicepresidentrow = mysql_fetch_array($vicepresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['vicepresident_id']; ?>>
				Vice Pres. <?PHP echo $vicepresidentrow['firstname']; ?>	
				<?PHP if(!empty($vicepresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicepresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicepresidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
	<?PHP while($senatorrow = mysql_fetch_array($senatormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senatorrow['senator_id']; ?>>
				Sen. <?PHP echo $senatorrow['firstname']; ?>	
				<?PHP if(!empty($senatorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $senatorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $senatorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($senatormem);
	?>	
	<?PHP while($representativerow = mysql_fetch_array($representativemem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$representativerow['representative_id']; ?>>
				Rep. <?PHP echo $representativerow['firstname']; ?>	
				<?PHP if(!empty($representativerow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $representativerow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $representativerow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($representativemem);
	?>	
	<?PHP while($governorrow = mysql_fetch_array($governormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['governor_id']; ?>>
				Gov. <?PHP echo $governorrow['firstname']; ?>	
				<?PHP if(!empty($governorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $governorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $governorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($governormem);
	?>		
	<?PHP while($vicegovernorrow = mysql_fetch_array($vicegovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['vicegovernor_id']; ?>>
				Vice Gov. <?PHP echo $vicegovernorrow['firstname']; ?>	
				<?PHP if(!empty($vicegovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicegovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicegovernorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($vicegovernormem);
	?>			
	<?PHP while($provboardmemberrow = mysql_fetch_array($provboardmembermem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/provboardmemdet.php?provboardmemid=".$provboardmemberrow['provboardmember_id']; ?>>
				Provincial Board Member <?PHP echo $provboardmemberrow['firstname']; ?>	
				<?PHP if(!empty($provboardmemberrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $provboardmemberrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $provboardmemberrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($provboardmembermem);
	?>			
	<?PHP while($mayorrow = mysql_fetch_array($mayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['mayor_id']; ?>>
				Mayor <?PHP echo $mayorrow['firstname']; ?>	
				<?PHP if(!empty($mayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $mayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $mayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($mayormem);
	?>				
	<?PHP while($vicemayorrow = mysql_fetch_array($vicemayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['vicemayor_id']; ?>>
				Vice Mayor <?PHP echo $vicemayorrow['firstname']; ?>	
				<?PHP if(!empty($vicemayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicemayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicemayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($vicemayormem);
	?>							
	<?PHP while($councilorrow = mysql_fetch_array($councilormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorrow['councilor_id']; ?>>
				Councilor <?PHP echo $councilorrow['firstname']; ?>	
				<?PHP if(!empty($councilorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $councilorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $councilorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($councilormem);
	?>								
</OL>
<TABLE WIDTH="50%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP 
	if($numsenatormem > 0) {
		echo "<TR><TD><B>No. of Senators:</B></TD><TD>".$numsenatormem."</TD></TR>";
	}		
?> 
<?PHP 
	if($numrepresentativemem > 0) {
		echo "<TR><TD><B>No. of House Representatives:</B></TD><TD>".$numrepresentativemem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numgovernormem > 0) {
		echo "<TR><TD><B>No. of Governors:</B></TD><TD>".$numgovernormem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numvicegovernormem > 0) {
		echo "<TR><TD><B>No. of Vice Governors:</B></TD><TD>".$numvicegovernormem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numprovboardmembermem > 0) {
		echo "<TR><TD><B>No. of Provincial Board Members:</B></TD><TD>".$numprovboardmembermem."</TD></TR>";
	}		
?> 
<?PHP 
	if($nummayormem > 0) {
		echo "<TR><TD><B>No. of Mayors:</B></TD><TD>".$nummayormem."</TD></TR>";
	}		
?>   
<?PHP 
	if($numvicemayormem > 0) {
		echo "<TR><TD><B>No. of Vice Mayors:</B></TD><TD>".$numvicemayormem."</TD></TR>";
	}		
?>   
<?PHP 
	if($numcouncilormem > 0) {
		echo "<TR><TD><B>No. of Councilors:</B></TD><TD>".$numcouncilormem."</TD></TR>";
	}		
?>  
</TABLE>
<H2 CLASS="HIGHLIGHTS">Members of the Party Vying for Government Positions<BR>
(Sorted alphabetically by last name)</H2>
<?PHP if ($numcandpresidentmem > 0) { ?>
	<B>For President</B><BR>
<?PHP } ?>	
<OL>
	<?PHP while($candpresidentrow = mysql_fetch_array($candpresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$candpresidentrow['president_id']; ?>>
				<?PHP echo $candpresidentrow['lastname']; ?>,&nbsp;
				<?PHP echo $candpresidentrow['firstname']; ?>	
				<?PHP if(!empty($candpresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candpresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } ?>
</OL>
<?PHP if ($numcandvicepresidentmem > 0) { ?>	
	<B>For Vice President</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candvicepresidentrow = mysql_fetch_array($candvicepresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$candvicepresidentrow['vicepresident_id']; ?>>
				<?PHP echo $candvicepresidentrow['lastname']; ?>,&nbsp;
				<?PHP echo $candvicepresidentrow['firstname']; ?>	
				<?PHP if(!empty($candvicepresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicepresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } ?>
</OL>	
<?PHP if ($numcandsenatormem > 0) { ?>
	<B>For Senators</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candsenatorrow = mysql_fetch_array($candsenatormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorrow['senator_id']; ?>>
				<?PHP echo $candsenatorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candsenatorrow['firstname']; ?>	
				<?PHP if(!empty($candsenatorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candsenatorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } 
		mysql_free_result($candsenatormem);
	?>	
</OL>	
<?PHP if ($numcandrepresentativemem > 0) { ?>
	<B>For House Representatives</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candrepresentativerow = mysql_fetch_array($candrepresentativemem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativerow['representative_id']; ?>>
				<?PHP echo $candrepresentativerow['lastname']; ?>,&nbsp;
				<?PHP echo $candrepresentativerow['firstname']; ?>	
				<?PHP if(!empty($candrepresentativerow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candrepresentativerow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } 
		mysql_free_result($candrepresentativemem);
	?>	
</OL>
<?PHP if ($numcandgovernormem > 0) { ?>	
	<B>For Governor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candgovernorrow = mysql_fetch_array($candgovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorrow['governor_id']; ?>>
				<?PHP echo $candgovernorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candgovernorrow['firstname']; ?>	
				<?PHP if(!empty($candgovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candgovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } 
		mysql_free_result($candgovernormem);
	?>		
</OL>	
<?PHP if ($numcandvicegovernormem > 0) { ?>
	<B>For Vice Governor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candvicegovernorrow = mysql_fetch_array($candvicegovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorrow['vicegovernor_id']; ?>>
				<?PHP echo $candvicegovernorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candvicegovernorrow['firstname']; ?>	
				<?PHP if(!empty($candvicegovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicegovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>	
	<?PHP } 
		mysql_free_result($candvicegovernormem);
	?>			
</OL>	
<?PHP if ($numcandboardmemmem > 0) { ?>
	<B>For Provincial Board Members</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candprovboardmemberrow = mysql_fetch_array($candboardmemmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candboardmemdet.php?candprovboardmemid=".$candprovboardmemberrow['provboardmember_id']; ?>>
				<?PHP echo $candprovboardmemberrow['lastname']; ?>,&nbsp;
				<?PHP echo $candprovboardmemberrow['firstname']; ?>	
				<?PHP if(!empty($candprovboardmemberrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candprovboardmemberrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>
	<?PHP } 
		mysql_free_result($candboardmemmem);
	?>			
</OL>	
<?PHP if ($numcandmayormem > 0) { ?>
	<B>For Mayor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candmayorrow = mysql_fetch_array($candmayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorrow['mayor_id']; ?>>
				<?PHP echo $candmayorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candmayorrow['firstname']; ?>	
				<?PHP if(!empty($candmayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candmayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>
	<?PHP } 
		mysql_free_result($candmayormem);
	?>				
</OL>	
<?PHP if ($numcandvicemayormem > 0) { ?>
	<B>For Vice Mayor</B><BR>
<?PHP } ?>	
<OL>
	<?PHP while($candvicemayorrow = mysql_fetch_array($candvicemayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorrow['vicemayor_id']; ?>>
				<?PHP echo $candvicemayorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candvicemayorrow['firstname']; ?>	
				<?PHP if(!empty($candvicemayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicemayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>
	<?PHP } 
		mysql_free_result($candvicemayormem);
	?>							
</OL>	
<?PHP if ($numcandcouncilormem > 0) { ?>
	<B>For Councilors</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candcouncilorrow = mysql_fetch_array($candcouncilormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorrow['councilor_id']; ?>>
				<?PHP echo $candcouncilorrow['lastname']; ?>,&nbsp;
				<?PHP echo $candcouncilorrow['firstname']; ?>	
				<?PHP if(!empty($candcouncilorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candcouncilorrow['middleinitial'].". "; ?>
				<?PHP } ?>
			</A>
	<?PHP } 
		mysql_free_result($candcouncilormem);
	?>	
</OL>	
<!-- End of 1st Column --->	
	</TD>
	<TD WIDTH="1%">
<!-- Start of 2nd Column to act as spacer between 1st and 3rd column --->	
&nbsp;
<!-- End of 2nd Column to act as spacer between 1st and 3rd column --->		
	</TD>
	<TD VALIGN="TOP" WIDTH="1%">
<!-- Start of 3rd Column --->
&nbsp;
<!-- End of 3rd Column --->	
	</TD>
</TR>
</TABLE>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
