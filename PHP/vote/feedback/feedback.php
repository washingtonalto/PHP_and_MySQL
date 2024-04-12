<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Feedback</TITLE>
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
<B>Feedback</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>FEEDBACK</B></DIV>
<BR>
<BR>			
<FORM ACTION="/vote/feedback/feedbacksent.php" METHOD="post">	
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="25%" HEIGHT="14" ALIGN="left" VALIGN="top">Your Name <B>(optional)</B>:</TD> 
	    <TD HEIGHT="14" ALIGN="left" VALIGN="top"><INPUT TYPE="text" NAME="name" SIZE="34" MAXLENGTH="90"></TD>
	</TR>	
	<TR>
		<TD HEIGHT="14" ALIGN="left" VALIGN="top">Your E-mail <B>(required)</B>:</TD> 
		<TD HEIGHT="14" ALIGN="left" VALIGN="top"><INPUT TYPE="text" NAME="email" SIZE="34" MAXLENGTH="90"></TD>
	</TR>	
</TABLE>
<BR>
Your Comment: <BR>
  <TEXTAREA COLS="70" ROWS="15" NAME="comment"></TEXTAREA>
<BR><BR> 
<INPUT TYPE="hidden" NAME="URL_last_visit" VALUE=<?PHP echo rawurlencode($HTTP_REFERER); ?>>
<INPUT TYPE="hidden" NAME="user_browser" VALUE=<?PHP echo rawurlencode($HTTP_USER_AGENT); ?>> 
<INPUT TYPE="hidden" NAME="remote_addr" VALUE=<?PHP echo rawurlencode($REMOTE_ADDR); ?>> 
<DIV ALIGN="center"><INPUT TYPE="submit" VALUE="SEND"></DIV>
<BR><BR>
</FORM> 
<BR>
<BR>
<H2 CLASS="HIGHLIGHTS">Some Feedback of Users</H2>
<B>Fred Robillos&nbsp;(4/10/2001)</B>
<PRE>
Very Informative... Keep it up...
I already send info regarding your site to my friends...
</PRE> 
<B>Unknown&nbsp;(4/12/2001)</B>
<PRE>
i believe this is a good election portal based on its scope.  
however, it lacks in-depth data.  i know its still in the beta stage 
but election is very near and still there\'s not much info in your site.   
</PRE>
<B>Sheila&nbsp;(4/16/2001)</B>
<PRE>
This site is great! Well researched. Very informative. But it would help 
if there are little bits of info regarding  the backgrounds of at least 
the senatorial candidates. Like what were their previous positions before 
running for senatorial seats. Something like that. 
</PRE>
<B>Beth&nbsp;(4/17/2001)</B>
<PRE>
hi. i think your site is terrific. informative and very easy to navigate.
</PRE>
<B>Mike&nbsp;(4/23/2001)</B>
<PRE>
<P>
I just feel that there should had been a special registration day for the 
4 million young people who couldn't vote this May. I have nothing against 
the COMELEC, but I just think that the longer the issue regarding the 
registration floated, the stronger the excuse was by the COMELEC about 
the inadequacy of the time before the actual elections.
<P>
If we really desire for a new political system in our nation, more than 
having new personalities in office, we should also have fresh people 
participating in significant events such as in election day.
<P>
Nevertheless, I respect the COMELEC's decision and the government's for 
that matter. I just hope that issues prevail in the upcoming elections 
and that it doesn't merely become a popularity contest or a name-recall 
kind of game.
<P>
Thanks! 
</PRE>
<B>chelle apiado&nbsp;(5/3/2001)</B>
<PRE>
<P>
I just wanna know who are those candidates  in the town of Sta Maria, 
Pangasinan.More power and Thank you.
</PRE>
<B>JP Australia&nbsp;(5/6/2001)</B>
<PRE>
The website is informative  not only for those people in the Philippines 
but also for those overseas like me. The number of political parties 
contending for the election is just unbelievable.  Is it a political 
mediocrity or simply the fad of cinematic situation of the country?
</PRE>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
