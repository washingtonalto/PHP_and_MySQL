<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  activities.body As bodytext, activities.title As title, activities.source As source, Date_format(activities.date,'%M %e, %Y') As date
  FROM activities, party 
  WHERE (activities.party_id = party.party_id) AND (activities.activity_id = ".$activityid.")";
$activities =  getqueryresults($query);
$activitiesrow = mysql_fetch_array($activities);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Activity&nbsp;-&nbsp;<?PHP echo stripslashes($activitiesrow['title']); ?></TITLE>
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
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Activity&nbsp;-&nbsp;<?PHP echo stripslashes($activitiesrow['title']); ?>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B><?PHP echo strtoupper(stripslashes($activitiesrow['title'])); ?></B></DIV>
<BR>
<B>Date:</B>&nbsp;<?PHP echo $activitiesrow['date']; ?><BR>
<B>Source:</B>&nbsp;<?PHP echo stripslashes($activitiesrow['source']); ?><BR>
<BR>
<?PHP echo stripslashes($activitiesrow['bodytext']); ?><BR>
	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
