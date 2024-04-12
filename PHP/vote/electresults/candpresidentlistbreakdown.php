<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$sortorder = " ORDER BY totvotes DESC";
if (empty($optiontype)) {
	$optiontype = 18;
}
if (!empty($submit)) {
	switch($optiontype) {
		case 0: $sortorder = "";
				break;
		case 1: $sortorder = " ORDER BY region1votes DESC";
		        $optionchosen = "Sorted by Region 1 Votes";
				break;
		case 2: $sortorder = " ORDER BY region2votes DESC";
		        $optionchosen = "Sorted by Region 2 Votes";
				break;
		case 3: $sortorder = " ORDER BY region3votes DESC";
		        $optionchosen = "Sorted by Region 3 Votes";
				break;
		case 4: $sortorder = " ORDER BY region4votes DESC";
		        $optionchosen = "Sorted by Region 4 Votes";
				break;
		case 5: $sortorder = " ORDER BY region5votes DESC";
		        $optionchosen = "Sorted by Region 5 Votes";
				break;
		case 6: $sortorder = " ORDER BY region6votes DESC";
		        $optionchosen = "Sorted by Region 6 Votes";
				break;
		case 7: $sortorder = " ORDER BY region7votes DESC";
		        $optionchosen = "Sorted by Region 7 Votes";
				break;
		case 8: $sortorder = " ORDER BY region8votes DESC";
		        $optionchosen = "Sorted by Region 8 Votes";
				break;
		case 9: $sortorder = " ORDER BY region9votes DESC";
		        $optionchosen = "Sorted by Region 9 Votes";
				break;
		case 10: $sortorder = " ORDER BY region10votes DESC";
		        $optionchosen = "Sorted by Region 10 Votes";
				break;
		case 11: $sortorder = " ORDER BY region11votes DESC";
		        $optionchosen = "Sorted by Region 11 Votes";		
				break;
		case 12: $sortorder = " ORDER BY region12votes DESC";
		        $optionchosen = "Sorted by Region 12 Votes";		
				break;
		case 13: $sortorder = " ORDER BY regionARMMvotes DESC";
		        $optionchosen = "Sorted by ARMM Votes";		
				break;
		case 14: $sortorder = " ORDER BY regionCARvotes DESC";
		        $optionchosen = "Sorted by CAR Votes";		
				break;
		case 15: $sortorder = " ORDER BY regionNCRvotes DESC";
		        $optionchosen = "Sorted by NCR Votes";		
				break;
		case 16: $sortorder = " ORDER BY region13votes DESC";
		        $optionchosen = "Sorted by CARAGA Votes";		
				break;
		case 17: $sortorder = " ORDER BY absenteevotes DESC";
		        $optionchosen = "Sorted by Absentee Votes";		
				break;
		case 18: $sortorder = " ORDER BY totvotes DESC";
		        $optionchosen = "Sorted by Total Votes";		
				break;

	}
}

$query = "SELECT president_id, lastname,firstname, middleinitial, (region1votes + region2votes + region3votes + region4votes + region5votes + region6votes + region7votes + region8votes + region9votes + region10votes + region11votes + region12votes + region13votes + regionARMMvotes + regionCARvotes + regionNCRvotes + Absenteevotes) As totvotes, 
    region1votes, region2votes, region3votes, region4votes, region5votes,
    region6votes, region7votes, region8votes, region9votes, region10votes,	
    region11votes, region12votes, region13votes, regionARMMvotes, regionCARvotes, 
	regionNCRvotes, Absenteevotes	
	FROM candpresidents ".$sortorder;
