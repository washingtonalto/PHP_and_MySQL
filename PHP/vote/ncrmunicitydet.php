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
$query = "SELECT  nationalcapitalregion.name As municityname, nationalcapitalregion.landarea As landarea, nationalcapitalregion.numbarangays As numbarangays, 
  nationalcapitalregion.nummaleregvoters As nummaleregvoters, nationalcapitalregion.numregvoters As numregvoters, nationalcapitalregion.numfemaleregvoters,
  nationalcapitalregion.numprecincts As numprecincts, nationalcapitalregion.factsheet As factsheet,
  nationalcapitalregion.is_maydispresult, nationalcapitalregion.is_vmaydispresult, nationalcapitalregion.is_coundispresult, nationalcapitalregion.mayresultcomment, 
  nationalcapitalregion.vmayresultcomment, nationalcapitalregion.counresultcomment, nationalcapitalregion.numactualvoters  
  FROM nationalcapitalregion
  WHERE nationalcapitalregion.municity_id = ".$municityid;
$ncrmunicity =  getqueryresults($query);
$ncrmunicityrow = mysql_fetch_array($ncrmunicity);

$query = "SELECT legdistricts.legdist_id As legdist_id,legdistricts.dist_num As districtnum
	FROM legdistricts
	WHERE legdistricts.ncrmunicity_id = ".$municityid."
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
  FROM party,party_type,nationalcapitalregion
  WHERE (party.ncrmunicity_id = nationalcapitalregion.municity_id) AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (party.ncrmunicity_id = ".$municityid.")
  ORDER BY party.acronym,party.partyname";
$regpolparties = getqueryresults($query);
$numregpolparties = mysql_num_rows($regpolparties);

$query = "SELECT  mayors.mayor_id As mayor_id, YEAR(mayors.term_begin) As yearbegin,mayors.lastname As lastname,mayors.firstname As firstname,mayors.middleinitial As middleinitial
  FROM mayors
  WHERE YEAR(mayors.term_begin) = ".$mayterm." AND (mayors.ncrmunicity_id = ".$municityid.")  AND (mayors.is_deceased = 'N') AND (mayors.is_unfinishedterm = 'N')
  ORDER BY yearbegin,mayors.lastname";
$mayors = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candmayors.mayor_id As mayor_id, candmayors.lastname As lastname,candmayors.firstname As firstname,candmayors.middleinitial As middleinitial
  FROM candmayors, party
  WHERE (candmayors.party_id = party.party_id) AND (candmayors.ncrmunicity_id = ".$municityid.")
  ORDER BY candmayors.lastname";
$candmayors = getqueryresults($query);
$numcandmayors = mysql_num_rows($candmayors);

$query = "SELECT  vicemayors.vicemayor_id As vicemayor_id, YEAR(vicemayors.term_begin) As yearbegin,vicemayors.lastname As lastname,vicemayors.firstname As firstname,vicemayors.middleinitial As middleinitial
  	FROM vicemayors
  	WHERE YEAR(vicemayors.term_begin) = ".$vmayterm." AND (vicemayors.ncrmunicity_id = ".$municityid.")  AND (vicemayors.is_deceased = 'N') AND (vicemayors.is_unfinishedterm = 'N')
  	ORDER BY yearbegin,vicemayors.lastname";
$vicemayors = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candvicemayors.vicemayor_id As vicemayor_id, candvicemayors.lastname As lastname,candvicemayors.firstname As firstname,candvicemayors.middleinitial As middleinitial
  FROM candvicemayors, party
  WHERE (candvicemayors.party_id = party.party_id) AND (candvicemayors.ncrmunicity_id = ".$municityid.")
  ORDER BY candvicemayors.lastname";
$candvicemayors = getqueryresults($query);
$numcandvicemayors = mysql_num_rows($candvicemayors);

$query = "SELECT  councilors.councilor_id As councilor_id, YEAR(councilors.term_begin) As yearbegin,councilors.lastname As lastname,councilors.firstname As firstname,councilors.middleinitial As middleinitial
  FROM councilors
  WHERE YEAR(councilors.term_begin) = ".$counterm." AND (councilors.ncrmunicity_id = ".$municityid.")
  ORDER BY yearbegin,councilors.lastname";
$councilors = getqueryresults($query);
$numcouncilors = mysql_num_rows($councilors);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candcouncilors.councilor_id As councilor_id, candcouncilors.lastname As lastname,candcouncilors.firstname As firstname,candcouncilors.middleinitial As middleinitial
  FROM candcouncilors, party
  WHERE (candcouncilors.party_id = party.party_id) AND (candcouncilors.ncrmunicity_id = ".$municityid.")
  ORDER BY candcouncilors.lastname";
$candcouncilors = getqueryresults($query);
$numcandcouncilors = mysql_num_rows($candcouncilors);

