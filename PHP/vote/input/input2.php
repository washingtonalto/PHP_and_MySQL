<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT party.party_id, party.name As party, party.acronym
          FROM party
		  ORDER BY party.acronym, party.name";
$party = getqueryresults($query);

$query = "SELECT coalitions.coalition_id, coalitions.name As coalition, coalitions.acronym
		  FROM coalitions
		  ORDER BY coalitions.name";
$coalition = getqueryresults($query);		 

if (!empty($provinceid)) {
$query = "SELECT provinces.province_id, provinces.name As province
          FROM provinces
		  WHERE (provinces.province_id = ".$provinceid.")";
$province = getqueryresults($query);
$provincerow = mysql_fetch_array($province);
$provincename = $provincerow['province'];
} 

if (!empty($provinceid) AND $position == "Representative") {
$query = "SELECT legdistricts.dist_num
          FROM legdistricts, provinces
		  WHERE (legdistricts.province_id = provinces.province_id) AND (provinces.province_id = ".$provinceid.")";
$legdistricts = getqueryresults($query);
} 

if (!empty($ncrmunicityid) AND $position == "Representative") {
$query = "SELECT legdistricts.dist_num
          FROM legdistricts, nationalcapitalregion
		  WHERE (legdistricts.ncrmunicity_id = nationalcapitalregion.municity_id) AND (nationalcapitalregion.municity_id = ".$ncrmunicityid.")";
$legdistricts = getqueryresults($query);
}

