<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : About</TITLE>
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
<B>About</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ABOUT VOTE.PH</B></DIV>
<BR>
<BR>		
<P>
<TABLE>
	<TR>
		<TD WIDTH="5%">&nbsp;</TD>
		<TD>
<P>		
<B><SPAN STYLE="font-size: 14pt; color: Maroon;">Vote.ph</SPAN></B> is the non-partisan, non-sectoral online directory and quick reference 
center on Philippine elected government officials and election candidates for both the national and the local levels. 
As such, it has a dual purpose of helping the voters know who are running in their respective area and
who their incumbent elected officials are. 

<P>
<H2 CLASS="HIGHLIGHTS">FEATURES</H2>
<OL>
<LI>Can list all candidates, including party-list, vying for every elected positions in different areas of 
the country from the president level down to the councilor level. 
<LI>Can list all elected government officials, including party-list, vying for every elected positions in 
different areas of the country from the president level down to the councilor level. After the election, 
information on the winning candidate can be transferred to that as incumbent official for the specified
position of the specified area of responsibility (See <A HREF="/vote/presidentsdet.php?presidentid=1">President Gloria Macapagal-Arroyo's</A> page to view working example).
<LI>For each candidates and incumbent official, can show his/her qualification, program of government, 
platform, stand on certain issues, accomplishments, work experience in public and private office, 
educational attainment, party affiliation, and much more. 
<LI>Each province, legislative district, city or municipality will have a page of its own (See the page for 
<A HREF="/vote/ncrmunicitydet.php?municityid=1">City of Manila</A> as working example).
<LI>Allows user to browse either <A HREF="/vote/byarea.php">by area</A>, <A HREF="/vote/byposition.php">by position</A>, or <A HREF="/vote/byparty.php">by party</A>.
<LI>Can show other pertinent personal records the candidate or official want to make public such as (but not
limited to) family information, birthday, place of birth, etc.		
<LI>Can feature each political parties, sectoral parties or sectoral organizations in party lists highlighting
their vision, mission, platforms, stand on certain issues, party organization, address, e-mail, contact numbers,
fax numbers. 
<LI>Allows user to use the site's special <A HREF="/vote/search/search.php">search engine</A> to search for 
<A HREF="/vote/search/searchnames.php">specific names</A>, <A HREF="/vote/search/searchmunicity.php">municipality/city</A>,
<A HREF="/vote/search/searchprovinces.php">provinces</A>, or <A HREF="/vote/search/searchparty.php">party</A>.	 
<LI>Allows user to view the site's <A HREF="/vote/statistics/">interactive statistics</A> (user can sort according to his/her preferences).
<LI>Allows user to inform friends about this site via <A HREF="/vote/feedback/emailtofriend.php">email to friend</A> feature.
</OL>

<H2 CLASS="HIGHLIGHTS">CREDITS</H2>

<P>
This site is conceptualized, designed and developed by Washington Alto (With the help from his family and friends, FilWorld PH, Inc. was set-up). 
Washington was a systems engineer at another startup company managing pre-sales and technical support of systems management software running on Windows NT, Windows9x and Unix platform. He is a 
Microsoft-Certified Professional (ID: 1521909) after passing Exam 067: Implementing and Supporting NT Server 4. Washington earned his 
Master in Computer Science from De La Salle University. He also graduated from De La Salle University (cum laude) with a degree in B.S. 
Applied Mathematics and Bachelor in Education. 

<H2 CLASS="HIGHLIGHTS">CONTACT INFORMATION</H2>

<B>Contact person:</B> Washington Alto<BR>
<B>Cell-phone:</B>&nbsp;0918-5338885<BR>
<B>E-mail:</B> <A HREF="mailto:washingtonalto@vote.ph">washingtonalto@vote.ph</A>, <A HREF="mailto:info@vote.ph">info@vote.ph</A><BR>
<BR><BR>
Please don't hesitate to contact us if you want:
<UL>
	<LI>to advertise in the site.
	<LI>to be listed in the site either as a candidate.
	<LI>to discuss partnership arrangements or other related matters.
</UL>
<BR>
<BR>
<BR>
<B><I>Last Note:</I></B> Don't forget us to send us your <A HREF="/vote/feedback/feedback.php">feedback!</A>
		</TD>
		<TD WIDTH="5%">&nbsp;</TD>		
	</TR>
</TABLE>
<BR>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
