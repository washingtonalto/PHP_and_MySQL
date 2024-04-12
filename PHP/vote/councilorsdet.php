<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT councilors.lastname As lastname, councilors.firstname As firstname, councilors.middleinitial As middleinitial,
   councilors.picturelocation As pictureloc, date_format(councilors.birthdate,'%M %e, %Y') As birthdate, councilors.educattainment As educattainment,
   councilors.accomplishments As accomplishments, councilors.platform As platform, councilors.workexperiences As workexperiences,
   councilors.familyinfo As familyinfo, councilors.biography As biography, councilors.birthplace As birthplace, councilors.emailaddr As emailaddr,
   councilors.telnum As telnum, councilors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(councilors.birthdate) As age, councilors.programofgovt As programofgovt,
   councilors.standonissues As standonissues, councilors.nickname As nickname, councilors.counlegdist, councilors.activities 
  FROM councilors
  WHERE (councilors.councilor_id = ".$councilorid.")";
$councilors = getqueryresults($query);
$councilorsrow = mysql_fetch_array($councilors);
$councilorsrow = slashstripper($councilorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id, municity.municity_id As municity_id, municity.name As municity
  FROM councilors, legdistricts, provinces, municity
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id) AND (municity.municity_id = councilors.municity_id) AND (councilors.councilor_id = ".$councilorid.")";
$provinces = getqueryresults($query);

$query = "SELECT nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id
  FROM councilors, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = councilors.ncrmunicity_id) AND (councilors.councilor_id = ".$councilorid.")";
$ncr = getqueryresults($query);

if (mysql_num_rows($provinces) > 0) {
	$provincerow = mysql_fetch_array($provinces); 
	$isprovince = 'Y';
} else {
	$ncrrow = mysql_fetch_array($ncr); 
	$isprovince = 'N';  
}

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM councilors, coalitions
  WHERE (coalitions.coalition_id = councilors.coalition_id) AND (councilors.councilor_id = ".$councilorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM councilors, party
  WHERE (party.party_id = councilors.party_id) AND (councilors.councilor_id = ".$councilorid.")";
$councilorsparty = getqueryresults($query);
$councilorspartyrow = mysql_fetch_array($councilorsparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, councilors
		  WHERE (councilors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (councilors.councilor_id = ".$councilorid.")";
$councivilstatus = getqueryresults($query);
$councivilstatrow = mysql_fetch_array($councivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM councilors, links
  WHERE (councilors.councilor_id = links.councilor_id) AND (councilors.councilor_id = ".$councilorid.")";
$councilorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Councilor <?PHP echo $councilorsrow['firstname']; ?>	
<?PHP if(!empty($councilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $councilorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $councilorsrow['lastname']; ?>
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
<A HREF="/vote/councilorlist.php"><B>Incumbent Councilors</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Councilor <?PHP echo $councilorsrow['firstname']; ?>	
<?PHP if(!empty($councilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $councilorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $councilorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
COUNCILOR&nbsp;<?PHP echo strtoupper($councilorsrow['firstname']); ?>	
<?PHP if(!empty($councilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($councilorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($councilorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($councilorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$councilorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($councilorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$councilorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($councilorspartyrow['acronym'])) { 
		    	echo $councilorspartyrow['acronym']; 
			} else { 
			    echo $councilorspartyrow['partyname']; 
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

<B>Municipality/City:</B>&nbsp;&nbsp;
<?PHP if ($isprovince == 'Y') { ?> 
	<A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provincerow['municity_id']; ?>>
	<?PHP echo $provincerow['municity']; ?>
	</A><BR>
<?PHP } else { ?>
	<A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrrow['municity_id']; ?>>
	<?PHP echo $ncrrow['municity']; ?>
	</A><BR>
<?PHP } ?>	
<?PHP if ($councilorsrow['counlegdist'] <> 0) { ?>
	<B>Councilor Legislative District:</B>&nbsp;&nbsp;<?PHP echo numtoordinal($councilorsrow['counlegdist']); ?><BR>
<?PHP } ?>
<?PHP if ($isprovince == 'Y') { ?> 
	<B>Province:</B>&nbsp;&nbsp;
	<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provincerow['province_id']; ?>>
	<?PHP echo $provincerow['province']; ?>
	</A><BR>
<?PHP } ?>

<?PHP if (!empty($councilorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($councivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $councivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($councilorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($councilorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($councilorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($councilorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $councilorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($councilorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$councilorsrow['emailaddr']; ?>><?PHP echo $councilorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($councilorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $councilorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $councilorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($councilorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $councilorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($councilorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($councilorslink)) { ?>
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
