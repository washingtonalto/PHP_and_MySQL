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
<A HREF="/vote/admin/inputparty/"><B>Data Entry for Parties and Coalitions</B></A>
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
	$query = "SELECT name, acronym, yearfounded, yearregistered, is_national,
	            province_id, partytype_id, municity_id, ncrmunicity_id, vision,
				mission, platform, party_history, partyorganization, email, telnumbers,
				address, faxnumbers, programofgovt, standonissues  
				FROM party WHERE (party_id = ".$partyid.")";
	$party = getqueryresults($query); 
	$partyrow = mysql_fetch_array($party);
	
	$query = "SELECT link_id, url, title FROM links, party
	          WHERE (party.party_id = links.party_id) AND 
			        (links.party_id = ".$partyid.")";
	$links = getqueryresults($query);		
	
	$query = "SELECT name As province, province_id FROM provinces ORDER by provinces.name";
	$province = getqueryresults($query);   
	
	$query = "SELECT municity.municity_id, municity.name As municity,
	          provinces.name As province FROM municity, legdistricts, provinces
	          WHERE (municity.legdist_id = legdistricts.legdist_id) AND 
			        (legdistricts.province_id = provinces.province_id)
			  ORDER BY provinces.name, municity.name";
	$municity = getqueryresults($query);	
	
	$query = "SELECT nationalcapitalregion.municity_id, 
	                 nationalcapitalregion.name As municity
	          FROM nationalcapitalregion ORDER BY nationalcapitalregion.name";
	$ncrmunicity = getqueryresults($query);		  	    
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
<B>Full Name:</B>&nbsp;&nbsp;<?PHP echo $partyrow['name']; ?><BR>
<B>Acronym:</B>&nbsp;&nbsp;<?PHP echo stripslashes($partyrow['acronym']); ?><BR>
<B>Tel Nos.:</B>&nbsp;&nbsp;<?PHP echo stripslashes($partyrow['telnumbers']); ?><BR>
<B>Fax Nos.:</B>&nbsp;&nbsp;<?PHP echo stripslashes($partyrow['faxnumbers']); ?><BR>
<B>E-mail:</B>&nbsp;&nbsp;<?PHP echo stripslashes($partyrow['email']); ?><BR>

<H2 CLASS="INDPROFILE">Vision</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Vision -->
    <SPAN CLASS="VOTERDETAIL">
	<?PHP echo stripslashes($partyrow['vision']); ?>	
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
	<?PHP echo stripslashes($partyrow['mission']); ?>	
    </SPAN> 
	<!-- End of Information on Mission -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Party History</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Party History -->
    <SPAN CLASS="VOTERDETAIL">
	<?PHP echo stripslashes($partyrow['party_history']); ?>	
    </SPAN> 
	<!-- End of Information on Party History -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Party Organization</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Party Organzation -->
    <SPAN CLASS="VOTERDETAIL">
	<?PHP echo stripslashes($partyrow['partyorganization']); ?>	
    </SPAN> 
	<!-- End of Information on Party Organization -->	
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
	<?PHP echo stripslashes($partyrow['platform']); ?>	
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
	<?PHP echo stripslashes($partyrow['programofgovt']); ?>	
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
	<?PHP echo stripslashes($partyrow['standonissues']); ?>	
	</SPAN> 
	<!-- End of Information on Stand on Certain Issues -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Links</H2>

<?PHP $ctr=1; $linksrow = mysql_fetch_array($links); ?>
<OL>
<?PHP while ($ctr <= 10) { ?>
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
<INPUT TYPE="hidden" NAME="partyid" VALUE="<?PHP echo $partyid; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Delete Record"></DIV>
</FORM>
<?PHP mysql_free_result($party); ?>

<?PHP } else { ?> <!-- display preview -->

<?PHP
	$query = "DELETE FROM party WHERE (party_id = ".$partyid.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"insert");
?>
<BR>
<BR>
Click <A HREF="<?PHP echo $HTTP_REFERER; ?>">here</A> to go to page you last visited.<BR>
Click <A HREF="/vote/admin/inputparty/">here</A> to go back to Data Entry for Party and Coalition Page.
<BR><BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

