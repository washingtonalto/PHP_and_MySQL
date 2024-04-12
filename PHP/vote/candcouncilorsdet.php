<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candcouncilors.lastname As lastname, candcouncilors.firstname As firstname, candcouncilors.middleinitial As middleinitial,
   candcouncilors.picturelocation As pictureloc, date_format(candcouncilors.birthdate,'%M %e, %Y') As birthdate, candcouncilors.educattainment As educattainment,
   candcouncilors.accomplishments As accomplishments, candcouncilors.platform As platform, candcouncilors.workexperiences As workexperiences,
   candcouncilors.familyinfo As familyinfo, candcouncilors.biography As biography, candcouncilors.birthplace As birthplace, candcouncilors.emailaddr As emailaddr,
   candcouncilors.telnum As telnum, candcouncilors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candcouncilors.birthdate) As age, candcouncilors.programofgovt As programofgovt,
   candcouncilors.standonissues As standonissues, candcouncilors.nickname As nickname, candcouncilors.adpaidby As adpaidby, candcouncilors.counlegdist, candcouncilors.activities
  FROM candcouncilors
  WHERE (candcouncilors.councilor_id = ".$candcouncilorid.")";
$candcouncilors = getqueryresults($query);
$candcouncilorsrow = mysql_fetch_array($candcouncilors);
$candcouncilorsrow = slashstripper($candcouncilorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id, municity.municity_id As municity_id, municity.name As municity
  FROM candcouncilors, legdistricts, provinces, municity
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id) AND (municity.municity_id = candcouncilors.municity_id) AND (candcouncilors.councilor_id = ".$candcouncilorid.")";
$provinces = getqueryresults($query);

$query = "SELECT nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id
  FROM candcouncilors, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = candcouncilors.ncrmunicity_id)  AND (candcouncilors.councilor_id = ".$candcouncilorid.")";
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
  FROM candcouncilors, coalitions
  WHERE (coalitions.coalition_id = candcouncilors.coalition_id) AND (candcouncilors.councilor_id = ".$candcouncilorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candcouncilors, party
  WHERE (party.party_id = candcouncilors.party_id) AND (candcouncilors.councilor_id = ".$candcouncilorid.")";
$candcouncilorsparty = getqueryresults($query);
$candcouncilorspartyrow = mysql_fetch_array($candcouncilorsparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candcouncilors
		  WHERE (candcouncilors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candcouncilors.councilor_id = ".$candcouncilorid.")";
$candcouncivilstatus = getqueryresults($query);
$candcouncivilstatrow = mysql_fetch_array($candcouncivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candcouncilors, links
  WHERE (candcouncilors.councilor_id = links.councilor_id) AND (candcouncilors.councilor_id = ".$candcouncilorid.")";
$candcouncilorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Councilor <?PHP echo $candcouncilorsrow['firstname']; ?>	
<?PHP if(!empty($candcouncilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candcouncilorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candcouncilorsrow['lastname']; ?>
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
<A HREF="/vote/candcouncilorlist.php"><B>Candidates for Councilor</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $candcouncilorsrow['firstname']; ?>	
<?PHP if(!empty($candcouncilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candcouncilorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candcouncilorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
&nbsp;<?PHP echo strtoupper($candcouncilorsrow['firstname']); ?>	
<?PHP if(!empty($candcouncilorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candcouncilorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candcouncilorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candcouncilorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candcouncilorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candcouncilorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candcouncilorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candcouncilorspartyrow['acronym'])) { 
		    	echo $candcouncilorspartyrow['acronym']; 
			} else { 
			    echo $candcouncilorspartyrow['partyname']; 
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
<?PHP if ($candcouncilorsrow['counlegdist'] <> 0) { ?>
	<B>Councilor Legislative District:</B>&nbsp;&nbsp;<?PHP echo numtoordinal($candcouncilorsrow['counlegdist']); ?><BR>
<?PHP } ?>
<?PHP if ($isprovince == 'Y') { ?> 
	<B>Province:</B>&nbsp;&nbsp;
	<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provincerow['province_id']; ?>>
	<?PHP echo $provincerow['province']; ?>
	</A><BR>

<?PHP } ?>

<?PHP if (!empty($candcouncilorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($candcouncivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candcouncivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candcouncilorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candcouncilorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candcouncilorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candcouncilorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candcouncilorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candcouncilorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candcouncilorsrow['emailaddr']; ?>><?PHP echo $candcouncilorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candcouncilorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candcouncilorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candcouncilorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candcouncilorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candcouncilorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candcouncilorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candcouncilorslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candcouncilorsrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candcouncilorsrow['adpaidby']; ?></SPAN>
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
 