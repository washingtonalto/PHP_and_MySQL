<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->
<?PHP	

if (!empty($submit)) {

	//Provincial Municity
	$query = "SELECT  municity.municity_id As id, municity.name as municity, provinces.name As province, provinces.province_id As province_id 
  	FROM municity, provinces, legdistricts
	WHERE (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND UCASE(municity.name) LIKE UCASE(\"%".$name."%\")
	ORDER BY municity.name";
	$provmunicity =  getqueryresults($query);
	$provmunicitynum = mysql_num_rows($provmunicity);
	
	//NCR Municity
	$query = "SELECT  nationalcapitalregion.municity_id As id, nationalcapitalregion.name as municity, 'National Capital Region' As province
  	FROM nationalcapitalregion
	WHERE UCASE(nationalcapitalregion.name) LIKE UCASE(\"%".$name."%\")
	ORDER BY nationalcapitalregion.name";
	$ncrmunicity =  getqueryresults($query);
	$ncrmunicitynum = mysql_num_rows($ncrmunicity);	
	
	$numresults = $provmunicitynum + $ncrmunicitynum;
}	
?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Search Municipality/City</TITLE>
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
<A HREF="/vote/search/search.php"><B>Search Vote.ph</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Search Municipality/City</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>SEARCH MUNICIPALITY/CITY</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="get">
Enter search string for municipality or city:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" SIZE="40" MAXLENGTH="80"><BR><BR> 
<I>Enter a search string matching a portion of the name of the municipality or city you want 
   to search. For example, the search string <B><I>abuc</I></B>	will return the municipality 
   of <B><I>Abucay</I></B> of Bataan and <B><I>Cabucgayan</I></B> of Biliran. Note that this 
   search is case-insensitive and hence, lowercase letters or capital letters
   do not matter.
</I>.<BR><BR> 
<INPUT TYPE="hidden" NAME="submit" VALUE="SUBMIT">
<INPUT TYPE="submit" VALUE="Submit">
</FORM>		
<BR>
<?PHP if (!empty($submit)) { ?>
<H2 CLASS="HIGHLIGHTS">SEARCH RESULTS</H2>
<P>
<?PHP $ctr=0; ?>
Search results for <B><SPAN STYLE="color: Blue;"><I><?PHP echo $name; ?></I></SPAN>&nbsp;(<?PHP echo $numresults; ?>&nbsp;matches):</B><BR><BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>No.</B></TD><TD><B>Municipality/City</B></TD><TD><B>Province</B></TD></TR>
	<?PHP while ($ncrmunicityrow = mysql_fetch_array($ncrmunicity)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
				<TD><?PHP echo $ctr; ?></TD><TD><A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrmunicityrow['id']; ?>><?PHP echo $ncrmunicityrow['municity']; ?></A></TD><TD><?PHP echo $ncrmunicityrow['province']; ?></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($ncrmunicity); ?>
	
	
	<?PHP while ($provmunicityrow = mysql_fetch_array($provmunicity)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
				<TD><?PHP echo $ctr; ?></TD><TD><A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$provmunicityrow['id']; ?>><?PHP echo $provmunicityrow['municity']; ?></A></TD><TD><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provmunicityrow['province_id']; ?>><?PHP echo $provmunicityrow['province']; ?></A></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($provmunicity); ?>
	
</TABLE>	
<?PHP } ?>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
