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
  WHERE (is_national = 'Y') AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
  ORDER BY start_date DESC";
$current_national =  getqueryresults($query);
$num_current_national = mysql_num_rows($current_national);

$query = "SELECT  newsevents_id, nationalcapitalregion.municity_id As ncrmunicity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, nationalcapitalregion.name As ncrmunicity
  FROM newsevents, nationalcapitalregion 
  WHERE (ncrmunicity_id = nationalcapitalregion.municity_id) AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
  ORDER BY start_date DESC, nationalcapitalregion.name";
$current_ncrmunicity =  getqueryresults($query);
$num_current_ncrmunicity = mysql_num_rows($current_ncrmunicity);

$query = "SELECT  newsevents_id, provinces.province_id As province_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, provinces.name As province
  FROM newsevents, provinces 
  WHERE (newsevents.province_id = provinces.province_id) AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
  ORDER BY start_date DESC, provinces.name";
$current_province =  getqueryresults($query);
$num_current_province = mysql_num_rows($current_province);

$query = "SELECT  newsevents_id, municity.municity_id As municity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, municity.name As municity
  FROM newsevents, municity 
  WHERE (newsevents.municity_id = municity.municity_id) AND (start_date <= CURRENT_DATE) AND (CURRENT_DATE <= end_date)
  ORDER BY start_date DESC, municity.name";
$current_municity =  getqueryresults($query);
$num_current_municity = mysql_num_rows($current_municity);

$query = "SELECT  newsevents_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, is_national
  FROM newsevents 
  WHERE (is_national = 'Y') AND (CURRENT_DATE <= start_date)
  ORDER BY start_date DESC";
$upcoming_national =  getqueryresults($query);
$num_upcoming_national = mysql_num_rows($upcoming_national);

$query = "SELECT  newsevents_id, nationalcapitalregion.municity_id As ncrmunicity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, nationalcapitalregion.name As ncrmunicity
  FROM newsevents, nationalcapitalregion 
  WHERE (ncrmunicity_id = nationalcapitalregion.municity_id) AND (CURRENT_DATE <= start_date)
  ORDER BY start_date DESC, nationalcapitalregion.name";
$upcoming_ncrmunicity =  getqueryresults($query);
$num_upcoming_ncrmunicity = mysql_num_rows($upcoming_ncrmunicity);

$query = "SELECT  newsevents_id, provinces.province_id As province_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, provinces.name As province
  FROM newsevents, provinces 
  WHERE (newsevents.province_id = provinces.province_id) AND (CURRENT_DATE <= start_date)
  ORDER BY start_date DESC, provinces.name";
$upcoming_province =  getqueryresults($query);
$num_upcoming_province = mysql_num_rows($upcoming_province);

$query = "SELECT  newsevents_id, municity.municity_id As municity_id, body, title, source, Date_format(start_date,'%m/%d/%Y') As start_date, Date_format(start_date,'%m/%d/%Y') As end_date, municity.name As municity
  FROM newsevents, municity 
  WHERE (newsevents.municity_id = municity.municity_id) AND (CURRENT_DATE <= start_date)
  ORDER BY start_date DESC, municity.name";
