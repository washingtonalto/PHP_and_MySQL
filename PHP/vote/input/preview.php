<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP

if (!empty($provinceid)) {
$query="SELECT provinces.name As province
        FROM provinces
		WHERE (provinces.province_id = ".$provinceid.")";
$provinces = getqueryresults($query);
$provincerow = mysql_fetch_array($provinces);
}

if (!empty($ncrmunicityid)) {
$query="SELECT nationalcapitalregion.name As municity
        FROM nationalcapitalregion
		WHERE (nationalcapitalregion.municity_id = ".$ncrmunicityid.")";
$ncrmunicity = getqueryresults($query);
$ncrmunicityrow = mysql_fetch_array($ncrmunicity);
}

if (!empty($municityid)) {
$query="SELECT municity.name As municity
        FROM municity
		WHERE (municity.municity_id = ".$municityid.")";
$municity = getqueryresults($query);
$municityrow = mysql_fetch_array($municity);
}
		
if (!empty($coalitionid)) {		
$query="SELECT coalitions.coalition_id, coalitions.acronym, coalitions.name As coalition
        FROM coalitions
		WHERE (coalitions.coalition_id = ".$coalitionid.")";
$coalitionname = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalitionname); 		
}

if (!empty($partyid)) {		
$query="SELECT party.party_id, party.acronym, party.name As party
        FROM party
		WHERE (party.party_id = ".$partyid.")";
$partyname = getqueryresults($query);
$partyrow = mysql_fetch_array($partyname); 		 	
}

?>

<!--======================= End of MetaHeaders =================-->

<?PHP 
	if ($type == "Candidate") {
		$label = "Candidate for ";
	} else {	 
		$label = "Incumbent ";
	}	
?>
<TITLE>Vote.ph : <?PHP echo $label.$position; ?>&nbsp;<?PHP echo $firstname; ?>	
<?PHP if(!empty($middleinitial)) { ?>
      &nbsp;<?PHP echo $middleinitial.". "; ?>
<?PHP } ?>
<?PHP echo $lastname; ?>
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
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<A HREF="/vote/byposition.php"><B>By Position</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $label.$position; ?></B>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B><?PHP echo $firstname; ?>	
<?PHP if(!empty($middleinitial)) { ?>
      &nbsp;<?PHP echo $middleinitial.". "; ?>
<?PHP } ?>
<?PHP echo $lastname; ?></B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>PREVIEW PAGE FOR
&nbsp;<?PHP echo strtoupper($firstname); ?>	
<?PHP if(!empty($middleinitial)) { ?>
      &nbsp;<?PHP echo strtoupper($middleinitial).". "; ?>
<?PHP } ?>
<?PHP echo strtoupper($lastname); ?>
</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
&nbsp;
		<BR>
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<?PHP if (!empty($partyid)) { ?>
	<B>Party:</B>&nbsp;&nbsp;
 		<?PHP 
			if (!empty($partyrow['acronym'])) {
		    	echo $partyrow['acronym'];
			} else {
		    	echo $partyrow['party'];			
			}	 
		?>
		<BR>
<?PHP } ?>

<?PHP if (!empty($coalitionid)) { ?>
	<B>Coalition:</B>&nbsp;&nbsp;
 		<?PHP 
	    	echo $coalitionrow['acronym']; 
		?>
		<BR>
<?PHP } ?>

<?PHP if ($position == "Mayor" OR 
          $position == "Vice-mayor" OR
          $position == "Councilor") { ?>
<B>Municipality/City:</B>&nbsp;&nbsp;
<?PHP if (!empty($municityid)) { ?> 
	<?PHP echo $municityrow['municity']; ?>
	<BR>
<?PHP } else { ?>
	<?PHP echo $ncrmunicityrow['municity']; ?>
    <BR>
<?PHP } ?>
<?PHP } ?>

<?PHP if ($position == "Representative") { ?>
<B>Legislative District:</B>&nbsp;&nbsp;
<?PHP if (!empty($provinceid)) { ?>
	<?PHP echo numtoordinal($legdist) ?>&nbsp;District of&nbsp;<?PHP echo $provincerow['province']; ?><BR> 
<?PHP } elseif (!empty($ncrmunicityid)) { ?>
	<?PHP echo numtoordinal($legdist) ?>&nbsp;District of&nbsp;<?PHP echo $ncrmunicityrow['municity']; ?><BR> 
<?PHP } ?>
<?PHP } ?>

