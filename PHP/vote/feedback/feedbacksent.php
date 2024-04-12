<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Feedback Sent</TITLE>
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
<B>Feedback Sent</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>FEEDBACK SENT</B></DIV>
<BR>
<BR>				
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="25%" HEIGHT="14" ALIGN="left" VALIGN="top">Your Name <B>(optional)</B>:</TD> 
	    <TD HEIGHT="14" ALIGN="left" VALIGN="top"><?PHP echo stripslashes($name); ?></TD>
	</TR>	
	<TR>
		<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your E-mail <B>(optional)</B>:</TD> 
		<TD HEIGHT="14" ALIGN="left" VALIGN="top"><?PHP echo stripslashes($email); ?></TD>
	</TR>	
</TABLE>
<BR>
Your Comment: <BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR> 
  <TD WIDTH="3%" ALIGN="left" VALIGN="top">&nbsp;</TD>	 
  <TD><?PHP echo stripslashes(rawurldecode($comment)); ?></TD>
</TR>
</TABLE>  
<BR><BR> 
<?PHP $URL_last_visit = rawurldecode($URL_last_visit); ?> 
Click <A HREF=<?PHP echo $URL_last_visit; ?>>here</A> to browse the page you last visited.
You will also receive an email containing the feedback you just sent.
<?PHP $user_browser = rawurldecode($user_browser); ?> 
<?PHP $remote_addr = rawurldecode($remote_addr); ?>
 
<?PHP 
$bodyemail = "The ff. comments and feedback has been sent  \n
-------------------------------\n
Name of feedback sender: $name \n
E-mail of feedback sender: $email \n    		 
\n\n
Comment:\n
$comment\n\n
";
$addinfo = "
-------------------------------\n
URL last visited: $URL_last_visit \n
User browser: $user_browser \n
Remote Address: $remote_addr \n
";

mail($email,"Your feedback on vote.ph",$bodyemail,"From: ".$email."\n");
mail($webmasteremail,"Feedback on vote.ph",$bodyemail.$addinfo,"From: ".$email."\n");
?> 
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