if (!empty($provinceid)) {
$query = "SELECT municity.municity_id, municity.name As municity, provinces.name As province
          FROM municity, legdistricts, provinces
		  WHERE (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND (provinces.province_id = ".$provinceid.")
		  ORDER BY provinces.name, municity.name";
$municity = getqueryresults($query);
}		  
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Input Form for Candidates and Officials</TITLE>
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
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Input Form for Candidates and Officials</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INPUT FORM FOR CANDIDATES AND OFFICIALS</B></DIV>
<BR>

<!--======== Start of Submit No. 2 ===========-->
<FORM ACTION="/vote/input/preview.php" METHOD="post">

<B><SPAN STYLE="color: Maroon;">1. BASIC INFORMATION</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<B>Last Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="lastname" SIZE="17" MAXLENGTH="30">&nbsp;&nbsp;
<B>First Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="firstname" SIZE="17" MAXLENGTH="30">&nbsp;&nbsp; 
<B>Middle Initial:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="middleinitial" SIZE="1" MAXLENGTH="1"><BR><BR>
<B>Nickname:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="nickname" SIZE="30" MAXLENGTH="30"><BR><BR>

<?PHP if (!empty($provinceid)) { ?>
<B>Province:</B>&nbsp;<?PHP echo $provincename; ?>&nbsp;&nbsp;
<?PHP } ?>

<?PHP if ($position == "Representative" AND !empty($provinceid)) { ?>
<B>Legislative District:</B>&nbsp;
<SELECT NAME="legdist" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
		<?PHP while ($legdistrictsrow = mysql_fetch_array($legdistricts)) { ?>
		<OPTION VALUE=<?PHP echo $legdistrictsrow['dist_num']; ?>><?PHP echo $legdistrictsrow['dist_num']; ?></OPTION>
		<?PHP } ?>
</SELECT><BR><BR>
<?PHP } ?>

<?PHP if ($position == "Representative" AND !empty($ncrmunicityid)) { ?>
<B>Legislative District:</B>&nbsp;
<SELECT NAME="legdist" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
		<?PHP while ($legdistrictsrow = mysql_fetch_array($legdistricts)) { ?>
		<OPTION VALUE=<?PHP echo $legdistrictsrow['dist_num']; ?>><?PHP echo $legdistrictsrow['dist_num']; ?></OPTION>
		<?PHP } ?>
</SELECT><BR><BR>
<?PHP } ?>

<?PHP if (($position == "Mayor" 
       OR $position == "Vice Mayor" 
	   OR $position == "Councilor") AND !empty($provinceid)) { ?>
<B>Municipality/City:</B>&nbsp;
<SELECT NAME="municityid" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
	<?PHP while ($municityrow = mysql_fetch_array($municity)) { ?>
		<OPTION VALUE=<?PHP echo $municityrow['municity_id']; ?>><?PHP echo $municityrow['municity']; ?></OPTION>
	<?PHP } ?>	
</SELECT>
<?PHP mysql_free_result($municity); ?>
<BR><BR>
<?PHP } ?>


<B>Coalition:</B>&nbsp;
<SELECT NAME="coalitionid" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
	<?PHP while ($coalitionrow = mysql_fetch_array($coalition)) { ?>
		<OPTION VALUE=<?PHP echo $coalitionrow['coalition_id']; ?>><?PHP echo $coalitionrow['acronym']; ?></OPTION>
	<?PHP } ?>	
</SELECT>&nbsp;&nbsp;&nbsp;
<B>Party:</B>&nbsp;
<SELECT NAME="partyid" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
	<?PHP while ($partyrow = mysql_fetch_array($party)) { ?>
		<OPTION VALUE=<?PHP echo $partyrow['party_id']; ?>>
		    <?PHP if (!empty($partyrow['acronym'])) {
			         echo $partyrow['acronym']; 
				  } else {
				  	 echo $partyrow['party']; 
				  }	 
			?>
		 </OPTION>
	<?PHP } ?>	
</SELECT>
<BR>
<BR>
<B>Birthdate:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="birthdate" SIZE="8" MAXLENGTH="8">&nbsp;&nbsp;
<B>Birthplace:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="birthplace" SIZE="25" MAXLENGTH="30">&nbsp;&nbsp;
<B>Civil Status:</B>&nbsp;&nbsp;
<SELECT NAME="civilstatus" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
		<OPTION VALUE="single">Single</OPTION>
		<OPTION VALUE="married">Married</OPTION>
</SELECT><BR><BR>
<B>Telephone Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="telnos" SIZE="35" MAXLENGTH="56">&nbsp;&nbsp;
<B>Fax Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="faxnos" SIZE="35" MAXLENGTH="56"><BR><BR>
<B>E-mail:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="email" SIZE="34" MAXLENGTH="50"><BR><BR>
		</TD>
	</TR>
</TABLE>

<B><SPAN STYLE="color: Maroon;">2. BIOGRAPHY</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="biography" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">3. PLATFORM</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="platform" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">4. PROGRAM OF GOVERNMENT</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="programofgovt" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">5. STAND ON CERTAIN ISSUES</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="standonissues" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">6. ACCOMPLISHMENT</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="accomplishments" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">7. WORK EXPERIENCE</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="workexperiences" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">8. EDUCATIONAL ATTAINMENT</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="educattainment" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">9. FAMILY INFORMATION</SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
<TEXTAREA COLS="80" ROWS="10" NAME="familyinfo" WRAP="soft"></TEXTAREA>
		</TD>
	</TR>
</TABLE>
<BR>

<B><SPAN STYLE="color: Maroon;">10. EXTERNAL LINKS <SPAN STYLE="color: Green;">(For example, http://www.candidate.com/)</SPAN></SPAN></B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="30">&nbsp;</TD>
		<TD>
a.&nbsp;&nbsp;<INPUT TYPE="text" NAME="link1" SIZE="50" MAXLENGTH="100"><BR>
b.&nbsp;&nbsp;<INPUT TYPE="text" NAME="link2" SIZE="50" MAXLENGTH="100"><BR>
c.&nbsp;&nbsp;<INPUT TYPE="text" NAME="link3" SIZE="50" MAXLENGTH="100"><BR>   
		</TD>
	</TR>
</TABLE>
<BR>

<INPUT TYPE="hidden" NAME="position" VALUE=<?PHP echo $position; ?>>
<INPUT TYPE="hidden" NAME="type" VALUE=<?PHP echo $type; ?>>
<?PHP if (!empty($provinceid)) { ?>
	<INPUT TYPE="hidden" NAME="provinceid" VALUE=<?PHP echo $provinceid; ?>>
<?PHP } ?>
<?PHP if (!empty($ncrmunicityid)) { ?>
	<INPUT TYPE="hidden" NAME="ncrmunicityid" VALUE=<?PHP echo $ncrmunicityid; ?>>
<?PHP } ?>
<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
<BR><BR>
<DIV ALIGN="center"><INPUT TYPE="submit" VALUE="Preview Page"></DIV>
</FORM>
<!--======== End of Submit No. 2 ===========-->

<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
