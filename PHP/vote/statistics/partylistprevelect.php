<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$sortorder = " ORDER BY numvotes DESC";
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
		case 13: $sortorder = " ORDER BY ARMMvotes DESC";
		        $optionchosen = "Sorted by ARMM Votes";		
				break;
		case 14: $sortorder = " ORDER BY CARvotes DESC";
		        $optionchosen = "Sorted by CAR Votes";		
				break;
		case 15: $sortorder = " ORDER BY NCRvotes DESC";
		        $optionchosen = "Sorted by NCR Votes";		
				break;
		case 16: $sortorder = " ORDER BY numvotes DESC";
		        $optionchosen = "Sorted by Total Votes";		
				break;
	}
}

$query = "SELECT party.party_id, party.acronym As partyacronym, numvotes, 
    region1votes, region2votes, region3votes, region4votes, region5votes,
    region6votes, region7votes, region8votes, region9votes, region10votes,	
    region11votes, region12votes, ARMMvotes, CARvotes, NCRvotes	
	FROM partylistprevelect, party
	WHERE (partylistprevelect.party_id = party.party_id)
	".$sortorder;
$partylist =  getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Performance of Top 20 Party Lists During the 1998 Election</TITLE>
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
<B>Performance of Top 20 Party Lists During the 1998 Election</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>PERFORMANCE OF TOP 20 PARTY LISTS DURING THE 1998 ELECTION</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?>>
	Select view options:
	<SELECT NAME="optiontype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>		
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
		<OPTION VALUE="15">Sorted by NCR votes</OPTION>	
		<OPTION VALUE="16">Sorted by total votes</OPTION>			
	</SELECT>
	<INPUT TYPE="hidden" NAME="submit" VALUE="submit">
	<INPUT TYPE="submit" VALUE="Go"><BR>
	<?PHP if (empty($optionchosen)) {
	         $optionchosen = "Sorted by Total Votes";
		  }
	?>
	Selected option:&nbsp;<B><I> <?PHP echo $optionchosen; ?></I></B>
</FORM>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">No.</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">Party</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">Total Votes</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">NCR</SPAN></B></TD>			
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">I</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">II</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">III</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">IV</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">V</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">VI</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">VII</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">VIII</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">IX</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">X</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">XI</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">XII</SPAN></B></TD>
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">ARMM</SPAN></B></TD>		
		<TD ALIGN="center"><B><SPAN CLASS="partyliststat">CAR</SPAN></B></TD>
	</TR>
	<?PHP $ctr=0; ?>
	<?PHP while ($partylistrow = mysql_fetch_array($partylist)) { ?>
		<TR>
		    <?PHP $ctr++; ?>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($ctr); ?></SPAN></TD>		
			<TD ALIGN="left"><A HREF=<?PHP echo "/vote/partydet.php?partyid=".$partylistrow['party_id']; ?>><SPAN CLASS="partyliststat"><?PHP echo $partylistrow['partyacronym']; ?></SPAN></A></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['numvotes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['NCRvotes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region1votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region2votes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region3votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region4votes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region5votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region6votes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region7votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region8votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region9votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region10votes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region11votes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['region12votes']); ?></SPAN></TD>			
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['ARMMvotes']); ?></SPAN></TD>
			<TD ALIGN="right"><SPAN CLASS="partyliststat"><?PHP echo number_format($partylistrow['CARvotes']); ?></SPAN></TD>
		</TR>
	<?PHP } ?>
</TABLE>
<BR>
<BR>
<BR>	
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

