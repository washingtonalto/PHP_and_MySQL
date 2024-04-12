<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Edit Record Page</TITLE>
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
<A HREF="/vote/admin/"><B>Web Administration</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<A HREF="/vote/admin/input/"><B>Data Entry for Election Candidates and Incumbent Elected Officials</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Edit Record Page</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>EDIT RECORD PAGE</B></DIV>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<?PHP 
	switch($type) {
		case "president":
		case "vicepresident":
		case "senator":
		case "governor":
		case "vicegovernor":
		case "mayor":
		case "vicemayor":
		case "councilor":
		case "representative":
		case "provboardmember":
					$querylabel3 = $type;
					$querylabel2 = $type;
					$querylabel1 = $querylabel2."s";
					break;		  
		case "candpresident":
		case "candvicepresident":
		case "candsenator":
		case "candgovernor":
		case "candvicegovernor":
		case "candmayor":
		case "candvicemayor":
		case "candcouncilor":
		case "candrepresentative":
					$querylabel3 = $type;
					$querylabel2 = substr($type,4,strlen($type)-4);
					$querylabel1 = $type."s";
					break;
		case "candboardmem":
					$querylabel3 = $type;
					$querylabel2 = "provboardmember";
					$querylabel1 = $type;
					break;				
	}
	// echo $querylabel1."<BR>";
	// echo $querylabel2."<BR>";
	$query = "SELECT lastname, firstname, middleinitial, party_id, coalition_id, 
	          picturelocation, 
	          birthdate, educattainment, accomplishments, platform, workexperiences,
              familyinfo, biography, birthplace, emailaddr, telnum, faxnum, 
			  programofgovt, standonissues, nickname, activities, civilstatus_id
	          FROM ".$querylabel1." WHERE (".$querylabel2."_id = ".$id.")";
	// echo $query."<BR>";
	$profile = getqueryresults($query); 
	$profilerow = mysql_fetch_array($profile);
	$query="SELECT link_id, url, title FROM links, ".$querylabel1.
	   " WHERE (links.".$querylabel3."_id = ".$querylabel1.".".$querylabel2."_id) AND (".$querylabel1.".".$querylabel2."_id = ".$id.")";
	// echo $query."<BR>";
	$links = getqueryresults($query);
	$query = "SELECT civilstatus_id, status FROM civilstatus ORDER BY civilstatus_id";
	$civilstatus = getqueryresults($query);
	$query = "SELECT party_id, name As partyname, acronym FROM party ORDER by party.acronym, party.name";
	$party = getqueryresults($query);
	$query = "SELECT coalition_id, name As coalitionname, acronym FROM coalitions ORDER by coalitions.acronym, coalitions.name";
	$coalition = getqueryresults($query);
	
?>

<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">

<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="150" ALIGN="left" VALIGN="top">	
	&nbsp;
	</TD>
	<TD ALIGN="left" VALIGN="top">
<!--- Start Body of Information -->
<H2 CLASS="INDPROFILE">Basic Information</H2>
<B>Full Name:</B>&nbsp;&nbsp;<?PHP echo $profilerow['lastname'].", ".$profilerow['firstname']; ?>
<?PHP if (!empty($profilerow['middleinitial'])) { ?>
	<?PHP echo $profilerow['middleinitial']; ?>
<?PHP } ?><BR>
<B>Last Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="lastname" VALUE="<?PHP echo stripslashes($profilerow['lastname']); ?>" SIZE="24"><BR>
<B>First Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="firstname" VALUE="<?PHP echo stripslashes($profilerow['firstname']); ?>" SIZE="24"><BR>
<B>Middle Initial:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="middleinitial" VALUE="<?PHP echo stripslashes($profilerow['middleinitial']); ?>" SIZE="24"><BR>
<B>Party:</B>&nbsp;&nbsp;
   <SELECT NAME="party_id" SIZE="1">
   			<OPTION VALUE="0">&nbsp;</OPTION>   	
     <?PHP while ($partyrow = mysql_fetch_array($party)) { ?>
	  		<OPTION VALUE="<?PHP echo $partyrow['party_id']; ?>" <?PHP if ($profilerow['party_id'] == $partyrow['party_id']) echo "SELECTED" ?>>
				<?PHP if (!empty($partyrow['acronym'])) { ?>
 				        <?PHP echo $partyrow['acronym']."&nbsp;&nbsp;|&nbsp;&nbsp;"; ?>
				<?PHP } ?>		
			    <?PHP echo substr($partyrow['partyname'],0,50); ?>
			</OPTION>
     <?PHP } ?>	
   </SELECT><BR>
