<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT mayors.lastname As lastname, mayors.firstname As firstname, mayors.middleinitial As middleinitial,
   mayors.picturelocation As pictureloc, date_format(mayors.birthdate,'%M %e, %Y') As birthdate, mayors.educattainment As educattainment,
   mayors.accomplishments As accomplishments, mayors.platform As platform, mayors.workexperiences As workexperiences,
   mayors.familyinfo As familyinfo, mayors.biography As biography, mayors.birthplace As birthplace, mayors.emailaddr As emailaddr,
   mayors.telnum As telnum, mayors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(mayors.birthdate) As age, mayors.programofgovt As programofgovt,
   mayors.standonissues As standonissues, mayors.nickname As nickname, mayors.activities 
  FROM mayors
  WHERE (mayors.mayor_id = ".$mayorid.")";
$mayors = getqueryresults($query);
$mayorsrow = mysql_fetch_array($mayors);
$mayorsrow = slashstripper($mayorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id, municity.municity_id As municity_id, municity.name As municity
  FROM mayors, legdistricts, provinces, municity
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id) AND (municity.municity_id = mayors.municity_id) AND (mayors.mayor_id = ".$mayorid.")";
$provinces = getqueryresults($query);

$query = "SELECT nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id
  FROM mayors, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = mayors.ncrmunicity_id) AND (mayors.mayor_id = ".$mayorid.")";
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
  FROM mayors, coalitions
  WHERE (coalitions.coalition_id = mayors.coalition_id) AND (mayors.mayor_id = ".$mayorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM mayors, party
  WHERE (party.party_id = mayors.party_id) AND (mayors.mayor_id = ".$mayorid.")";
$mayorsparty = getqueryresults($query);
$mayorspartyrow = mysql_fetch_array($mayorsparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, mayors
		  WHERE (mayors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (mayors.mayor_id = ".$mayorid.")";
$maycivilstatus = getqueryresults($query);
$maycivilstatrow = mysql_fetch_array($maycivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM mayors, links
  WHERE (mayors.mayor_id = links.mayor_id) AND (mayors.mayor_id = ".$mayorid.")";
$mayorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Mayor <?PHP echo $mayorsrow['firstname']; ?>	
<?PHP if(!empty($mayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $mayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $mayorsrow['lastname']; ?>
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
<A HREF="/vote/mayorlist.php"><B>Incumbent Mayors</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Mayor <?PHP echo $mayorsrow['firstname']; ?>	
<?PHP if(!empty($mayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $mayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $mayorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
MAYOR&nbsp;<?PHP echo strtoupper($mayorsrow['firstname']); ?>	
<?PHP if(!empty($mayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($mayorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($mayorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($mayorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$mayorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($mayorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$mayorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($mayorspartyrow['acronym'])) { 
		    	echo $mayorspartyrow['acronym']; 
			} else { 
			    echo $mayorspartyrow['partyname']; 
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

<?PHP if (!empty($mayorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $governorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($maycivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $maycivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($mayorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $mayorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $mayorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($mayorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $mayorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($mayorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $mayorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($mayorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $mayorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($mayorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$mayorsrow['emailaddr']; ?>><?PHP echo $mayorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($mayorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $mayorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $mayorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($mayorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $mayorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($mayorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($mayorslink)) { ?>
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
