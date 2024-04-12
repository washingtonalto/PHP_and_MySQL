<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->

<?PHP	

$query = "SELECT  newsevents_id, date_format(start_date,'%b %e, %Y') As start_date,  date_format(end_date,'%b %e, %Y') As end_date,  
          title
   FROM newsevents
   ORDER BY start_date desc";
$newsevents =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Data Entry for News, Events and Activities</TITLE>
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
<B>Data Entry for News, Events and Activities</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>VIEW PARTY ACTIVITIES</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD><B>Start Date</B></TD>
	<TD><B>End Date</B></TD>		
	<TD><B>Title</B></TD>
</TR>
<?PHP while ($newseventsrow = mysql_fetch_array($newsevents)) { ?>
	<TR>
		<TD><?PHP echo $newseventsrow['start_date']; ?></TD>
		<TD><?PHP echo $newseventsrow['end_date']; ?></TD>		
		<TD><A HREF="<?PHP echo "/vote/admin/inputnewsevents/editnewsevents.php?newseventsid=".$newseventsrow['newsevents_id']; ?>"><?PHP echo $newseventsrow['title'];  ?></A></TD>
	</TR>
<?PHP } ?>
</TABLE> 
<BR>
<A HREF="/vote/admin/inputnewsevents/addnewsevents.php">Insert Record</A>		
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

