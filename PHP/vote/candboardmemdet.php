<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candboardmem.lastname As lastname, candboardmem.firstname As firstname, candboardmem.middleinitial As middleinitial,
   candboardmem.picturelocation As pictureloc, date_format(candboardmem.birthdate,'%M %e, %Y') As birthdate, candboardmem.educattainment As educattainment,
   candboardmem.accomplishments As accomplishments, candboardmem.platform As platform, candboardmem.workexperiences As workexperiences,
   candboardmem.familyinfo As familyinfo, candboardmem.biography As biography, candboardmem.birthplace As birthplace, candboardmem.emailaddr As emailaddr,
   candboardmem.telnum As telnum, candboardmem.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candboardmem.birthdate) As age, candboardmem.programofgovt As programofgovt,
   candboardmem.standonissues As standonissues, candboardmem.nickname As nickname, candboardmem.adpaidby As adpaidby, candboardmem.activities 
  FROM candboardmem
  WHERE (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
$candboardmem = getqueryresults($query);
$candboardmemrow = mysql_fetch_array($candboardmem);

$query = "SELECT legdistricts.dist_num As districtnum, provinces.name As province, provinces.province_id As province_id, legdistricts.legdist_id As legdist_id
  FROM candboardmem, legdistricts, provinces
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = candboardmem.legdist_id) AND (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
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
  FROM candboardmem, coalitions
  WHERE (coalitions.coalition_id = candboardmem.coalition_id) AND (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candboardmem, party
  WHERE (party.party_id = candboardmem.party_id) AND (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
$provboardmemberparty = getqueryresults($query);
$candboardmempartyrow = mysql_fetch_array($provboardmemberparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candboardmem
		  WHERE (candboardmem.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
$candboardcivilstatus = getqueryresults($query);
$candboardcivilstatrow = mysql_fetch_array($candboardcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candboardmem, links
  WHERE (candboardmem.provboardmember_id = links.provboardmember_id) AND (candboardmem.provboardmember_id = ".$candprovboardmemid.")";
$candboardmemlink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Provincial Board Member <?PHP echo $candboardmemrow['firstname']; ?>	
<?PHP if(!empty($candboardmemrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candboardmemrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candboardmemrow['lastname']; ?>
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
<A HREF="/vote/candprovboardmemlist.php"><B>Candidates for Provincial Board Member</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $candboardmemrow['firstname']; ?>	
<?PHP if(!empty($candboardmemrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candboardmemrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candboardmemrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
<?PHP echo strtoupper($candboardmemrow['firstname']); ?>	
<?PHP if(!empty($candboardmemrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candboardmemrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candboardmemrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candboardmemrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candboardmemrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candboardmempartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candboardmempartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candboardmempartyrow['acronym'])) { 
		    	echo $candboardmempartyrow['acronym']; 
			} else { 
			    echo $candboardmempartyrow['partyname']; 
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
<?PHP if (!empty($candboardmemrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['nickname']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candboardcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candboardcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candboardmemrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candboardmemrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candboardmemrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candboardmemrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candboardmemrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candboardmemrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candboardmemrow['emailaddr']; ?>><?PHP echo $candboardmemrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candboardmemrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>
	
<?PHP if($candboardmemrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candboardmemrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candboardmemrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candboardmemrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candboardmemrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candboardmemlink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candboardmemlink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candboardmemrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candboardmemrow['adpaidby']; ?></SPAN>
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
