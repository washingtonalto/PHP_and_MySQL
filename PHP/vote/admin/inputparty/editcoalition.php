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
<A HREF="/vote/admin/inputparty/"><B>Data Entry for Parties and Coalitions</B></A>
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
	$query = "SELECT name, acronym, vision, mission, platform, 
	            coalitionorganization, email, telnumbers,
				address, faxnumbers, programofgovt, standonissues,
				coalitionhistory  
				FROM coalitions WHERE (coalition_id = ".$coalitionid.")";
	$coalition = getqueryresults($query); 
	$coalitionrow = mysql_fetch_array($coalition);
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
<B>Full Name:</B>&nbsp;&nbsp;<?PHP echo $coalitionrow['name']; ?><BR>
<B>Full Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" VALUE="<?PHP echo stripslashes($coalitionrow['name']); ?>" SIZE="70"><BR>
<B>Acronym:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="acronym" VALUE="<?PHP echo stripslashes($coalitionrow['acronym']); ?>" SIZE="25"><BR>
<B>Tel Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="telnumbers" SIZE="30" VALUE="<?PHP echo stripslashes($coalitionrow['telnumbers']); ?>"><BR>
<B>Fax Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="faxnumbers" SIZE="30" VALUE="<?PHP echo stripslashes($coalitionrow['faxnumbers']); ?>"><BR>
<B>E-mail:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="email" SIZE="50" VALUE="<?PHP echo stripslashes($coalitionrow['email']); ?>"><BR>
<H2 CLASS="INDPROFILE">Vision</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Vision -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="vision">
	<?PHP echo stripslashes($coalitionrow['vision']); ?>	
    </TEXTAREA>
	</SPAN>
	<!-- End of Information on Vision -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Mission</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Mission -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="mission">
	<?PHP echo stripslashes($coalitionrow['mission']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Mission -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Coalition Organization</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Coalition Organzation -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="coalitionorganization">
	<?PHP echo stripslashes($coalitionrow['coalitionorganization']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Coalition Organization -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Coalition History</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Coalition History -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="coalitionhistory">
	<?PHP echo stripslashes($coalitionrow['coalitionhistory']); ?>	
	</TEXTAREA>
    </SPAN> 
	<!-- End of Information on Coalition History -->	
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
	<?PHP echo stripslashes($coalitionrow['platform']); ?>	
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
	<?PHP echo stripslashes($coalitionrow['programofgovt']); ?>	
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
	<?PHP echo stripslashes($coalitionrow['standonissues']); ?>	
    </TEXTAREA>
	</SPAN> 
	<!-- End of Information on Stand on Certain Issues -->	
	</TD>
	</TR>
</TABLE>

<!--- End Body of Information -->	
	</TD>	
</TR>
</TABLE>
<BR><BR><BR>
<INPUT TYPE="hidden" NAME="coalitionid" VALUE="<?PHP echo $coalitionid; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>
<?PHP mysql_free_result($coalition); ?>

<?PHP } else { ?> <!-- display preview -->

<?PHP
	$query = "UPDATE coalitions SET name = '".addslashes($name).
	                       "', acronym = '".addslashes($acronym).
						   "', mission = '".addslashes($mission).    
        				   "', platform = '".addslashes(trim($platform)).
							"', coalitionhistory = '".addslashes(trim($coalitionhistory)).
						    "', coalitionorganization = '".addslashes(trim($coalitionorganization)).
							"', email = '".addslashes(trim($email)).
							"', telnumbers = '".addslashes(trim($telnumbers)).
							"', faxnumbers = '".addslashes(trim($faxnumbers)).
							"', programofgovt = '".addslashes(trim($programofgovt)).
							"', standonissues = '".addslashes(trim($standonissues)).
							"' WHERE (coalition_id = ".$coalitionid.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"insert");
?>
<BR>
<BR>
Click <A HREF="<?PHP echo $HTTP_REFERER; ?>">here</A> to go to page you last visited.<BR>
Click <A HREF="/vote/admin/inputparty/">here</A> to go back to Data Entry for Incumbents and Candidates Page.
<BR><BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

