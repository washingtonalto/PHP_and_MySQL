<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Email this page to friends</TITLE>
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
<B>Email this page to friends</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>EMAIL THIS PAGE TO FRIENDS</B></DIV>
<BR>
<BR>
<?PHP if(empty($submit)) { 
		$URL_last_visited = $HTTP_REFERER; 
      } 
?>
The page you want to send to your friends is: <BR>
<A HREF=<?PHP echo $URL_last_visited; ?>><?PHP echo $URL_last_visited; ?></A><BR><BR>

<?PHP if (empty($submit)) { ?>			
	<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">	
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="42%" HEIGHT="14" ALIGN="left" VALIGN="top">Your Name <B>(optional)</B>:</TD> 
	    	<TD HEIGHT="14" ALIGN="left" VALIGN="top"><INPUT TYPE="text" NAME="name" SIZE="34" MAXLENGTH="90"></TD>
		</TR>	
		<TR>
			<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your E-mail <B>(required)</B>:</TD> 
			<TD HEIGHT="14" ALIGN="left" VALIGN="top"><INPUT TYPE="text" NAME="youremail" SIZE="34" MAXLENGTH="90"></TD>
		</TR>	
		<TR>
			<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your Friend's E-mail Addresses <BR>(separate email addresses by commas)<B>(required)</B>:</TD> 
			<TD HEIGHT="14" ALIGN="left" VALIGN="bottom"><TEXTAREA COLS="50" ROWS="4" NAME="emailaddresses"></TEXTAREA></TD>
		</TR>		
	</TABLE>
	<BR>
	Your Comment <B>(optional)</B>: <BR>
  		<TEXTAREA COLS="70" ROWS="15" NAME="comment"></TEXTAREA>
	<BR><BR> 
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="hidden" NAME="URL_last_visited" VALUE=<?PHP echo $URL_last_visited; ?>>	
	<DIV ALIGN="center"><INPUT TYPE="submit" VALUE="SEND"></DIV>
	<BR><BR>
	</FORM>  
<?PHP } else { ?>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR>
			<TD WIDTH="42%" HEIGHT="14" ALIGN="left" VALIGN="top">Your Name <B>(optional)</B>:</TD> 
	    	<TD HEIGHT="14" ALIGN="left" VALIGN="top"><?PHP echo stripslashes($name); ?></TD>
		</TR>	
		<TR>
			<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your E-mail <B>(optional)</B>:</TD> 
			<TD HEIGHT="14" ALIGN="left" VALIGN="top"><?PHP echo stripslashes($youremail); ?></TD>
		</TR>	
		<TR>
			<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your Friend's E-mail Addresses <BR>(separate email addresses by commas)<B>(required)</B>:</TD> 
			<TD HEIGHT="14" ALIGN="left" VALIGN="bottom"><?PHP echo stripslashes($emailaddresses); ?></TD>
		</TR>		
	</TABLE>
	<BR>
	Your Comment <B>(optional)</B>: <BR>
	<?PHP echo stripslashes($comment); ?>
 	<BR><BR> 
	<?PHP 
	
	if (empty($name)) {
		$name = "(undisclosed)";
	}
	$bodyemail = "$name visited a page at vote.ph (http://www.vote.ph) and recommends that you view the ff. link:\n\n$URL_last_visited\n\n";
	if (mail($emailaddresses,$name." has recommended you to visit the ff. link at vote.ph",$bodyemail,"From: ".$youremail."\n")) {
			echo "Your page has been sent successfully to your friends.";
	} else { 
			echo "Your page has not been sent due to an error. Please try again at some later time. We're sorry
			for the inconvenience.";
	}	       
	?>
<?PHP } ?>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
