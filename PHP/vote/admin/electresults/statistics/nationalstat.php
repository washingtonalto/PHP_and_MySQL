<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : National Statistics</TITLE>
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
<A HREF="/vote/admin/electresults/"><B>Election Results Input Page</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>National Statistics</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>NATIONAL STATISTICS</B></DIV>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<!-- MySQL Initialization -->
<?PHP
$query = "SELECT capital,nummaleregvoters,numfemaleregvoters,
                 numregvoters,numprovinces,numcities,
				 nummunicipalities, numlegdist, numbarangays,
				 numprecincts, factsheet, is_presresult,
				 is_vpresresult, is_senresult, is_partylistresult,
				 numactualvoters  
          FROM natfactsheet";  
$nationalstats = getqueryresults($query);
$nationalstatsrow = mysql_fetch_array($nationalstats);
?>

<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Capital:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="capital" VALUE="<?PHP echo $nationalstatsrow['capital']; ?>"><BR>
<B>No. of Male Registered Voters:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="nummaleregvoters" VALUE="<?PHP echo $nationalstatsrow['nummaleregvoters']; ?>"><BR>
<B>No. of Female Registered Voters:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numfemaleregvoters" VALUE="<?PHP echo $nationalstatsrow['numfemaleregvoters']; ?>"><BR>
<B>No. of Registered Voters:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numregvoters" VALUE="<?PHP echo $nationalstatsrow['numregvoters']; ?>"><BR>
<B>No. of Actual Voters:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numactualvoters" VALUE="<?PHP echo $nationalstatsrow['numactualvoters']; ?>"><BR>
<B>No. of Provinces:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numprovinces" VALUE="<?PHP echo $nationalstatsrow['numprovinces']; ?>"><BR>
<B>No. of Cities:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numcities" VALUE="<?PHP echo $nationalstatsrow['numcities']; ?>"><BR>
<B>No. of Municipalities:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="nummunicipalities" VALUE="<?PHP echo $nationalstatsrow['nummunicipalities']; ?>"><BR>
<B>No. of Legislative Districts:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numlegdist" VALUE="<?PHP echo $nationalstatsrow['numlegdist']; ?>"><BR>
<B>No. of Barangays:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numbarangays" VALUE="<?PHP echo $nationalstatsrow['numbarangays']; ?>"><BR>
<B>No. of Precincts:&nbsp;&nbsp;</B><INPUT TYPE="text" NAME="numprecincts" VALUE="<?PHP echo $nationalstatsrow['numprecincts']; ?>"><BR>
<B>Display Presidential Election Results?&nbsp;&nbsp;</B>
<SELECT NAME="is_presresult" SIZE="1">
		<OPTION VALUE="Y" <?PHP if ($nationalstatsrow['is_presresult'] == "Y") echo "SELECTED"; ?>>Y</OPTION>
		<OPTION VALUE="N" <?PHP if ($nationalstatsrow['is_presresult'] == "N") echo "SELECTED"; ?>>N</OPTION>
</SELECT><BR>
<B>Display Vice Presidential Election Results?&nbsp;&nbsp;</B>
<SELECT NAME="is_vpresresult" SIZE="1">
		<OPTION VALUE="Y" <?PHP if ($nationalstatsrow['is_vpresresult'] == "Y") echo "SELECTED"; ?>>Y</OPTION>
		<OPTION VALUE="N" <?PHP if ($nationalstatsrow['is_vpresresult'] == "N") echo "SELECTED"; ?>>N</OPTION>
</SELECT><BR>
<B>Display Senatorial Election Results?&nbsp;&nbsp;</B>
<SELECT NAME="is_senresult" SIZE="1">
		<OPTION VALUE="Y" <?PHP if ($nationalstatsrow['is_senresult'] == "Y") echo "SELECTED"; ?>>Y</OPTION>
		<OPTION VALUE="N" <?PHP if ($nationalstatsrow['is_senresult'] == "N") echo "SELECTED"; ?>>N</OPTION>
