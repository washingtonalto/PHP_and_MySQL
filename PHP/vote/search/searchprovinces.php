<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->
<?PHP	

if (!empty($submit)) {

	//Province
	$query = "SELECT  provinces.province_id As id, provinces.name as province
	FROM provinces
	WHERE UCASE(provinces.name) LIKE UCASE(\"%".$name."%\")
	ORDER BY provinces.name";
	$province =  getqueryresults($query);
	$provincenum = mysql_num_rows($province);
	
	$numresults = $provincenum;
}	
?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Search Province</TITLE>
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
<B>Search Province</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>SEARCH PROVINCE</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="get">
Enter search string for province:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" SIZE="40" MAXLENGTH="80"><BR><BR>
<I>Enter a search string matching a portion of the name of the province you want 
   to search. For example, the search string <B><I>ab</I></B> will the provinces 
   of <I><B>Isabela</B></I>, <B><I>Abra</I></B>, etc. Note that this search is 
   case-insensitive and hence, lowercase letters or capital letters do not matter.
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
	<TR><TD><B>No.</B></TD><TD><B>Province</B></TD></TR>
	<?PHP while ($provincerow = mysql_fetch_array($province)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
				<TD><?PHP echo $ctr; ?></TD><TD><A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provincerow['id']; ?>><?PHP echo $provincerow['province']; ?></A></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($province); ?>

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
