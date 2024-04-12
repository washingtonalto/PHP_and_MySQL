<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP
$query = "SELECT lastname, firstname, nationalcapitalregion.name As municity FROM candvicemayors, nationalcapitalregion WHERE (candvicemayors.ncrmunicity_id = nationalcapitalregion.municity_id) 
           ORDER BY nationalcapitalregion.name, candvicemayors.lastname, candvicemayors.firstname";
$candvicemayors = getqueryresults($query);
?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : NCR Vice Mayoral Candidates Election Results Guide</TITLE>
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
<A HREF="/vote/admin/electresults/"><B>Election Results Input Page</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>NCR Vice Mayoral Candidates Guide</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>NCR VICE MAYORAL CANDIDATES ELECTION RESULTS GUIDE</B></DIV>
<BR>
<?PHP while ($candvicemayorsrow = mysql_fetch_array($candvicemayors)) { ?>
	<B><?PHP echo $candvicemayorsrow['lastname']; ?> , <?PHP echo $candvicemayorsrow['firstname']; ?> , <?PHP echo $candvicemayorsrow['municity']; ?></B><BR>	
<?PHP } ?>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>



