<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT vicemayors.lastname As lastname, vicemayors.firstname As firstname, vicemayors.middleinitial As middleinitial,
   vicemayors.picturelocation As pictureloc, date_format(vicemayors.birthdate,'%M %e, %Y') As birthdate, vicemayors.educattainment As educattainment,
   vicemayors.accomplishments As accomplishments, vicemayors.platform As platform, vicemayors.workexperiences As workexperiences,
   vicemayors.familyinfo As familyinfo, vicemayors.biography As biography, vicemayors.birthplace As birthplace, vicemayors.emailaddr As emailaddr,
   vicemayors.telnum As telnum, vicemayors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(vicemayors.birthdate) As age, vicemayors.programofgovt As programofgovt,
   vicemayors.standonissues As standonissues, vicemayors.nickname As nickname, vicemayors.activities 
  FROM vicemayors
  WHERE (vicemayors.vicemayor_id = ".$vicemayorid.")";
$vicemayors = getqueryresults($query);
$vicemayorsrow = mysql_fetch_array($vicemayors);
$vicemayorsrow = slashstripper($vicemayorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id, municity.municity_id As municity_id, municity.name As municity
  FROM vicemayors, legdistricts, provinces, municity
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id) AND (municity.municity_id = vicemayors.municity_id) AND (vicemayors.vicemayor_id = ".$vicemayorid.")";
$provinces = getqueryresults($query);

$query = "SELECT nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id
  FROM vicemayors, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = vicemayors.ncrmunicity_id) AND (vicemayors.vicemayor_id = ".$vicemayorid.")";
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
  FROM vicemayors, coalitions
  WHERE (coalitions.coalition_id = vicemayors.coalition_id) AND (vicemayors.vicemayor_id = ".$vicemayorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM vicemayors, party
  WHERE (party.party_id = vicemayors.party_id) AND (vicemayors.vicemayor_id = ".$vicemayorid.")";
$vicemayorsparty = getqueryresults($query);
$vicemayorspartyrow = mysql_fetch_array($vicemayorsparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, vicemayors
		  WHERE (vicemayors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (vicemayors.vicemayor_id = ".$vicemayorid.")";
$vmaycivilstatus = getqueryresults($query);
$vmaycivilstatrow = mysql_fetch_array($vmaycivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM vicemayors, links
  WHERE (vicemayors.vicemayor_id = links.vicemayor_id) AND (vicemayors.vicemayor_id = ".$vicemayorid.")";
$vicemayorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Vice Mayor <?PHP echo $vicemayorsrow['firstname']; ?>	
<?PHP if(!empty($vicemayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicemayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicemayorsrow['lastname']; ?>
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
<A HREF="/vote/vicemayorlist.php"><B>Incumbent Vice Mayors</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Vice Mayor <?PHP echo $vicemayorsrow['firstname']; ?>	
<?PHP if(!empty($vicemayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicemayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicemayorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
VICE MAYOR&nbsp;<?PHP echo strtoupper($vicemayorsrow['firstname']); ?>	
<?PHP if(!empty($vicemayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($vicemayorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($vicemayorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($vicemayorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$vicemayorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($vicemayorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$vicemayorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($vicemayorspartyrow['acronym'])) { 
		    	echo $vicemayorspartyrow['acronym']; 
			} else { 
			    echo $vicemayorspartyrow['partyname']; 
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
<?PHP if ($isprovince == 'Y') { ?> 
	<B>Province:</B>&nbsp;&nbsp;
	<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provincerow['province_id']; ?>>
	<?PHP echo $provincerow['province']; ?>
	</A><BR>
<?PHP } ?>

<?PHP if (!empty($vicemayorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($vicemayorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($vmaycivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $vmaycivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicemayorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicemayorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($vicemayorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicemayorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicemayorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$vicemayorsrow['emailaddr']; ?>><?PHP echo $vicemayorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($vicemayorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicemayorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicemayorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicemayorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicemayorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($vicemayorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($vicemayorslink)) { ?>
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