$query = "SELECT activities.activity_id As activity_id, DATE_FORMAT(activities.date,'%m/%d/%y') As date, party.acronym As acronym, activities.title As title, party.party_id As party_id
FROM activities, party, nationalcapitalregion
WHERE (activities.ncrmunicity_id = nationalcapitalregion.municity_id) AND (activities.date >= CURRENT_DATE) AND (activities.party_id = party.party_id) AND (nationalcapitalregion.municity_id = ".$municityid.")
ORDER BY activities.date, party.acronym, party.name";
$activities = getqueryresults($query);
$numactivities = mysql_num_rows($activities);

$query = "SELECT newsevents_id, title, source
FROM newsevents
WHERE (ncrmunicity_id = ".$municityid.") AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
ORDER BY end_date, start_date";
$newsevents = getqueryresults($query);
$numnewsevents = mysql_num_rows($newsevents);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : NCR - <?PHP echo $ncrmunicityrow['municityname']; ?></TITLE>
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
<B>NCR - <?PHP echo $ncrmunicityrow['municityname']; ?></B>
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
while ($legdistrictsrow = mysql_fetch_array($legdistricts)) {
?>
	<B><SPAN CLASS="BROWSEBOXHEADER"><A HREF=<?PHP echo "/vote/ncrlegdistdet.php?legdistid=".$legdistrictsrow['legdist_id']; ?>>
	<?PHP if ($numlegdistricts > 1) {
	         echo numtoordinal($legdistrictsrow['districtnum']); 
		  } else {
		     echo "Lone"; 
		  }	 
	?>
	&nbsp;District</A></SPAN></B><BR>	
<?PHP	
}
?>
<?PHP mysql_free_result($legdistricts); ?>						
					</TD>
				</TR>
			</TABLE>
<!-- End of Browse Box -->
<BR>
<!-- Start of Municipal/City Fact Sheet Box -->
			<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="2" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
				<TR>
					<TD ALIGN="center" VALIGN="middle" BGCOLOR="#FFBBBB">						
					    <DIV ALIGN="center"><B><?PHP echo $ncrmunicityrow['municityname']; ?><BR>Fact Sheet</B></DIV>
					</TD>
				</TR>
				<TR>	
					<TD>
