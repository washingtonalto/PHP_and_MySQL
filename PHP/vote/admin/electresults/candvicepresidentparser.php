<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results Input on Vice Presidential Candidates</TITLE>
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
<A HREF="/vote/admin/electresults/"><B>Elections Results Input</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Vice Presidential Candidates (Parser)</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT ON VICE PRESIDENTIAL CANDIDATES (VIA PARSER)</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>There should be exactly three values which are delimited by commas. The first one should be lastname as it
will appear in vote.ph vicepresidential candidate's list; the second one should represented official count and the third
one should represent quick count.
<LI>The last name value is case-insensitive.
<LI>If vote values have commas, remove them so that program can distinguish delimited fields. 
<LI>The important delimiters to remember are the "," and the ";". Spaces are discarded by the parser.
<LI>Failure to follow any of the instructions above may result in a page-full of errors. Garbage-in, garbage-out.
<LI>The manner of updating here is non-destructive. It will only update those fields where values
are supplied.
<LI>This service is provided as-is with no warranties provided, implied or expressed. Be sure to
use the regular web form after using this.
</OL>
<B>Examples of inputs:</B><BR>
Arroyo,4,5;<BR>
Bajunaid,7,8;<BR>
Adaza,234343,234224;<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Enter vice presidential input in comma-delimited format:</B><BR>
<TEXTAREA COLS="80" ROWS="18" NAME="parseinput"></TEXTAREA>
<BR>
<BR>
<BR>
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>

<?PHP } else { ?> <!-- display preview -->

<?PHP 
echo "<B>Input</B>:<BR>";
echo $parseinput; 
echo "<BR><BR>";
echo "<B>Queries executed</B>:<BR>";
$linearray = explode(";",$parseinput);
for ($ctr=0;$ctr < sizeof($linearray)-1;$ctr++) {
	list($lastname,$numvotes,$numvotesunof) = split(",",$linearray[$ctr]);
	$query	= "UPDATE candvicepresidents SET numvotes=".strval($numvotes).", numvotesunof=".strval($numvotesunof).
	          " WHERE UCASE(lastname) = '".strtoupper(trim($lastname))."'";
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
$query = "SELECT candvicepresidents.vicepresident_id, candvicepresidents.lastname, candvicepresidents.firstname, candvicepresidents.middleinitial, candvicepresidents.numvotes, candvicepresidents.numvotesunof
          FROM candvicepresidents ORDER BY candvicepresidents.lastname";
$candvicepresidents = getqueryresults($query);
?>
<BR>
<?PHP $ctr = 0; ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Official Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD>
</TR>
	<?PHP
		while ($candvicepresidentsrow = mysql_fetch_array($candvicepresidents)) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
		<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname'] ?>	
		<?PHP if(!empty($candvicepresidentsrow['middleinitial'])) { ?>
      		&nbsp;<?PHP echo $candvicepresidentsrow['middleinitial']."."; ?>
		<?PHP } ?>	
	</TD>
	<TD ALIGN="right"><?PHP echo number_format($candvicepresidentsrow['numvotes']); ?></TD>
	<TD ALIGN="right"><?PHP echo number_format($candvicepresidentsrow['numvotesunof']); ?></TD>	
	</TR>
	<?PHP } ?>
</TABLE>
<BR>
Click <A HREF="/vote/electresults/candvicepresidentlist.php">here</A> to view vicepresidential election results.<BR>
Click <A HREF="/vote/admin/electresults/">here</A> to go back to election results input main page.<BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