$candpresidents =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Election Results on Presidential Candidates With Regional Breakdown</TITLE>
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
<A HREF="/vote/electresults/candpresidentlist.php"><B>Election Results on Presidential Candidates</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Regional Breakdown</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>ELECTION RESULTS ON PRESIDENTIAL CANDIDATES WITH REGIONAL BREAKDOWN</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
		<OPTION VALUE="15">Sorted by NCR votes</OPTION>	
		<OPTION VALUE="1">Sorted by region 1 votes</OPTION>	
		<OPTION VALUE="2">Sorted by region 2 votes</OPTION>			
		<OPTION VALUE="3">Sorted by region 3 votes</OPTION>	
		<OPTION VALUE="4">Sorted by region 4 votes</OPTION>			
		<OPTION VALUE="5">Sorted by region 5 votes</OPTION>	
		<OPTION VALUE="6">Sorted by region 6 votes</OPTION>			
		<OPTION VALUE="7">Sorted by region 7 votes</OPTION>	
		<OPTION VALUE="8">Sorted by region 8 votes</OPTION>			
		<OPTION VALUE="9">Sorted by region 9 votes</OPTION>	
		<OPTION VALUE="10">Sorted by region 10 votes</OPTION>			
		<OPTION VALUE="11">Sorted by region 11 votes</OPTION>	
		<OPTION VALUE="12">Sorted by region 12 votes</OPTION>			
		<OPTION VALUE="13">Sorted by ARMM votes</OPTION>	
		<OPTION VALUE="14">Sorted by CAR votes</OPTION>			
		<OPTION VALUE="16">Sorted by CARAGA votes</OPTION>			
		<OPTION VALUE="17">Sorted by Absentee votes</OPTION>			
		<OPTION VALUE="18">Sorted by Total votes</OPTION>					
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go"><BR>
	<?PHP if (empty($optionchosen)) {
	         $optionchosen = "Sorted by Total Votes";
		  }
	?>
	<B>Selected option:</B>&nbsp;<?PHP echo $optionchosen; ?>
</FORM>
<B>Notes:</B><BR>
<?PHP require ("$votehome/vote/admin/electresults/electresultspresidentbreakdown.txt"); ?>
<BR>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="left" VALIGN="top"><B><SPAN CLASS="breakdownstat">No.</SPAN></B></TD>
		<TD ALIGN="left" VALIGN="top"><B><SPAN CLASS="breakdownstat">Name</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">Total</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">NCR</SPAN></B></TD>			
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">I</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">II</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">III</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">IV</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">V</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VI</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VII</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">VIII</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">IX</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">X</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">XI</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">XII</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">ARMM</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">CAR</SPAN></B></TD>
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">CARAGA</SPAN></B></TD>		
		<TD WIDTH="50" ALIGN="center" VALIGN="top" NOWRAP><B><SPAN CLASS="breakdownstat">Absentee</SPAN></B></TD>		
	</TR>
	<?PHP $ctr=0; ?>
	<?PHP while ($candpresidentsrow = mysql_fetch_array($candpresidents)) { ?>
		<?PHP if (($ctr % 2 == 0) AND ($ctr <= 13 )) { ?>
			<TR BGCOLOR="#FFD5D5">
		<?PHP } else if ($ctr % 2 == 0) { ?>	
			<TR BGCOLOR="#C5E0FE">	
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		    <?PHP $ctr++; ?>
			<TD ALIGN="right"><SPAN CLASS="breakdownstat"><?PHP echo number_format($ctr); ?></SPAN></TD>		
			<TD ALIGN="left"><A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentsrow['president_id']; ?>>
			    <SPAN CLASS="breakdownstat">
					<?PHP echo $candpresidentsrow['lastname'].", ".$candpresidentsrow['firstname'] ?>	
					<?PHP if(!empty($candpresidentsrow['middleinitial'])) { ?>
      					&nbsp;<?PHP echo $candpresidentsrow['middleinitial']."."; ?>
					<?PHP } ?>	    
				</SPAN></A></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 18) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['totvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 15) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['regionNCRvotes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 1) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region1votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 2) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region2votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 3) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region3votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 4) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region4votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 5) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region5votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 6) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region6votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 7) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region7votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 8) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region8votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 9) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region9votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 10) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region10votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 11) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region11votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 12) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region12votes']); ?></SPAN></TD>			
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 13) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['regionARMMvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 14) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['regionCARvotes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 16) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['region13votes']); ?></SPAN></TD>
			<TD ALIGN="right" NOWRAP><SPAN STYLE=<?PHP if ($optiontype == 17) { echo "color:red; font-weight : bold;"; } else { echo "color:black;"; } ?> CLASS="breakdownstat"><?PHP echo number_format($candpresidentsrow['Absenteevotes']); ?></SPAN></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<?PHP mysql_free_result($candpresidents); ?>
<BR>
<BR>
<BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