<B>Coalition:</B>&nbsp;&nbsp;
   <SELECT NAME="coalition_id" SIZE="1">
   			<OPTION VALUE="0">&nbsp;</OPTION>   	
     <?PHP while ($coalitionrow = mysql_fetch_array($coalition)) { ?>
	  		<OPTION VALUE="<?PHP echo $coalitionrow['coalition_id']; ?>" <?PHP if ($profilerow['coalition_id'] == $coalitionrow['coalition_id']) echo "SELECTED" ?>>
				<?PHP if (!empty($coalitionrow['acronym'])) { ?>
 				        <?PHP echo $coalitionrow['acronym']."&nbsp;&nbsp;|&nbsp;&nbsp;"; ?>
				<?PHP } ?>		
			    <?PHP echo substr($coalitionrow['coalitionname'],0,40); ?>
			</OPTION>
     <?PHP } ?>	
   </SELECT><BR>   
<B>Type:</B>&nbsp;&nbsp;<?PHP echo $type; ?><BR>
<B>File Name for Picture (if any):</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="picturelocation" SIZE="50" VALUE="<?PHP echo $profilerow['picturelocation']; ?>"><BR>
<B>Nickname:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="nickname" SIZE="15" VALUE="<?PHP echo stripslashes($profilerow['nickname']); ?>"><BR>	
<B>Civil Status:</B>&nbsp;&nbsp;
   <SELECT NAME="civilstatus_id" SIZE="1">
   			<OPTION VALUE="0">&nbsp;</OPTION>
     <?PHP while ($civilstatusrow = mysql_fetch_array($civilstatus)) { ?>
	  		<OPTION VALUE="<?PHP echo $civilstatusrow['civilstatus_id']; ?>" <?PHP if ($profilerow['civilstatus_id'] == $civilstatusrow['civilstatus_id']) echo "SELECTED" ?>><?PHP echo $civilstatusrow['status']; ?></OPTION>
     <?PHP } ?>	
	</SELECT><BR>
