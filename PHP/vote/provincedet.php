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
$query = "SELECT  regions.regionname As region,provinces.name As provincename,provinces.provincialcapital As capital,provinces.landarea As landarea,
          provinces.numbarangays As numbarangays,provinces.nummaleregvoters As nummaleregvoters, provinces.numfemaleregvoters As numfemaleregvoters, 
		  provinces.factsheet As factsheet, numregvoters As numregvoters,numprecincts As numprecincts, provinces.is_dispgovresult, 
		  provinces.is_dispvicegovresult, provinces.numactualvoters
  FROM provinces, regions
  WHERE provinces.region_id = regions.region_id AND provinces.province_id = ".$provinceid;
$province =  getqueryresults($query);
$provincerow = mysql_fetch_array($province);

$query = "SELECT legdistricts.legdist_id As legdist_id, legdistricts.dist_num As districtnum, municity.name As municity,municity.municity_id As municity_id
	FROM legdistricts, municity
	WHERE legdistricts.legdist_id = municity.legdist_id AND legdistricts.province_id = ".$provinceid."
	ORDER BY legdistricts.dist_num, municity.name";
$municity = getqueryresults($query);

$query = "SELECT legdistricts.dist_num As districtnum
	FROM legdistricts
	WHERE legdistricts.province_id = ".$provinceid."
	ORDER BY legdistricts.dist_num";
$legdistricts = getqueryresults($query);
$numlegdistricts = mysql_num_rows($legdistricts);
	
$query = "SELECT coalitions.coalition_id, coalitions.acronym, coalitions.name as coalitionname
          FROM coalitions
		  ORDER BY coalitions.name";
$coalitions = getqueryresults($query);
	
$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname
  FROM party,party_type
  WHERE (party.is_national = 'Y') AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political')
  ORDER BY party.acronym,party.partyname";
$natpolparties = getqueryresults($query);

$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname
  FROM party,party_type,provinces
  WHERE (party.province_id = provinces.province_id) AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (provinces.province_id = ".$provinceid.")
  ORDER BY party.acronym,party.partyname";
$regpolparties = getqueryresults($query);
$numregpolparties = mysql_num_rows($regpolparties);

$query = "SELECT  governors.governor_id As governor_id, YEAR(governors.term_begin) As yearbegin,governors.lastname As lastname,governors.firstname As firstname,governors.middleinitial As middleinitial
  FROM governors
  WHERE YEAR(governors.term_begin) = ".$govterm." AND (governors.province_id = ".$provinceid.") AND (governors.is_deceased = 'N') AND (governors.is_unfinishedterm = 'N') 
  ORDER BY yearbegin,governors.lastname";
$governors = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candgovernors.governor_id As governor_id, candgovernors.lastname As lastname,candgovernors.firstname As firstname,candgovernors.middleinitial As middleinitial
  FROM candgovernors, party
  WHERE (candgovernors.party_id = party.party_id) AND (candgovernors.province_id = ".$provinceid.")
  ORDER BY candgovernors.lastname";
$candgovernors = getqueryresults($query);
$numcandgovernors = mysql_num_rows($candgovernors);

$query = "SELECT  vicegovernors.vicegovernor_id As vicegovernor_id, YEAR(vicegovernors.term_begin) As yearbegin,vicegovernors.lastname As lastname,vicegovernors.firstname As firstname,vicegovernors.middleinitial As middleinitial
  FROM vicegovernors
  WHERE YEAR(vicegovernors.term_begin) = ".$govterm." AND (vicegovernors.province_id = ".$provinceid.") AND (vicegovernors.is_deceased = 'N') AND (vicegovernors.is_unfinishedterm = 'N') 
  ORDER BY yearbegin,vicegovernors.lastname";
$vicegovernors = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candvicegovernors.vicegovernor_id As vicegovernor_id, candvicegovernors.lastname As lastname,candvicegovernors.firstname As firstname,candvicegovernors.middleinitial As middleinitial
  FROM candvicegovernors, party
  WHERE (candvicegovernors.party_id = party.party_id) AND (candvicegovernors.province_id = ".$provinceid.")
  ORDER BY candvicegovernors.lastname";
$candvicegovernors = getqueryresults($query);
$numcandvicegovernors = mysql_num_rows($candvicegovernors);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%y') As date, party.acronym As acronym, activities.title As title, party.party_id As party_id
FROM activities, party, provinces
WHERE (activities.province_id = provinces.province_id) AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (provinces.province_id = ".$provinceid.")
ORDER BY activities.date, party.acronym, party.name";
$activities = getqueryresults($query);
$numactivities = mysql_num_rows($activities);