<SPAN CLASS="FACTSHEETFONT">
<?PHP if ($ncrmunicityrow['landarea'] <> 0) { ?>		
<I><B>Land Area (square km.):</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['landarea']); ?><BR>	
<?PHP } ?>
<?PHP if ($ncrmunicityrow['numbarangays'] <> 0) { ?>
<I><B>No. of Barangays:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['numbarangays']); ?><BR>			
<?PHP } ?>
<?PHP if ($ncrmunicityrow['nummaleregvoters'] <> 0) { ?>
<I><B>No. of Male Registered Voters:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['nummaleregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($ncrmunicityrow['numfemaleregvoters'] <> 0) { ?>
<I><B>No. of Female Registered Voters:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['numfemaleregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($ncrmunicityrow['numregvoters'] <> 0) { ?>
<I><B>No. of Registered Voters:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['numregvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($ncrmunicityrow['numactualvoters'] <> 0) { ?>
<I><B>No. of Actual Voters:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['numactualvoters']); ?><BR>							
<?PHP } ?>
<?PHP if ($ncrmunicityrow['numprecincts'] <> 0) { ?>
<I><B>No. of Precincts:</B></I>&nbsp;<?PHP echo number_format($ncrmunicityrow['numprecincts']); ?><BR>							
<?PHP } ?>
<?PHP if (strlen(trim($ncrmunicityrow['factsheet'])) <> 0) { ?>
<I><B>Others:</B></I><BR></SPAN> 
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="2%">&nbsp;</TD>
	<TD><SPAN CLASS="RIGHTBOXFONT">	<?PHP echo $ncrmunicityrow['factsheet']; ?></SPAN></TD>
</TR>
</TABLE>					
<?PHP } ?>
					</TD>
				</TR>
			</TABLE>
<!-- End of Municipal/City Fact Sheet Box -->
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
		<B>NEWS, EVENTS AND ACTIVITIES OF <?PHP echo strtoupper($ncrmunicityrow['municityname']); ?></B>	
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
		<B><?PHP echo strtoupper($ncrmunicityrow['municityname']); ?>&nbsp;MAYOR</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Mayor Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Mayor</H2>
<?PHP
$mayorrow = mysql_fetch_array($mayors);	
?>
<DIV ALIGN="center">
<?PHP if ($mayorrow['mayor_id'] <> 0) { ?>
	<A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['mayor_id']; ?>>
		Mayor <?PHP echo $mayorrow['firstname']; ?>	
	<?PHP if(!empty($mayorrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $mayorrow['middleinitial']."."; ?>
	<?PHP } ?>
	<?PHP echo $mayorrow['lastname']; ?>
	</A>
<?PHP } ?>		    
<BR>
</DIV>
<BR>
<?PHP mysql_free_result($mayors); ?>
<?PHP if ($numcandmayors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Mayor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandmayors > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candmayorsrow = mysql_fetch_array($candmayors);
while ($candmayorsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorsrow['mayor_id']; ?>>
<?PHP echo $candmayorsrow['lastname'].", ".$candmayorsrow['firstname'] ?>	
<?PHP if(!empty($candmayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candmayorsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candmayorsrow['party_id']; ?>>
       <?PHP 
	       if (!empty($candmayorsrow['acronym'])) {
	       		echo $candmayorsrow['acronym'];
		   } else {
	       		echo $candmayorsrow['partyname'];		   
		   }		 
	   ?>
	</A></TD>
</TR>
<?PHP $candmayorsrow = mysql_fetch_array($candmayors); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candmayors); ?>
</TABLE>
<?PHP if ($ncrmunicityrow['is_maydispresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/ncrcandmayorlist.php?municityid=".$municityid; ?>><B><I>Election Results...</I></B></A></DIV>		
<?PHP } ?>
<BR>
<!-- End of Mayor Content -->	
		</TD>
	</TR>
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>VICE MAYOR OF <?PHP echo strtoupper($ncrmunicityrow['municityname']); ?> </B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Vice Mayor Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Vice Mayor</H2>
<?PHP
$vicemayorrow = mysql_fetch_array($vicemayors);	
?>
<DIV ALIGN="center">
<?PHP if ($vicemayorrow['vicemayor_id'] <> 0) { ?>
	<A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['vicemayor_id']; ?>>
		Vice Mayor&nbsp;<?PHP echo $vicemayorrow['firstname']; ?>	
	<?PHP if(!empty($vicemayorrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicemayorrow['middleinitial']."."; ?>
	<?PHP } ?>
	<?PHP echo $vicemayorrow['lastname']; ?>
	</A>
<?PHP } ?>		    
</DIV><BR>
<BR>
<?PHP mysql_free_result($vicemayors); ?>
<?PHP if ($numcandvicemayors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Vice Mayor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandvicemayors > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candvicemayorrow = mysql_fetch_array($candvicemayors);
while ($candvicemayorrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorrow['vicemayor_id']; ?>>
<?PHP echo $candvicemayorrow['lastname'].", ".$candvicemayorrow['firstname'] ?>	
<?PHP if(!empty($candvicemayorrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicemayorrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candvicemayorrow['party_id']; ?>>
      <?PHP
	      if (!empty($candvicemayorrow['acronym'])) { 
	      	echo $candvicemayorrow['acronym']; 
		  } else {
	      	echo $candvicemayorrow['partyname']; 
		  }	
	  ?>
	</A></TD>
</TR>
<?PHP $candvicemayorrow = mysql_fetch_array($candvicemayors); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candvicemayors); ?>
</TABLE>
<?PHP if ($ncrmunicityrow['is_vmaydispresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/ncrcandvicemayorlist.php?municityid=".$municityid; ?>><B><I>Election Results...</I></B></A></DIV>		
<?PHP } ?>
<BR>
<!-- End of Vice Mayor Content -->	
		</TD>
	</TR>					
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>COUNCILORS</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Councilors Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Councilors</H2>
<?PHP $numcouncilrows = ceil($numcouncilors/2); ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<?PHP
$ctr = 0;
$councilorsrow = mysql_fetch_array($councilors);
while ($councilorsrow) { 	
?>
<TD ALIGN="center">
<?PHP while ($ctr < $numcouncilrows) { ?>
	<A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorsrow['councilor_id']; ?>>
		<?PHP echo $councilorsrow['firstname']; ?>	
			<?PHP if(!empty($councilorsrow['middleinitial'])) { ?>
      		&nbsp;<?PHP echo $councilorsrow['middleinitial']."."; ?>
		<?PHP } ?>
		<?PHP echo $councilorsrow['lastname']; ?>
	</A><BR>	
	<?PHP 
		$ctr++;
		$councilorsrow = mysql_fetch_array($councilors);
	?>
<?PHP } ?>
<?PHP $ctr = 0; ?>	
</TD>
<?PHP } ?>
</TR>
</TABLE>
<BR>
<?PHP mysql_free_result($councilors); ?>
<?PHP if ($numcandcouncilors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Councilors</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandcouncilors > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candcouncilorsrow = mysql_fetch_array($candcouncilors);
while ($candcouncilorsrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorsrow['councilor_id']; ?>>
<?PHP echo $candcouncilorsrow['lastname'].", ".$candcouncilorsrow['firstname'] ?>	
<?PHP if(!empty($candcouncilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candcouncilorsrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candcouncilorsrow['party_id']; ?>>
       <?PHP 
	      if (!empty($candcouncilorsrow['acronym'])) {
	   		echo $candcouncilorsrow['acronym'];
		  } else {
	   		echo $candcouncilorsrow['partyname'];		  
		  }	 
	   ?>
	 </A></TD>
</TR>
<?PHP $candcouncilorsrow = mysql_fetch_array($candcouncilors); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candcouncilors); ?>
</TABLE>
<?PHP if ($ncrmunicityrow['is_coundispresult'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/ncrcandcouncilorlist.php?municityid=".$municityid; ?>><B><I>Election Results...</I></B></A></DIV>		
<?PHP } ?>
<BR>
<!-- End of Councilors Content -->	
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
	<DIV ALIGN="left"><B>City/Municipal:</B></DIV>					
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
