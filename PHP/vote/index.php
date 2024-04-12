<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/terms.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  provinces.province_id As province_id,regions.regionname As region, regions.fullname As regionfullname, provinces.name As province
  FROM regions, provinces 
  WHERE regions.region_id = provinces.region_id
  ORDER BY regions.regorder, provinces.name";
$provinces =  getqueryresults($query);

$query = "SELECT natfactsheet.capital As capital, natfactsheet.nummaleregvoters As nummaleregvoters, natfactsheet.numfemaleregvoters As numfemaleregvoters,
  natfactsheet.numprovinces As numprovinces, natfactsheet.numcities As numcities, natfactsheet.nummunicipalities As nummunicipalities,
  natfactsheet.numlegdist As numlegdist, natfactsheet.numbarangays As numbarangays, natfactsheet.factsheet As factsheet, natfactsheet.numregvoters As numregvoters,
  natfactsheet.numprecincts As numprecincts, natfactsheet.is_presresult, natfactsheet.is_vpresresult, natfactsheet.is_senresult, natfactsheet.is_partylistresult
  FROM natfactsheet"; 
$natfactsheet = getqueryresults($query);
$natfactsheetrow = mysql_fetch_array($natfactsheet);  

$query = "SELECT nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity
  FROM nationalcapitalregion
  ORDER BY nationalcapitalregion.name";
$municityncr = getqueryresults($query);

$query = "SELECT  presidents.president_id As president_id, YEAR(presidents.term_begin) As yearbegin,presidents.lastname As lastname,presidents.firstname As firstname,presidents.middleinitial As middleinitial
  FROM presidents
  WHERE (YEAR(presidents.term_begin) = ".$pterm.") AND (presidents.is_deceased = 'N') AND (presidents.is_unfinishedterm = 'N')
  ORDER BY yearbegin,presidents.lastname";
$president = getqueryresults($query);

$query = "SELECT  vicepresidents.vicepresident_id As vicepresident_id, YEAR(vicepresidents.term_begin) As yearbegin,vicepresidents.lastname As lastname,vicepresidents.firstname As firstname,vicepresidents.middleinitial As middleinitial
  FROM vicepresidents
  WHERE YEAR(vicepresidents.term_begin) = ".$vpterm." AND (vicepresidents.is_deceased = 'N') AND (vicepresidents.is_unfinishedterm = 'N')
  ORDER BY yearbegin,vicepresidents.lastname";
$vicepresident = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.party_id As party_id, candpresidents.president_id As president_id, candpresidents.lastname As lastname,candpresidents.firstname As firstname,candpresidents.middleinitial As middleinitial
  FROM candpresidents, party
  WHERE candpresidents.party_id = party.party_id
  ORDER BY candpresidents.lastname";
$candpresidents = getqueryresults($query);
$numcandpresidents = mysql_num_rows($candpresidents);

$query = "SELECT  party.acronym As acronym, party.party_id As party_id, candvicepresidents.vicepresident_id As vicepresident_id, candvicepresidents.lastname As lastname,candvicepresidents.firstname As firstname,candvicepresidents.middleinitial As middleinitial
  FROM candvicepresidents, party
  WHERE candvicepresidents.party_id = party.party_id
  ORDER BY candvicepresidents.lastname";
$candvicepresidents = getqueryresults($query);
$numcandvicepresidents = mysql_num_rows($candvicepresidents);

$query = "SELECT senators.is_deceased,senators.senator_id As senator_id,YEAR(senators.term_begin) As yearbegin,senators.lastname As lastname,senators.firstname As firstname,senators.middleinitial As middleinitial
  FROM senators
  WHERE (YEAR(senators.term_begin) = ".$term1st.") AND (senators.is_deceased = 'N') AND (senators.is_unfinishedterm = 'N')
  ORDER BY yearbegin,senators.lastname";
$senators1st = getqueryresults($query);

$query = "SELECT  senators.is_deceased,senators.senator_id As senator_id, YEAR(senators.term_begin) As yearbegin,senators.lastname As lastname,senators.firstname As firstname,senators.middleinitial As middleinitial
  FROM senators
  WHERE (YEAR(senators.term_begin) = ".$term2nd.") AND (senators.is_deceased = 'N') AND (senators.is_unfinishedterm = 'N')
  ORDER BY yearbegin,senators.lastname";
