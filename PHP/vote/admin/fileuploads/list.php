<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : List Uploaded Files</TITLE>
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
<A HREF="/vote/admin/fileuploads/"><B>File Uploads Main</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>List Uploaded Files</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>LIST OF UPLOADED FILES</B></DIV>
<BR>

<B>/attachments</B>
<UL>
<?PHP 
$handle=opendir($votehome."/vote/attachments"); 
while (false!==($file = readdir($handle))) { 
    if ($file != "." && $file != "..") { 
        echo "<LI>".$file."\n"; 
    } 
}
closedir($handle); 
?>
</UL>

<B>/graphics</B>
<UL>
<?PHP 
$handle=opendir($votehome."/vote/graphics"); 
while (false!==($file = readdir($handle))) { 
    if ($file != "." && $file != "..") { 
        echo "<LI>".$file."\n"; 
    } 
}
closedir($handle); 
?>
</UL>

<B>/pictures</B>
<UL>
<?PHP 
$handle=opendir($votehome."/vote/pictures"); 
while (false!==($file = readdir($handle))) { 
    if ($file != "." && $file != "..") { 
        echo "<LI>".$file."\n"; 
    } 
}
closedir($handle); 
?>
</UL>

<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
