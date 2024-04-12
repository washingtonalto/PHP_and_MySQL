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

$query = "SELECT regions.regionname As region, provinces.province_id As province_id, legdistricts.legdist_id As legdist_id, provinces.name As province, legdistricts.dist_num As districtnum,
    legdistricts.is_disprepresults, legdistricts.is_dispprovresults, legdistricts.represultcomment, legdistricts.provresultcomment 
	FROM legdistricts,provinces,regions 
 	WHERE (regions.region_id = provinces.region_id) AND (legdistricts.province_id = provinces.province_id) AND (legdistricts.legdist_id = ".$legdistid.") 
	ORDER BY provinces.name, legdistricts.dist_num";
$legdistrict = getqueryresults($query);	
$legdistrow = mysql_fetch_array($legdistrict);

$query = "SELECT legdistricts.dist_num As dist_num
	FROM legdistricts 
 	WHERE (legdistricts.province_id = ".$legdistrow['province_id'].") 
	ORDER BY legdistricts.dist_num";
$districtcount = getqueryresults($query);	
$numdistricts = mysql_num_rows($districtcount);
mysql_free_result($districtcount);

$query = "SELECT municity.name as municityname,municity.municity_id As municity_id
	FROM municity,legdistricts
	WHERE (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.legdist_id = ".$legdistid.")
	ORDER BY municity.name";
$municity = getqueryresults($query);	

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
  WHERE (party.province_id = provinces.province_id) AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (provinces.province_id = ".$legdistrow['province_id'].")
  ORDER BY party.acronym,party.partyname";
$regpolparties = getqueryresults($query);
$numregpolparties = mysql_num_rows($regpolparties);

$query = "SELECT  representatives.representative_id As representative_id, YEAR(representatives.term_begin) As yearbegin,representatives.lastname As lastname,representatives.firstname As firstname,representatives.middleinitial As middleinitial
  FROM representatives
  WHERE YEAR(representatives.term_begin) = ".$repterm." AND (representatives.legdist_id = ".$legdistid.")  AND (representatives.is_deceased = 'N') AND (representatives.is_unfinishedterm = 'N')
  ORDER BY yearbegin,representatives.lastname";
$representatives = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As party, party.party_id As party_id, candrepresentatives.representative_id As representative_id, candrepresentatives.lastname As lastname,candrepresentatives.firstname As firstname,candrepresentatives.middleinitial As middleinitial
  FROM candrepresentatives, party
  WHERE (candrepresentatives.party_id = party.party_id) AND (candrepresentatives.legdist_id = ".$legdistid.")
  ORDER BY candrepresentatives.lastname";
$candrepresentatives = getqueryresults($query);
$numcandrepresentatives = mysql_num_rows($candrepresentatives);

$query = "SELECT  provboardmembers.provboardmember_id As provboardmember_id, YEAR(provboardmembers.term_begin) As yearbegin,provboardmembers.lastname As lastname,provboardmembers.firstname As firstname,provboardmembers.middleinitial As middleinitial
  FROM provboardmembers
  WHERE YEAR(provboardmembers.term_begin) = ".$provterm." AND (provboardmembers.legdist_id = ".$legdistid.") AND (provboardmembers.is_deceased = 'N') AND (provboardmembers.is_unfinishedterm = 'N')
  ORDER BY yearbegin,provboardmembers.lastname";
$provboardmem = getqueryresults($query);

$query = "SELECT  party.acronym As acronym, party.name As partyname, party.party_id As party_id, candboardmem.provboardmember_id As provboardmember_id, candboardmem.lastname As lastname,candboardmem.firstname As firstname,candboardmem.middleinitial As middleinitial
  FROM candboardmem, party
  WHERE (candboardmem.party_id = party.party_id) AND (candboardmem.legdist_id = ".$legdistid.")
  ORDER BY candboardmem.lastname";
$candprovboardmembers = getqueryresults($query);
$numcandprovboardmembers = mysql_num_rows($candprovboardmembers);

?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : 
<?PHP 
	if ($numdistricts == 1) { 
		echo "Lone District"; 
	} else {	
		echo numtoordinal($legdistrow['districtnum'])."&nbsp;District";
	}	 
?> of <?PHP echo $legdistrow['province']; ?></TITLE>
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
<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$legdistrow['province_id']; ?>><B><?PHP echo $legdistrow['region']; ?>&nbsp;-&nbsp;<?PHP echo $legdistrow['province']; ?></B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>
<?PHP 
	if ($numdistricts == 1) { 
		echo "Lone District"; 
	} else {	
		echo numtoordinal($legdistrow['districtnum'])."&nbsp;District";
	}	 
?>
</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30%" ALIGN="left" VALIGN="top">
<!---- Start of First Column of Content Table ---->
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
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR><TD WIDTH="10%">&nbsp;</TD>
			<TD ALIGN="left">
				<?PHP
					$municityrow = mysql_fetch_array($municity);
					while ($municityrow) {
				?>				
			   	<SPAN CLASS="BROWSEBOXFONT">
			    	<A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$municityrow['municity_id']; ?>><?PHP echo $municityrow['municityname']; ?></A>&nbsp;
				</SPAN> <BR>
				<?PHP $municityrow = mysql_fetch_array($municity); ?>
 
				<?PHP } ?>
			</TD>	
		</TR>
	</TABLE>	
<?PHP mysql_free_result($municity); ?>					
					</TD>
				</TR>
			</TABLE>
