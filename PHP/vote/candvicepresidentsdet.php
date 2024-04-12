<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candvicepresidents.lastname As lastname, candvicepresidents.firstname As firstname, candvicepresidents.middleinitial As middleinitial,
   candvicepresidents.picturelocation As pictureloc, date_format(candvicepresidents.birthdate,'%M %e, %Y') As birthdate, candvicepresidents.educattainment As educattainment,
   candvicepresidents.accomplishments As accomplishments, candvicepresidents.platform As platform, candvicepresidents.workexperiences As workexperiences,
   candvicepresidents.familyinfo As familyinfo, candvicepresidents.biography As biography, candvicepresidents.birthplace As birthplace, candvicepresidents.emailaddr As emailaddr,
   candvicepresidents.telnum As telnum, candvicepresidents.faxnum As faxnum, YEAR(CURDATE()) - YEAR(candvicepresidents.birthdate) As age, candvicepresidents.programofgovt As programofgovt,
   candvicepresidents.standonissues As standonissues, candvicepresidents.nickname As nickname, candvicepresidents.adpaidby As adpaidby, candvicepresidents.activities 
  FROM candvicepresidents
  WHERE (candvicepresidents.vicepresident_id = ".$candvicepresidentid.")";
$candvicepresident = getqueryresults($query);
$candvicepresidentrow = mysql_fetch_array($candvicepresident);
$candvicepresidentrow = slashstripper($candvicepresidentrow);

$query = "SELECT coalitions.name As coalitionname, coalitions.coalition_id, 
          coalitions.acronym
  FROM candvicepresidents, coalitions
  WHERE (coalitions.coalition_id = candvicepresidents.coalition_id) AND (candvicepresidents.vicepresident_id = ".$candvicepresidentid.")";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);

$query = "SELECT party.name As partyname, party.party_id As party_id, party.acronym As acronym
  FROM candvicepresidents, party
  WHERE (party.party_id = candvicepresidents.party_id) AND (candvicepresidents.vicepresident_id = ".$candvicepresidentid.")";
$candvicepresidentparty = getqueryresults($query);
$candvicepresidentpartyrow = mysql_fetch_array($candvicepresidentparty);

$query = "SELECT civilstatus.status As status
          FROM civilstatus, candvicepresidents
		  WHERE (candvicepresidents.civilstatus_id = civilstatus.civilstatus_id) AND
		        (candvicepresidents.vicepresident_id = ".$candvicepresidentid.")";
$candvprescivilstatus = getqueryresults($query);
$candvprescivilstatrow = mysql_fetch_array($candvprescivilstatus);

$query = "SELECT links.url As url, links.title As title
  FROM candvicepresidents, links
  WHERE (candvicepresidents.vicepresident_id = links.candvicepresident_id) AND (candvicepresidents.vicepresident_id = ".$candvicepresidentid.")";
$candvicepresidentlink = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidate for Vice President <?PHP echo $candvicepresidentrow['firstname']; ?>	
<?PHP if(!empty($candvicepresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicepresidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candvicepresidentrow['lastname']; ?>
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
<B>Candidate for Vice President&nbsp;<?PHP echo $candvicepresidentrow['firstname']; ?>	
<?PHP if(!empty($candvicepresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo $candvicepresidentrow['middleinitial'].". "; ?>
<?PHP } ?>
<?PHP echo $candvicepresidentrow['lastname']; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>
<?PHP echo strtoupper($candvicepresidentrow['firstname']); ?>	
<?PHP if(!empty($candvicepresidentrow['middleinitial'])) { ?>
      &nbsp;<?PHP echo strtoupper($candvicepresidentrow['middleinitial']).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($candvicepresidentrow['lastname']); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
		<?PHP if(!empty($candvicepresidentrow['pictureloc'])) { ?>
			<IMG SRC="<?PHP echo "/vote/pictures/".$candvicepresidentrow['pictureloc']; ?>" BORDER="0" ALT="" ALIGN="TOP">
		<?PHP } ?>	
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if ($candvicepresidentpartyrow['party_id'] <> 0) { ?>
	<B>Party:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candvicepresidentpartyrow['party_id']; ?>>
 		<?PHP 
			if (!empty($candvicepresidentpartyrow['acronym'])) { 
		    	echo $candvicepresidentpartyrow['acronym']; 
			} else { 
			    echo $candvicepresidentpartyrow['partyname']; 
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
		
<?PHP if (!empty($candvicepresidentrow['nickname'])) ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['nickname']; ?><BR>	
<?PHP } ?>		

<?PHP if (!empty($candvprescivilstatrow['status'])) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $candvprescivilstatrow['status']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candvicepresidentrow['birthdate'])) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['birthdate']; ?><BR>
	<B>Age:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['age']; ?><BR> 		
<?PHP } ?>

<?PHP if (!empty($candvicepresidentrow['birthplace'])) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['birthplace']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candvicepresidentrow['telnum'])) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['telnum']; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($candvicepresidentrow['faxnum'])) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $candvicepresidentrow['faxnum']; ?><BR>
<?PHP } ?>

<?PHP if (!empty($candvicepresidentrow['emailaddr'])) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$candvicepresidentrow['emailaddr']; ?>><?PHP echo $candvicepresidentrow['emailaddr']; ?></A><BR>
<?PHP } ?>

<?PHP if($candvicepresidentrow['activities']) { ?>
	<H2 CLASS="INDPROFILE">Activities</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Activities -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['activities']; ?>	
                        </SPAN> 
			<!-- End of Information on Activities -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['biography']) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['biography']; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>		
		
<?PHP if($candvicepresidentrow['platform']) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['platform']; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['programofgovt']) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['programofgovt']; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['standonissues']) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['standonissues']; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['accomplishments']) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candvicepresidentrow['accomplishments']; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['workexperiences']) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['workexperiences']; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['educattainment']) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $candvicepresidentrow['educattainment']; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($candvicepresidentrow['familyinfo']) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $candvicepresidentrow['familyinfo']; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (mysql_num_rows($candvicepresidentlink) > 0) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP while ($linkrow = mysql_fetch_array($candvicepresidentlink)) { ?>
			<LI> <A HREF=<?PHP echo $linkrow['url']; ?>><?PHP echo $linkrow['title'] ?></A>
	<?PHP } ?>		
	</UL>
<?PHP } ?>	

<?PHP if($candvicepresidentrow['adpaidby']) { ?>
	<BR><SPAN CLASS="ADPAIDBY">This ad is paid by <?PHP echo $candvicepresidentrow['adpaidby']; ?></SPAN>
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
