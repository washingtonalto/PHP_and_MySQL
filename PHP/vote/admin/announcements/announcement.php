<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
 
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Announcement Input</TITLE>
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
<B>Announcement Input</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ANNOUNCEMENT INPUT</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<?PHP 
	$fp = fopen($votehome."/vote/ssi/announcements.inc",'r');
	$content = fread($fp,filesize($votehome."/vote/ssi/announcements.inc"));
	fclose($fp);
?>
<B>Note:</B><BR>
<P>
Please use the class "rightboxfont" to make the font smaller in proportion
to the text box of the front page e.g. &lt;P CLASS="RIGHTBOXFONT"&gt;.  
<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Enter announcement for the first page:</B><BR>
<TEXTAREA COLS="80" ROWS="24" NAME="announcement"><?PHP echo $content; ?></TEXTAREA>
<BR>
<BR>
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>

<?PHP } else { ?> <!-- display preview -->

<?PHP 
echo "<B>Announcement Entered</B>:<BR>";
$announcement = stripslashes($announcement);
echo "<PRE>";
echo htmlspecialchars($announcement); 
echo "</PRE>";
?>
<BR>

<?PHP
  $fp = fopen($votehome."/vote/ssi/announcements.inc",'w');
  fwrite($fp, $announcement);
  fclose($fp);

?>

<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

