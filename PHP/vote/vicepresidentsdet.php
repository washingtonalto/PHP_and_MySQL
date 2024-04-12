<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT vicepresidents.lastname As lastname, vicepresidents.firstname As firstname, vicepresidents.middleinitial As middleinitial,
   vicepresidents.picturelocation As pictureloc, date_format(vicepresidents.birthdate,'%M %e, %Y') As birthdate, vicepresidents.educattainment As educattainment,
   vicepresidents.accomplishments As accomplishments, vicepresidents.platform As platform, vicepresidents.workexperiences As workexperiences,
   vicepresidents.familyinfo As familyinfo, vicepresidents.biography As biography, vicepresidents.birthplace As birthplace, vicepresidents.emailaddr As emailaddr,
   vicepresidents.telnum As telnum, vicepresidents.faxnum As faxnum, YEAR(CURDATE()) - YEAR(vicepresidents.birthdate) As age, vicepresidents.programofgovt As programofgovt,
   vicepresidents.standonissues As standonissues, vicepresidents.nickname As nickname, vicepresidents.activities 
  FROM vicepresidents
  WHERE (vicepresidents.vicepresident_id = ".$vicepresidentid.")";
$vicepresidents = getqueryresults($query);
$vicepresidentsrow = mysql_fetch_array($vicepresidents);
$vicepresidentsrow = slashstripper($vicepresidentsrow);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM vicepresidents, coalitions
  WHERE (coalitions.coalition_id = vicepresidents.coalition_id) AND (vicepresidents.vicepresident_id = ".$vicepresidentid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM vicepresidents, party
  WHERE (party.party_id = vicepresidents.party_id) AND (vicepresidents.vicepresident_id = ".$vicepresidentid.")";
$vicepresidentparty = getqueryresults($query);
$vpresidentpartyrow = mysql_fetch_array($vicepresidentparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, vicepresidents
		  WHERE (vicepresidents.civilstatus_id = civilstatus.civilstatus_id) AND
		        (vicepresidents.vicepresident_id = ".$vicepresidentid.")";
$vprescivilstatus = getqueryresults($query);
$vprescivilstatrow = mysql_fetch_array($vprescivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM vicepresidents, links
  WHERE (vicepresidents.vicepresident_id = links.vicepresident_id) AND (vicepresidents.vicepresident_id = ".$vicepresidentid.")";
$vicepresidentslink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Vice President <?PHP echo $vicepresidentsrow['firstname']; ?>	
<?PHP if(!empty($vicepresidentsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicepresidentsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicepresidentsrow['lastname']; ?>
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
<B>Vice President <?PHP echo $vicepresidentsrow['firstname']; ?>	
<?PHP if(!empty($vicepresidentsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $vicepresidentsrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $vicepresidentsrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
VICE PRESIDENT <?PHP echo strtoupper($vicepresidentsrow['firstname']); ?>	
<?PHP if(!empty($vicepresidentsrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($vicepresidentsrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($vicepresidentsrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($vicepresidentsrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$vicepresidentsrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($vpresidentpartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$vpresidentpartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($vpresidentpartyrow['acronym'])) { 
		    	echo $vpresidentpartyrow['acronym']; 
			} else { 
			    echo $vpresidentpartyrow['partyname']; 
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

<?PHP if (!empty($vicepresidentsrow['nickname'])) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['nickname']; ?><BR>	
<?PHP } ?>		
		
<?PHP if (!empty($vprescivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $vprescivilstatrow['status']; ?><BR>
<?PHP } ?>
		
<?PHP if (!empty($vicepresidentsrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($vicepresidentsrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicepresidentsrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($vicepresidentsrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $vicepresidentsrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($vicepresidentsrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$vicepresidentsrow['emailaddr']; ?>><?PHP echo $vicepresidentrow['emailaddr']; ?></A><BR>
<?PHP } ?>
		
<?PHP if($vicepresidentsrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>
		
<?PHP if($vicepresidentsrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicepresidentsrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $vicepresidentsrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($vicepresidentsrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $vicepresidentsrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($vicepresidentslink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($vicepresidentslink)) { ?>
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
