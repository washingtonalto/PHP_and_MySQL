<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$sortorder = " ORDER BY Year(Now())-Year(candsenators.birthdate) DESC";
if (!empty($submit)) {
	switch($optiontype) {
		case 1: $sortorder = " ORDER BY Year(Now())-Year(candsenators.birthdate) DESC";
				break;
		case 2: $sortorder = " ORDER BY Month(candsenators.birthdate), candsenators.birthdate";
				break;
		case 3: $sortorder = " ORDER BY candsenators.lastname";
				break;		
	}
}

$query = "SELECT candsenators.senator_id, candsenators.lastname, candsenators.firstname, candsenators.middleinitial, Date_format(candsenators.birthdate,'%M %e, %Y') As birthdate, Year(Now())-Year(candsenators.birthdate) AS age, Month(candsenators.birthdate) AS birthmonthnum,
    Monthname(candsenators.birthdate) As birthmonth
	FROM candsenators
	WHERE Month(candsenators.birthdate) > 0 ".$sortorder;
$senator =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Age Statistics of Senatorial Candidates</TITLE>
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
<A HREF="/vote/statistics"><B>Statistics</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Age Statistics of Senatorial Candidates</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>AGE STATISTICS OF SENATORIAL CANDIDATES</B></DIV>
<BR>
<BR>
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="1">Sorted by age (in descending order)</OPTION>	
		<OPTION VALUE="2">Sorted by birth month</OPTION>
		<OPTION VALUE="3">Sorted by name</OPTION>
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go">
</FORM>
<?PHP $ctr=0; $agerunsum=0; ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>Birthdate</B></TD><TD><B>Age</B></TD><TD><B>Birth Month</B></TD></TR>
	<?PHP while ($senatorrow = mysql_fetch_array($senator)) { ?>
	<TR>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD><?PHP echo $ctr; ?></TD>	
		<TD>
			<A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$senatorrow['senator_id']; ?>>
			<?PHP echo $senatorrow['lastname']; ?>,&nbsp;
			<?PHP echo $senatorrow['firstname']; ?>&nbsp;
			<?PHP if (!empty($senatorrow['middleinitial'])) { ?>
				<?PHP echo $senatorrow['middleinitial']; ?>.
			<?PHP } ?>	
			</A>
		</TD>
		<TD>
			<?PHP echo $senatorrow['birthdate']; ?>
		</TD>
		<TD>
			<?PHP echo $senatorrow['age']; $agerunsum = $agerunsum + $senatorrow['age'];  ?>
		</TD>
		<TD>
			<?PHP echo $senatorrow['birthmonth']; ?>
		</TD>
	</TR>	
	<?PHP } ?>
</TABLE>
<BR>
<?PHP if (!empty($agerunsum)) { ?>
<B>Average age:</B>&nbsp;<?PHP echo round($agerunsum/$ctr,2); ?>
<?PHP } ?>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

