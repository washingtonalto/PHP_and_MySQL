<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->

<?PHP	

if (!empty($submit)) {

	//Party
	$query = "SELECT  party.party_id As id, party.acronym As acronym, party.name As partyname
	FROM party
	WHERE (UCASE(TRIM(party.acronym)) LIKE UCASE(\"%".$name."%\")) OR (UCASE(TRIM(party.name)) LIKE UCASE(\"%".$name."%\")) 
	ORDER BY party.acronym";
	$party =  getqueryresults($query);
	$partynum = mysql_num_rows($party);

	//Coalition
    $query = "SELECT coalition_id As id, acronym, name As coalitionname
	          FROM coalitions
			  WHERE (UCASE(TRIM(coalitions.acronym)) LIKE UCASE(\"%".$name."%\")) OR (UCASE(TRIM(coalitions.name)) LIKE UCASE(\"%".$name."%\")) 
	          ORDER BY coalitions.acronym";
	$coalition =  getqueryresults($query);
	$coalitionnum = mysql_num_rows($coalition);
	$numresults = $coalitionnum + $partynum;
}

?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Delete Records</TITLE>
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
<B>Delete Records</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>DELETE RECORDS</B></DIV>
<BR>
<BR>		
<FORM ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="get">
Enter search string for name:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" SIZE="40" MAXLENGTH="80"><BR><BR>
<I>Enter a search string matching a portion of the party/coalition acronym or name you want to search. For 
   example, the search string <B><I>la</I></B> may return parties/coalitions containing the string 
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
	<?PHP while ($coalitionrow = mysql_fetch_array($coalition)) { ?>
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
			    <A HREF=<?PHP echo "/vote/admin/inputparty/deletecoalition.php?coalitionid=".$coalitionrow['id']; ?>>
			       <?PHP
				       if (!empty($coalitionrow['acronym'])) { 
				            echo $coalitionrow['acronym'];
						} else {
							echo "&nbsp;";
						} 	 
				   ?>
				</A>
			</TD>
			<TD>
			    <A HREF=<?PHP echo "/vote/admin/inputparty/deletecoalition.php?coalitionid=".$coalitionrow['id']; ?>>			
			    <?PHP echo $coalitionrow['coalitionname']; ?>
				</A>
			</TD>
			</TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($coalition); ?>

	<?PHP while ($partyrow = mysql_fetch_array($party)) { ?>
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
			    <A HREF=<?PHP echo "/vote/admin/inputparty/deleteparty.php?partyid=".$partyrow['id']; ?>>
			       <?PHP
				       if (!empty($partyrow['acronym'])) { 
				            echo $partyrow['acronym'];
						} else {
							echo "&nbsp;";
						} 	 
				   ?>
				</A>
			</TD>
			<TD>
			    <A HREF=<?PHP echo "/vote/admin/inputparty/deleteparty.php?partyid=".$partyrow['id']; ?>>			
			    <?PHP echo $partyrow['partyname']; ?>
				</A>
			</TD>
			</TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($party); ?>
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

