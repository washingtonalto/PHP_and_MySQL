<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  body, title, source, Date_format(start_date,'%M %e, %Y') As date
  FROM newsevents 
  WHERE (newsevents_id = ".$newseventsid.")";
$newsevents =  getqueryresults($query);
$newseventsrow = mysql_fetch_array($newsevents);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : News, Events &amp; Activities&nbsp;-&nbsp;<?PHP echo stripslashes($newseventsrow['title']); ?></TITLE>
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
<A HREF="/vote/newseventslist.php"><B>News, Events &amp; Activities</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<?PHP echo stripslashes($newseventsrow['title']); ?>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B><?PHP echo strtoupper(stripslashes($newseventsrow['title'])); ?></B></DIV>
<BR>
<B>Date:</B>&nbsp;<?PHP echo $newseventsrow['date']; ?><BR>
<B>Source:</B>&nbsp;<?PHP echo stripslashes($newseventsrow['source']); ?><BR>
<BR>
<?PHP echo stripslashes($newseventsrow['body']); ?>
<BR>
<BR>
<BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
