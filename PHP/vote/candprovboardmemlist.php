<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$filter = " (LEFT(candboardmem.lastname,1) = 'A') ";
if (!empty($submit)) {
	$filter = " (LEFT(candboardmem.lastname,1) = '".$option."') ";
}	
$query = "SELECT  candboardmem.provboardmember_id As provboardmember_id,candboardmem.lastname As lastname, candboardmem.firstname As firstname, candboardmem.middleinitial As middleinitial, provinces.name As province, legdistricts.legdist_id As legdist_id, legdistricts.dist_num As districtnum, party.party_id As party_id, party.acronym As acronym, party.name As partyname
  FROM candboardmem, provinces, legdistricts, party
  WHERE (candboardmem.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id) AND (candboardmem.party_id = party.party_id)
  AND ".$filter." ORDER BY candboardmem.lastname";
$candboardmem =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Candidates for Provincial Board Member </TITLE>
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
<A HREF="/vote/byposition.php"><B>By Position</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Candidates for Provincial Board Member</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>CANDIDATES FOR PROVINCIAL BOARD MEMBERS</B></DIV>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD WIDTH="99%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column -->
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select first letter of last name:
	<SELECT NAME="option" SIZE="1">
		<OPTION VALUE="">&nbsp;</OPTION>
		<?PHP for ($ctr=65; $ctr < 91; $ctr++) { ?>
			<OPTION VALUE=<?PHP echo chr($ctr); ?>><?PHP echo chr($ctr); ?></OPTION>
		<?PHP } ?>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go"><BR>
	<?PHP if(empty($option)) { $option = "A"; } ?>
	Selected letter: <B><?PHP echo $option; ?></B><BR>
</FORM>
<BR>
<BR>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD WIDTH="16" ALIGN="center"><B><SPAN CLASS="LISTBOXFONT">#</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Name</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Legislative District</SPAN></B></TD><TD ALIGN="left"><B><SPAN CLASS="LISTBOXFONT">Party</SPAN></B></TD></TR>
<?PHP 
  $ctr = 0;	
  while ($candboardmemrow = mysql_fetch_array($candboardmem)) { 
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>
	<TD><SPAN CLASS="LISTBOXFONT"><?PHP echo $ctr; ?></SPAN>&nbsp;&nbsp;</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/candboardmemdet.php?candprovboardmemid=".$candboardmemrow['provboardmember_id']; ?>><?PHP echo $candboardmemrow['lastname'].", ".$candboardmemrow['firstname']; ?>	
	<?PHP if(!empty($candboardmemrow['middleinitial'])) { ?>
      	&nbsp;<?PHP echo $candboardmemrow['middleinitial']."."; ?>
	<?PHP } ?>
	</A></SPAN>
	</TD>
	<TD>
	<SPAN CLASS="LISTBOXFONT"><A HREF=<?PHP echo "/vote/legdistdet.php?legdistid=".$candboardmemrow['legdist_id']; ?>>
	<?PHP if ($candboardmemrow['districtnum'] == 1) { ?>
		1st/Lone
	<?PHP } else { ?>	
		<?PHP echo numtoordinal($candboardmemrow['districtnum']); ?>
	<?PHP } ?>
	District of&nbsp;<?PHP echo $candboardmemrow['province']; ?>	

	</A></SPAN>
	</TD>
	<TD><SPAN CLASS="LISTBOXFONT">
	    <A HREF=<?PHP echo "/vote/partydet.php?partyid=".$candboardmemrow['party_id']; ?>>
		    <?PHP 
			   if (!empty($candboardmemrow['acronym'])) {
			   	  echo $candboardmemrow['acronym']; 
			   } else {
			   	  echo $candboardmemrow['partyname']; 			   
			   }	  
			?>
	    </A></SPAN></TD>	
	</TR>
<?PHP } ?>
</TABLE>
<!-- End of 1st Column -->
	</TD>
	<TD WIDTH="8">&nbsp;</TD>	
	<TD ALIGN="left" VALIGN="top">
<!-- Start of 3rd Column -->
<BR>
<!-- End of 3rd Column -->	
	</TD>
		</TR>
</TABLE>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
