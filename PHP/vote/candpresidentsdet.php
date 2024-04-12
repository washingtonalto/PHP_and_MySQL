<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candpresidents.lastname As lastname, candpresidents.firstname As firstname, candpresidents.middleinitial As middleinitial,
   candpresidents.picturelocation As pictureloc, date_format(candpresidents.birthdate,'%M %e, %Y') As birthdate, candpresidents.educattainment As educattainment,
   candpresidents.accomplishments As accomplishments, candpresidents.platform As platform, candpresidents.workexperiences As workexperiences,
   candpresidents.familyinfo As familyinfo, candpresidents.biography As biography, candpresidents.birthplace As birthplace, candpresidents.emailaddr As emailaddr,
   candpresidents.telnum As telnum, candpresidents.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candpresidents.birthdate) As age, candpresidents.programofgovt As programofgovt,
   candpresidents.standonissues As standonissues, candpresidents.nickname As nickname, candpresidents.adpaidby As adpaidby, candpresidents.activities 
  FROM candpresidents
  WHERE (candpresidents.president_id = ".$candpresidentid.")";
$candpresident = getqueryresults($query);
$candpresidentrow = mysql_fetch_array($candpresident);
$candpresidentrow = slashstripper($canpresidentrow);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM candpresidents, coalitions
  WHERE (coalitions.coalition_id = candpresidents.coalition_id) AND (candpresidents.president_id = ".$candpresidentid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candpresidents, party
  WHERE (party.party_id = candpresidents.party_id) AND (candpresidents.president_id = ".$candpresidentid.")";
$candpresidentparty = getqueryresults($query);
$candpresidentpartyrow = mysql_fetch_array($candpresidentparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candpresidents
		  WHERE (candpresidents.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candmayors.president_id = ".$candpresidentid.")";
$candprescivilstatus = getqueryresults($query);
$candprescivilstatrow = mysql_fetch_array($candprescivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candpresidents, links
  WHERE (candpresidents.president_id = links.candpresident_id) AND (candpresidents.president_id = ".$candpresidentid.")";
$candpresidentlink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Presidential Candidate <?PHP echo $candpresidentrow['firstname']; ?>	
<?PHP if(!empty($candpresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candpresidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candpresidentrow['lastname']; ?>
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
<B>Presidential Candidate <?PHP echo $candpresidentrow['firstname']; ?>	
<?PHP if(!empty($candpresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candpresidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candpresidentrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
<?PHP echo strtoupper($candpresidentrow['firstname']); ?>	
<?PHP if(!empty($candpresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candpresidentrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candpresidentrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candpresidentrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candpresidentrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candpresidentpartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candpresidentpartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candpresidentpartyrow['acronym'])) { 
		    	echo $candpresidentpartyrow['acronym']; 
			} else { 
			    echo $candpresidentpartyrow['partyname']; 
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
		
<?PHP if (!empty($candpresidentrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['nickname']; ?><BR>	
<?PHP } ?>		

<?PHP if (!empty($candprescivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candprescivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candpresidentrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candpresidentrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candpresidentrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candpresidentrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candpresidentrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candpresidentrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candpresidentrow['emailaddr']; ?>><?PHP echo $candpresidentrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candpresidentrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>
		
<?PHP if($candpresidentrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>
		
<?PHP if($candpresidentrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candpresidentrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candpresidentrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candpresidentrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candpresidentrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candpresidentlink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candpresidentlink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candpresidentrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candpresidentrow['adpaidby']; ?></SPAN>
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
