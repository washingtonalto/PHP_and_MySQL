<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->
<?PHP	

if (!empty($submit)) {

	//President
	$query = "SELECT  'President' As label, presidents.president_id As id, TRIM(CONCAT_WS('', presidents.lastname,', ',presidents.firstname,' ',presidents.middleinitial))  As fullname 
  	FROM presidents
	WHERE UCASE(TRIM(CONCAT_WS('', presidents.lastname,', ',presidents.firstname,' ',presidents.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY presidents.lastname
	LIMIT 20";
	$president =  getqueryresults($query);
	$presidentnum = mysql_num_rows($president);

	//Vice-President
	$query = "SELECT  'Vice President' As label, vicepresidents.vicepresident_id As id, TRIM(CONCAT_WS('', vicepresidents.lastname,', ',vicepresidents.firstname,' ',vicepresidents.middleinitial))  As fullname 
  	FROM vicepresidents
	WHERE UCASE(TRIM(CONCAT_WS('', vicepresidents.lastname,', ',vicepresidents.firstname,' ',vicepresidents.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY vicepresidents.lastname
	LIMIT 20";
	$vicepresident =  getqueryresults($query);
	$vicepresidentnum = mysql_num_rows($vicepresident);
	
	//Senator
	$query = "SELECT  'Senator' As label, senators.senator_id As id, TRIM(CONCAT_WS('', senators.lastname,', ',senators.firstname,' ',senators.middleinitial))  As fullname 
  	FROM senators
	WHERE UCASE(TRIM(CONCAT_WS('', senators.lastname,', ',senators.firstname,' ',senators.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY senators.lastname
	LIMIT 20";
	$senator =  getqueryresults($query);
	$senatornum = mysql_num_rows($senator);
	
	//Representative
	$query = "SELECT  'House Representative' As label, representatives.representative_id As id, TRIM(CONCAT_WS('', representatives.lastname,', ',representatives.firstname,' ',representatives.middleinitial))  As fullname 
  	FROM representatives
	WHERE UCASE(TRIM(CONCAT_WS('', representatives.lastname,', ',representatives.firstname,' ',representatives.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY representatives.lastname
	LIMIT 20";
	$representative =  getqueryresults($query);
	$representativenum = mysql_num_rows($representative);

	//Governor
	$query = "SELECT  'Governor' As label, governors.governor_id As id, TRIM(CONCAT_WS('', governors.lastname,', ',governors.firstname,' ',governors.middleinitial))  As fullname 
  	FROM governors
	WHERE UCASE(TRIM(CONCAT_WS('', governors.lastname,', ',governors.firstname,' ',governors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY governors.lastname
	LIMIT 20";
	$governor =  getqueryresults($query);
	$governornum = mysql_num_rows($governor);	

	//Vice-Governor
	$query = "SELECT  'Vice Governor' As label, vicegovernors.vicegovernor_id As id, TRIM(CONCAT_WS('', vicegovernors.lastname,', ',vicegovernors.firstname,' ',vicegovernors.middleinitial))  As fullname 
  	FROM vicegovernors
	WHERE UCASE(TRIM(CONCAT_WS('', vicegovernors.lastname,', ',vicegovernors.firstname,' ',vicegovernors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY vicegovernors.lastname
	LIMIT 20";
	$vicegovernor =  getqueryresults($query);
	$vicegovernornum = mysql_num_rows($vicegovernor);		

	//Provincial Board Members
	$query = "SELECT  'Provincial Board Members' As label, provboardmembers.provboardmember_id As id, TRIM(CONCAT_WS('', provboardmembers.lastname,', ',provboardmembers.firstname,' ',provboardmembers.middleinitial))  As fullname 
  	FROM provboardmembers
	WHERE UCASE(TRIM(CONCAT_WS('', provboardmembers.lastname,', ',provboardmembers.firstname,' ',provboardmembers.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY provboardmembers.lastname
	LIMIT 20";
	$provboardmember =  getqueryresults($query);
	$provboardmembernum = mysql_num_rows($provboardmember);		
	
	//Mayors
	$query = "SELECT  'Mayor' As label, mayors.mayor_id As id, TRIM(CONCAT_WS('', mayors.lastname,', ',mayors.firstname,' ',mayors.middleinitial))  As fullname 
  	FROM mayors
	WHERE UCASE(TRIM(CONCAT_WS('', mayors.lastname,', ',mayors.firstname,' ',mayors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY mayors.lastname
	LIMIT 20";
	$mayor =  getqueryresults($query);
	$mayornum = mysql_num_rows($mayor);		
	
	//Vice Mayors
	$query = "SELECT  'Vice Mayor' As label, vicemayors.vicemayor_id As id, TRIM(CONCAT_WS('', vicemayors.lastname,', ',vicemayors.firstname,' ',vicemayors.middleinitial))  As fullname 
  	FROM vicemayors
	WHERE UCASE(TRIM(CONCAT_WS('', vicemayors.lastname,', ',vicemayors.firstname,' ',vicemayors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY vicemayors.lastname
	LIMIT 20";
	$vicemayor =  getqueryresults($query);
	$vicemayornum = mysql_num_rows($vicemayor);		

	//Councilor
	$query = "SELECT  'Councilor' As label, councilors.councilor_id As id, TRIM(CONCAT_WS('', councilors.lastname,', ',councilors.firstname,' ',councilors.middleinitial))  As fullname 
  	FROM councilors
	WHERE UCASE(TRIM(CONCAT_WS('', councilors.lastname,', ',councilors.firstname,' ',councilors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY councilors.lastname
	LIMIT 20";
	$councilor =  getqueryresults($query);
	$councilornum = mysql_num_rows($councilor);	
	
	//Candidate for President
	$query = "SELECT  'Candidate for President' As label, candpresidents.president_id As id, TRIM(CONCAT_WS('', candpresidents.lastname,', ',candpresidents.firstname,' ',candpresidents.middleinitial))  As fullname 
  	FROM candpresidents
	WHERE UCASE(TRIM(CONCAT_WS('', candpresidents.lastname,', ',candpresidents.firstname,' ',candpresidents.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candpresidents.lastname
	LIMIT 20";
	$candpresident =  getqueryresults($query);
	$candpresidentnum = mysql_num_rows($candpresident);

	//Candidate for Vice-President
	$query = "SELECT  'Candidate for Vice President' As label, candvicepresidents.vicepresident_id As id, TRIM(CONCAT_WS('', candvicepresidents.lastname,', ',candvicepresidents.firstname,' ',candvicepresidents.middleinitial))  As fullname 
  	FROM candvicepresidents
	WHERE UCASE(TRIM(CONCAT_WS('', candvicepresidents.lastname,', ',candvicepresidents.firstname,' ',candvicepresidents.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candvicepresidents.lastname
	LIMIT 20";
	$candvicepresident =  getqueryresults($query);
	$candvicepresidentnum = mysql_num_rows($candvicepresident);
	
	//Candidate for Senator
	$query = "SELECT  'Candidate for Senator' As label, candsenators.senator_id As id, TRIM(CONCAT_WS('', candsenators.lastname,', ',candsenators.firstname,' ',candsenators.middleinitial))  As fullname 
  	FROM candsenators
	WHERE UCASE(TRIM(CONCAT_WS('', candsenators.lastname,', ',candsenators.firstname,' ',candsenators.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candsenators.lastname
	LIMIT 20";
	$candsenator =  getqueryresults($query);
	$candsenatornum = mysql_num_rows($candsenator);
	
	//Candidate for Representative
	$query = "SELECT  'Candidate for House Representative' As label, candrepresentatives.representative_id As id, TRIM(CONCAT_WS('', candrepresentatives.lastname,', ',candrepresentatives.firstname,' ',candrepresentatives.middleinitial))  As fullname 
  	FROM candrepresentatives
	WHERE UCASE(TRIM(CONCAT_WS('', candrepresentatives.lastname,', ',candrepresentatives.firstname,' ',candrepresentatives.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candrepresentatives.lastname
	LIMIT 20";
	$candrepresentative =  getqueryresults($query);
	$candrepresentativenum = mysql_num_rows($candrepresentative);

	//Candidate for Governor
	$query = "SELECT  'Candidate for Governor' As label, candgovernors.governor_id As id, TRIM(CONCAT_WS('', candgovernors.lastname,', ',candgovernors.firstname,' ',candgovernors.middleinitial))  As fullname 
  	FROM candgovernors
	WHERE UCASE(TRIM(CONCAT_WS('', candgovernors.lastname,', ',candgovernors.firstname,' ',candgovernors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candgovernors.lastname
	LIMIT 20";
	$candgovernor =  getqueryresults($query);
	$candgovernornum = mysql_num_rows($candgovernor);	

	//Candidate for Vice-Governor
	$query = "SELECT  'Candidate for Vice Governor' As label, candvicegovernors.vicegovernor_id As id, TRIM(CONCAT_WS('', candvicegovernors.lastname,', ',candvicegovernors.firstname,' ',candvicegovernors.middleinitial))  As fullname 
  	FROM candvicegovernors
	WHERE UCASE(TRIM(CONCAT_WS('', candvicegovernors.lastname,', ',candvicegovernors.firstname,' ',candvicegovernors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candvicegovernors.lastname
	LIMIT 20";
	$candvicegovernor =  getqueryresults($query);
	$candvicegovernornum = mysql_num_rows($candvicegovernor);		

	//Candidate for Provincial Board Members
	$query = "SELECT  'Candidate for Provincial Board Members' As label, candboardmem.provboardmember_id As id, TRIM(CONCAT_WS('', candboardmem.lastname,', ',candboardmem.firstname,' ',candboardmem.middleinitial))  As fullname 
  	FROM candboardmem
	WHERE UCASE(TRIM(CONCAT_WS('', candboardmem.lastname,', ',candboardmem.firstname,' ',candboardmem.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candboardmem.lastname
	LIMIT 20";
	$candboardmem =  getqueryresults($query);
	$candboardmemnum = mysql_num_rows($candboardmem);		
	
	//Candidate for Mayors
	$query = "SELECT  'Candidate for Mayor' As label, candmayors.mayor_id As id, TRIM(CONCAT_WS('', candmayors.lastname,', ',candmayors.firstname,' ',candmayors.middleinitial))  As fullname 
  	FROM candmayors
	WHERE UCASE(TRIM(CONCAT_WS('', candmayors.lastname,', ',candmayors.firstname,' ',candmayors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candmayors.lastname
	LIMIT 20";
	$candmayor =  getqueryresults($query);
	$candmayornum = mysql_num_rows($candmayor);		
	
	//Candidate for Vice Mayors
	$query = "SELECT  'Vice Mayor' As label, candvicemayors.vicemayor_id As id, TRIM(CONCAT_WS('', candvicemayors.lastname,', ',candvicemayors.firstname,' ',candvicemayors.middleinitial))  As fullname 
  	FROM candvicemayors
	WHERE UCASE(TRIM(CONCAT_WS('', candvicemayors.lastname,', ',candvicemayors.firstname,' ',candvicemayors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candvicemayors.lastname
	LIMIT 20";
	$candvicemayor =  getqueryresults($query);
	$candvicemayornum = mysql_num_rows($candvicemayor);		

	//Candidate for Councilor
	$query = "SELECT  'Councilor' As label, candcouncilors.councilor_id As id, TRIM(CONCAT_WS('', candcouncilors.lastname,', ',candcouncilors.firstname,' ',candcouncilors.middleinitial))  As fullname 
  	FROM candcouncilors
	WHERE UCASE(TRIM(CONCAT_WS('', candcouncilors.lastname,', ',candcouncilors.firstname,' ',candcouncilors.middleinitial))) LIKE UCASE(\"%".$name."%\") 
	ORDER BY candcouncilors.lastname
	LIMIT 20";
	$candcouncilor =  getqueryresults($query);
	$candcouncilornum = mysql_num_rows($candcouncilor);		
	
	$numresults = $presidentnum + $vicepresidentnum + $senatornum + $representativenum
	              +	$governornum + $vicegovernornum + $provboardmembernum + $mayornum
				  + $vicemayornum + $councilornum + $candpresidentnum + $candvicepresidentnum
				  + $candsenatornum + $candrepresentativenum + $candgovernornum +
				  + $candvicegovernornum + $candboardmemnum + $candmayornum + $candvicemayornum
				  + $candcouncilornum;
}	
?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Search Names</TITLE>
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
<B>Search Names</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>SEARCH NAMES</B></DIV>
<BR>
<BR>		
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="get">
Enter search string for name:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name" SIZE="40" MAXLENGTH="80"><BR><BR>
<I>Enter a search string matching a portion of the name you want to search. For 
   example, the search string <B><I>ang</I></B> may return names with first name 
   or last name having string <B><I>angara</I></B>, <B><I>anping</I></B>, <B><I>angelo</I></B>, etc.
   Note that this search is case-insensitive and hence, lowercase letters or capital letters
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
	<TR><TD><B>No.</B></TD><TD><B>Position</B></TD><TD><B>Name</B></TD></TR>
	<?PHP while ($presidentrow = mysql_fetch_array($president)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $presidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['id']; ?>><?PHP echo $presidentrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($president); ?>
	
	
	<?PHP while ($vicepresidentrow = mysql_fetch_array($vicepresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicepresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['id']; ?>><?PHP echo $vicepresidentrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicepresident); ?>	
	
	
	<?PHP while ($senatorrow = mysql_fetch_array($senator)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $senatorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senatorrow['id']; ?>><?PHP echo $senatorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($senator); ?>	
	
	
	<?PHP while ($representativerow = mysql_fetch_array($representative)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $representativerow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$representativerow['id']; ?>><?PHP echo $representativerow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($representative); ?>	

	
	<?PHP while ($governorrow = mysql_fetch_array($governor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $governorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['id']; ?>><?PHP echo $governorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($governor); ?>		


	<?PHP while ($vicegovernorrow = mysql_fetch_array($vicegovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicegovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['id']; ?>><?PHP echo $vicegovernorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicegovernor); ?>			
	
	
	<?PHP while ($provboardmemberrow = mysql_fetch_array($provboardmember)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $provboardmemberrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/provboardmembersdet.php?provboardmemberid=".$provboardmemberrow['id']; ?>><?PHP echo $provboardmemberrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($provboardmember); ?>	
	
	<?PHP while ($mayorrow = mysql_fetch_array($mayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $mayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['id']; ?>><?PHP echo $mayorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($mayor); ?>		
	
	<?PHP while ($vicemayorrow = mysql_fetch_array($vicemayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicemayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['id']; ?>><?PHP echo $vicemayorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicemayor); ?>		
	
	<?PHP while ($councilorrow = mysql_fetch_array($councilor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $councilorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorrow['id']; ?>><?PHP echo $councilorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($councilor); ?>
	
	<?PHP while ($candpresidentrow = mysql_fetch_array($candpresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candpresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentrow['id']; ?>><?PHP echo $candpresidentrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($candpresident); ?>
	
	
	<?PHP while ($candvicepresidentrow = mysql_fetch_array($candvicepresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicepresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicepresidentsdet.php?candvicepresidentid=".$candvicepresidentrow['id']; ?>><?PHP echo $candvicepresidentrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicepresident); ?>	
	
	
	<?PHP while ($candsenatorrow = mysql_fetch_array($candsenator)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candsenatorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorrow['id']; ?>><?PHP echo $candsenatorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candsenator); ?>	
	
	
	<?PHP while ($candrepresentativerow = mysql_fetch_array($candrepresentative)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candrepresentativerow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativerow['id']; ?>><?PHP echo $candrepresentativerow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candrepresentative); ?>	

	
	<?PHP while ($candgovernorrow = mysql_fetch_array($candgovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candgovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorrow['id']; ?>><?PHP echo $candgovernorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candgovernor); ?>		


	<?PHP while ($candvicegovernorrow = mysql_fetch_array($candvicegovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicegovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorrow['id']; ?>><?PHP echo $candvicegovernorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicegovernor); ?>			
	
	
	<?PHP while ($candboardmemrow = mysql_fetch_array($candboardmem)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candboardmemrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candboardmemsdet.php?candboardmemid=".$candboardmemrow['id']; ?>><?PHP echo $candboardmemrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candboardmem); ?>	
	
	<?PHP while ($candmayorrow = mysql_fetch_array($candmayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candmayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorrow['id']; ?>><?PHP echo $candmayorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candmayor); ?>		
	
	<?PHP while ($candvicemayorrow = mysql_fetch_array($candvicemayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicemayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorrow['id']; ?>><?PHP echo $candvicemayorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicemayor); ?>		
	
	<?PHP while ($candcouncilorrow = mysql_fetch_array($candcouncilor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candcouncilorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorrow['id']; ?>><?PHP echo $candcouncilorrow['fullname']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candcouncilor); ?>				
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
