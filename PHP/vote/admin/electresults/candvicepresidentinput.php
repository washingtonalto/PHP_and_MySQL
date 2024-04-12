<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT candvicepresidents.vicepresident_id, candvicepresidents.lastname, candvicepresidents.firstname, candvicepresidents.middleinitial, candvicepresidents.numvotes, candvicepresidents.numvotesunof,
          is_proclaimed
          FROM candvicepresidents ORDER BY candvicepresidents.lastname";
$candvicepresidents = getqueryresults($query);
  
?>

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
<B>Vice Presidential Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT ON VICE PRESIDENTIAL CANDIDATES</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentunoff.txt",'r');
	$contentunoff = fread($fp,filesize($votehome."/vote/admin/electresults/electresultsvicepresidentunoff.txt"));
	fclose($fp);
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentoff.txt",'r');
	$contentoff = fread($fp,filesize($votehome."/vote/admin/electresults/electresultsvicepresidentoff.txt"));
	fclose($fp);
	$fp = fopen($votehome."/vote/admin/electresults/vicepresidentcomments.txt",'r');
	$comments = fread($fp,filesize($votehome."/vote/admin/electresults/vicepresidentcomments.txt"));
	fclose($fp);
?>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Updater's Private Comments:</B> <BR>
<TEXTAREA COLS="80" ROWS="5" NAME="updatercomments"><?PHP echo $comments; ?></TEXTAREA>
<BR>
<BR>
<B>Enter Quick Count Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="commentunoff"><?PHP echo $contentunoff; ?></TEXTAREA>
<BR>
<BR>
<B>Enter Official Count Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="commentoff"><?PHP echo $contentoff; ?></TEXTAREA>
<BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Official Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Is Proclaimed</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candvicepresidentsrow = mysql_fetch_array($candvicepresidents);
		while ($candvicepresidentsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
			<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname'] ?>	
			<INPUT TYPE="hidden" NAME="<?PHP echo "vicepresidentid[$ctr]"; ?>" VALUE="<?PHP echo $candvicepresidentsrow['vicepresident_id']; ?>">			   
			<INPUT TYPE="hidden" NAME="<?PHP echo "fullnames[$ctr]"; ?>" VALUE="<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname']; ?>">
	</TD>
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "numvotes[$ctr]"; ?>" SIZE="12" MAXLENGTH="12" VALUE="<?PHP echo $candvicepresidentsrow['numvotes']; ?>"></TD>
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "numvotesunof[$ctr]"; ?>" SIZE="12" MAXLENGTH="12" VALUE="<?PHP echo $candvicepresidentsrow['numvotesunof']; ?>"></TD>	
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "is_proclaimed[$ctr]"; ?>" SIZE="12" MAXLENGTH="12" VALUE="<?PHP echo $candvicepresidentsrow['is_proclaimed']; ?>"></TD>		
	</TR>
	<?PHP $candvicepresidentsrow = mysql_fetch_array($candvicepresidents); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candvicepresidents); ?>