<?PHP if (!empty($provinceid)) { ?> 
	<B>Province:</B>&nbsp;&nbsp;
	<?PHP echo $provincerow['province']; ?>
	<BR>

<?PHP } ?>

<?PHP if (!empty($nickname)) { ?>
	<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $nickname; ?><BR>	
<?PHP } ?>

<?PHP if (!empty($civilstatus)) { ?>
	<B>Civil Status:</B>&nbsp;&nbsp;<?PHP echo $civilstatus; ?><BR>
<?PHP } ?>

<?PHP if (!empty($birthdate)) { ?>
	<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $birthdate; ?><BR>
<?PHP } ?>

<?PHP if (!empty($birthplace)) { ?>
	<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo $birthplace; ?><BR>
<?PHP } ?>


<?PHP if (!empty($telnos)) { ?>
	<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo $telnos; ?><BR>
<?PHP } ?>
	
<?PHP if (!empty($faxnos)) { ?>
	<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo $faxnos; ?><BR>
<?PHP } ?>

<?PHP if (!empty($email)) { ?>
	<B>E-mail:</B>&nbsp;&nbsp;<A HREF=<?PHP echo "mailto:".$email; ?>><?PHP echo $email; ?></A><BR>
<?PHP } ?>


<?PHP if($biography) { ?>
	<H2 CLASS="INDPROFILE">Biography</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Biography -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $biography; ?>	
                        </SPAN> 
			<!-- End of Information on Biography -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($platform) { ?>
	<H2 CLASS="INDPROFILE">Platform</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Platform -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $platform; ?>	
                        </SPAN> 
			<!-- End of Information on Platform -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($programofgovt) { ?>
	<H2 CLASS="INDPROFILE">Program of Government</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Program of Government -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $programofgovt; ?>	
                        </SPAN> 
			<!-- End of Information on Program of Government -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($standonissues) { ?>
	<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Stand on Certain Issues -->
                        <SPAN CLASS="VOTERDETAIL">
				<?PHP echo $standonissues; ?>	
                        </SPAN> 
			<!-- End of Information on Stand on Certain Issues -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($accomplishments) { ?>
	<H2 CLASS="INDPROFILE">Accomplishments</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on accomplishments -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $accomplishments; ?>	
			</SPAN>
			<!-- End of Information on accomplishments  -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($workexperiences) { ?>
	<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on work experience -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $workexperiences; ?>	
			</SPAN>
			<!-- End of Information on work experience -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($educattainment) { ?>
	<H2 CLASS="INDPROFILE">Educational Attainment</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on  Educational Attainment -->
			<SPAN CLASS="VOTERDETAIL">
				<?PHP echo $educattainment; ?>	
			</SPAN>
			<!-- End of Information on Educational Attainment -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if($familyinfo) { ?>
	<H2 CLASS="INDPROFILE">Family Information</H2>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="24">&nbsp;
			</TD>
			<TD>
			<!-- Start of Information on Family Information -->
			<SPAN CLASS="VOTERDETAIL">
					<?PHP echo $familyinfo; ?>	
			</SPAN>
			<!-- End of Information on Family Information -->	
			</TD>
		</TR>
	</TABLE>
<?PHP } ?>

<?PHP if (!empty($link1) OR !empty($link2) OR !empty($link3)) { ?>
	<H2 CLASS="INDPROFILE">Links</H2>
	<UL>
	<?PHP if (!empty($link1)) { ?>
			<LI> <A HREF=<?PHP echo $link1; ?>><?PHP echo $link1; ?></A>
	<?PHP } ?>
	<?PHP if (!empty($link2)) { ?>
			<LI> <A HREF=<?PHP echo $link2; ?>><?PHP echo $link2; ?></A>
	<?PHP } ?>			
	<?PHP if (!empty($link3)) { ?>
			<LI> <A HREF=<?PHP echo $link3; ?>><?PHP echo $link3; ?></A>
	<?PHP } ?>	
	</UL>
<?PHP } ?>	
<DIV ALIGN="CENTER">
<FORM ACTION="/vote/input/send.php" METHOD="post">
<TABLE WIDTH="200" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center" VALIGN="top" BGCOLOR="#FFBB77"><B>Do you certify that the ff. informations are correct?</B>
		</TD>
	</TR>
	<TR>
		<TD ALIGN="center" VALIGN="top">
<INPUT TYPE="radio" NAME="is_correct" VALUE="Y" CHECKED>Yes<BR>
<INPUT TYPE="radio" NAME="is_correct" VALUE="N">No<BR><BR>
		</TD>
	</TR>
</TABLE>
<BR><BR>
<TABLE WIDTH="500" BORDER="1" CELLSPACING="0" CELLPADDING="7" ALIGN="center">
	<TR>
		<TD COLSPAN="2" ALIGN="left" VALIGN="top" BGCOLOR="#FFCAFF"><B>Please fill-up the ff. information below whenever applicable (for verification purposes only):</B>
		</TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Name:</B></TD><TD><INPUT TYPE="text" NAME="postersname" SIZE="34" MAXLENGTH="80"></TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Relation to candidate/official (e.g. campaign manager, supporter, etc.):</B></TD><TD><INPUT TYPE="text" NAME="postersrelation" SIZE="34" MAXLENGTH="80"></TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Address:</B></TD><TD><TEXTAREA COLS="30" ROWS="5" NAME="postersaddress"></TEXTAREA></TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Tel. Nos.:</B></TD><TD><INPUT TYPE="text" NAME="posterstelnum" SIZE="34" MAXLENGTH="80"></TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Fax Nos.:</B></TD><TD><INPUT TYPE="text" NAME="postersfaxnum" SIZE="34" MAXLENGTH="80"></TD>
	</TR><TR>
<TD ALIGN="left" VALIGN="top"><B>Poster's Email:</B></TD><TD><INPUT TYPE="text" NAME="postersemail" SIZE="34" MAXLENGTH="80"></TD>
	</TR><TR>
<TD COLSPAN="2" ALIGN="center"><INPUT TYPE="submit" VALUE="Submit"></TD>
     </TR> 
</TABLE>

<?PHP if (!empty($type)) { ?>
	<INPUT TYPE="hidden" NAME="type" VALUE="<?PHP echo $type; ?>">
<?PHP } ?>
<?PHP if (!empty($position)) { ?>
	<INPUT TYPE="hidden" NAME="position" VALUE="<?PHP echo $position; ?>">
<?PHP } ?>
<?PHP if (!empty($lastname)) { ?>
	<INPUT TYPE="hidden" NAME="lastname" VALUE="<?PHP echo $lastname; ?>">
<?PHP } ?>
<?PHP if (!empty($firstname)) { ?>
	<INPUT TYPE="hidden" NAME="firstname" VALUE="<?PHP echo $firstname; ?>">
<?PHP } ?>
<?PHP if (!empty($middleinitial)) { ?>
	<INPUT TYPE="hidden" NAME="middleinitial" VALUE="<?PHP echo $middleinitial; ?>">
<?PHP } ?>
<?PHP if (!empty($partyname)) { ?>
	<INPUT TYPE="hidden" NAME="partyname" VALUE="<?PHP 
					if (!empty($partyrow['acronym'])) {
		    			echo $partyrow['acronym'];
					} else {
		    			echo $partyrow['party'];			
					}	 
 					?>">
<?PHP } ?>
<?PHP if (!empty($coalitionname)) { ?>
	<INPUT TYPE="hidden" NAME="coalitionname" VALUE="<?PHP echo $coalitionrow['coalition']; ?>">
<?PHP } ?>
<?PHP if (!empty($provinceid)) { ?>
	<INPUT TYPE="hidden" NAME="province" VALUE="<?PHP echo $provincerow['province']; ?>">
<?PHP } ?>
<?PHP if (!empty($legdist)) { ?>
	<INPUT TYPE="hidden" NAME="legdist" VALUE="<?PHP echo $legdist; ?>">
<?PHP } ?>
<?PHP if (!empty($municityid)) { ?>
	<INPUT TYPE="hidden" NAME="municity" VALUE="<?PHP echo $municityrow['municity']; ?>">
<?PHP } ?>
<?PHP if (!empty($ncrmunicityid)) { ?>
	<INPUT TYPE="hidden" NAME="ncrmunicity" VALUE="<?PHP echo $ncrmunicityrow['municity']; ?>">
<?PHP } ?>
<?PHP if (!empty($civilstatus)) { ?>
	<INPUT TYPE="hidden" NAME="civilstatus" VALUE="<?PHP echo $civilstatus; ?>">
<?PHP } ?>
<?PHP if (!empty($nickname)) { ?>
	<INPUT TYPE="hidden" NAME="nickname" VALUE="<?PHP echo $nickname; ?>">
<?PHP } ?>
<?PHP if (!empty($birthdate)) { ?>
	<INPUT TYPE="hidden" NAME="birthdate" VALUE=<?PHP echo $birthdate; ?>>
<?PHP } ?>
<?PHP if (!empty($birthplace)) { ?>
	<INPUT TYPE="hidden" NAME="birthplace" VALUE="<?PHP echo $birthplace; ?>">	
<?PHP } ?>
<?PHP if (!empty($telnos)) { ?>
	<INPUT TYPE="hidden" NAME="telnos" VALUE="<?PHP echo $telnos; ?>">	
<?PHP } ?>
<?PHP if (!empty($faxnos)) { ?>
	<INPUT TYPE="hidden" NAME="faxnos" VALUE="<?PHP echo $faxnos; ?>">	
<?PHP } ?>
<?PHP if (!empty($email)) { ?>
	<INPUT TYPE="hidden" NAME="email" VALUE="<?PHP echo $email; ?>">	
<?PHP } ?>
<?PHP if (!empty($biography)) { ?>
	<INPUT TYPE="hidden" NAME="biography" VALUE="<?PHP echo $biography; ?>">
<?PHP } ?>
<?PHP if (!empty($platform)) { ?>
	<INPUT TYPE="hidden" NAME="platform" VALUE="<?PHP echo $platform; ?>">	
<?PHP } ?>
<?PHP if (!empty($programofgovt)) { ?>
	<INPUT TYPE="hidden" NAME="programofgovt" VALUE="<?PHP echo $programofgovt; ?>">
<?PHP } ?>
<?PHP if (!empty($standonissues)) { ?>
	<INPUT TYPE="hidden" NAME="standonissues" VALUE="<?PHP echo $standonissues; ?>">
<?PHP } ?>
<?PHP if (!empty($accomplishments)) { ?>
	<INPUT TYPE="hidden" NAME="accomplishments" VALUE="<?PHP echo $accomplishments; ?>">
<?PHP } ?>
<?PHP if (!empty($platform)) { ?>
	<INPUT TYPE="hidden" NAME="platform" VALUE="<?PHP echo $platform; ?>">
<?PHP } ?>
<?PHP if (!empty($workexperiences)) { ?>
	<INPUT TYPE="hidden" NAME="workexperiences" VALUE="<?PHP echo $workexperiences; ?>">
<?PHP } ?>
<?PHP if (!empty($educattainment)) { ?>
	<INPUT TYPE="hidden" NAME="educattainment" VALUE="<?PHP echo $educattainment; ?>">
<?PHP } ?>
<?PHP if (!empty($familyinfo)) { ?>
	<INPUT TYPE="hidden" NAME="familyinfo" VALUE="<?PHP echo $familyinfo; ?>">
<?PHP } ?>
<?PHP if (!empty($link1)) { ?>	
	<INPUT TYPE="hidden" NAME="link1" VALUE="<?PHP echo $link1; ?>">
<?PHP } ?>
<?PHP if (!empty($link2)) { ?>
	<INPUT TYPE="hidden" NAME="link2" VALUE="<?PHP echo $link2; ?>">
<?PHP } ?>
<?PHP if (!empty($link3)) { ?>
	<INPUT TYPE="hidden" NAME="link3" VALUE="<?PHP echo $link3; ?>">
<?PHP } ?>
</FORM>
</DIV>
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

