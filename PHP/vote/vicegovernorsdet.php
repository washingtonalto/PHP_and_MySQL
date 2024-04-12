<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT vicegovernors.lastname As lastname, vicegovernors.firstname As firstname, vicegovernors.middleinitial As middleinitial,
   vicegovernors.picturelocation As pictureloc, date_format(vicegovernors.birthdate,'%M %e, %Y') As birthdate, vicegovernors.educattainment As educattainment,
   vicegovernors.accomplishments As accomplishments, vicegovernors.platform As platform, vicegovernors.workexperiences As workexperiences,
   vicegovernors.familyinfo As familyinfo, vicegovernors.biography As biography, vicegovernors.birthplace As birthplace, vicegovernors.emailaddr As emailaddr,
   vicegovernors.telnum As telnum, vicegovernors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(vicegovernors.birthdate) As age, vicegovernors.programofgovt As programofgovt,
   vicegovernors.standonissues As standonissues, vicegovernors.nickname As nickname, vicegovernors.activities 
  FROM vicegovernors
  WHERE (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$vicegovernors = getqueryresults($query);
$vicegovernorsrow = mysql_fetch_array($vicegovernors);
$vicegovernorsrow = slashstripper($vicegovernorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id
  FROM vicegovernors, provinces
  WHERE (vicegovernors.province_id = provinces.province_id) AND (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM vicegovernors, coalitions
  WHERE (coalitions.coalition_id = vicegovernors.coalition_id) AND (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM vicegovernors, party
  WHERE (party.party_id = vicegovernors.party_id) AND (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$vicegovernorparty = getqueryresults($query);
$vicegovernorspartyrow = mysql_fetch_array($vicegovernorparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, vicegovernors
		  WHERE (vicegovernors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$vgovcivilstatus = getqueryresults($query);
$vgovcivilstatrow = mysql_fetch_array($vgovcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM vicegovernors, links
  WHERE (vicegovernors.vicegovernor_id = links.vicegovernor_id) AND (vicegovernors.vicegovernor_id = ".$vicegovernorid.")";
$vicegovernorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Vice Gov. <?PHP echo $vicegovernorsrow['firstname']; ?>	
<?PHP if(!empty($vicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicegovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicegovernorsrow['lastname']; ?>
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
<A HREF="vicegovernorlist.php"><B>Incumbent Vice Governors</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Vice Gov.&nbsp;<?PHP echo $vicegovernorsrow['firstname']; ?>	
<?PHP if(!empty($vicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicegovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicegovernorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
VICE GOVERNOR <?PHP echo strtoupper($vicegovernorsrow['firstname']); ?>	
<?PHP if(!empty($vicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($vicegovernorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($vicegovernorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($vicegovernorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$vicegovernorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($vicegovernorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$vicegovernorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($vicegovernorspartyrow['acronym'])) { 
		    	echo $vicegovernorspartyrow['acronym']; 
			} else { 
			    echo $vicegovernorspartyrow['partyname']; 
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

<?PHP if (!empty($vicegovernorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($vgovcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $vgovcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicegovernorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($vicegovernorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicegovernorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($vicegovernorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicegovernorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicegovernorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$vicegovernorsrow['emailaddr']; ?>><?PHP echo $vicegovernorsrow['emailaddr']; ?></A><BR>
<?PHP } ?> 		

<?PHP if($vicegovernorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicegovernorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicegovernorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicegovernorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicegovernorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($vicegovernorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($vicegovernorslink)) { ?>
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