<B>Birthdate:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="birthdate" SIZE="15" VALUE="<?PHP echo $profilerow['birthdate']; ?>"><BR>
<B>Birthplace:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="birthplace" SIZE="40" VALUE="<?PHP echo stripslashes($profilerow['birthplace']); ?>"><BR>
<B>Tel Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="telnum" SIZE="30" VALUE="<?PHP echo stripslashes($profilerow['telnum']); ?>"><BR>
<B>Fax Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="faxnum" SIZE="30" VALUE="<?PHP echo stripslashes($profilerow['faxnum']); ?>"><BR>
<B>E-mail:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="emailaddr" SIZE="50" VALUE="<?PHP echo stripslashes($profilerow['emailaddr']); ?>"><BR>
<H2 CLASS="INDPROFILE">Activities</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Activities -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="activities">
	<?PHP echo stripslashes($profilerow['activities']); ?>	
    </TEXTAREA>
	</SPAN>
	<!-- End of Information on Activities -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Biography</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Biography -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="biography">
	<?PHP echo stripslashes($profilerow['biography']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Biography -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Platform</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Platform -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="platform">	
	<?PHP echo stripslashes($profilerow['platform']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Platform -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Program of Government</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Program of Government -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="programofgovt">
	<?PHP echo stripslashes($profilerow['programofgovt']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Program of Government -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Stand on Certain Issues</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Stand on Certain Issues -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="standonissues">
	<?PHP echo stripslashes($profilerow['standonissues']); ?>	
    </TEXTAREA>
	</SPAN> 
	<!-- End of Information on Stand on Certain Issues -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Accomplishments</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on accomplishments -->
	<SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="accomplishments">
	<?PHP echo stripslashes($profilerow['accomplishments']); ?>	
	</TEXTAREA>
	</SPAN>
	<!-- End of Information on accomplishments  -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Work Experiences in Public and Private Offices</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on work experience -->
	<SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="workexperiences">
	<?PHP echo stripslashes($profilerow['workexperiences']); ?>	
	</TEXTAREA>
	</SPAN>
	<!-- End of Information on work experience -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Educational Attainment</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on  Educational Attainment -->
	<SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="educattainment">
	<?PHP echo stripslashes($profilerow['educattainment']); ?>	
	</TEXTAREA>
	</SPAN>
	<!-- End of Information on Educational Attainment -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Family Information</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Family Information -->
	<SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="familyinfo">
	<?PHP echo stripslashes($profilerow['familyinfo']); ?>	
	</TEXTAREA>
	</SPAN>
	<!-- End of Information on Family Information -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Links</H2>

<?PHP $ctr=1; $linksrow = mysql_fetch_array($links); ?>
<OL>
<?PHP while ($ctr <= 30) { ?>
	<LI><B>URL:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="<?PHP echo "linkurl[$ctr]"; ?>" SIZE="75" VALUE="<?PHP echo stripslashes($linksrow['url']); ?>"><BR>
	    <B>Title:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="<?PHP echo "linktitle[$ctr]"; ?>" SIZE="75" VALUE="<?PHP echo stripslashes($linksrow['title']); ?>"><BR>
        <INPUT TYPE="hidden" NAME="<?PHP echo "linkid[$ctr]"; ?>" VALUE="<?PHP echo $linksrow['link_id']; ?>">
	<?PHP $ctr++; $linksrow = mysql_fetch_array($links); ?>	 
<?PHP } ?>
</OL>		
<!--- End Body of Information -->	
	</TD>	
</TR>
</TABLE>
<BR><BR><BR>
<INPUT TYPE="hidden" NAME="id" VALUE="<?PHP echo $id; ?>">
<INPUT TYPE="hidden" NAME="type" VALUE="<?PHP echo $type; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>
<?PHP mysql_free_result($profile); ?>

<?PHP } else { ?> <!-- display preview -->

<?PHP
	switch($type) {
		case "president":
		case "vicepresident":
		case "senator":
		case "governor":
		case "vicegovernor":
		case "mayor":
		case "vicemayor":
		case "councilor":
		case "representative":
		case "provboardmember":
					$querylabel3 = $type;
					$querylabel2 = $type;
					$querylabel1 = $querylabel2."s";
					break;		  
		case "candpresident":
		case "candvicepresident":
		case "candsenator":
		case "candgovernor":
		case "candvicegovernor":
		case "candmayor":
		case "candvicemayor":
		case "candcouncilor":
		case "candrepresentative":
					$querylabel3 = $type;
					$querylabel2 = substr($type,4,strlen($type)-4);
					$querylabel1 = $type."s";
					break;
		case "candboardmem":
					$querylabel3 = $type;
					$querylabel2 = "provboardmember";
					$querylabel1 = $type;
					break;				
	}
	$query = "UPDATE ".$querylabel1." SET firstname = '".addslashes($firstname).
	                                  "', lastname = '".addslashes($lastname).
									  "', middleinitial = '".addslashes($middleinitial).    
	                                  "', picturelocation = '".addslashes($picturelocation).
	                                  "', birthdate = '".addslashes($birthdate).
									  "', educattainment = '".addslashes(trim($educattainment)).
									  "', accomplishments = '".addslashes(trim($accomplishments)).
									  "', platform = '".addslashes(trim($platform)).
									  "', workexperiences = '".addslashes(trim($workexperiences)).
									  "', familyinfo = '".addslashes(trim($familyinfo)).
									  "', biography = '".addslashes(trim($biography)).
									  "', birthplace = '".addslashes(trim($birthplace)).
									  "', emailaddr = '".addslashes(trim($emailaddr)).
									  "', telnum = '".addslashes(trim($telnum)).
									  "', faxnum = '".addslashes(trim($faxnum)).
									  "', programofgovt = '".addslashes(trim($programofgovt)).
									  "', standonissues = '".addslashes(trim($standonissues)).
									  "', nickname = '".addslashes(trim($nickname)).
									  "', activities = '".addslashes(trim($activities)).
									  "', civilstatus_id = ".$civilstatus_id.
									  ", party_id = ".$party_id.
									  ", coalition_id = ".$coalition_id.									  
									  " WHERE (".$querylabel2."_id = ".$id.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"insert");
	echo "<BR><BR><B>Links Query Executed:</B><BR>";	
	for ($ctr=1;$ctr <= 30; $ctr++) {
	    if (!empty($linkurl[$ctr])) {
		   if (!empty($linkid[$ctr])) {
		        $query = "UPDATE links SET url= '".trim(addslashes($linkurl[$ctr]))."', ".
		                            "title = '".trim(addslashes($linktitle[$ctr])).
					    			"' WHERE (".$querylabel2."_id = ".$id.") AND (link_id = ".$linkid[$ctr].")";
		        echo $query."<BR>";
	            $results = getqueryresults($query);
	            displayerrormsg($results,"insert");
			} else {
		        $query = "INSERT INTO links (url, title, ".$querylabel2."_id) VALUES ('".trim(addslashes($linkurl[$ctr]))."', ".
		                            "'".trim(addslashes($linktitle[$ctr])).
					    			"', ".$id.")";
		        echo $query."<BR>";
	            $results = getqueryresults($query);
	            displayerrormsg($results,"insert");
			}	
		} else {
		   if (!empty($linkid[$ctr])) { 
		        $query = "DELETE FROM links WHERE (link_id = ".$linkid[$ctr].")";
		        echo $query."<BR>";
	            $results = getqueryresults($query);
				displayerrormsg($results,"delete");				
		   }
		}						
	}
?>
<BR>
<BR>
Click <A HREF="<?PHP echo $HTTP_REFERER; ?>">here</A> to go to page you last visited.<BR>
Click <A HREF="/vote/admin/input/">here</A> to go back to Data Entry for Incumbents and Candidates Page.
<BR><BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