$senators2nd = getqueryresults($query);

$query = "SELECT  party.name As partyname, party.acronym As acronym, party.party_id As party_id, candsenators.senator_id As candsenator_id, candsenators.lastname As lastname,candsenators.firstname As firstname,candsenators.middleinitial As middleinitial
  FROM candsenators, party
  WHERE candsenators.party_id = party.party_id
  ORDER BY candsenators.lastname";
$candsenators = getqueryresults($query);
$numcandsenators = mysql_num_rows($candsenators);

$query = "SELECT coalitions.coalition_id, coalitions.acronym, coalitions.name as coalitionname
          FROM coalitions
		  ORDER BY coalitions.name";
$coalitions = getqueryresults($query);

$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname
  FROM party,party_type
  WHERE party.is_national = 'Y' AND party.partytype_id = party_type.partytype_id AND party_type.type = 'political'
  ORDER BY party.acronym,party.partyname";
$polparties = getqueryresults($query);

$query = "SELECT  partylist.party_id As party_id, party.acronym As acronym, party.name As partyname
  FROM party, partylist
  WHERE party.is_national = 'Y' AND party.party_id = partylist.party_id 
  ORDER BY party.acronym,party.name";
$partylists = getqueryresults($query);

$query = "SELECT  candpartylist.party_id As party_id, party.acronym As acronym, party.name As partyname
  FROM party,candpartylist
  WHERE party.party_id = candpartylist.party_id AND party.acronym IS NOT NULL
  ORDER BY party.acronym,party.partyname";
$candpartylists = getqueryresults($query);
$numcandpartylists = mysql_num_rows($candpartylists);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%y') As date, party.acronym As acronym, activities.title As title, party.party_id As party_id
FROM activities, party
WHERE (activities.is_national='Y') AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id)
ORDER BY activities.date, party.acronym, party.name";
$natactivities = getqueryresults($query);
$numnatactivities = mysql_num_rows($natactivities);

$query = "SELECT newsevents_id, title, source
FROM newsevents
WHERE (is_national='Y') AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
ORDER BY end_date, start_date";
$newsevents = getqueryresults($query);
$numnewsevents = mysql_num_rows($newsevents);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph - Your Guide to a Wiser and Intelligent Voting : Home Page</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF"> <!-- BGColor defines color of Web Page -->

<!--===================== Start of Banner Table ======================-->
<?PHP require("$votehome/vote/ssi/bannertable.inc"); ?>
<!--======================== End of Banner Table =======================-->

<!--================ Start of Breadcrumb Trails =======================-->		
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="4">
<TR>
<TD WIDTH="100%" HEIGHT="12" COLSPAN="2" VALIGN="middle" BGCOLOR="#8DC1FC"><B>Home</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30%" ALIGN="left" VALIGN="top">
<!---- Start of First Column of Content Table ---->
<!-- Start of Activities Box -->
<?PHP if ($numnatactivities > 0) { ?>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
	<TR>
		<TD ALIGN="center" VALIGN="middle" BGCOLOR="RED">						
  	    	<DIV STYLE="color: White;" ALIGN="CENTER"><B>PARTY ACTIVITIES</B></DIV>
		</TD>
	</TR>
	<TR>	
		<TD>
			<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
			<?PHP while ($natactivitiesrow = mysql_fetch_array($natactivities)) { ?>
				<TR>
					<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $natactivitiesrow['date']; ?></SPAN>
					</TD>
					<TD ALIGN="left" VALIGN="top">
						<SPAN CLASS="BROWSEBOXFONT" STYLE="color: Navy; font-weight: bold;"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$natactivitiesrow['party_id']; ?>><?PHP echo $natactivitiesrow['acronym']; ?></A></SPAN><BR>
					    <SPAN CLASS="BROWSEBOXFONT"><A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$natactivitiesrow['activity_id']; ?>><?PHP echo stripslashes($natactivitiesrow['title']); ?></A></SPAN>
					</TD>
				</TR>
			<?PHP } ?>
			</TABLE>
		</TD>
	</TR>
</TABLE>
<?PHP mysql_free_result($natactivities); ?>
<?PHP } ?>
<!-- End of Activities Box -->					
<BR>
<!-- Start of Browse Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="RED">						
					    <DIV STYLE="color: White;"><B>BROWSE</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD ALIGN="left" VALIGN="top">
