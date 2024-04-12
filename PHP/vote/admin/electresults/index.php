<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results Input Page</TITLE>
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
<B>Election Results Input Page</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS INPUT PAGE</B></DIV>
<BR>
<B>National Elections</B><BR>
<UL>
<LI><A HREF="/vote/admin/electresults/candpresidentinput.php">Presidential Election Results</A>
<LI><A HREF="/vote/admin/electresults/candpresidentparser.php">Presidential Election Results (via parser)</A>
<LI><A HREF="/vote/admin/electresults/candpresidentparserbreakdown.php">Presidential Election Results Regional Breakdown(via parser)</A><BR><BR>
<LI><A HREF="/vote/admin/electresults/candvicepresidentinput.php">Vice Presidential Election Results</A>
<LI><A HREF="/vote/admin/electresults/candvicepresidentparser.php">Vice Presidential Election Results (via parser)</A>
<LI><A HREF="/vote/admin/electresults/candvicepresidentparserbreakdown.php">Vice Presidential Election Results Regional Breakdown(via parser)</A><BR><BR>
<LI><A HREF="/vote/admin/electresults/candsenatorinput.php">Senatorial Election Results</A>
<LI><A HREF="/vote/admin/electresults/candsenatorparser.php">Senatorial Election Results (via parser)</A>
<LI><A HREF="/vote/admin/electresults/candsenatorparserbreakdown.php">Senatorial Election Results Regional Breakdown(via parser)</A><BR><BR>
<LI><A HREF="/vote/admin/electresults/candpartylistinput.php">Party List Election Results</A>
<LI><A HREF="/vote/admin/electresults/candpartylistparser.php">Party List Election Results (via parser)</A>
<LI><A HREF="/vote/admin/electresults/candpartylistparserbreakdown.php">Party-list Election Results Regional Breakdown(via parser)</A>
</UL>
<BR>
<B>Local Elections (via parser)</B><BR>
<UL>
<LI><A HREF="candncrrepresentativesparser.php">NCR House Represdentatives Election Results</A>
<LI><A HREF="candprovrepresentativeparser.php">Provincial House Represdentatives Election Results</A><BR><BR>
<LI><A HREF="candgovernorparser.php">Governor Election Results</A>
<LI><A HREF="candvicegovernorparser.php">Vice Governor Election Results</A>
<LI><A HREF="candprovboardmemberparser.php">Provincial Board Member Election Results</A><BR><BR>
<LI><A HREF="candncrmayorparser.php">NCR Mayor Election Results</A>
<LI><A HREF="candncrvicemayorparser.php">NCR Vice Mayor Election Results</A>
<LI><A HREF="candncrcouncilorparser.php">NCR Councilor Election Results</A><BR><BR>
<LI><A HREF="candprovmayorparser.php">Provincial Mayor Election Results</A>
<LI><A HREF="candprovvicemayorparser.php">Provincial Vice Mayor Election Results</A>
<LI><A HREF="candprovcouncilorparser.php">Provincial Councilor Election Results</A>
</UL>
<BR>
<B>Election Results Guide</B><BR>
<UL>
<LI><A HREF="guide/provinceslist.php">List of Provinces</A>
<LI><A HREF="guide/provlegdist.php">List of Provincial Legislative Districts</A>
<LI><A HREF="guide/ncrlegdist.php">List of NCR Legislative Districts</A>
<LI><A HREF="guide/ncrlist.php">List of NCR City/Municipality</A>
<LI><A HREF="guide/provmunicitylist.php">List of Provincial City/Municipality</A><BR><BR>
<LI><A HREF="guide/candpresidentsguide.php">President</A>
<LI><A HREF="guide/candvicepresidentsguide.php">Vice President</A>
<LI><A HREF="guide/candsenatorsguide.php">Senator</A>
<LI><A HREF="guide/candpartylistguide.php">Party-list Representative</A>
<LI><A HREF="guide/candncrrepresentativesguide.php">NCR Representative</A>
<LI><A HREF="guide/candprovrepresentativesguide.php">Provincial Representative</A>
<LI><A HREF="guide/candgovernorsguide.php">Governor</A>
<LI><A HREF="guide/candvicegovernorsguide.php">Vice Governor</A>
<LI><A HREF="guide/candboardmemguide.php">Provincial Board Member</A>
<LI><A HREF="guide/candncrmayorsguide.php">NCR Mayor</A>
<LI><A HREF="guide/candncrvicemayorsguide.php">NCR Vice Mayor</A>
<LI><A HREF="guide/candncrcouncilorsguide.php">NCR Councilor</A>
<LI><A HREF="guide/candprovmayorsguide.php">Provincial Mayor</A>
<LI><A HREF="guide/candprovvicemayorsguide.php">Provincial Vice Mayor</A>
<LI><A HREF="guide/candprovcouncilorsguide.php">Provincial Councilor</A>
</UL>
<BR>
<B>Election Results Notes</B><BR>
<UL>
<LI><A HREF="notes/provincesnotes.php">Province</A><BR><BR>
<LI><A HREF="notes/provlegdistnotes.php">Provincial Legislative District</A>
<LI><A HREF="notes/ncrlegdistnotes.php">NCR Legislative District</A><BR><BR>
<LI><A HREF="notes/provmunicity.php">Provincial Municipality/City</A>
<LI><A HREF="notes/ncrmunicity.php">NCR Municipality/City</A>
</UL>
<BR>	
<B>Election Statistics</B><BR>
<UL>
<LI><A HREF="statistics/nationalstat.php">National</A>
<LI><A HREF="statistics/province.php">Province</A>
<LI><A HREF="statistics/ncrmunicity.php">NCR City/Municipality</A>
<LI><A HREF="statistics/municity.php">Provincial City/Municipality</A>
</UL>						
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