$upcoming_municity =  getqueryresults($query);
$num_upcoming_municity = mysql_num_rows($upcoming_municity);

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
<B>News, Events &amp; Activities</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>CURRENT AND UPCOMING NEWS, EVENTS AND ACTIVITIES</B></DIV>
<BR>
View <A HREF="/vote/newseventspastlist.php">Archived News, Events and Activities</A><BR>
<BR>
<BR>
<?PHP if ($num_current_national + $num_current_ncrmunicity + $num_current_province + $num_current_municity > 0) { ?>
<DIV ALIGN="CENTER"><B>CURRENT NEWS, EVENTS AND ACTIVIITES</B></DIV><BR><BR>
<?PHP } ?>
<?PHP if ($num_current_national > 0) {?>
<H2 CLASS="HIGHLIGHTS">National Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($current_nationalrow = mysql_fetch_array($current_national)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $current_nationalrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $current_nationalrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$current_nationalrow['newsevents_id']; ?>"><?PHP echo $current_nationalrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP 
				if ($current_nationalrow['is_national'] == "Y") { 
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
<?PHP if ($num_current_ncrmunicity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">NCR Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($current_ncrmunicityrow = mysql_fetch_array($current_ncrmunicity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $current_ncrmunicityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $current_ncrmunicityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$current_ncrmunicityrow['newsevents_id']; ?>"><?PHP echo $current_ncrmunicityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$current_ncrmunicityrow['ncrmunicity_id']; ?>"><?PHP echo $current_ncrmunicityrow['ncrmunicity'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_current_province > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($current_provincerow = mysql_fetch_array($current_province)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $current_provincerow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $current_provincerow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$current_provincerow['newsevents_id']; ?>"><?PHP echo $current_provincerow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/provincesdet.php?provinceid=".$current_provincerow['_id']; ?>"><?PHP echo $current_provincerow['province'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_current_municity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Municipality/City Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($current_municityrow = mysql_fetch_array($current_municity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $current_municityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $current_municityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$current_municityrow['newsevents_id']; ?>"><?PHP echo $current_municityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/municitydet.php?municityid=".$current_municityrow['municity_id']; ?>"><?PHP echo $current_municityrow['municity'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>

<?PHP if ($num_upcoming_national + $num_upcoming_ncrmunicity + $num_upcoming_province + $num_upcoming_municity > 0) { ?>
<DIV ALIGN="CENTER"><B>UPCOMING NEWS, EVENTS AND ACTIVIITES</B></DIV><BR><BR>
<?PHP } ?>
<?PHP if ($num_upcoming_national > 0) { ?>
<H2 CLASS="HIGHLIGHTS">National Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($upcoming_nationalrow = mysql_fetch_array($upcoming_national)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $upcoming_nationalrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $upcoming_nationalrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$upcoming_nationalrow['newsevents_id']; ?>"><?PHP echo $upcoming_nationalrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP 
				if ($upcoming_nationalrow['is_national'] == "Y") { 
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
<?PHP if ($num_upcoming_ncrmunicity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">NCR Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($upcoming_ncrmunicityrow = mysql_fetch_array($upcoming_ncrmunicity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $upcoming_ncrmunicityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $upcoming_ncrmunicityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$upcoming_ncrmunicityrow['newsevents_id']; ?>"><?PHP echo $upcoming_ncrmunicityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$upcoming_ncrmunicityrow['ncrmunicity_id']; ?>"><?PHP echo $upcoming_ncrmunicityrow['ncrmunicity'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_upcoming_province > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($upcoming_provincerow = mysql_fetch_array($upcoming_province)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $upcoming_provincerow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $upcoming_provincerow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$upcoming_provincerow['newsevents_id']; ?>"><?PHP echo $upcoming_provincerow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/provincesdet.php?provinceid=".$upcoming_provincerow['_id']; ?>"><?PHP echo $upcoming_provincerow['province'];	?></A>
		</TD>
	</TR>
<?PHP } ?>	
</TABLE>
<?PHP } ?>
<?PHP if ($num_upcoming_municity > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Municipality/City Events</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>Start Date</B></TD>
	<TD WIDTH="90" ALIGN="left" VALIGN="top"><B>End Date</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Title</B></TD>
	<TD ALIGN="left" VALIGN="top"><B>Location</B></TD>
</TR>
<?PHP while ($upcoming_municityrow = mysql_fetch_array($upcoming_municity)) { ?>
	<TR>
		<TD ALIGN="left" VALIGN="top">			
		    <?PHP echo $upcoming_municityrow['start_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $upcoming_municityrow['end_date']; ?>
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/newseventsdet.php?newseventsid=".$upcoming_municityrow['newsevents_id']; ?>"><?PHP echo $upcoming_municityrow['title']; ?></A>		
		</TD>
		<TD ALIGN="left" VALIGN="top">
			<A HREF="<?PHP echo "/vote/municitydet.php?municityid=".$upcoming_municityrow['municity_id']; ?>"><?PHP echo $upcoming_municityrow['municity'];	?></A>
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

