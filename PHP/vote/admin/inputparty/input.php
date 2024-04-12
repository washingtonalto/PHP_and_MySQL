<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Add Records (via parser)</TITLE>
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
<B>Add Records (via parser)</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ADD RECORDS (VIA PARSER)</B></DIV>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>Check the syntax below these important instructions for correctness
<LI>All alphanumeric values are case-insensitive 
<LI>If vote values have commas, remove them so that program can distinguish delimited fields. 
<LI>The important delimiters to remember are the "," and the ";". Spaces are discarded by the parser.
<LI>Failure to follow any of the instructions above may result in a page-full of errors. Garbage-in, garbage-out.
<LI>This service is provided as-is with no warranties provided, implied or expressed. 
</OL>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Syntax:</B><BR>
[Party Name],[Party Acronym],[Year Founded],[Year Registered]<BR><BR>
<B>Enter input in comma-delimited format:</B><BR>
<TEXTAREA COLS="80" ROWS="18" NAME="parseinput"></TEXTAREA>
<BR>
<BR>
<BR>
<INPUT TYPE="hidden" NAME="type" VALUE="<?PHP echo $type; ?>">
<INPUT TYPE="hidden" NAME="position" VALUE="<?PHP echo $position; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>

<?PHP } else { ?> <!-- display preview -->

<?PHP 
echo "<B>Queries executed</B>:<BR>";
$linearray = explode(";",$parseinput);
for ($ctr=0;$ctr < sizeof($linearray)-1;$ctr++) {
	echo strval($ctr+1)."&nbsp<BR>";
	list($partyname,$partyacronym,$yearfounded,$yearregistered) = split(",",$linearray[$ctr]);		
    $query = "INSERT INTO party (name, acronym, yearfounded, yearregistered) 
	            VALUES ('".$partyname."','".$partyacronym."',".$yearfounded.",".$yearregistered.")";
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
echo "<BR><BR>";
echo "<B>There were ".$ctr." records successfully added to the database!</B>";
?>
<BR>

<?PHP } ?> <!-- End of if (empty($submit)) -->

<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