<!-- End of Browse Box -->
<!---- End of First Column of Content Table ---->
		</TD>
		<TD WIDTH="1%">&nbsp;</TD> 
		<!-- Second column defining space between first and third column -->
		<TD VALIGN="top" BGCOLOR="#FFFFFF">
<!---- Start of Third Column of Content Table ---->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD>&nbsp;</TD></TR>
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
<B>HOUSE REPRESENTATIVE <BR> 
(<?PHP 
	if ($numdistricts == 1) { 
		echo "Lone District"; 
	} else {	
		echo numtoordinal($legdistrow['districtnum'])."&nbsp;District";
	}	 
?> of <?PHP echo $legdistrow['province']; ?>)
</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Representatives Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Representative</H2>
<?PHP
$reprow = mysql_fetch_array($representatives);	
?>
<DIV ALIGN="center">
<?PHP if ($reprow['representative_id'] <> 0) { ?>
	<A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$reprow['representative_id']; ?>>
		Rep. <?PHP echo $reprow['firstname']; ?>	
	<?PHP if(!empty($reprow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $reprow['middleinitial'].". "; ?>
	<?PHP } ?>
	<?PHP echo $reprow['lastname']; ?>
	</A>
<?PHP } ?>	 
<BR>
</DIV>
<BR>
<?PHP mysql_free_result($representatives); ?>
<?PHP if ($numcandrepresentatives > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for House Representative</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandrepresentatives > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candrepresentativesrow = mysql_fetch_array($candrepresentatives);
while ($candrepresentativesrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativesrow['representative_id']; ?>>
<?PHP echo $candrepresentativesrow['lastname'].", ".$candrepresentativesrow['firstname'] ?>	
<?PHP if(!empty($candrepresentativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candrepresentativesrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candrepresentativesrow['party_id']; ?>>
    <?PHP if (!empty($candrepresentativesrow['acronym'])) { ?>  
        <?PHP echo $candrepresentativesrow['acronym']; ?>
	<?PHP } else { ?>
        <?PHP echo $candrepresentativesrow['party']; ?>	
	<?PHP } ?>	
	</A></TD>
</TR>
<?PHP $candrepresentativesrow = mysql_fetch_array($candrepresentatives); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candrepresentatives); ?>
</TABLE>
<?PHP if ($legdistrow['is_disprepresults'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/candrepresentativelist.php?legdistid=".$legdistid; ?>><B><I>Election Results...</I></B></A></DIV>	
<?PHP } ?>
<BR>
<!-- End of Representatives Content -->	
		</TD>
	</TR>
	<TR>
	    <TD HEIGHT="12" ALIGN="center" VALIGN="middle" BGCOLOR="#E6E6E6">	
		<B>PROVINCIAL BOARD MEMBERS</B>	
		</TD>
	</TR>	
	<TR>
		<TD VALIGN="top">		
<!-- Start of Provincial Board Members Content -->	
<BR>
<H2 CLASS="HIGHLIGHTS">Incumbent Board Members</H2>
<?PHP
while ($provboardmemrow = mysql_fetch_array($provboardmem)) { 	
?>
<DIV ALIGN="center">
<A HREF=<?PHP echo "/vote/provboardmemdet.php?provboardmemid=".$provboardmemrow['provboardmember_id']; ?>>
<?PHP echo $provboardmemrow['firstname']; ?>	
<?PHP if(!empty($provboardmemrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $provboardmemrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $provboardmemrow['lastname']; ?>
</A>	    
</DIV>
<?PHP } ?>
<BR>
<?PHP mysql_free_result($provboardmem); ?>
<?PHP if ($numcandprovboardmembers > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Provincial Board Members</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandprovboardmembers > 0) { ?>
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="left" VALIGN="top"><B>Party</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$candprovboardmemrow = mysql_fetch_array($candprovboardmembers);
while ($candprovboardmemrow) {
?>
<?PHP if ($ctr % 2 == 0) { ?>
	<TR BGCOLOR="#C5E0FE">
<?PHP } else { ?>
	<TR>
<?PHP } ?>
<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
<TD>
<A HREF=<?PHP echo "/vote/candboardmemdet.php?candprovboardmemid=".$candprovboardmemrow['provboardmember_id']; ?>>
<?PHP echo $candprovboardmemrow['lastname'].", ".$candprovboardmemrow['firstname'] ?>	
<?PHP if(!empty($candprovboardmemrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candprovboardmemrow['middleinitial']."."; ?>
<?PHP } ?>	    
</A>
</TD>
<TD><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candprovboardmemrow['party_id']; ?>>
       <?PHP
	        if (!empty($candprovboardmemrow['acronym'])) { 
	        	echo $candprovboardmemrow['acronym']; 
			} else {
			    echo $candprovboardmemrow['partyname'];
			}	
	   ?>
	</A></TD>
</TR>
<?PHP $candprovboardmemrow = mysql_fetch_array($candprovboardmembers); ?>
	
<?PHP 
} 
?>
<?PHP mysql_free_result($candprovboardmembers); ?>
</TABLE>
<?PHP if ($legdistrow['is_dispprovresults'] == "Y") { ?>
	<BR>
	<DIV ALIGN="RIGHT"><A HREF=<?PHP echo "/vote/electresults/candboardmemlist.php?legdistid=".$legdistid; ?>><B><I>Election Results...</I></B></A></DIV>			
<?PHP } ?>
<BR>
<!-- End of Provincial Board Members Content -->	
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
