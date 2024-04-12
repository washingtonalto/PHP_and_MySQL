<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Search Vote.ph</TITLE>
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
<B>Search Vote.ph</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>SEARCH VOTE.PH</B></DIV>
<BR>
<BR>		
<H2 CLASS="HIGHLIGHTS">Special Search</H2>	
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="15%" ALIGN="left" VALIGN="top"><A HREF="/vote/search/searchnames.php">Names</A></TD>
		<TD>Allows you to search for names listed at the site's database given 
		    some search strings matching a portion of the name you want to search.
			For example, the search string <I><B>ang</B></I> may return names with first name or 
			last name having string <I><B>angara</B></I>, <I><B>anping</B></I>, <I><B>angelo</B></I>, 
			etc.<BR><BR></TD>
	</TR>
	<TR>
		<TD ALIGN="left" VALIGN="top"><A HREF="/vote/search/searchmunicity.php">Municipality/City</A></TD>
		<TD>Allows you to search for municipalities or cities at the site's database 
		    given some search strings matching a portion of the name of the city or 
			municipality you want to search. For example, the search string <B><I>abuc</I></B>
			will return the municipality of <B><I>Abucay</I></B> of Bataan and 
			<B><I>Cabucgayan</I></B> of Biliran.<BR><BR></TD>
	</TR>
	<TR>
		<TD ALIGN="left" VALIGN="top"><A HREF="/vote/search/searchprovinces.php">Province</A></TD>
		<TD>Allows you to search for provinces at the site's database given some search strings
		matching a portion of the province name you want to search. For example, the search
		string <B><I>ab</I></B> will the provinces of <I><B>Isabela</B></I>, <B><I>Abra</I></B>, etc.
		<BR><BR></TD>
	</TR>			
	<TR>
		<TD ALIGN="left" VALIGN="top"><A HREF="/vote/search/searchparty.php">Party</A></TD>
		<TD>Allows you to search for parties at the site's database given some search strings
		matching a portion of the party acronym or name you want to search. For example, the search 
		string <B><I>la</I></B> may return parties containing the string <B><I>lakas</I></B>, 
		<B><I>laban</I></B>, etc.
		<BR><BR></TD>
	</TR>				
</TABLE>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