$query = "SELECT newsevents_id, title, source
FROM newsevents
WHERE (province_id = ".$provinceid.") AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
ORDER BY end_date, start_date";
$newsevents = getqueryresults($query);
$numnewsevents = mysql_num_rows($newsevents);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : <?PHP echo $provincerow['region']; ?>&nbsp;-&nbsp;<?PHP echo $provincerow['provincename']; ?></TITLE>
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
<A HREF="/vote/byarea.php"><B>Browse by Area</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $provincerow['region']; ?>&nbsp;-&nbsp;<?PHP echo $provincerow['provincename']; ?></B>
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
<?PHP if ($numactivities > 0) { ?>
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
			<?PHP while ($activitiesrow = mysql_fetch_array($activities)) { ?>
				<TR>
					<TD ALIGN="left" VALIGN="top" WIDTH="60"><SPAN CLASS="BROWSEBOXFONT"><?PHP echo $activitiesrow['date']; ?></SPAN>
					</TD>
					<TD ALIGN="left" VALIGN="top">
						<SPAN CLASS="BROWSEBOXFONT" STYLE="color: Navy; font-weight: bold;"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$activitiesrow['party_id']; ?>><?PHP echo $activitiesrow['acronym']; ?></A></SPAN><BR>
					    <SPAN CLASS="BROWSEBOXFONT"><A HREF=<?PHP echo "/vote/activitydet.php?activityid=".$activitiesrow['activity_id']; ?>><?PHP echo stripslashes($activitiesrow['title']); ?></A></SPAN>
					</TD>
				</TR>
			<?PHP } ?>
			</TABLE>
		</TD>
	</TR>
</TABLE>
<?PHP mysql_free_result($activities); ?>
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
<?PHP
$municityrow = mysql_fetch_array($municity);
while ($municityrow) {
?>
	<?PHP 
		$district_num = $municityrow['districtnum'];
	?>
	<B><SPAN CLASS="BROWSEBOXHEADER"><A HREF=<?PHP echo "/vote/legdistdet.php?legdistid=".$municityrow['legdist_id']; ?>>
	<?PHP if ($numlegdistricts > 1) {
	         echo numtoordinal($municityrow['districtnum']); 
		  } else {
		     echo "Lone"; 
		  }	 
	?>
	&nbsp;District</A></SPAN></B>	
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR><TD WIDTH="10%">&nbsp;</TD>
			<TD ALIGN="left">	
			<?PHP while ($district_num == $municityrow['districtnum']) { ?>
			   	<SPAN CLASS="BROWSEBOXFONT">
			    	<A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$municityrow['municity_id']; ?>><?PHP echo $municityrow['municity']; ?></A>&nbsp;
				</SPAN> 
				<?PHP $municityrow = mysql_fetch_array($municity); ?>
				<?PHP if($district_num ==$municityrow['districtnum']) { ?>
				  ,&nbsp;
				<?PHP } ?>  
			<?PHP } ?>
			</TD>	
		</TR>
	</TABLE>	
<?PHP	
}
?>
<?PHP mysql_free_result($municity); ?>					
					</TD>
				</TR>
			</TABLE>
<!-- End of Browse Box -->
<BR>
<!-- Start of Provincial Fact Sheet Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#FFBBBB">						
					    <DIV ALIGN="center"><B><?PHP echo $provincerow['provincename']; ?><BR>Fact Sheet</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<SPAN CLASS="FACTSHEETFONT">
<?PHP if (!empty($provincerow['capital'])) { ?>		
<I><B>Capital:</B></I>&nbsp;<?PHP echo $provincerow['capital']; ?><BR>
<?PHP } ?>
<?PHP if ($provincerow['landarea'] <> 0) { ?>
<I><B>Land Area (square km.):</B></I>&nbsp;<?PHP echo number_format($provincerow['landarea']); ?><BR>	
<?PHP } ?>
<?PHP if ($provincerow['numbarangays'] <> 0) { ?>
<I><B>No. of Barangays:</B></I>&nbsp;<?PHP echo number_format($provincerow['numbarangays']); ?><BR>			
<?PHP } ?>
<?PHP if ($provincerow['nummaleregvoters'] <> 0) { ?>
<I><B>No. of Male Registered Voters:</B></I>&nbsp;<?PHP echo number_format($provincerow['nummaleregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($provincerow['numfemaleregvoters'] <> 0) { ?>
<I><B>No. of Female Registered Voters:</B></I>&nbsp;<?PHP echo number_format($provincerow['numfemaleregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($provincerow['numregvoters'] <> 0) { ?>
<I><B>No. of Registered Voters:</B></I>&nbsp;<?PHP echo number_format($provincerow['numregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($provincerow['numactualvoters'] <> 0) { ?>
<I><B>No. of Actual Voters:</B></I>&nbsp;<?PHP echo number_format($provincerow['numactualvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($provincerow['numprecincts'] <> 0) { ?>
<I><B>No. of Precincts:</B></I>&nbsp;<?PHP echo number_format($provincerow['numprecincts']); ?><BR>							
<?PHP } ?>
<?PHP if (strlen(trim($provincerow['factsheet'])) <> 0) { ?>
<I><B>Others:</B></I><BR></SPAN> 
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="2%">&nbsp;</TD>
	<TD><SPAN CLASS="RIGHTBOXFONT">	<?PHP echo $provincerow['factsheet']; ?></SPAN></TD>
</TR>
</TABLE>
<?PHP } ?>				
					</TD>
				</TR>
			</TABLE>
<!-- End of Provincial Fact Sheet Box -->
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
		<B>NEWS, EVENTS AND ACTIVITIES OF <?PHP echo strtoupper($provincerow['provincename']); ?></B>	
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
		<B><?PHP echo strtoupper($provincerow['provincename']); ?>&nbsp;GOVERNOR</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Governor Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Governor</H2>
<?PHP
$governorrow = mysql_fetch_array($governors);	
?>
<DIV ALIGN="center">
<?PHP if ($governorrow['governor_id'] <> 0) { ?>
	<A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['governor_id']; ?>>
		Gov. <?PHP echo $governorrow['firstname']; ?>
	<?PHP if(!empty($governorrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $governorrow['middleinitial'].". "; ?>
	<?PHP } ?>
	<?PHP echo $governorrow['lastname']; ?>
	</A>   
<?PHP } ?>
<BR>
</DIV>
<BR>
<?PHP mysql_free_result($governors); ?>
<?PHP if ($numcandgovernors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandgovernors > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candgovernorsrow = mysql_fetch_array($candgovernors);
while ($candgovernorsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorsrow['governor_id']; ?>>
<?PHP echo $candgovernorsrow['lastname'].", ".$candgovernorsrow['firstname'] ?>	
<?PHP if(!empty($candgovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candgovernorsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candgovernorsrow['party_id']; ?>>
       <?PHP 
	   		if (!empty($candgovernorsrow['acronym'])) {
	   	   		echo $candgovernorsrow['acronym'];
			} else {
			    echo $candgovernorsrow['partyname'];
			}	 
	   ?>
	</A></TD>
</TR>
<?PHP $candgovernorsrow = mysql_fetch_array($candgovernors); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candgovernors); ?>
</TABLE>
<?PHP if ($provincerow['is_dispgovresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/candgovernorlist.php?provinceid=".$provinceid; ?>><B><I>Election Results...</I></B></A></DIV>
<?PHP } ?>
<BR>
<!-- End of Governor Content -->	
		</TD>
	</TR>
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B><?PHP echo strtoupper($provincerow['provincename']); ?>&nbsp;VICE GOVERNOR</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Vice Governor Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Vice Governor</H2>
<?PHP
$vicegovernorrow = mysql_fetch_array($vicegovernors);	
?>
<DIV ALIGN="center">
<?PHP if ($vicegovernorrow['vicegovernor_id'] <> 0) { ?>
	<A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['vicegovernor_id']; ?>>
		Vice Gov. <?PHP echo $vicegovernorrow['firstname']; ?>	
	<?PHP if(!empty($vicegovernorrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicegovernorrow['middleinitial'].". "; ?>
	<?PHP } ?>
	<?PHP echo $vicegovernorrow['lastname']; ?>
	</A>
<?PHP } ?>	    
<BR>
</DIV>
<BR>
<?PHP mysql_free_result($vicegovernors); ?>
<?PHP if ($numcandvicegovernors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Vice Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandvicegovernors > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candvicegovernorsrow = mysql_fetch_array($candvicegovernors);
while ($candvicegovernorsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorsrow['vicegovernor_id']; ?>>
<?PHP echo $candvicegovernorsrow['lastname'].", ".$candvicegovernorsrow['firstname'] ?>	
<?PHP if(!empty($candvicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicegovernorsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candvicegovernorsrow['party_id']; ?>>
       <?PHP 
	      if (!empty($candvicegovernorsrow['acronym'])) {
		  	echo $candvicegovernorsrow['acronym']; 
		  } else {
		    echo $candvicegovernorsrow['partyname']; 
		  }	
	   ?>
	</A></TD>
</TR>
<?PHP $candvicegovernorsrow = mysql_fetch_array($candvicegovernors); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candvicegovernors); ?>
</TABLE>
<?PHP if ($provincerow['is_dispvicegovresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/candvicegovernorlist.php?provinceid=".$provinceid; ?>><B><I>Election Results...</I></B></A></DIV>
<?PHP } ?>
<BR>
<!-- End of Vice Governor Content -->	
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
$polpartiesrow = mysql_fetch_array($natpolparties);
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
<?PHP $polpartiesrow = mysql_fetch_array($natpolparties); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($natpolparties); ?>	
<?PHP if($numregpolparties > 0) { ?>
	<DIV ALIGN="left"><B>Provincial:</B></DIV>					
<?PHP } ?>
<?PHP
$polpartiesrow = mysql_fetch_array($regpolparties);
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
<?PHP $polpartiesrow = mysql_fetch_array($regpolparties); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($regpolparties); ?>					
					</TD>
				</TR>
			</TABLE>
<!-- End of Political Parties Box -->
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