<B><SPAN CLASS="BROWSEBOXHEADER"><I>NCR</I> 
	   - National Capital Region</SPAN></B>					
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR><TD WIDTH="10%">&nbsp;</TD>
<TD ALIGN="left">
<?PHP
$municityrow = mysql_fetch_array($municityncr);
while ($municityrow) {
?>
	<SPAN CLASS="BROWSEBOXFONT">
	<A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$municityrow['municity_id']; ?>><?PHP echo $municityrow['municity']; ?></A>&nbsp;
	</SPAN>
	<?PHP 
	   $municityrow = mysql_fetch_array($municityncr); 
	   if ($municityrow) {
	     echo ",&nbsp;";
	   } 
	?>
<?PHP 
}
?>
<?PHP mysql_free_result($municityncr); ?>
</TD>
</TABLE>


<?PHP
$provrow = mysql_fetch_array($provinces);
while ($provrow) {
?>
	<?PHP 
		$region = $provrow['region'];
	?>
	<B><SPAN CLASS="BROWSEBOXHEADER"><I><?PHP echo $provrow['region']; ?></I> 
	   - <?PHP echo $provrow['regionfullname']; ?></SPAN></B>	
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR><TD WIDTH="10%">&nbsp;</TD>
			<TD ALIGN="left">	
			<?PHP while ($region == $provrow['region']) { ?>
			   	<SPAN CLASS="BROWSEBOXFONT">
			    	<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provrow['province_id']; ?>><?PHP echo $provrow['province']; ?></A>&nbsp;
				</SPAN> 
				<?PHP $provrow = mysql_fetch_array($provinces); ?>
				<?PHP if($region ==$provrow['region']) { ?>
				  ,&nbsp;
				<?PHP } ?>  
			<?PHP } ?>
			</TD>	
		</TR>
	</TABLE>	
<?PHP	
}
?>
<?PHP mysql_free_result($provinces); ?>
					
					</TD>
				</TR>
			</TABLE>
<!-- End of Browse Box -->
<BR>
<!-- Start of National Fact Sheet Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#FFBBBB">						
					    <DIV ALIGN="center"><B>National Government Fact Sheet</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<SPAN CLASS="FACTSHEETFONT">		
<?PHP if (!empty($natfactsheetrow['capital']))  { ?>			
<I><B>Capital:</B></I>&nbsp;&nbsp;<?PHP echo $natfactsheetrow['capital']; ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['nummaleregvoters'] <> 0)  { ?>			
<I><B>No. of Male Registered Voters:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['nummaleregvoters']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numfemaleregvoters'] <> 0)  { ?>
<I><B>No. of Female Registered Voters:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numfemaleregvoters']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numregvoters'] <> 0)  { ?>
<I><B>No. of Registered Voters:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numregvoters']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numprecincts'] <> 0)  { ?>
<I><B>No. of Precincts:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numprecincts']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numprovinces'] <> 0)  { ?>
<I><B>No. of Provinces:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numprovinces']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numlegdist'] <> 0)  { ?>
<I><B>No. of Legislative Districts:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numlegdist']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numcities'] <> 0)  { ?>
<I><B>No. of Cities:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numcities']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['nummunicipalities'] <> 0)  { ?>
<I><B>No. of Municipalities:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['nummunicipalities']); ?><BR>
<?PHP } ?>
<?PHP if ($natfactsheetrow['numbarangays'] <> 0)  { ?>
<I><B>No. of Barangays:</B></I>&nbsp;&nbsp;<?PHP echo number_format($natfactsheetrow['numbarangays']); ?><BR>
<?PHP } ?>
<?PHP if (strlen(trim($natfactsheetrow['factsheet'])) <>  0)  { ?>
<B><I>Others:</I></B><BR>
<?PHP echo $natfactsheetrow['factsheet']; ?>
<?PHP } ?>
</SPAN> 
<?PHP if (strlen(trim($natfactsheetrow['factsheet'])) <>  0)  { ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="2%">&nbsp;</TD>
	<TD><SPAN CLASS="RIGHTBOXFONT">	<?PHP echo $natfactsheetrow['factsheet']; ?></SPAN></TD>
</TR>
</TABLE>
<?PHP } ?>			
					</TD>
				</TR>
			</TABLE>
