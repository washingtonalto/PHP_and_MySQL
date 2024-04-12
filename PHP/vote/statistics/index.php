<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Statistics</TITLE>
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
<B>Statistics</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>STATISTICS</B></DIV>
<BR>
<BR>	
<UL>
	<LI><A HREF="/vote/statistics/regionalstat1.php">No. of Provinces, Cities, Municipalities per Region</A>
	<LI><A HREF="/vote/statistics/regionalstat2.php">No. of Precincts and Registered Voters per Region</A>
	<LI><A HREF="/vote/statistics/partylistprevelect.php">Performance of Top 20 Party Lists During the 1998 Election</A>
	<LI><A HREF="/vote/statistics/citieslist.php">List of Cities in the Philippines</A>
	<!-- <LI><A HREF="/vote/statistics/candsenatorage.php">Age Statistics of Senatorial Candidates</A> -->
	<LI><A HREF="/vote/statistics/senatorage.php">Age Statistics of Senators</A>
	<LI><A HREF="/vote/statistics/senatorsprevelectbreakdown.php">2001 Senatorial Election Results with Breakdown</A>
</UL>
<BR><BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