</TABLE>
<BR>
<BR>
<DIV ALIGN="center">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Clear">
</DIV>
</FORM>
<?PHP } else if ($hassubmit == "Clear") { ?> <!-- Reset Button -->

<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentunoff.txt",'r');
	$contentunoff = fread($fp,filesize($votehome."/vote/admin/electresults/electresultsvicepresidentunoff.txt"));
	fclose($fp);
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentoff.txt",'r');
	$contentoff = fread($fp,filesize($votehome."/vote/admin/electresults/electresultsvicepresidentoff.txt"));
	fclose($fp);
	$fp = fopen($votehome."/vote/admin/electresults/vicepresidentcomments.txt",'r');
	$comments = fread($fp,filesize($votehome."/vote/admin/electresults/vicepresidentcomments.txt"));
	fclose($fp);
?>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Updater's Private Comments:</B> <BR>
<TEXTAREA COLS="80" ROWS="5" NAME="updatercomments"><?PHP echo $comments; ?></TEXTAREA>
<BR>
<BR>
<B>Enter Quick Count Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="commentunoff"><?PHP echo $contentunoff; ?></TEXTAREA>
<BR>
<BR>
<B>Enter Official Count Notes:</B><BR>
<TEXTAREA COLS="80" ROWS="5" NAME="commentoff"><?PHP echo $contentoff; ?></TEXTAREA>
<BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Official Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Is Proclaimed</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$candvicepresidentsrow = mysql_fetch_array($candvicepresidents);
		while ($candvicepresidentsrow) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
			<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname'] ?>	
			<INPUT TYPE="hidden" NAME="<?PHP echo "vicepresidentid[$ctr]"; ?>" VALUE="<?PHP echo $candvicepresidentsrow['vicepresident_id']; ?>">			   
			<INPUT TYPE="hidden" NAME="<?PHP echo "fullnames[$ctr]"; ?>" VALUE="<?PHP echo $candvicepresidentsrow['lastname'].", ".$candvicepresidentsrow['firstname']; ?>">
	</TD>
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "numvotes[$ctr]"; ?>" SIZE="12" MAXLENGTH="12"></TD>
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "numvotesunof[$ctr]"; ?>" SIZE="12" MAXLENGTH="12"></TD>	
	<TD ALIGN="right"><INPUT TYPE="text" NAME="<?PHP echo "is_proclaimed[$ctr]"; ?>" SIZE="12" MAXLENGTH="12"></TD>	
	</TR>
	<?PHP $candvicepresidentsrow = mysql_fetch_array($candvicepresidents); ?>
	
	<?PHP } ?>
	<?PHP mysql_free_result($candvicepresidents); ?>
</TABLE>
<BR>
<BR>
<DIV ALIGN="center">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Clear">
</DIV>
</FORM>

<?PHP } else { ?> <!-- display preview -->

You have just updated the election results as follows:
<BR>
<BR>
<B>Quick Count Notes:</B><BR>
<PRE>
<?PHP echo $commentunoff; ?>
</PRE>
<BR>
<B>Official Count Notes:</B><BR>
<PRE>
<?PHP echo $commentoff; ?>
</PRE>
<BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD ALIGN="left" VALIGN="top"><B>#</B></TD><TD ALIGN="left" VALIGN="top"><B>Name</B></TD><TD ALIGN="right" VALIGN="top"><B>Official Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Quick Count Votes</B></TD><TD ALIGN="right" VALIGN="top"><B>Is Proclaimed</B></TD>
</TR>
	<?PHP
		$ctr = 0;
		$numvicepresidents = sizeof($vicepresidentid);
		while ($ctr < $numvicepresidents) {
	?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><?PHP $ctr++; echo $ctr; ?>&nbsp;&nbsp;</TD>
	<TD>
			<?PHP echo $fullnames[$ctr]; ?>
	</TD>
	<TD ALIGN="right"><?PHP echo number_format($numvotes[$ctr]); ?></TD>
	<TD ALIGN="right"><?PHP echo number_format($numvotesunof[$ctr]); ?></TD>	
	<TD ALIGN="right"><?PHP echo $is_proclaimed[$ctr]; ?></TD>		
	</TR>
	<?PHP
	    if (empty($numvotes[$ctr])) {
			$numvotes[$ctr] = 0;
		}
	    if (empty($numvotesunof[$ctr])) {
			$numvotesunof[$ctr] = 0;
		}
		$query	= "UPDATE candvicepresidents SET numvotes=".strval($numvotes[$ctr]).", numvotesunof=".strval($numvotesunof[$ctr]).
		          ", is_proclaimed = '".trim($is_proclaimed[$ctr]).
		          "' WHERE vicepresident_id = ".$vicepresidentid[$ctr];
		$results = getqueryresults($query);		
	?>
	<?PHP } ?>
</TABLE>
<BR>
<BR>
<?PHP
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentunoff.txt",'w');
	fwrite($fp,$commentunoff);
	fclose($fp);
	$fp = fopen($votehome."/vote/admin/electresults/electresultsvicepresidentoff.txt",'w');
	fwrite($fp,$commentoff);
	fclose($fp);	
	$fp = fopen($votehome."/vote/admin/electresults/vicepresidentcomments.txt",'w');
	fwrite($fp,$updatercomments);
	fclose($fp);	
?>
<BR>
Click <A HREF="/vote/electresults/candvicepresidentlist.php">here</A> to view vicepresidential election results.<BR>
Click <A HREF="/vote/admin/electresults/">here</A> to go back to election results input main page.<BR>
<BR>
<BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
