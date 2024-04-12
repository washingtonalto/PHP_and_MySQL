<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT provboardmembers.lastname As lastname, provboardmembers.firstname As firstname, provboardmembers.middleinitial As middleinitial,
   provboardmembers.picturelocation As pictureloc, date_format(provboardmembers.birthdate,'%M %e, %Y') As birthdate, provboardmembers.educattainment As educattainment,
   provboardmembers.accomplishments As accomplishments, provboardmembers.platform As platform, provboardmembers.workexperiences As workexperiences,
   provboardmembers.familyinfo As familyinfo, provboardmembers.biography As biography, provboardmembers.birthplace As birthplace, provboardmembers.emailaddr As emailaddr,
   provboardmembers.telnum As telnum, provboardmembers.faxnum As faxnum, YEAR(CURDATE()) - YEAR(provboardmembers.birthdate) As age, provboardmembers.programofgovt As programofgovt,
   provboardmembers.standonissues As standonissues, provboardmembers.nickname As nickname, provboardmembers.activities 
  FROM provboardmembers
  WHERE (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$provboardmembers = getqueryresults($query);
$provboardmembersrow = mysql_fetch_array($provboardmembers);
$provboardmembersrow = slashstripper($provboardmembersrow);

$query = "SELECT legdistricts.dist_num As districtnum, provinces.name As province, provinces.province_id As province_id, legdistricts.legdist_id As legdist_id
  FROM provboardmembers, legdistricts, provinces
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = provboardmembers.legdist_id) AND (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$provlegdist = getqueryresults($query);

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

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM provboardmembers, coalitions
  WHERE (coalitions.coalition_id = provboardmembers.coalition_id) AND (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM provboardmembers, party
  WHERE (party.party_id = provboardmembers.party_id) AND (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$provboardmemberparty = getqueryresults($query);
$provboardmemberspartyrow = mysql_fetch_array($provboardmemberparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, provboardmembers
		  WHERE (provboardmembers.civilstatus_id = civilstatus.civilstatus_id) AND
		        (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$pboardcivilstatus = getqueryresults($query);
$pboardcivilstatrow = mysql_fetch_array($pboardcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM provboardmembers, links
  WHERE (provboardmembers.provboardmember_id = links.provboardmember_id) AND (provboardmembers.provboardmember_id = ".$provboardmemid.")";
$provboardmemberslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Provincial Board Member <?PHP echo $provboardmembersrow['firstname']; ?>	
<?PHP if(!empty($provboardmembersrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $provboardmembersrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $provboardmembersrow['lastname']; ?>
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
<A HREF="/vote/provboardmemlist.php"><B>Incumbent Provincial Board Member</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $provboardmembersrow['firstname']; ?>	
<?PHP if(!empty($provboardmembersrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $provboardmembersrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $provboardmembersrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
PROVINCIAL BOARD MEMBER <?PHP echo strtoupper($provboardmembersrow['firstname']); ?>	
<?PHP if(!empty($provboardmembersrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($provboardmembersrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($provboardmembersrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($provboardmembersrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$provboardmembersrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($provboardmemberspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$provboardmemberspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($provboardmemberspartyrow['acronym'])) { 
		    	echo $provboardmemberspartyrow['acronym']; 
			} else { 
			    echo $provboardmemberspartyrow['partyname']; 
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

<B>Legislative District:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/legdistdet.php?legdistid=".$legdistrow['legdist_id']; ?>><?PHP echo $legdistarea; ?>
</A><BR>

<?PHP if(!empty($provboardmembersrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($pboardcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $pboardcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($provboardmembersrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($provboardmembersrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($provboardmembersrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($provboardmembersrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $provboardmembersrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($provboardmembersrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$provboardmembersrow['emailaddr']; ?>><?PHP echo $provboardmembersrow['emailaddr']; ?></A><BR>
<?PHP } ?>
 		
<?PHP if($provboardmembersrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $provboardmembersrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $provboardmembersrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($provboardmembersrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $provboardmembersrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($provboardmemberslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($provboardmemberslink)) { ?>
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
