<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT representatives.lastname As lastname, representatives.firstname As firstname, representatives.middleinitial As middleinitial,
   representatives.picturelocation As pictureloc, date_format(representatives.birthdate,'%M %e, %Y') As birthdate, representatives.educattainment As educattainment,
   representatives.accomplishments As accomplishments, representatives.platform As platform, representatives.workexperiences As workexperiences,
   representatives.familyinfo As familyinfo, representatives.biography As biography, representatives.birthplace As birthplace, representatives.emailaddr As emailaddr,
   representatives.telnum As telnum, representatives.faxnum As faxnum, YEAR(CURDATE()) - YEAR(representatives.birthdate) As age, representatives.programofgovt As programofgovt,
   representatives.standonissues As standonissues, representatives.nickname As nickname, representatives.activities 
  FROM representatives
  WHERE (representatives.representative_id = ".$representativeid.")";
$representatives = getqueryresults($query);
$representativesrow = mysql_fetch_array($representatives);
$representativesrow = slashstripper($representativesrow);

$query = "SELECT legdistricts.dist_num As districtnum, provinces.name As province, provinces.province_id As province_id, legdistricts.legdist_id As legdist_id
  FROM representatives, legdistricts, provinces
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = representatives.legdist_id) AND (representatives.representative_id = ".$representativeid.")";
$provlegdist = getqueryresults($query);

$query = "SELECT legdistricts.dist_num As districtnum, nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id, legdistricts.legdist_id As legdist_id
  FROM representatives, legdistricts, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = legdistricts.ncrmunicity_id) AND (legdistricts.legdist_id = representatives.legdist_id) AND (representatives.representative_id = ".$representativeid.")";
$ncrlegdist = getqueryresults($query);

$query = "SELECT party.party_id As party_id, party.name As partylistname
  FROM representatives, party
  WHERE (party.party_id = representatives.party_id) AND (representatives.representative_id = ".$representativeid.")";
$partylist = getqueryresults($query);

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
} elseif (mysql_num_rows($ncrlegdist) > 0) {
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
	$legdistrow = mysql_fetch_array($partylist);
	
	$legdistarea = $legdistrow['partylistname'];
	$legdistid = $legdistrow['party_id'];	
	$isprovince = 'N/A';  	
}

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM representatives, coalitions
  WHERE (coalitions.coalition_id = representatives.coalition_id) AND (representatives.representative_id = ".$representativeid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM representatives, party
  WHERE (party.party_id = representatives.party_id) AND (representatives.representative_id = ".$representativeid.")";
$representativesparty = getqueryresults($query);
$representativespartyrow = mysql_fetch_array($representativesparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, representatives
		  WHERE (representatives.civilstatus_id = civilstatus.civilstatus_id) AND
		        (representatives.representative_id = ".$representativeid.")";
$repcivilstatus = getqueryresults($query);
$repcivilstatrow = mysql_fetch_array($repcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM representatives, links
  WHERE (representatives.representative_id = links.representative_id) AND (representatives.representative_id = ".$representativeid.")";
$representativeslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Rep. <?PHP echo $representativesrow['firstname']; ?>	
<?PHP if(!empty($representativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $representativesrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $representativesrow['lastname']; ?>
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
<A HREF="/vote/representativeslist.php"><B>Incumbent House Representatives</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Rep. <?PHP echo $representativesrow['firstname']; ?>	
<?PHP if(!empty($representativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $representativesrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $representativesrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
REP.&nbsp;<?PHP echo strtoupper($representativesrow['firstname']); ?>	
<?PHP if(!empty($representativesrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($representativesrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($representativesrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($representativesrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$representativesrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($representativespartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$representativespartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($representativespartyrow['acronym'])) { 
		    	echo $representativespartyrow['acronym']; 
			} else { 
			    echo $representativespartyrow['partyname']; 
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
	} elseif ($isprovince == 'N') {
	    echo "/vote/ncrlegdistdet.php?legdistid=".$legdistid;
	} else {
		echo "/vote/partydet.php?partyid=".$legdistid;
	}  
?>><?PHP echo $legdistarea; ?></A><BR>

<?PHP if (!empty($representativesrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($repcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $repcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($representativesrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($representativesrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($representativesrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($representativesrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $representativesrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($representativesrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$representativesrow['emailaddr']; ?>><?PHP echo $representativesrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($representativesrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>


<?PHP if($representativesrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $representativesrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $representativesrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($representativesrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $representativesrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($representativeslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($representativeslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
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
