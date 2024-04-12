<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candgovernors.lastname As lastname, candgovernors.firstname As firstname, candgovernors.middleinitial As middleinitial,
   candgovernors.picturelocation As pictureloc, date_format(candgovernors.birthdate,'%M %e, %Y') As birthdate, candgovernors.educattainment As educattainment,
   candgovernors.accomplishments As accomplishments, candgovernors.platform As platform, candgovernors.workexperiences As workexperiences,
   candgovernors.familyinfo As familyinfo, candgovernors.biography As biography, candgovernors.birthplace As birthplace, candgovernors.emailaddr As emailaddr,
   candgovernors.telnum As telnum, candgovernors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candgovernors.birthdate) As age, candgovernors.programofgovt As programofgovt,
   candgovernors.standonissues As standonissues, candgovernors.nickname As nickname, candgovernors.adpaidby As adpaidby, candgovernors.activities 
  FROM candgovernors
  WHERE (candgovernors.governor_id = ".$candgovernorid.")";
$candgovernors = getqueryresults($query);
$candgovernorsrow = mysql_fetch_array($candgovernors);
$candgovernorsrow = slashstripper($candgovernorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id
  FROM candgovernors, provinces
  WHERE (candgovernors.province_id = provinces.province_id) AND (candgovernors.governor_id = ".$candgovernorid.")";
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM candgovernors, coalitions
  WHERE (coalitions.coalition_id = candgovernors.coalition_id) AND (candgovernors.governor_id = ".$candgovernorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candgovernors, party
  WHERE (party.party_id = candgovernors.party_id) AND (candgovernors.governor_id = ".$candgovernorid.")";
$candgovernorparty = getqueryresults($query);
$candgovernorspartyrow = mysql_fetch_array($candgovernorparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candgovernors
		  WHERE (candgovernors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candgovernors.governor_id = ".$candgovernorid.")";
$candgovcivilstatus = getqueryresults($query);
$candgovcivilstatrow = mysql_fetch_array($candgovcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candgovernors, links
  WHERE (candgovernors.governor_id = links.candgovernor_id) AND (candgovernors.governor_id = ".$candgovernorid.")";
$candgovernorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Governor <?PHP echo $candgovernorsrow['firstname']; ?>	
<?PHP if(!empty($candgovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candgovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candgovernorsrow['lastname']; ?>
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
<A HREF="/vote/candgovernorlist.php"><B>Candidates for Governor</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>&nbsp;<?PHP echo $candgovernorsrow['firstname']; ?>	
<?PHP if(!empty($candgovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candgovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candgovernorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
<?PHP echo strtoupper($candgovernorsrow['firstname']); ?>	
<?PHP if(!empty($candgovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candgovernorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candgovernorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candgovernorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candgovernorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candgovernorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candgovernorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candgovernorspartyrow['acronym'])) { 
		    	echo $candgovernorspartyrow['acronym']; 
			} else { 
			    echo $candgovernorspartyrow['partyname']; 
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

<B>Province:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provincerow['province_id']; ?>>
<?PHP echo $provincerow['province']; ?>
</A><BR>

<?PHP if (!empty($candgovernorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($candgovcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candgovcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candgovernorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candgovernorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candgovernorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candgovernorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candgovernorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candgovernorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candgovernorsrow['emailaddr']; ?>><?PHP echo $candgovernorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candgovernorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candgovernorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candgovernorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candgovernorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candgovernorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candgovernorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candgovernorslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candgovernorsrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candgovernorsrow['adpaidby']; ?></SPAN>
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
