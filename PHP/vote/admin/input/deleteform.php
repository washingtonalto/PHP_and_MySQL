<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Delete Record Page</TITLE>
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
<B>Delete Record Page</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>DELETE RECORD PAGE</B></DIV>
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
	$query = "SELECT lastname, firstname, middleinitial, picturelocation, 
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
<B>ID:</B>&nbsp;&nbsp;<?PHP echo $id; ?><BR>
<B>Full Name:</B>&nbsp;&nbsp;<?PHP echo $profilerow['lastname'].", ".$profilerow['firstname']; ?>
<?PHP if (!empty($profilerow['middleinitial'])) { ?>
	<?PHP echo $profilerow['middleinitial']; ?>
<?PHP } ?><BR>
<B>Type:</B>&nbsp;&nbsp;<?PHP echo $type; ?><BR>
<B>File Name for Picture (if any):</B>&nbsp;&nbsp;<?PHP echo $profilerow['picturelocation']; ?><BR>
<B>Nickname:</B>&nbsp;&nbsp;<?PHP echo $profilerow['nickname']; ?><BR>	
<B>Birthdate:</B>&nbsp;&nbsp;<?PHP echo $profilerow['birthdate']; ?><BR>
<B>Birthplace:</B>&nbsp;&nbsp;<?PHP echo stripslashes($profilerow['birthplace']); ?><BR>
<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo stripslashes($profilerow['telnum']); ?><BR>
<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo stripslashes($profilerow['faxnum']); ?><BR>
<B>E-mail:</B>&nbsp;&nbsp;<?PHP echo stripslashes($profilerow['emailaddr']); ?><BR>
<H2 CLASS="INDPROFILE">Activities</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Activities -->
    <SPAN CLASS="VOTERDETAIL">
	<?PHP echo stripslashes($profilerow['activities']); ?>	
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
	<?PHP echo stripslashes($profilerow['biography']); ?>	
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
	<?PHP echo stripslashes($profilerow['platform']); ?>	
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
	<?PHP echo stripslashes($profilerow['programofgovt']); ?>	
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
	<?PHP echo stripslashes($profilerow['standonissues']); ?>	
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
	<?PHP echo stripslashes($profilerow['accomplishments']); ?>	
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
	<?PHP echo stripslashes($profilerow['workexperiences']); ?>	
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
	<?PHP echo stripslashes($profilerow['educattainment']); ?>	
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
	<?PHP echo stripslashes($profilerow['familyinfo']); ?>	
	</SPAN>
	<!-- End of Information on Family Information -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Links</H2>

<?PHP $ctr=1; $linksrow = mysql_fetch_array($links); ?>
<OL>
<?PHP while ($ctr <= sizeof($links)) { ?>
	<LI><B>URL:</B>&nbsp;&nbsp;<?PHP echo stripslashes($linksrow['url']); ?><BR>
	    <B>Title:</B>&nbsp;&nbsp;<?PHP echo stripslashes($linksrow['title']); ?><BR>
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
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Delete Record"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Cancel"></DIV>
</FORM>
<?PHP mysql_free_result($profile); ?>

<?PHP } elseif ($hassubmit == "Cancel") { ?> <!-- If user decides to cancel -->

<B>User has cancelled deletion!</B><BR>

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
	$query = "DELETE FROM ".$querylabel1." WHERE (".$querylabel2."_id = ".$id.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"delete");
	$query = "DELETE FROM links WHERE (".$querylabel3."_id = ".$id.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"delete");
	
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

