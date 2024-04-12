<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candrepresentatives.lastname As lastname, candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial,
   candrepresentatives.picturelocation As pictureloc, date_format(candrepresentatives.birthdate,'%M %e, %Y') As birthdate, candrepresentatives.educattainment As educattainment,
   candrepresentatives.accomplishments As accomplishments, candrepresentatives.platform As platform, candrepresentatives.workexperiences As workexperiences,
   candrepresentatives.familyinfo As familyinfo, candrepresentatives.biography As biography, candrepresentatives.birthplace As birthplace, candrepresentatives.emailaddr As emailaddr,
   candrepresentatives.telnum As telnum, candrepresentatives.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candrepresentatives.birthdate) As age, candrepresentatives.programofgovt As programofgovt,
   candrepresentatives.standonissues As standonissues, candrepresentatives.nickname As nickname, candrepresentatives.adpaidby As adpaidby, candrepresentatives.activities 
  FROM candrepresentatives
  WHERE (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$candrepresentatives = getqueryresults($query);
$candrepresentativesrow = mysql_fetch_array($candrepresentatives);
$candrepresentativesrow = slashstripper($candrepresentativesrow);

$query = "SELECT legdistricts.dist_num As districtnum, provinces.name As province, provinces.province_id As province_id, legdistricts.legdist_id As legdist_id
  FROM candrepresentatives, legdistricts, provinces
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = candrepresentatives.legdist_id) AND (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$provlegdist = getqueryresults($query);

$query = "SELECT legdistricts.dist_num As districtnum, nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id, legdistricts.legdist_id As legdist_id
  FROM candrepresentatives, legdistricts, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = legdistricts.ncrmunicity_id) AND (legdistricts.legdist_id = candrepresentatives.legdist_id) AND (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$ncrlegdist = getqueryresults($query);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM candrepresentatives, coalitions
  WHERE (coalitions.coalition_id = candrepresentatives.coalition_id) AND (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candrepresentatives, party
  WHERE (party.party_id = candrepresentatives.party_id) AND (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$candrepresentativesparty = getqueryresults($query);
$candrepresentativespartyrow = mysql_fetch_array($candrepresentativesparty);

if (mysql_num_rows($provlegdist) > 0) { 
	$legdistrow = mysql_fetch_array($provlegdist);

	$query = "SELECT legdistricts.dist_num As dist_num
		FROM legdistricts 
 		WHERE (legdistricts.province_id = ".$legdistrow['province_id'].") 
		ORDER BY legdistricts.dist_num";
	$districtcount = getqueryresults($query);	
	$numdistricts = mysql_num_rows($districtcount);
	mysql_free_result($districtcount);
	
	if ($numdistricts == 1) {
		$legdistarea = "Lone District of ";
	} else { 
		$legdistarea = numtoordinal($legdistrow['districtnum'])." District of ";
	}	
	$legdistarea = $legdistarea.$legdistrow['province'];
	$isprovince = 'Y';
	$legdistid = $legdistrow['legdist_id'];
} else if (mysql_num_rows($ncrlegdist) > 0) {
	$legdistrow = mysql_fetch_array($ncrlegdist);

	$query = "SELECT legdistricts.dist_num As dist_num
		FROM legdistricts 
 		WHERE (legdistricts.ncrmunicity_id = ".$legdistrow['municity_id'].") 
		ORDER BY legdistricts.dist_num";
	$districtcount = getqueryresults($query);	
	$numdistricts = mysql_num_rows($districtcount);
	mysql_free_result($districtcount);
	
	if ($numdistricts == 1) {
		$legdistarea = "Lone District of ";
	} else { 
		$legdistarea = numtoordinal($legdistrow['districtnum'])." District of ";
	}	
	$legdistarea = $legdistarea.$legdistrow['municity'];
	$isprovince = 'N';  
	$legdistid = $legdistrow['legdist_id'];
} else {
	if (!empty($candrepresentativespartyrow['acronym'])) {
    	$legdistarea = $candrepresentativespartyrow['acronym'];	
	} else {
    	$legdistarea = $candrepresentativespartyrow['partyname'];		
	}
	$isprovince = 'N/A';  
	$legdistid = $candrepresentativespartyrow['party_id'];
}


$query = "SELECT civilstatus.status As status
          FROM civilstatus, candrepresentatives
		  WHERE (candrepresentatives.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$candrepcivilstatus = getqueryresults($query);
$candrepcivilstatrow = mysql_fetch_array($candrepcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candrepresentatives, links
  WHERE (candrepresentatives.representative_id = links.candrepresentative_id) AND (candrepresentatives.representative_id = ".$candrepresentativeid.")";
$candrepresentativeslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : House of Representatives Candidate <?PHP echo $candrepresentativesrow['firstname']; ?>	
<?PHP if(!empty($candrepresentativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candrepresentativesrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candrepresentativesrow['lastname']; ?>
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
<A HREF="/vote/byposition.php"><B>By Position</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<A HREF="/vote/candrepresentativeslist.php"><B>House of Representatives Candidates</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $candrepresentativesrow['firstname']; ?>	
<?PHP if(!empty($candrepresentativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candrepresentativesrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candrepresentativesrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
&nbsp;<?PHP echo strtoupper($candrepresentativesrow['firstname']); ?>	
<?PHP if(!empty($candrepresentativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candrepresentativesrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candrepresentativesrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candrepresentativesrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candrepresentativesrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candrepresentativespartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candrepresentativespartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candrepresentativespartyrow['acronym'])) { 
		    	echo $candrepresentativespartyrow['acronym']; 
			} else { 
			    echo $candrepresentativespartyrow['partyname']; 
			}	
		?>
		</A><BR>
<?PHP } ?>

<?PHP if ($coalitionrow['coalition_id'] <> 0) { ?>
	<B>Coalition:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/coalitiondet.php?coalitionid=".$coalitionrow['coalition_id']; ?>>
 		<?PHP 
			if (!empty($coalitionrow['acronym'])) { 
		    	echo $coalitionrow['acronym']; 
			} else { 
			    echo $coalitionrow['coalitionname']; 
			}	
		?>
		</A><BR>
<?PHP } ?>

<B>Legislative District:</B>&nbsp;&nbsp;
<A HREF=
<?PHP  
	if ($isprovince == 'Y') {
    	echo "/vote/legdistdet.php?legdistid=".$legdistid;
	} else if ($isprovince == 'N') {
		echo "/vote/ncrlegdistdet.php?legdistid=".$legdistid;
	} else {
		echo "/vote/partydet.php?partyid=".$legdistid;	
	} 
?>><?PHP echo $legdistarea; ?></A><BR>

<?PHP if (!empty($candrepresentativesrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($candrepcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candrepcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candrepresentativesrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candrepresentativesrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candrepresentativesrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candrepresentativesrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candrepresentativesrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candrepresentativesrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candrepresentativesrow['emailaddr']; ?>><?PHP echo $candrepresentativesrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candrepresentativesrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candrepresentativesrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candrepresentativesrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candrepresentativesrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candrepresentativesrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candrepresentativeslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candrepresentativeslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candrepresentativesrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candrepresentativesrow['adpaidby']; ?></SPAN>
<?PHP } ?>
<!--- End Body of Information -->	
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
