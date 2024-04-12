<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  newsevents_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, is_national
  FROM newsevents 
  WHERE (is_national = 'Y') AND (CURRENT_DATE > end_date)
  ORDER BY start_date DESC";
$past_national =  getqueryresults($query);
$num_past_national = mysql_num_rows($past_national);

$query = "SELECT  newsevents_id, nationalcapitalregion.municity_id As ncrmunicity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, nationalcapitalregion.name As ncrmunicity
  FROM newsevents, nationalcapitalregion 
  WHERE (ncrmunicity_id = nationalcapitalregion.municity_id) AND (CURRENT_DATE > end_date)
  ORDER BY start_date DESC, nationalcapitalregion.name";
$past_ncrmunicity =  getqueryresults($query);
$num_past_ncrmunicity = mysql_num_rows($past_ncrmunicity);

$query = "SELECT  newsevents_id, provinces.province_id As province_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, provinces.name As province
  FROM newsevents, provinces 
  WHERE (newsevents.province_id = provinces.province_id) AND (CURRENT_DATE > end_date)
  ORDER BY start_date DESC, provinces.name";
$past_province =  getqueryresults($query);
$num_past_province = mysql_num_rows($past_province);

$query = "SELECT  newsevents_id, municity.municity_id As municity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, municity.name As municity
  FROM newsevents, municity 
  WHERE (newsevents.municity_id = municity.municity_id) AND (CURRENT_DATE > end_date)
  ORDER BY start_date DESC, municity.name";
$past_municity =  getqueryresults($query);
$num_past_municity = mysql_num_rows($past_municity);

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
<B>Past News, Events and Activities</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>PAST NEWS, EVENTS AND ACTIVITIES</B></DIV>
<BR>
<?PHP if ($num_past_national > 0) {?>
<H2 CLASS="HIGHLIGHTS">National Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($past_nationalrow = mysql_fetch_array($past_national)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $past_nationalrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $past_nationalrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$past_nationalrow['newsevents_id']; ?>"><?PHP echo $past_nationalrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP 
				if ($past_nationalrow['is_national'] == "Y") { 
					echo "National"; 
				} else {
					echo "&nbsp;";
				}	
			?>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_past_ncrmunicity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">NCR Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($past_ncrmunicityrow = mysql_fetch_array($past_ncrmunicity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $past_ncrmunicityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $past_ncrmunicityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$past_ncrmunicityrow['newsevents_id']; ?>"><?PHP echo $past_ncrmunicityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$past_ncrmunicityrow['ncrmunicity_id']; ?>"><?PHP echo $past_ncrmunicityrow['ncrmunicity'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_past_province > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($past_provincerow = mysql_fetch_array($past_province)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $past_provincerow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $past_provincerow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$past_provincerow['newsevents_id']; ?>"><?PHP echo $past_provincerow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/provincesdet.php?provinceid=".$past_provincerow['_id']; ?>"><?PHP echo $past_provincerow['province'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_past_municity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Municipality/City Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($past_municityrow = mysql_fetch_array($past_municity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $past_municityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $past_municityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$past_municityrow['newsevents_id']; ?>"><?PHP echo $past_municityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/municitydet.php?municityid=".$past_municityrow['municity_id']; ?>"><?PHP echo $past_municityrow['municity'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

