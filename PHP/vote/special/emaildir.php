<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP

	//President
	$query = "SELECT  'President' As label, president_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM presidents
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$president =  getqueryresults($query);
	$presidentnum = mysql_num_rows($president);

	//Vice-President
	$query = "SELECT  'Vice-president' As label, vicepresident_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM vicepresidents
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$vicepresident =  getqueryresults($query);
	$vicepresidentnum = mysql_num_rows($vicepresident);
	
	//Senator
	$query = "SELECT  'Senator' As label,  senator_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM senators
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$senator =  getqueryresults($query);
	$senatornum = mysql_num_rows($senator);
	
	//Representative
	$query = "SELECT  'Representative' As label, representative_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM representatives
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$representative =  getqueryresults($query);
	$representativenum = mysql_num_rows($representative);

	//Governor
	$query = "SELECT  'Governor' As label, governor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM governors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$governor =  getqueryresults($query);
	$governornum = mysql_num_rows($governor);	

	//Vice-Governor
	$query = "SELECT  'Vice Governor' As label, vicegovernor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM vicegovernors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$vicegovernor =  getqueryresults($query);
	$vicegovernornum = mysql_num_rows($vicegovernor);		

	//Provincial Board Members
	$query = "SELECT  'Provincial Board Member' As label, provboardmember_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM provboardmembers
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$provboardmember =  getqueryresults($query);
	$provboardmembernum = mysql_num_rows($provboardmember);		
	
	//Mayors
	$query = "SELECT  'Mayor' As label, mayor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM mayors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$mayor =  getqueryresults($query);
	$mayornum = mysql_num_rows($mayor);		
	
	//Vice Mayors
	$query = "SELECT  'Vice mayor' As label, vicemayor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM vicemayors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$vicemayor =  getqueryresults($query);
	$vicemayornum = mysql_num_rows($vicemayor);		

	//Councilor
	$query = "SELECT  'Councilor' As label, councilor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM councilors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$councilor =  getqueryresults($query);
	$councilornum = mysql_num_rows($councilor);	
	
	//Candidate for President
	$query = "SELECT  'Candidate for President' As label, president_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candpresidents
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candpresident =  getqueryresults($query);
	$candpresidentnum = mysql_num_rows($candpresident);

	//Candidate for Vice-President
	$query = "SELECT  'Candidate for Vice President' As label, vicepresident_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candvicepresidents
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candvicepresident =  getqueryresults($query);
	$candvicepresidentnum = mysql_num_rows($candvicepresident);
	
	//Candidate for Senator
	$query = "SELECT  'Candidate for Senator' As label, senator_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candsenators
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candsenator =  getqueryresults($query);
	$candsenatornum = mysql_num_rows($candsenator);
	
	//Candidate for Representative
	$query = "SELECT  'Candidate for Representative' As label, representative_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candrepresentatives
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candrepresentative =  getqueryresults($query);
	$candrepresentativenum = mysql_num_rows($candrepresentative);

	//Candidate for Governor
	$query = "SELECT  'Candidate for Governor' As label, governor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candgovernors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candgovernor =  getqueryresults($query);
	$candgovernornum = mysql_num_rows($candgovernor);	

	//Candidate for Vice-Governor
	$query = "SELECT  'Candidate for Vice Governor' As label, vicegovernor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candvicegovernors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candvicegovernor =  getqueryresults($query);
	$candvicegovernornum = mysql_num_rows($candvicegovernor);		

	//Candidate for Provincial Board Members
	$query = "SELECT  'Candidate for Provincial Board Member' As label, provboardmember_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candboardmem
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candboardmem =  getqueryresults($query);
	$candboardmemnum = mysql_num_rows($candboardmem);		
	
	//Candidate for Mayors
	$query = "SELECT  'Candidate for Mayor' As label, mayor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candmayors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candmayor =  getqueryresults($query);
	$candmayornum = mysql_num_rows($candmayor);		
	
	//Candidate for Vice Mayors
	$query = "SELECT  'Candidate for Vice Mayor' As label, vicemayor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candvicemayors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candvicemayor =  getqueryresults($query);
	$candvicemayornum = mysql_num_rows($candvicemayor);		

	//Candidate for Councilor
	$query = "SELECT  'Candidate for Councilor' As label, councilor_id As id, TRIM(CONCAT_WS('', lastname,', ',firstname,' ',middleinitial))  As fullname, emailaddr 
  	FROM candcouncilors
	WHERE ASCII(emailaddr) <> 0 
	ORDER BY lastname";
	$candcouncilor =  getqueryresults($query);
	$candcouncilornum = mysql_num_rows($candcouncilor);		

	$numresults = $presidentnum + $vicepresidentnum + $senatornum + $representativenum
	              +	$governornum + $vicegovernornum + $provboardmembernum + $mayornum
				  + $vicemayornum + $councilornum + $candpresidentnum + $candvicepresidentnum
				  + $candsenatornum + $candrepresentativenum + $candgovernornum +
				  + $candvicegovernornum + $candboardmemnum + $candmayornum + $candvicemayornum
				  + $candcouncilornum;
