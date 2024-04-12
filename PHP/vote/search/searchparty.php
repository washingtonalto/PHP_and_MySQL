<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->
<?PHP	

if (!empty($submit)) {

	//Acronym
	$query = "SELECT  party.party_id As id, party.acronym As acronym, party.name As partyname
	FROM party
	WHERE (UCASE(TRIM(party.acronym)) LIKE UCASE(\"%".$name."%\")) OR (UCASE(TRIM(party.name)) LIKE UCASE(\"%".$name."%\")) 
	ORDER BY party.acronym";
	$acroparty =  getqueryresults($query);
	$acropartynum = mysql_num_rows($acroparty);

	$numresults = $acropartynum;
}	
?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Search Party</TITLE>
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
<A HREF="/vote/search/search.php"><B>Search Vote.ph</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Search Party</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>SEARCH PARTY</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="get">
Enter search string for party acronym:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" SIZE="40" MAXLENGTH="80"><BR><BR>
<I>Enter a search string matching a portion of the party acronym or name you want to search. For 
   example, the search string <B><I>la</I></B> may return parties containing the string 
   <B><I>lakas</I></B>, <B><I>laban</I></B>, etc. Note that this search is case-insensitive 
   and hence, lowercase letters or capital letters do not matter.
</I>.<BR><BR> 
<INPUT TYPE="hidden" NAME="submit" VALUE="SUBMIT">
<INPUT TYPE="submit" VALUE="Submit">
</FORM>		
<BR>
<?PHP if (!empty($submit)) { ?>
<H2 CLASS="HIGHLIGHTS">SEARCH RESULTS</H2>
<P>
<?PHP $ctr=0; ?>
Search results for <B><SPAN STYLE="color: Blue;"><I><?PHP echo $name; ?></I></SPAN>&nbsp;(<?PHP echo $numresults; ?>&nbsp;matches):</B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>No.</B></TD><TD><B>Acronym</B></TD><TD><B>Name</B></TD></TR>
	<?PHP while ($acropartyrow = mysql_fetch_array($acroparty)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD>
			   <?PHP echo $ctr; ?>
			</TD>
			<TD>
			    <A HREF=<?PHP echo "/vote/partydet.php?partyid=".$acropartyrow['id']; ?>>
			       <?PHP
				       if (!empty($acropartyrow['acronym'])) { 
				            echo $acropartyrow['acronym'];
						} else {
							echo "&nbsp;";
						} 	 
				   ?>
				</A>
			</TD>
			<TD>
			    <A HREF=<?PHP echo "/vote/partydet.php?partyid=".$acropartyrow['id']; ?>>			
			    <?PHP echo $acropartyrow['partyname']; ?>
				</A>
			</TD>
			</TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($acroparty); ?>

</TABLE>	
<?PHP } ?>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
