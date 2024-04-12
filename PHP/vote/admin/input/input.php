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
<A HREF="/vote/admin/input/"><B>Data Entry for Election Candidates and Incumbent Elected Officials</B></A>
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

<FORM ACTION="/vote/admin/input/parser.php">
<TABLE WIDTH="300" BORDER="1" CELLSPACING="0" CELLPADDING="4" ALIGN="center">
	<TR>
		<TD ALIGN="center" BGCOLOR="#FFBBBB"><B>Type</B></TD>
	</TR>
	<TR>
		<TD>
<INPUT TYPE="radio" NAME="type" VALUE="Incumbent" CHECKED>Incumbent Elected Official<BR>
<INPUT TYPE="radio" NAME="type" VALUE="Candidate">Election Candidate<BR>
		</TD>
	</TR>
</TABLE>
<P>
<TABLE WIDTH="300" BORDER="1" CELLSPACING="0" CELLPADDING="4" ALIGN="center">
	<TR>
		<TD ALIGN="center" BGCOLOR="#FFBBBB"><B>Position</B></TD>
	</TR>
	<TR>
		<TD>
<INPUT TYPE="radio" NAME="position" VALUE="President" CHECKED>President <BR>
<INPUT TYPE="radio" NAME="position" VALUE="Vice-president">Vice-President<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Senator">Senator<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Representative">Representative<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Party-list Representative">Party-list Representative<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Governor">Governor<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Vice Governor">Vice Governor<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Provincial Board Member">Provincial Board Member<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Mayor">Mayor<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Vice Mayor">Vice Mayor<BR>
<INPUT TYPE="radio" NAME="position" VALUE="Councilor">Councilor<BR>
		</TD>
	</TR>
</TABLE>
<BR><BR>
<DIV ALIGN="center"><INPUT TYPE="submit" VALUE="Next"></DIV>
</FORM>

<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

