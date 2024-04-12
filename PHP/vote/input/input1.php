<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT nationalcapitalregion.municity_id, nationalcapitalregion.name As municity
          FROM nationalcapitalregion ORDER BY nationalcapitalregion.municity";
$ncrmunicity = getqueryresults($query);
		  
$query = "SELECT provinces.province_id, provinces.name As province 
          FROM provinces ORDER BY provinces.name";
$province = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Input Form for Candidates and Officials</TITLE>
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
<B>Input Form for Candidates and Officials</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INPUT FORM FOR CANDIDATES AND OFFICIALS</B></DIV>
<BR>

<!--======== Start of Submit No. 2 ===========-->
<FORM ACTION="/vote/input/input2.php">
<DIV ALIGN="CENTER">
<B>Position:</B>&nbsp; 
                <?PHP if ($type == "candidate") { 
					  echo $position."&nbsp;candidate"; 
			    } else {
					  echo "Incumbent&nbsp;".$position;	
				} ?>
</DIV>				
<BR>
<?PHP if ($position <> "President" AND $position <> "Vice-president"
		  AND $position <> "Senator" AND $position <> "Party-list Representative") { ?>
<DIV ALIGN="CENTER">
<B>Province:</B>&nbsp;
<SELECT NAME="provinceid" SIZE="1">
		<OPTION VALUE=""><B>N/A</B></OPTION>
	<?PHP while ($provincerow = mysql_fetch_array($province)) { ?>
		<OPTION VALUE=<?PHP echo $provincerow['province_id']; ?>><?PHP echo $provincerow['province']; ?></OPTION>
	<?PHP } ?>	
</SELECT>
<?PHP mysql_free_result($province); ?>
</DIV><BR>
<DIV ALIGN="CENTER">
<B>NCR City/Municipality:</B>&nbsp;
<SELECT NAME="ncrmunicityid" SIZE="1">
		<OPTION VALUE=""><B>N/A</B></OPTION>
	<?PHP while ($ncrmunicityrow = mysql_fetch_array($ncrmunicity)) { ?>
		<OPTION VALUE=<?PHP echo $ncrmunicityrow['municity_id']; ?>><?PHP echo $ncrmunicityrow['municity']; ?></OPTION>	
	<?PHP } ?>	
</SELECT>
<?PHP mysql_free_result($ncrmunicity); ?>
</DIV><BR>

<?PHP } ?>
<INPUT TYPE="hidden" NAME="type" VALUE=<?PHP echo $type; ?>>
<INPUT TYPE="hidden" NAME="position" VALUE=<?PHP echo $position; ?>>
<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
<BR><BR>
<DIV ALIGN="center"><INPUT TYPE="submit" VALUE="Next"></DIV>
</FORM>
<!--======== End of Submit No. 2 ===========-->

<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