<!-- End of National Fact Sheet Box -->

<!---- End of First Column of Content Table ---->
		</TD>
		<TD WIDTH="1%">&nbsp;</TD> 
		<!-- Second column defining space between first and third column -->
		<TD VALIGN="top" BGCOLOR="#FFFFFF">
<!---- Start of Third Column of Content Table ---->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD>&nbsp;</TD></TR>
<?PHP if ($numnewsevents > 0) { ?>	
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#DDBA9B">	
		<B>NEWS, EVENTS AND ACTIVITIES</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of News, Events & Activities Content -->	
<BR>
<?PHP while ($newseventsrow = mysql_fetch_array($newsevents)) { ?>
&nbsp;&nbsp;<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$newseventsrow['newsevents_id']; ?>"><B><?PHP echo $newseventsrow['title']; ?></B></A>
	<BR>
<?PHP } ?>
<BR>
<!-- End of News, Events & Activities Content -->
		</TD>
	</TR>					
<?PHP } ?>	
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>PRESIDENT AND VICE-PRESIDENT</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of President & Vice-President Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent President and Vice President</H2>
<?PHP
$presidentrow = mysql_fetch_array($president);	
$vicepresidentrow = mysql_fetch_array($vicepresident);
?>
<DIV ALIGN="center">
<A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['president_id']; ?>>
President <?PHP echo $presidentrow['firstname']; ?>	
<?PHP if(!empty($presidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $presidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $presidentrow['lastname']; ?>
</A>
<BR>
</DIV>
<DIV ALIGN="center">
<A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['vicepresident_id']; ?>>
Vice President <?PHP echo $vicepresidentrow['firstname']." "; ?>	
<?PHP if(!empty($vicepresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicepresidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicepresidentrow['lastname']; ?>
</A>
<BR>
</DIV>
<?PHP 
mysql_free_result($president); 
mysql_free_result($vicepresident);
?>
<?PHP if($numcandpresidents > 0) { ?>
<BR>
<H2 CLASS="HIGHLIGHTS">Presidential Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if($numcandpresidents > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candpresidentsrow = mysql_fetch_array($candpresidents);
while ($candpresidentsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentsrow['president_id']; ?>>
<?PHP echo $candpresidentsrow['lastname'].", ".$candpresidentsrow['firstname'] ?>	
<?PHP if(!empty($candpresidentsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candpresidentsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candpresidentsrow['party_id']; ?>><?PHP echo $candpresidentsrow['acronym']; ?></A></TD>
</TR>
<?PHP $candpresidentsrow = mysql_fetch_array($candpresidents); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candpresidents); ?>
</TABLE>
<?PHP if($numcandvicepresidents > 0) { ?>
<BR>
<H2 CLASS="HIGHLIGHTS">Vice Presidential Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if($numcandvicepresidents > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candvicepresidentsrow = mysql_fetch_array($candvicepresidents);
while ($candvicepresidentsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candvicepresidentsdet.php?candvicepresidentid=".$candvicepresidentsrow['vicepresident_id']; ?>>
<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname'] ?>	
<?PHP if(!empty($candvicepresidentsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicepresidentsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candvicepresidentsrow['party_id']; ?>><?PHP echo $candvicepresidentsrow['acronym']; ?></A></TD>
</TR>
<?PHP $candvicepresidentsrow = mysql_fetch_array($candvicepresidents); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candvicepresidents); ?>
</TABLE>
<?PHP if ($natfactsheetrow['is_presresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF="/vote/electresults/candpresidentlist.php"><B><I>Presidential Election Results...</I></B></A></DIV>
<?PHP } ?>
<?PHP if ($natfactsheetrow['is_vpresresult'] == "Y") { ?>
	<DIV ALIGN="RIGHT"><A HREF="/vote/electresults/candvicepresidentlist.php"><B><I>Vice Presidential Election Results...</I></B></A></DIV>
<?PHP } ?>
<BR>
<!-- End of President & Vice-President Content -->
		</TD>
	</TR>					
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>SENATORS</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Senators Content -->
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Senators</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="3" ALIGN="center">
	<TR>
		<TD ALIGN="left" VALIGN="top">
<DIV ALIGN="center" STYLE="color: Maroon;"><I>(<?PHP $term1stend = $term1st + 6; echo $term1st." - ".$term1stend; ?>)</I></DIV>		
<?PHP
$senators1strow = mysql_fetch_array($senators1st);
while ($senators1strow) {
?>

<A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senators1strow['senator_id']; ?>><?PHP echo $senators1strow['lastname'].", ".$senators1strow['firstname']; ?>	
<?PHP if(!empty($senators1strow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $senators1strow['middleinitial']."."; ?>
<?PHP } ?>
</A>
<BR>
<?PHP $senators1strow = mysql_fetch_array($senators1st); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($senators1st); ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
<DIV ALIGN="center" STYLE="color: Maroon;"><I>(<?PHP $term2ndend = $term2nd + 6; echo $term2nd." - ".$term2ndend; ?>)</I></DIV>				
<?PHP
$senators2ndrow = mysql_fetch_array($senators2nd);
while ($senators2ndrow) {
?>

<A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senators2ndrow['senator_id']; ?>>
<?PHP echo $senators2ndrow['lastname'].", ".$senators2ndrow['firstname'] ?>	
<?PHP if(!empty($senators2ndrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $senators2ndrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
<BR>
<?PHP $senators2ndrow = mysql_fetch_array($senators2nd); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($senators2nd); ?>
		</TD>		
	</TR>
</TABLE>
<?PHP if($numcandsenators > 0) { ?>
<BR>
<H2 CLASS="HIGHLIGHTS">Senatorial Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if($numcandsenators > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candsenatorsrow = mysql_fetch_array($candsenators);
while ($candsenatorsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorsrow['candsenator_id']; ?>>
<?PHP echo $candsenatorsrow['lastname'].", ".$candsenatorsrow['firstname'] ?>	
<?PHP if(!empty($candsenatorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candsenatorsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candsenatorsrow['party_id']; ?>>
    <?PHP if (!empty($candsenatorsrow['acronym'])) { ?>
         <?PHP echo $candsenatorsrow['acronym']; ?>
	<?PHP } else { ?>
         <?PHP echo $candsenatorsrow['partyname']; ?>	
	<?PHP } ?>	 
	</A></TD>
</TR>
<?PHP $candsenatorsrow = mysql_fetch_array($candsenators); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candsenators); ?>
</TABLE>
<?PHP if ($natfactsheetrow['is_senresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF="/vote/electresults/candsenatorlist.php"><B><I>Senatorial Election Results...</I></B></A></DIV>
<?PHP } ?>
<BR>
<!-- End of Senators Content -->
		</TD>	
	</TR>
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>PARTY LISTS</B>	
		</TD>
	</TR>		
	<TR>
		<TD VALIGN="top">		
<!-- Start of Party List Content -->
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Party Lists</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP
$ctr = 0;
$partylistrow = mysql_fetch_array($partylists);
while ($partylistrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD WIDTH="15" VALIGN="top"><SPAN STYLE="font-size:9pt;"><?PHP $ctr++; echo $ctr; ?></SPAN></TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$partylistrow['party_id']; ?>>
    <SPAN STYLE="font-size:9pt;"><?PHP echo $partylistrow['acronym']; ?></SPAN></A>
<BR><SPAN STYLE="font-size:9pt;"><?PHP echo $partylistrow['partyname']; ?></SPAN>
</TD>
</TR>
<?PHP $partylistrow = mysql_fetch_array($partylists); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($partylists); ?>
</TABLE>
<?PHP if($numcandpartylists > 0) { ?>
<BR>
<H2 CLASS="HIGHLIGHTS">Party List Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<?PHP
$ctr = 0;
$numpartylist = mysql_num_rows($candpartylists);
$numofrowincol = ceil($numpartylist/3) + 1;
$candpartylistrow = mysql_fetch_array($candpartylists);
?>
<?PHP while ($candpartylistrow) { ?>
<TD WIDTH="33%" ALIGN="left" VALIGN="top">	<?PHP while ($ctr < $numofrowincol) { ?>
		<SPAN STYLE="font-size: 9pt;"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candpartylistrow['party_id']; ?> TITLE='<?PHP echo stripslashes($candpartylistrow['partyname']); ?>'><?PHP echo $candpartylistrow['acronym']; ?></A></SPAN><BR>
		<?PHP $ctr++ ?>
		<?PHP $candpartylistrow = mysql_fetch_array($candpartylists); ?>
	<?PHP } ?>	
	<?PHP $ctr = 0 ?>
</TD>	
<?PHP } ?>
</TR>
</TABLE>
<?PHP mysql_free_result($candpartylists); ?>
<?PHP if ($natfactsheetrow['is_partylistresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF="/vote/electresults/candpartylist.php"><B><I>Election Results...</I></B></A></DIV>
<?PHP } ?>
<BR>
<!-- End of Party List Content -->
		</TD>
	</TR>				
</TABLE>
<!---- End of Third Column of Content Table ---->
		</TD>
		<TD WIDTH="1%">&nbsp;</TD> 
		<!-- Fourth column defining space between third and fifth column -->
		<TD WIDTH="20%" ALIGN="left" VALIGN="top">
<!---- Start of Fifth Column of Content Table ------> 
<BR>
<!-- Start of Announcement Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#8DC1FC">						
					    <DIV ALIGN="center"><B>Announcement</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<?PHP require ("$votehome/vote/ssi/announcements.inc"); ?>					
					</TD>
				</TR>
			</TABLE>
<BR>
<!-- Start of Announcement Box -->
<!-- Start of Help Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#8DC1FC">						
					    <DIV ALIGN="center"><B>Help</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<B>If your are a:</B><BR>
<SPAN CLASS="RIGHTBOXFONT">
&nbsp;&nbsp;<A HREF="/vote/help/incumbents.php" TITLE="Are you an incumbent? Click here">an elected official</A><BR>
</SPAN>
<BR>
<B>If you would like to:</B><BR>
<SPAN CLASS="RIGHTBOXFONT">
&nbsp;&nbsp;<A HREF="/vote/feedback/feedback.php">send us your feedback</A><BR>
&nbsp;&nbsp;<A HREF="/vote/feedback/emailtofriend.php">recommend us to others</A><BR>
</SPAN>
					</TD>
				</TR>
			</TABLE>
<BR>
<!-- Start of Help Box -->
<!-- Start of Political Parties Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#8DC1FC">						
					    <DIV ALIGN="center"><B>Political Parties and Coalitions</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<DIV ALIGN="left"><B>Coalitions:</B></DIV>
<?PHP
$coalitionsrow = mysql_fetch_array($coalitions);
while ($coalitionsrow) {
?>

<SPAN CLASS="RIGHTBOXFONT">
&nbsp;&nbsp;
<A HREF=<?PHP echo "/vote/coalitiondet.php?coalitionid=".$coalitionsrow['coalition_id']; ?>>
<?PHP 
	if (!empty($coalitionsrow['acronym'])) {
		echo $coalitionsrow['acronym'];
	} else {
		echo $coalitionsrow['coalitionname'];
	}	
?>	
</A>
</SPAN>
<BR>
<?PHP $coalitionsrow = mysql_fetch_array($coalitions); ?>
	
<?PHP } ?>
<?PHP mysql_free_result($coalitions); ?>					

<DIV ALIGN="left"><B>National:</B></DIV>					
<?PHP
$polpartiesrow = mysql_fetch_array($polparties);
while ($polpartiesrow) {
?>

<SPAN CLASS="RIGHTBOXFONT">
&nbsp;&nbsp;
<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$polpartiesrow['polparty_id']; ?>>
<?PHP 
	if (!empty($polpartiesrow['acronym'])) {
		echo $polpartiesrow['acronym'];
	} else {
		echo $polpartiesrow['partyname'];
	}	
?>	
</A>
</SPAN>
<BR>
<?PHP $polpartiesrow = mysql_fetch_array($polparties); ?>
	
<?PHP } ?>
<?PHP mysql_free_result($polparties); ?>					
					</TD>
				</TR>
			</TABLE>
<!-- End of Political Parties Box -->
<BR>
<!----- End of Fifth Column of Content Table ------>
		</TD>
	</TR>
	<TR><TD> &nbsp;	</TD></TR>
</TABLE>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
