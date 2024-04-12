<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results Input on Party-list Candidates By Region</TITLE>
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
<B>Party-list Candidates Regional Breakdown (Parser)</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT ON PARTY-LIST CANDIDATES REGIONAL BREAKDOWN (VIA PARSER)</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultspartylistbreakdown.txt",'r');
	$content = fread($fp,filesize($votehome."/vote/admin/electresults/electresultspartylistbreakdown.txt"));
	fclose($fp);
?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>There should be exactly 19 values which are delimited by commas. The should be strictly in the ff. order:
party acronym, Absentee votes, NCR votes, CAR votes, region 1 votes, region 2 votes, region 3 votes, region 4 votes, 
region 5 votes, region 6 votes, region 7 votes, region 8 votes, region 9 votes, region 10 votes, region 11 votes,
region 12 votes, ARMM votes, CARAGA (region 13) votes. 
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
A	,	0	,	0	,	0	,	180	,	61	,	250	,	233	,	128	,	1320	,	93	,	18	,	0	,	11	,	0	,	0	,	0	,	0	;<BR>
AA	,	0	,	0	,	0	,	45	,	3	,	92	,	23	,	25	,	7	,	16	,	6	,	0	,	33	,	0	,	0	,	0	,	0	;<BR>
AAAFPI	,	0	,	0	,	0	,	32	,	11	,	281	,	129	,	52	,	34	,	3	,	8	,	0	,	17	,	0	,	0	,	0	,	0	;<BR>
AASAHAN	,	0	,	0	,	0	,	13	,	3	,	26	,	34	,	24	,	9	,	1	,	0	,	0	,	1	,	0	,	0	,	0	,	0	;<BR>
<BR><BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Enter Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="comments"><?PHP echo $content; ?></TEXTAREA>
<BR>
<BR>
<B>Enter party-list input in comma-delimited format:</B><BR>
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
	list($acronym,$Absenteevotes, $regionNCRvotes, $regionCARvotes, $region1votes,$region2votes,$region3votes,$region4votes,$region5votes,$region6votes,$region7votes,$region8votes,$region9votes,$region10votes,$region11votes,$region12votes, $regionARMMvotes, $region13votes) = split(",",$linearray[$ctr]);
	$query = "SELECT candpartylist.party_id FROM party,candpartylist WHERE (party.party_id = candpartylist.party_id) AND (UCASE(party.acronym) = '".strtoupper(trim($acronym))."')"; 
	echo $query."<BR>";		  		
	$party = getqueryresults($query);
	$partyrow = mysql_fetch_array($party);
	$query	= "UPDATE candpartylist SET regionNCRvotes=".strval($regionNCRvotes).", region1votes=".strval($region1votes).
	                                 " ,region2votes=".strval($region2votes).", region3votes=".strval($region3votes).  
									 " ,region4votes=".strval($region4votes).", region5votes=".strval($region5votes).									 
									 " ,region6votes=".strval($region6votes).", region7votes=".strval($region7votes).
									 " ,region8votes=".strval($region8votes).", region9votes=".strval($region9votes).									 
									 " ,region10votes=".strval($region10votes).", region11votes=".strval($region11votes).	
									 " ,region12votes=".strval($region12votes).", region13votes=".strval($region13votes).	
									 " ,regionCARvotes=".strval($regionCARvotes).", regionARMMvotes=".strval($regionARMMvotes).									 									 " ,region8votes=".strval($region8votes).", region9votes=".strval($region9votes).									 									 
									 " ,Absenteevotes=".strval($Absenteevotes).								 									 								 
	          " WHERE candpartylist.party_id = ".$partyrow['party_id']."";
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
$query = "SELECT candpartylist.party_id, party.acronym, (region1votes + region2votes + region3votes + region4votes + region5votes + region6votes + region7votes + region8votes + region9votes + region10votes + region11votes + region12votes + region13votes + regionARMMvotes + regionCARvotes + regionNCRvotes + Absenteevotes) As totvotes, 
    region1votes, region2votes, region3votes, region4votes, region5votes,
    region6votes, region7votes, region8votes, region9votes, region10votes,	
    region11votes, region12votes, region13votes, regionARMMvotes, regionCARvotes, 
	regionNCRvotes, Absenteevotes	
	FROM candpartylist, party 
	WHERE (candpartylist.party_id = party.party_id)
	ORDER by party.acronym";
$candpartylist = getqueryresults($query);
?>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="left" VALIGN="top"><B><SPAN CLASS="breakdownstat">No.</SPAN></B></TD>
		<TD ALIGN="left" VALIGN="top"><B><SPAN CLASS="breakdownstat">Name</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">Total</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">NCR</SPAN></B></TD>			
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">I</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">II</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">III</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">IV</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">V</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VI</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VII</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VIII</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">IX</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">X</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">XI</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">XII</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">ARMM</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">CAR</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">CARAGA</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">Absentee</SPAN></B></TD>		
	</TR>
	<?PHP $ctr=0; ?>
	<?PHP while ($candpartylistrow = mysql_fetch_array($candpartylist)) { ?>
        <?PHP if ($ctr % 2 == 0) { ?>	
			<TR BGCOLOR="#C5E0FE">	
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		    <?PHP $ctr++; ?>
			<TD ALIGN="right"><SPAN CLASS="breakdownstat"><?PHP echo number_format($ctr); ?></SPAN></TD>		
			<TD ALIGN="left">
			    <SPAN CLASS="breakdownstat">
					<?PHP echo $candpartylistrow['acronym']; ?>	
				</SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['totvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['regionNCRvotes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region1votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region2votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region3votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region4votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region5votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region6votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region7votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region8votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region9votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region10votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region11votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region12votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['regionARMMvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['regionCARvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['region13votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candpartylistrow['Absenteevotes']); ?></SPAN></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<?PHP mysql_free_result($candpartylist); ?><BR>
<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultspartylistbreakdown.txt",'w');
	fwrite($fp,$comments);
	fclose($fp);
?>
Click <A HREF="/vote/electresults/candpartylistbreakdown.php">here</A> to view party-list election results by regional breakdown.<BR>
Click <A HREF="/vote/admin/electresults/">here</A> to go back to election results input main page.<BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
