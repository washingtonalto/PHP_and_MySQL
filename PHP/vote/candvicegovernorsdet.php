<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candvicegovernors.lastname As lastname, candvicegovernors.firstname As firstname, candvicegovernors.middleinitial As middleinitial,
   candvicegovernors.picturelocation As pictureloc, date_format(candvicegovernors.birthdate,'%M %e, %Y') As birthdate, candvicegovernors.educattainment As educattainment,
   candvicegovernors.accomplishments As accomplishments, candvicegovernors.platform As platform, candvicegovernors.workexperiences As workexperiences,
   candvicegovernors.familyinfo As familyinfo, candvicegovernors.biography As biography, candvicegovernors.birthplace As birthplace, candvicegovernors.emailaddr As emailaddr,
   candvicegovernors.telnum As telnum, candvicegovernors.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candvicegovernors.birthdate) As age, candvicegovernors.programofgovt As programofgovt,
   candvicegovernors.standonissues As standonissues, candvicegovernors.nickname As nickname, candvicegovernors.adpaidby As adpaidby, candvicegovernors.activities 
  FROM candvicegovernors
  WHERE (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$candvicegovernors = getqueryresults($query);
$candvicegovernorsrow = mysql_fetch_array($candvicegovernors);
$candvicegovernorsrow = slashstripper($candvicegovernorsrow);

$query = "SELECT provinces.name As province, provinces.province_id As province_id
  FROM candvicegovernors, provinces
  WHERE (candvicegovernors.province_id = provinces.province_id) AND (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM candvicegovernors, coalitions
  WHERE (coalitions.coalition_id = candvicegovernors.coalition_id) AND (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candvicegovernors, party
  WHERE (party.party_id = candvicegovernors.party_id) AND (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$candvicegovernorparty = getqueryresults($query);
$candvicegovernorspartyrow = mysql_fetch_array($candvicegovernorparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candvicegovernors
		  WHERE (candvicegovernors.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$candvgovcivilstatus = getqueryresults($query);
$candvgovcivilstatrow = mysql_fetch_array($candvgovcivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candvicegovernors, links
  WHERE (candvicegovernors.vicegovernor_id = links.candvicegovernor_id) AND (candvicegovernors.vicegovernor_id = ".$candvicegovernorid.")";
$candvicegovernorslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Vice Governor <?PHP echo $candvicegovernorsrow['firstname']; ?>	
<?PHP if(!empty($candvicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicegovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candvicegovernorsrow['lastname']; ?>
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
<A HREF="/vote/candvicegovernorlist.php"><B>Candidates for Vice Governor</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>&nbsp;<?PHP echo $candvicegovernorsrow['firstname']; ?>	
<?PHP if(!empty($candvicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicegovernorsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candvicegovernorsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
<?PHP echo strtoupper($candvicegovernorsrow['firstname']); ?>	
<?PHP if(!empty($candvicegovernorsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candvicegovernorsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candvicegovernorsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candvicegovernorsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candvicegovernorsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candvicegovernorspartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candvicegovernorspartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candvicegovernorspartyrow['acronym'])) { 
		    	echo $candvicegovernorspartyrow['acronym']; 
			} else { 
			    echo $candvicegovernorspartyrow['partyname']; 
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

<?PHP if (!empty($candvicegovernorsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['nickname']; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($candvgovcivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candvgovcivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candvicegovernorsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candvicegovernorsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['birthplace']; ?><BR>
<?PHP } ?>


<?PHP if (!empty($candvicegovernorsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candvicegovernorsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candvicegovernorsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candvicegovernorsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candvicegovernorsrow['emailaddr']; ?>><?PHP echo $candvicegovernorsrow['emailaddr']; ?></A><BR>
<?PHP } ?>
 		
<?PHP if($candvicegovernorsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candvicegovernorsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicegovernorsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicegovernorsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candvicegovernorsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candvicegovernorslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candvicegovernorslink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candvicegovernorsrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candvicegovernorsrow['adpaidby']; ?></SPAN>
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
