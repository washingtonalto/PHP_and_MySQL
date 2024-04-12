<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results Input on Vice Presidential Candidates By Region</TITLE>
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
<B>Vice Presidential Candidates Regional Breakdown (Parser)</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT ON VICE PRESIDENTIAL CANDIDATES REGIONAL BREAKDOWN (VIA PARSER)</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentbreakdown.txt",'r');
	$content = fread($fp,filesize($votehome."/vote/admin/electresults/electresultsvicepresidentbreakdown.txt"));
	fclose($fp);
?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>There should be exactly 19 values which are delimited by commas. The should be strictly in the ff. order:
lastname, Absentee votes, NCR votes, CAR votes, region 1 votes, region 2 votes, region 3 votes, region 4 votes, 
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
Adaza	,	11	,	16388	,	5840	,	12279	,	1564	,	13237	,	50381	,	3942	,	8069	,	775	,	804	,	3388	,	23286	,	4603	,	0	,	0	,	18187	;<BR>
Angara	,	237	,	218878	,	80779	,	193676	,	24797	,	273458	,	1140680	,	89025	,	217441	,	8909	,	18462	,	54492	,	68932	,	67734	,	0	,	0	,	130904	;<BR>
Arroyo	,	176	,	231855	,	112649	,	235170	,	24424	,	299756	,	943838	,	120595	,	219208	,	16038	,	18375	,	34961	,	88438	,	61185	,	0	,	0	,	139701	;<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Enter Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="comments"><?PHP echo $content; ?></TEXTAREA>
<BR>
<BR>
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
	list($lastname,$Absenteevotes, $regionNCRvotes, $regionCARvotes, $region1votes,$region2votes,$region3votes,$region4votes,$region5votes,$region6votes,$region7votes,$region8votes,$region9votes,$region10votes,$region11votes,$region12votes, $regionARMMvotes, $region13votes) = split(",",$linearray[$ctr]);
	$query	= "UPDATE candvicepresidents SET regionNCRvotes=".strval($regionNCRvotes).", region1votes=".strval($region1votes).
	                                 " ,region2votes=".strval($region2votes).", region3votes=".strval($region3votes).  
									 " ,region4votes=".strval($region4votes).", region5votes=".strval($region5votes).									 
									 " ,region6votes=".strval($region6votes).", region7votes=".strval($region7votes).
									 " ,region8votes=".strval($region8votes).", region9votes=".strval($region9votes).									 
									 " ,region10votes=".strval($region10votes).", region11votes=".strval($region11votes).	
									 " ,region12votes=".strval($region12votes).", region13votes=".strval($region13votes).	
									 " ,regionCARvotes=".strval($regionCARvotes).", regionARMMvotes=".strval($regionARMMvotes).									 									 " ,region8votes=".strval($region8votes).", region9votes=".strval($region9votes).									 									 
									 " ,Absenteevotes=".strval($Absenteevotes).								 									 								 
	          " WHERE UCASE(lastname) = '".strtoupper(trim($lastname))."'";
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
$query = "SELECT vicepresident_id, lastname,firstname, middleinitial, (region1votes + region2votes + region3votes + region4votes + region5votes + region6votes + region7votes + region8votes + region9votes + region10votes + region11votes + region12votes + region13votes + regionARMMvotes + regionCARvotes + regionNCRvotes + Absenteevotes) As totvotes, 
    region1votes, region2votes, region3votes, region4votes, region5votes,
    region6votes, region7votes, region8votes, region9votes, region10votes,	
    region11votes, region12votes, region13votes, regionARMMvotes, regionCARvotes, 
	regionNCRvotes, Absenteevotes	
	FROM candvicepresidents ORDER by candvicepresidents.lastname";
$candvicepresidents = getqueryresults($query);
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
	<?PHP while ($candvicepresidentsrow = mysql_fetch_array($candvicepresidents)) { ?>
        <?PHP if ($ctr % 2 == 0) { ?>	
			<TR BGCOLOR="#C5E0FE">	
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		    <?PHP $ctr++; ?>
			<TD ALIGN="right"><SPAN CLASS="breakdownstat"><?PHP echo number_format($ctr); ?></SPAN></TD>		
			<TD ALIGN="left">
			    <SPAN CLASS="breakdownstat">
					<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname'] ?>	
					<?PHP if(!empty($candvicepresidentsrow['middleinitial'])) { ?>
      					&nbsp;<?PHP echo $candvicepresidentsrow['middleinitial']."."; ?>
					<?PHP } ?>	    
				</SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['totvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['regionNCRvotes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region1votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region2votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region3votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region4votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region5votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region6votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region7votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region8votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region9votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region10votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region11votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region12votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['regionARMMvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['regionCARvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['region13votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN CLASS="breakdownstat"><?PHP echo number_format($candvicepresidentsrow['Absenteevotes']); ?></SPAN></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<?PHP mysql_free_result($candvicepresidents); ?><BR>
<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentbreakdown.txt",'w');
	fwrite($fp,$comments);
	fclose($fp);
?>
Click <A HREF="/vote/electresults/candvicepresidentlistbreakdown.php">here</A> to view vicepresidential election results by regional breakdown.<BR>
Click <A HREF="/vote/admin/electresults/">here</A> to go back to election results input main page.<BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
