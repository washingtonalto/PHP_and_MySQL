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
	$query = "SELECT name, acronym, yearfounded, yearregistered, is_national,
	            province_id, partytype_id, municity_id, ncrmunicity_id, vision,
				mission, platform, party_history, partyorganization, email, telnumbers,
				address, faxnumbers, programofgovt, standonissues, partytype_id  
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
	
	$query = "SELECT partytype_id, type FROM party_type
	          ORDER BY type";
	$partytype = getqueryresults($query);		  	    
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
<B>Full Name:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" VALUE="<?PHP echo stripslashes($partyrow['name']); ?>" SIZE="70"><BR>
<B>Acronym:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="acronym" VALUE="<?PHP echo stripslashes($partyrow['acronym']); ?>" SIZE="25"><BR>
<B>Tel Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="telnumbers" SIZE="30" VALUE="<?PHP echo stripslashes($partyrow['telnumbers']); ?>"><BR>
<B>Fax Nos.:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="faxnumbers" SIZE="30" VALUE="<?PHP echo stripslashes($partyrow['faxnumbers']); ?>"><BR>
<B>E-mail:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="email" SIZE="50" VALUE="<?PHP echo stripslashes($partyrow['email']); ?>"><BR>
<B>Party Type:</B>&nbsp;&nbsp;
	<SELECT NAME="partytype_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($partytyperow = mysql_fetch_array($partytype)) { ?>
			<OPTION VALUE="<?PHP echo $partytyperow['partytype_id']; ?>" <?PHP if ($partyrow['partytype_id'] == $partytyperow['partytype_id']) echo "SELECTED"; ?>>
			  <?PHP echo $partytyperow['type']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
<B>Year Registered:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="yearregistered" SIZE="15" VALUE="<?PHP echo $partyrow['yearregistered']; ?>"><BR>
<B>Year Founded:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="yearfounded" VALUE="<?PHP echo $partyrow['yearfounded']; ?>" SIZE="15"><BR>
<B>Is Party National?</B><BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="is_national" VALUE="Y" <?PHP if($partyrow['is_national'] == "Y") echo "CHECKED"; ?>>&nbsp;Yes<BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="is_national" VALUE="N" <?PHP if($partyrow['is_national'] == "N") echo "CHECKED"; ?>>&nbsp;No<BR>
<B>NCR Municipality/City:</B>&nbsp;&nbsp;
	<SELECT NAME="ncrmunicity_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($ncrmunicityrow = mysql_fetch_array($ncrmunicity)) { ?>
			<OPTION VALUE="<?PHP echo $ncrmunicityrow['municity_id']; ?>" <?PHP if ($partyrow['ncrmunicity_id'] == $ncrmunicityrow['municity_id']) echo "SELECTED"; ?>>
			  <?PHP echo $ncrmunicityrow['municity']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($ncrmunicity); ?>
<B>Province:</B>&nbsp;&nbsp;
	<SELECT NAME="province_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($provincerow = mysql_fetch_array($province)) { ?>
			<OPTION VALUE="<?PHP echo $provincerow['province_id']; ?>" <?PHP if ($partyrow['province_id'] == $provincerow['province_id']) echo "SELECTED"; ?>>
			  <?PHP echo $provincerow['province']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($province); ?>
<B>Provincial Municipality/City:</B>&nbsp;&nbsp;
	<SELECT NAME="municity_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($municityrow = mysql_fetch_array($municity)) { ?>
			<OPTION VALUE="<?PHP echo $municityrow['municity_id']; ?>" <?PHP if ($partyrow['municity_id'] == $municityrow['municity_id']) echo "SELECTED"; ?>>
			  <?PHP echo $municityrow['municity']; ?>&nbsp;&nbsp;of&nbsp;&nbsp;<?PHP echo $municityrow['province']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($municity); ?>

<H2 CLASS="INDPROFILE">Vision</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
	<TD WIDTH="24">&nbsp;
	</TD>
	<TD>
	<!-- Start of Information on Vision -->
    <SPAN CLASS="VOTERDETAIL">
	<TEXTAREA COLS="70" ROWS="20" NAME="vision">
	<?PHP echo stripslashes($partyrow['vision']); ?>	
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
	<?PHP echo stripslashes($partyrow['mission']); ?>	
	</TEXTAREA>
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
	<TEXTAREA COLS="70" ROWS="20" NAME="party_history">
	<?PHP echo stripslashes($partyrow['party_history']); ?>	
	</TEXTAREA>
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
	<TEXTAREA COLS="70" ROWS="20" NAME="partyorganization">
	<?PHP echo stripslashes($partyrow['partyorganization']); ?>	
	</TEXTAREA>
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
	<TEXTAREA COLS="70" ROWS="20" NAME="platform">	
	<?PHP echo stripslashes($partyrow['platform']); ?>	
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
	<?PHP echo stripslashes($partyrow['programofgovt']); ?>	
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
	<?PHP echo stripslashes($partyrow['standonissues']); ?>	
    </TEXTAREA>
	</SPAN> 
	<!-- End of Information on Stand on Certain Issues -->	
	</TD>
	</TR>
</TABLE>

<H2 CLASS="INDPROFILE">Links</H2>

<?PHP $ctr=1; $linksrow = mysql_fetch_array($links); ?>
<OL>
<?PHP while ($ctr <= 10) { ?>
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
<INPUT TYPE="hidden" NAME="partyid" VALUE="<?PHP echo $partyid; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>
<?PHP mysql_free_result($party); ?>

<?PHP } else { ?> <!-- display preview -->

<?PHP
	$query = "UPDATE party SET name = '".addslashes($name).
	                       "', acronym = '".addslashes($acronym).
						   "', mission = '".addslashes($mission).    
        				   "', platform = '".addslashes(trim($platform)).
							"', party_history = '".addslashes(trim($party_history)).
						    "', partyorganization = '".addslashes(trim($partyorganization)).
							"', email = '".addslashes(trim($email)).
							"', telnumbers = '".addslashes(trim($telnumbers)).
							"', faxnumbers = '".addslashes(trim($faxnumbers)).
							"', programofgovt = '".addslashes(trim($programofgovt)).
							"', standonissues = '".addslashes(trim($standonissues)).
							"', municity_id = ".$municity_id.
							",  ncrmunicity_id = ".$ncrmunicity_id.							
							", is_national = '".$is_national.
							"', province_id = ".$province_id.	
							", partytype_id = ".$partytype_id.
							", yearfounded = ".$yearfounded.								  
							", yearregistered = ".$yearregistered.
							" WHERE (party_id = ".$partyid.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"insert");
	echo "<BR><BR><B>Links Query Executed:</B><BR>";	
	for ($ctr=1;$ctr <= 10; $ctr++) {
	    if (!empty($linkurl[$ctr])) {
		   if (!empty($linkid[$ctr])) {
		        $query = "UPDATE links SET url= '".trim(addslashes($linkurl[$ctr]))."', ".
		                            "title = '".trim(addslashes($linktitle[$ctr])).
					    			"' WHERE (party_id = ".$partyid.") AND (link_id = ".$linkid[$ctr].")";
		        echo $query."<BR>";
	            $results = getqueryresults($query);
	            displayerrormsg($results,"insert");
			} else {
		        $query = "INSERT INTO links (url, title, party_id) VALUES ('".trim(addslashes($linkurl[$ctr]))."', ".
		                            "'".trim(addslashes($linktitle[$ctr])).
					    			"', ".$partyid.")";
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
Click <A HREF="/vote/admin/inputparty/">here</A> to go back to Data Entry for Party and Coalitions Page.
<BR><BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