?>	
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : E-mail Directory</TITLE>
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
<B> Email Directory</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>EMAIL DIRECTORY</B></DIV>
<BR>
<BR>	
No. of names with e-mail addresses: <?PHP echo $numresults; ?><BR><BR>	
<?PHP $ctr=0; ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
	<TR><TD><B>No.</B></TD><TD><B>Position</B></TD><TD><B>Name</B></TD><TD><B>E-mail</B></TD></TR>
	<?PHP while ($presidentrow = mysql_fetch_array($president)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $presidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['id']; ?>><?PHP echo $presidentrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$presidentrow['emailaddr']; ?>></A><?PHP echo $presidentrow['emailaddr']; ?></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($president); ?>
	
	
	<?PHP while ($vicepresidentrow = mysql_fetch_array($vicepresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicepresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['id']; ?>><?PHP echo $vicepresidentrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$vicepresidentrow['emailaddr']; ?>><?PHP echo $vicepresidentrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicepresident); ?>	
	
	
	<?PHP while ($senatorrow = mysql_fetch_array($senator)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $senatorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senatorrow['id']; ?>><?PHP echo $senatorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$senatorrow['emailaddr']; ?>><?PHP echo $senatorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($senator); ?>	
	
	
	<?PHP while ($representativerow = mysql_fetch_array($representative)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $representativerow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$representativerow['id']; ?>><?PHP echo $representativerow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$representativerow['emailaddr']; ?>><?PHP echo $representativerow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($representative); ?>	

	
	<?PHP while ($governorrow = mysql_fetch_array($governor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $governorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['id']; ?>><?PHP echo $governorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$governorrow['emailaddr']; ?>><?PHP echo $governorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($governor); ?>		


	<?PHP while ($vicegovernorrow = mysql_fetch_array($vicegovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicegovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['id']; ?>><?PHP echo $vicegovernorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$vicegovernorrow['emailaddr']; ?>><?PHP echo $vicegovernorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicegovernor); ?>			
	
	
	<?PHP while ($provboardmemberrow = mysql_fetch_array($provboardmember)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $provboardmemberrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/provboardmembersdet.php?provboardmemberid=".$provboardmemberrow['id']; ?>><?PHP echo $provboardmemberrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$provboardmemberrow['emailaddr']; ?>><?PHP echo $provboardmemberrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($provboardmember); ?>	
	
	<?PHP while ($mayorrow = mysql_fetch_array($mayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $mayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['id']; ?>><?PHP echo $mayorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$mayorrow['emailaddr']; ?>><?PHP echo $mayorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($mayor); ?>		
	
	<?PHP while ($vicemayorrow = mysql_fetch_array($vicemayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $vicemayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['id']; ?>><?PHP echo $vicemayorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$vicemayorrow['emailaddr']; ?>><?PHP echo $vicemayorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($vicemayor); ?>		
	
	<?PHP while ($councilorrow = mysql_fetch_array($councilor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $councilorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorrow['id']; ?>><?PHP echo $councilorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$councilorrow['emailaddr']; ?>><?PHP echo $councilorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($councilor); ?>
	
	<?PHP while ($candpresidentrow = mysql_fetch_array($candpresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candpresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentrow['id']; ?>><?PHP echo $candpresidentrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candpresidentrow['emailaddr']; ?>><?PHP echo $candpresidentrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>		
	<?PHP mysql_free_result($candpresident); ?>
	
	
	<?PHP while ($candvicepresidentrow = mysql_fetch_array($candvicepresident)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicepresidentrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicepresidentsdet.php?candvicepresidentid=".$candvicepresidentrow['id']; ?>><?PHP echo $candvicepresidentrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candvicepresidentrow['emailaddr']; ?>><?PHP echo $candvicepresidentrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicepresident); ?>	
	
	
	<?PHP while ($candsenatorrow = mysql_fetch_array($candsenator)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candsenatorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorrow['id']; ?>><?PHP echo $candsenatorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candsenatorrow['emailaddr']; ?>><?PHP echo $candsenatorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candsenator); ?>	
	
	
	<?PHP while ($candrepresentativerow = mysql_fetch_array($candrepresentative)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candrepresentativerow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativerow['id']; ?>><?PHP echo $candrepresentativerow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candrepresentativerow['emailaddr']; ?>><?PHP echo $candrepresentativerow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candrepresentative); ?>	

	
	<?PHP while ($candgovernorrow = mysql_fetch_array($candgovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candgovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorrow['id']; ?>><?PHP echo $candgovernorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candgovernorrow['emailaddr']; ?>><?PHP echo $candgovernorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>
	<?PHP mysql_free_result($candgovernor); ?>		


	<?PHP while ($candvicegovernorrow = mysql_fetch_array($candvicegovernor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicegovernorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorrow['id']; ?>><?PHP echo $candvicegovernorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candvicegovernorrow['emailaddr']; ?>><?PHP echo $candvicegovernorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicegovernor); ?>			
	
	
	<?PHP while ($candboardmemrow = mysql_fetch_array($candboardmem)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candboardmemrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candboardmemsdet.php?candboardmemid=".$candboardmemrow['id']; ?>><?PHP echo $candboardmemrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candboardmemrow['emailaddr']; ?>><?PHP echo $candboardmemrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candboardmem); ?>	
	
	<?PHP while ($candmayorrow = mysql_fetch_array($candmayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candmayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorrow['id']; ?>><?PHP echo $candmayorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candmayorrow['emailaddr']; ?>><?PHP echo $candmayorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candmayor); ?>		
	
	<?PHP while ($candvicemayorrow = mysql_fetch_array($candvicemayor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candvicemayorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorrow['id']; ?>><?PHP echo $candvicemayorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candvicemayorrow['emailaddr']; ?>><?PHP echo $candvicemayorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candvicemayor); ?>		
	
	<?PHP while ($candcouncilorrow = mysql_fetch_array($candcouncilor)) { ?>
			<?PHP $ctr++; ?>
			<?PHP if ($ctr % 2 == 0) { ?>
				<TR BGCOLOR="#C5E0FE">
			<?PHP } else { ?>
				<TR>
			<?PHP } ?>
			<TD><?PHP echo $ctr; ?></TD><TD><?PHP echo $candcouncilorrow['label']; ?></TD><TD><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorrow['id']; ?>><?PHP echo $candcouncilorrow['fullname']; ?></A></TD>
			    <TD><A HREF=<?PHP echo "mailto:".$candcouncilorrow['emailaddr']; ?>><?PHP echo $candcouncilorrow['emailaddr']; ?></A></TD></TR>	
	<?PHP } ?>	
	<?PHP mysql_free_result($candcouncilor); ?>				
</TABLE>
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