</SELECT><BR>
<B>Display Party List Election Results?&nbsp;&nbsp;</B>
<SELECT NAME="is_partylistresult" SIZE="1">
		<OPTION VALUE="Y" <?PHP if ($nationalstatsrow['is_partylistresult'] == "Y") echo "SELECTED"; ?>>Y</OPTION>
		<OPTION VALUE="N" <?PHP if ($nationalstatsrow['is_partylistresult'] == "N") echo "SELECTED"; ?>>N</OPTION>
</SELECT><BR>

<BR><B>Fact Sheet:</B><BR>
<TEXTAREA COLS="50" ROWS="8" NAME="factsheet"><?PHP echo $nationalstatsrow['factsheet']; ?></TEXTAREA>
<BR>
<BR>
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>

<?PHP 
	mysql_free_result($nationalstats);
?>

<?PHP } else { ?> <!-- display preview -->

<?PHP 
$query = "UPDATE natfactsheet SET capital='".trim($capital).
         "', nummaleregvoters=".strval($nummaleregvoters).
		 ", numfemaleregvoters=".strval($numfemaleregvoters).
		 ", numregvoters=".strval($numregvoters).
		 ", numactualvoters=".strval($numactualvoters).
		 ", numprecincts=".strval($numprecincts).
		 ", numbarangays=".strval($numbarangays).
		 ", numlegdist=".strval($numlegdist).
		 ", numprovinces=".strval($numprovinces).
		 ", numcities=".strval($numcities).
		 ", nummunicipalities=".strval($nummunicipalities).
		 ", factsheet='".trim(htmlspecialchars($factsheet)).
		 "', is_presresult='".trim($is_presresult).
		 "', is_vpresresult='".trim($is_vpresresult).
		 "', is_senresult='".trim($is_senresult).
		 "', is_partylistresult='".trim($is_partylistresult).
		 "' WHERE id = 1";
echo "<B>Query Executed:</B><BR>";
echo $query."<BR>";
$results = getqueryresults($query);	
displayerrormsg($results,"insert");
$query = "SELECT capital,nummaleregvoters,numfemaleregvoters,
                 numregvoters,numprovinces,numcities,
				 nummunicipalities, numlegdist, numbarangays,
				 numprecincts, factsheet, is_presresult,
				 is_vpresresult, is_senresult, is_partylistresult,
				 numactualvoters  
          FROM natfactsheet";  
$nationalstats = getqueryresults($query);
$nationalstatsrow = mysql_fetch_array($nationalstats);		
?>
<B>Capital:&nbsp;&nbsp;</B><?PHP echo $nationalstatsrow['capital']; ?><BR>
<B>No. of Male Registered Voters:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['nummaleregvoters']); ?><BR>
<B>No. of Female Registered Voters:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numfemaleregvoters']); ?><BR>
<B>No. of Registered Voters:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numregvoters']); ?><BR>
<B>No. of Actual Voters:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numactualvoters']); ?><BR>
<B>No. of Provinces:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numprovinces']); ?><BR>
<B>No. of Cities:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numcities']); ?><BR>
<B>No. of Municipalities:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['nummunicipalities']); ?><BR>
<B>No. of Legislative Districts:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numlegdist']); ?><BR>
<B>No. of Barangays:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numbarangays']); ?><BR>
<B>No. of Precincts:&nbsp;&nbsp;</B><?PHP echo number_format($nationalstatsrow['numprecincts']); ?><BR>
<B>Display Presidential Election Results?&nbsp;&nbsp;</B><?PHP echo $nationalstatsrow['is_presresult']; ?><BR>
<B>Display Vice Presidential Election Results?&nbsp;&nbsp;</B><?PHP echo $nationalstatsrow['is_vpresresult']; ?><BR>
<B>Display Senatorial Election Results?&nbsp;&nbsp;</B><?PHP echo $nationalstatsrow['is_senresult']; ?><BR>
<B>Display Party List Election Results?&nbsp;&nbsp;</B><?PHP echo $nationalstatsrow['is_partylistresult']; ?><BR>

<BR><B>Fact Sheet:</B><BR>
<?PHP echo $nationalstatsrow['factsheet']; ?><BR><BR>


<?PHP } ?> <!-- End of if (empty($submit)) -->

<BR>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>


