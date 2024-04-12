<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candmayors.lastname As lastname, candmayors.firstname As firstname, candmayors.middleinitial As middleinitial,
   candmayors.picturelocation As pictureloc, date_format(candmayors.birthdate,'%M %e, %Y') As birthdate, candmayors.educattainment As educattainment,
   candmayors.accomplishments As accomplishments, candmayors.platform As platform, candmayors.workexperiences As workexperiences,
   candmayors.familyinfo As familyinfo, candmayors.biography As biography, candmayors.birthplace As birthplace, candmayors.emailaddr As emailaddr,
   candmayors.telnum As telnum, candmayors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candmayors.birthdate) As age, candmayors.programofgovt As programofgovt,
   candmayors.standonissues As standonissues, candmayors.nickname As nickname, candmayors.adpaidby As adpaidby, candmayors.activities 
  FROM candmayors
  WHERE (candmayors.mayor_id = ".$candmayorid.")";
$candmayors = getqueryresults($query);
$candmayorsrow = mysql_fetch_array($candmayors);
$candmayorsrow = slashstripper($candmayorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id, municity.municity_id As municity_id, municity.name As municity
  FROM candmayors, legdistricts, provinces, municity
  WHERE (provinces.province_id = legdistricts.province_id) AND (legdistricts.legdist_id = municity.legdist_id) AND (municity.municity_id = candmayors.municity_id) AND (candmayors.mayor_id = ".$candmayorid.")";
$provinces = getqueryresults($query);

$query = "SELECT nationalcapitalregion.name As municity, nationalcapitalregion.municity_id As municity_id
  FROM candmayors, nationalcapitalregion
  WHERE (nationalcapitalregion.municity_id = candmayors.ncrmunicity_id) AND (candmayors.mayor_id = ".$candmayorid.")";
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
  FROM candmayors, coalitions
  WHERE (coalitions.coalition_id = candmayors.coalition_id) AND (candmayors.mayor_id = ".$candmayorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candmayors, party
  WHERE (party.party_id = candmayors.party_id) AND (candmayors.mayor_id = ".$candmayorid.")";
$candmayorsparty = getqueryresults($query);
$candmayorspartyrow = mysql_fetch_array($candmayorsparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candmayors
		  WHERE (candmayors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candmayors.mayor_id = ".$candmayorid.")";
$candmaycivilstatus = getqueryresults($query);
$candmaycivilstatrow = mysql_fetch_array($candmaycivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candmayors, links
  WHERE (candmayors.mayor_id = links.candmayor_id) AND (candmayors.mayor_id = ".$candmayorid.")";
$candmayorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Mayor <?PHP echo $candmayorsrow['firstname']; ?>	
<?PHP if(!empty($candmayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candmayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candmayorsrow['lastname']; ?>
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
<A HREF="/vote/candmayorlist.php"><B>Candidates for Mayor</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $candmayorsrow['firstname']; ?>	
<?PHP if(!empty($candmayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candmayorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candmayorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
&nbsp;<?PHP echo strtoupper($candmayorsrow['firstname']); ?>	
<?PHP if(!empty($candmayorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candmayorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candmayorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candmayorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candmayorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candmayorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candmayorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candmayorspartyrow['acronym'])) { 
		    	echo $candmayorspartyrow['acronym']; 
			} else { 
			    echo $candmayorspartyrow['partyname']; 
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

<?PHP if (!empty($candmayorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($candmaycivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candmaycivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candmayorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candmayorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candmayorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candmayorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candmayorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candmayorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candmayorsrow['emailaddr']; ?>><?PHP echo $candmayorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candmayorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candmayorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candmayorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candmayorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candmayorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candmayorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candmayorslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candmayorsrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candmayorsrow['adpaidby']; ?></SPAN>
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
