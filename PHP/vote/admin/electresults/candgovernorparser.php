<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results Input on Governor Candidates</TITLE>
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
<B>Governor Candidates (Parser)</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT ON GOVERNOR CANDIDATES (VIA PARSER)</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>There syntax is shown below.
<LI>The last name value is case-insensitive.
<LI>If vote values have commas, remove them so that program can distinguish delimited fields. 
<LI>The important delimiters to remember are the "," and the ";". Spaces are discarded by the parser.
<LI>Failure to follow any of the instructions above may result in a page-full of errors. Garbage-in, garbage-out.
<LI>The manner of updating here is non-destructive. It will only update those fields where values
are supplied.
<LI>This service is provided as-is with no warranties provided, implied or expressed. Be sure to
use the regular web form after using this.
</OL>
<B>Synax:</B><BR>
[Last Name],[First Name],[Province],[No. of Votes],[Is Proclaimed?];<BR>
<B>Examples of inputs:</B><BR>
Arroyo,Joker,Cavite,500,Y;<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Enter governors input in comma-delimited format:</B><BR>
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
	echo strval($ctr+1)."&nbsp;<BR>";
	list($lastname,$firstname,$province,$numvotes,$isproclaimed) = split(",",$linearray[$ctr]);
	$query	= "SELECT provinces.province_id FROM provinces WHERE (UCASE(provinces.name) = '".trim(strtoupper($province))."')";
	echo $query."<BR>";		
	$provinces = getqueryresults($query);
	$provincesrow = mysql_fetch_array($provinces);
	$query	= "UPDATE candgovernors SET numvotes=".strval($numvotes).", is_proclaimed='".trim(strtoupper($isproclaimed)).
	          "' WHERE (UCASE(lastname) = '".strtoupper(trim($lastname))."') AND (UCASE(firstname) = '".strtoupper(trim($firstname)).
			  "') AND (province_id = ".$provincesrow['province_id'].")";
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
echo "<BR><BR>";
echo "<B>".$ctr." records updated.</B><BR>";
?>
Click <A HREF="/vote/admin/electresults/">here</A> to go back to election results input main page.<BR>
<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

