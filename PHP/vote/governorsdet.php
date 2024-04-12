<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT governors.lastname As lastname, governors.firstname As firstname, governors.middleinitial As middleinitial,
   governors.picturelocation As pictureloc, date_format(governors.birthdate,'%M %e, %Y') As birthdate, governors.educattainment As educattainment,
   governors.accomplishments As accomplishments, governors.platform As platform, governors.workexperiences As workexperiences,
   governors.familyinfo As familyinfo, governors.biography As biography, governors.birthplace As birthplace, governors.emailaddr As emailaddr,
   governors.telnum As telnum, governors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(governors.birthdate) As age, governors.programofgovt As programofgovt,
   governors.standonissues As standonissues, governors.nickname As nickname, governors.activities 
  FROM governors
  WHERE (governors.governor_id = ".$governorid.")";
$governors = getqueryresults($query);
$governorsrow = mysql_fetch_array($governors);
$governorsrow = slashstripper($governorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id
  FROM governors, provinces
  WHERE (governors.province_id = provinces.province_id) AND (governors.governor_id = ".$governorid.")";
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM governors, coalitions
  WHERE (coalitions.coalition_id = governors.coalition_id) AND (governors.governor_id = ".$governorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM governors, party
  WHERE (party.party_id = governors.party_id) AND (governors.governor_id = ".$governorid.")";
$governorparty = getqueryresults($query);
$governorspartyrow = mysql_fetch_array($governorparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, governors
		  WHERE (governors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (governors.governor_id = ".$governorid.")";
$govcivilstatus = getqueryresults($query);
$govcivilstatrow = mysql_fetch_array($govcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM governors, links
  WHERE (governors.governor_id = links.governor_id) AND (governors.governor_id = ".$governorid.")";
$governorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Gov. <?PHP echo $governorsrow['firstname']; ?>	
<?PHP if(!empty($governorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $governorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $governorsrow['lastname']; ?>
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
<A HREF="governorlist.php"><B>Incumbent Governors</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Gov.&nbsp;<?PHP echo $governorsrow['firstname']; ?>	
<?PHP if(!empty($governorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $governorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $governorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
GOVERNOR <?PHP echo strtoupper($governorsrow['firstname']); ?>	
<?PHP if(!empty($governorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($governorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($governorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($governorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$governorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($governorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$governorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($governorspartyrow['acronym'])) { 
		    	echo $governorspartyrow['acronym']; 
			} else { 
			    echo $governorspartyrow['partyname']; 
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

<?PHP if (!empty($governorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($govcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $govcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($governorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($governorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($governorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($governorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($governorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$governorsrow['emailaddr']; ?>><?PHP echo $governorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>
 		
<?PHP if($governorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $governorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $governorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($governorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $governorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($governorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($governorslink)) { ?>
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
