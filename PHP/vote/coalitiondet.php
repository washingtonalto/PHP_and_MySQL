<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/terms.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  coalitions.coalition_id, coalitions.acronym, coalitions.name As coalitionname,
   coalitions.mission, coalitions.vision, coalitions.platform, coalitions.coalitionorganization, 
   coalitions.address,coalitions.telnumbers, coalitions.email,coalitions.faxnumbers, 
   coalitions.programofgovt, coalitions.standonissues, coalitions.coalitionhistory  
  FROM coalitions
  WHERE (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY coalitions.acronym,coalitions.name";
$coalition = getqueryresults($query);
$coalitionrow = mysql_fetch_array($coalition);
$coalitionrow = slashstripper($coalitionrow);

$query = "SELECT presidents.president_id As president_id, presidents.lastname As lastname,presidents.firstname As firstname, presidents.middleinitial As middleinitial 
  FROM coalitions, presidents
  WHERE (presidents.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.") AND (YEAR(presidents.term_begin) = ".$pterm.")   
  ORDER BY presidents.lastname,presidents.term_begin";
$presidentmem = getqueryresults($query);
$numpresidentmem = mysql_num_rows($presidentmem);

$query = "SELECT vicepresidents.vicepresident_id As vicepresident_id, vicepresidents.lastname As lastname,vicepresidents.firstname As firstname, vicepresidents.middleinitial As middleinitial 
  FROM coalitions, vicepresidents
  WHERE (vicepresidents.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.") AND (YEAR(vicepresidents.term_begin) = ".$vpterm.")   
  ORDER BY vicepresidents.lastname,vicepresidents.term_begin";
$vicepresidentmem = getqueryresults($query);
$numvicepresidentmem = mysql_num_rows($vicepresidentmem);

$query = "SELECT senators.senator_id As senator_id, senators.lastname As lastname,senators.firstname As firstname, senators.middleinitial As middleinitial 
  FROM coalitions, senators
  WHERE (senators.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.") AND ((YEAR(senators.term_begin) = ".$term1st.") OR (YEAR(senators.term_begin) = ".$term2nd."))  
  ORDER BY senators.lastname,senators.term_begin";
$senatormem = getqueryresults($query);
$numsenatormem = mysql_num_rows($senatormem);

$query = "SELECT representatives.representative_id As representative_id, representatives.lastname As lastname,representatives.firstname As firstname, representatives.middleinitial As middleinitial
  FROM coalitions, representatives
  WHERE (representatives.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.") AND (YEAR(representatives.term_begin) = ".$repterm.")   
  ORDER BY representatives.lastname,representatives.term_begin";
$representativemem = getqueryresults($query);
$numrepresentativemem = mysql_num_rows($representativemem);

$query = "SELECT governors.governor_id As governor_id, governors.lastname As lastname,governors.firstname As firstname, governors.middleinitial As middleinitial 
  FROM coalitions, governors
  WHERE (governors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.") AND (YEAR(governors.term_begin) = ".$govterm.")   
  ORDER BY governors.lastname,governors.term_begin";
$governormem = getqueryresults($query);
$numgovernormem = mysql_num_rows($governormem);

$query = "SELECT vicegovernors.vicegovernor_id As vicegovernor_id, vicegovernors.lastname As lastname,vicegovernors.firstname As firstname, vicegovernors.middleinitial As middleinitial 
  FROM coalitions, vicegovernors
  WHERE (vicegovernors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")AND (YEAR(vicegovernors.term_begin) = ".$vicegovterm.")   
  ORDER BY vicegovernors.lastname,vicegovernors.term_begin";
$vicegovernormem = getqueryresults($query);
$numvicegovernormem = mysql_num_rows($vicegovernormem);

$query = "SELECT provboardmembers.provboardmember_id As provboardmember_id, provboardmembers.lastname As lastname,provboardmembers.firstname As firstname, provboardmembers.middleinitial As middleinitial 
  FROM coalitions, provboardmembers
  WHERE (provboardmembers.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")AND (YEAR(provboardmembers.term_begin) = ".$provterm.")   
  ORDER BY provboardmembers.lastname,provboardmembers.term_begin";
$provboardmembermem = getqueryresults($query);
$numprovboardmembermem = mysql_num_rows($provboardmembermem);

$query = "SELECT mayors.mayor_id As mayor_id, mayors.lastname As lastname,mayors.firstname As firstname, mayors.middleinitial As middleinitial 
  FROM coalitions, mayors
  WHERE (mayors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")AND (YEAR(mayors.term_begin) = ".$mayterm.")   
  ORDER BY mayors.lastname,mayors.term_begin";
$mayormem = getqueryresults($query);
$nummayormem = mysql_num_rows($mayormem);

$query = "SELECT vicemayors.vicemayor_id As vicemayor_id, vicemayors.lastname As lastname,vicemayors.firstname As firstname, vicemayors.middleinitial As middleinitial 
  FROM coalitions, vicemayors
  WHERE (vicemayors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")AND (YEAR(vicemayors.term_begin) = ".$vmayterm.")   
  ORDER BY vicemayors.lastname,vicemayors.term_begin";
$vicemayormem = getqueryresults($query);
$numvicemayormem = mysql_num_rows($vicemayormem);

$query = "SELECT councilors.councilor_id As councilor_id, councilors.lastname As lastname,councilors.firstname As firstname, councilors.middleinitial As middleinitial 
  FROM coalitions, councilors
  WHERE (councilors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")AND (YEAR(councilors.term_begin) = ".$counterm.")   
  ORDER BY councilors.lastname,councilors.term_begin";
$councilormem = getqueryresults($query);
$numcouncilormem = mysql_num_rows($councilormem);

$query = "SELECT candpresidents.president_id As president_id, candpresidents.lastname As lastname,candpresidents.firstname As firstname, candpresidents.middleinitial As middleinitial 
  FROM coalitions, candpresidents
  WHERE (candpresidents.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")    
  ORDER BY candpresidents.lastname";
$candpresidentmem = getqueryresults($query);
$numcandpresidentmem = mysql_num_rows($candpresidentmem);

$query = "SELECT candvicepresidents.vicepresident_id As vicepresident_id, candvicepresidents.lastname As lastname,candvicepresidents.firstname As firstname, candvicepresidents.middleinitial As middleinitial 
  FROM coalitions, candvicepresidents
  WHERE (candvicepresidents.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candvicepresidents.lastname";
$candvicepresidentmem = getqueryresults($query);
$numcandvicepresidentmem = mysql_num_rows($candvicepresidentmem);

$query = "SELECT candsenators.senator_id As senator_id, candsenators.lastname As lastname,candsenators.firstname As firstname, candsenators.middleinitial As middleinitial 
  FROM coalitions, candsenators
  WHERE (candsenators.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candsenators.lastname";
$candsenatormem = getqueryresults($query);
$numcandsenatormem = mysql_num_rows($candsenatormem);

$query = "SELECT candrepresentatives.representative_id As representative_id, candrepresentatives.lastname As lastname,candrepresentatives.firstname As firstname, candrepresentatives.middleinitial As middleinitial
  FROM coalitions, candrepresentatives
  WHERE (candrepresentatives.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")    
  ORDER BY candrepresentatives.lastname";
$candrepresentativemem = getqueryresults($query);
$numcandrepresentativemem = mysql_num_rows($candrepresentativemem);

$query = "SELECT candgovernors.governor_id As governor_id, candgovernors.lastname As lastname,candgovernors.firstname As firstname, candgovernors.middleinitial As middleinitial 
  FROM coalitions, candgovernors
  WHERE (candgovernors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")    
  ORDER BY candgovernors.lastname";
$candgovernormem = getqueryresults($query);
$numcandgovernormem = mysql_num_rows($candgovernormem);

$query = "SELECT candvicegovernors.vicegovernor_id As vicegovernor_id, candvicegovernors.lastname As lastname,candvicegovernors.firstname As firstname, candvicegovernors.middleinitial As middleinitial 
  FROM coalitions, candvicegovernors
  WHERE (candvicegovernors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candvicegovernors.lastname";
$candvicegovernormem = getqueryresults($query);
$numcandvicegovernormem = mysql_num_rows($candvicegovernormem);

$query = "SELECT candboardmem.provboardmember_id As provboardmember_id, candboardmem.lastname As lastname,candboardmem.firstname As firstname, candboardmem.middleinitial As middleinitial 
  FROM coalitions, candboardmem
  WHERE (candboardmem.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candboardmem.lastname";
$candboardmemmem = getqueryresults($query);
$numcandboardmemmem = mysql_num_rows($candboardmemmem);

$query = "SELECT candmayors.mayor_id As mayor_id, candmayors.lastname As lastname,candmayors.firstname As firstname, candmayors.middleinitial As middleinitial 
  FROM coalitions, candmayors
  WHERE (candmayors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candmayors.lastname";
$candmayormem = getqueryresults($query);
$numcandmayormem = mysql_num_rows($candmayormem);

$query = "SELECT candvicemayors.vicemayor_id As vicemayor_id, candvicemayors.lastname As lastname,candvicemayors.firstname As firstname, candvicemayors.middleinitial As middleinitial 
  FROM coalitions, candvicemayors
  WHERE (candvicemayors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candvicemayors.lastname";
$candvicemayormem = getqueryresults($query);
$numcandvicemayormem = mysql_num_rows($candvicemayormem);

$query = "SELECT candcouncilors.councilor_id As councilor_id, candcouncilors.lastname As lastname,candcouncilors.firstname As firstname, candcouncilors.middleinitial As middleinitial 
  FROM coalitions, candcouncilors
  WHERE (candcouncilors.coalition_id = coalitions.coalition_id) AND (coalitions.coalition_id = ".$coalitionid.")   
  ORDER BY candcouncilors.lastname";
$candcouncilormem = getqueryresults($query);
$numcandcouncilormem = mysql_num_rows($candcouncilormem);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Coalition - <?PHP echo $coalitionrow['coalitionname']; ?>&nbsp;
<?PHP if(!empty($coalitionrow['acronym'])) { ?>
    (<?PHP echo $coalitionrow['acronym']; ?>)
<?PHP } ?>	
</TITLE>
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
<A HREF="/vote/byparty.php"><B>By Party</B></A>
<IMG SRC="graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Coalition - <?PHP echo $coalitionrow['coalitionname']; ?>&nbsp;
<?PHP if(!empty($coalitionrow['acronym'])) { ?>
    (<?PHP echo $coalitionrow['acronym']; ?>)
<?PHP } ?></B>	
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD WIDTH="15%" ALIGN="left" VALIGN="top">
<!-- Start of 1st Column --->
<?PHP if (!empty($coalitionrow['address']) OR !empty($coalitionrow['telnumbers']) OR !empty($coalitionrow['email']) OR !empty($coalitionrow['faxnumbers'])) { ?>
<BR>
<TABLE WIDTH="100%" BORDER="1" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
	<TD ALIGN="center" VALIGN="top" BGCOLOR="#7EBEBE"><DIV ALIGN="center"><B>Contact Information</B></DIV></TD>
</TR>
<TR>
	<TD ALIGN="left" VALIGN="top">
	<SPAN CLASS="BROWSEBOXFONT">
	<?PHP if (!empty($coalitionrow['address'])) { ?>
		<B>Address:</B>&nbsp; <?PHP echo $coalitionrow['address'] ?> <BR>
	<?PHP } ?>	
	<?PHP if (!empty($coalitionrow['telnumbers'])) { ?>	
	<B>Tel. Nos.:</B>&nbsp; <?PHP echo $coalitionrow['telnumbers'] ?> <BR>
	<?PHP } ?>		
	<?PHP if (!empty($coalitionrow['faxnumbers'])) { ?>			
	<B>Fax Nos.:</B>&nbsp; <?PHP echo $coalitionrow['faxnumbers'] ?> <BR>
	<?PHP } ?>		
	<?PHP if (!empty($coalitionrow['email'])) { ?>
		<B>E-mail:</B>&nbsp; <A HREF=<?PHP echo "mailto:".$coalitionrow['email']; ?>><?PHP echo $coalitionrow['email'] ?></A><BR>		
	<?PHP } ?>
	</SPAN>
	</TD>
</TR>
</TABLE>
<?PHP } ?>
<!-- End of 1st Column --->
	</TD>
	<TD WIDTH="1%">&nbsp;</TD> <!-- Spacer between 1st and 3rd column -->
	<TD WIDTH="30%" ALIGN="left" VALIGN="top">	
<!-- Start of 3rd Column --->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B><?PHP echo strtoupper($coalitionrow['coalitionname']); ?></B></DIV>
<BR>

<?PHP if(!empty($coalitionrow['vision'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Vision</H2>
	<?PHP echo $coalitionrow['vision']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['mission'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Mission</H2>
	<?PHP echo $coalitionrow['mission']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['platform'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Platform</H2>
	<?PHP echo $coalitionrow['platform']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['programofgovt'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Program of Government</H2>
	<?PHP echo $coalitionrow['programofgovt']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['standonissues'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Stand on Certain Issues</H2>
	<?PHP echo $coalitionrow['standonissues']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['coalitionhistory'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Coalition History</H2>
	<?PHP echo $coalitionrow['coalitionhistory']; ?>
<?PHP } ?>

<?PHP if(!empty($coalitionrow['coalitionorganization'])) { ?>
	<H2 CLASS="HIGHLIGHTS">Coalition Organization</H2>
	<?PHP echo $coalitionrow['coalitionorganization']; ?>
<?PHP } ?>

<H2 CLASS="HIGHLIGHTS">Members of the Coalition in Government Positions</H2>
<OL>
	<?PHP while($presidentrow = mysql_fetch_array($presidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['president_id']; ?>>
				Pres. <?PHP echo $presidentrow['firstname']; ?>	
				<?PHP if(!empty($presidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $presidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $presidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
	<?PHP while($vicepresidentrow = mysql_fetch_array($vicepresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['vicepresident_id']; ?>>
				Vice Pres. <?PHP echo $vicepresidentrow['firstname']; ?>	
				<?PHP if(!empty($vicepresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicepresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicepresidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
	<?PHP while($senatorrow = mysql_fetch_array($senatormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senatorrow['senator_id']; ?>>
				Sen. <?PHP echo $senatorrow['firstname']; ?>	
				<?PHP if(!empty($senatorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $senatorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $senatorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($senatormem);
	?>	
	<?PHP while($representativerow = mysql_fetch_array($representativemem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/representativedet.php?representativeid=".$representativerow['representative_id']; ?>>
				Rep. <?PHP echo $representativerow['firstname']; ?>	
				<?PHP if(!empty($representativerow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $representativerow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $representativerow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($representativemem);
	?>	
	<?PHP while($governorrow = mysql_fetch_array($governormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['governor_id']; ?>>
				Gov. <?PHP echo $governorrow['firstname']; ?>	
				<?PHP if(!empty($governorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $governorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $governorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($governormem);
	?>		
	<?PHP while($vicegovernorrow = mysql_fetch_array($vicegovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['vicegovernor_id']; ?>>
				Vice Gov. <?PHP echo $vicegovernorrow['firstname']; ?>	
				<?PHP if(!empty($vicegovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicegovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicegovernorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($vicegovernormem);
	?>			
	<?PHP while($provboardmemberrow = mysql_fetch_array($provboardmembermem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/provboardmemdet.php?provboardmemid=".$provboardmemberrow['provboardmember_id']; ?>>
				Provincial Board Member <?PHP echo $provboardmemberrow['firstname']; ?>	
				<?PHP if(!empty($provboardmemberrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $provboardmemberrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $provboardmemberrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($provboardmembermem);
	?>			
	<?PHP while($mayorrow = mysql_fetch_array($mayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['mayor_id']; ?>>
				Mayor <?PHP echo $mayorrow['firstname']; ?>	
				<?PHP if(!empty($mayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $mayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $mayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($mayormem);
	?>				
	<?PHP while($vicemayorrow = mysql_fetch_array($vicemayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['vicemayor_id']; ?>>
				Vice Mayor <?PHP echo $vicemayorrow['firstname']; ?>	
				<?PHP if(!empty($vicemayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $vicemayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $vicemayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($vicemayormem);
	?>							
	<?PHP while($councilorrow = mysql_fetch_array($councilormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorrow['councilor_id']; ?>>
				Councilor <?PHP echo $councilorrow['firstname']; ?>	
				<?PHP if(!empty($councilorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $councilorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $councilorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($councilormem);
	?>								
</OL>
<TABLE WIDTH="50%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP 
	if($numsenatormem > 0) {
		echo "<TR><TD><B>No. of Senators:</B></TD><TD>".$numsenatormem."</TD></TR>";
	}		
?> 
<?PHP 
	if($numrepresentativemem > 0) {
		echo "<TR><TD><B>No. of House Representatives:</B></TD><TD>".$numrepresentativemem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numgovernormem > 0) {
		echo "<TR><TD><B>No. of Governors:</B></TD><TD>".$numgovernormem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numvicegovernormem > 0) {
		echo "<TR><TD><B>No. of Vice Governors:</B></TD><TD>".$numvicegovernormem."</TD></TR>";
	}		
?>  
<?PHP 
	if($numprovboardmembermem > 0) {
		echo "<TR><TD><B>No. of Provincial Board Members:</B></TD><TD>".$numprovboardmembermem."</TD></TR>";
	}		
?> 
<?PHP 
	if($nummayormem > 0) {
		echo "<TR><TD><B>No. of Mayors:</B></TD><TD>".$nummayormem."</TD></TR>";
	}		
?>   
<?PHP 
	if($numvicemayormem > 0) {
		echo "<TR><TD><B>No. of Vice Mayors:</B></TD><TD>".$numvicemayormem."</TD></TR>";
	}		
?>   
<?PHP 
	if($numcouncilormem > 0) {
		echo "<TR><TD><B>No. of Councilors:</B></TD><TD>".$numcouncilormem."</TD></TR>";
	}		
?>  
</TABLE>
<H2 CLASS="HIGHLIGHTS">Members of the Coalition Vying for Government Positions</H2>
<?PHP if ($numcandpresidentmem > 0) { ?>
	<B>For President</B><BR>
<?PHP } ?>	
<OL>
	<?PHP while($candpresidentrow = mysql_fetch_array($candpresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$candpresidentrow['president_id']; ?>>
				<?PHP echo $candpresidentrow['firstname']; ?>	
				<?PHP if(!empty($candpresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candpresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candpresidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
</OL>
<?PHP if ($numcandvicepresidentmem > 0) { ?>	
	<B>For Vice President</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candvicepresidentrow = mysql_fetch_array($candvicepresidentmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$candvicepresidentrow['vicepresident_id']; ?>>
				<?PHP echo $candvicepresidentrow['firstname']; ?>	
				<?PHP if(!empty($candvicepresidentrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicepresidentrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candvicepresidentrow['lastname']; ?>
			</A>	
	<?PHP } ?>
</OL>	
<?PHP if ($numcandsenatormem > 0) { ?>
	<B>For Senators</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candsenatorrow = mysql_fetch_array($candsenatormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorrow['senator_id']; ?>>
				<?PHP echo $candsenatorrow['firstname']; ?>	
				<?PHP if(!empty($candsenatorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candsenatorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candsenatorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($candsenatormem);
	?>	
</OL>	
<?PHP if ($numcandrepresentativemem > 0) { ?>
	<B>For House Representatives</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candrepresentativerow = mysql_fetch_array($candrepresentativemem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativerow['representative_id']; ?>>
				<?PHP echo $candrepresentativerow['firstname']; ?>	
				<?PHP if(!empty($candrepresentativerow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candrepresentativerow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candrepresentativerow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($candrepresentativemem);
	?>	
</OL>
<?PHP if ($numcandgovernormem > 0) { ?>	
	<B>For Governor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candgovernorrow = mysql_fetch_array($candgovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorrow['governor_id']; ?>>
				<?PHP echo $candgovernorrow['firstname']; ?>	
				<?PHP if(!empty($candgovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candgovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candgovernorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($candgovernormem);
	?>		
</OL>	
<?PHP if ($numcandvicegovernormem > 0) { ?>
	<B>For Vice Governor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candvicegovernorrow = mysql_fetch_array($candvicegovernormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorrow['vicegovernor_id']; ?>>
				<?PHP echo $candvicegovernorrow['firstname']; ?>	
				<?PHP if(!empty($candvicegovernorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicegovernorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candvicegovernorrow['lastname']; ?>
			</A>	
	<?PHP } 
		mysql_free_result($candvicegovernormem);
	?>			
</OL>	
<?PHP if ($numcandboardmemmem > 0) { ?>
	<B>For Provincial Board Members</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candprovboardmemberrow = mysql_fetch_array($candboardmemmem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candboardmemdet.php?candprovboardmemid=".$candprovboardmemberrow['provboardmember_id']; ?>>
				<?PHP echo $candprovboardmemberrow['firstname']; ?>	
				<?PHP if(!empty($candprovboardmemberrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candprovboardmemberrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candprovboardmemberrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($candboardmemmem);
	?>			
</OL>	
<?PHP if ($numcandmayormem > 0) { ?>
	<B>For Mayor</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candmayorrow = mysql_fetch_array($candmayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorrow['mayor_id']; ?>>
				<?PHP echo $candmayorrow['firstname']; ?>	
				<?PHP if(!empty($candmayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candmayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candmayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($candmayormem);
	?>				
</OL>	
<?PHP if ($numcandvicemayormem > 0) { ?>
	<B>For Vice Mayor</B><BR>
<?PHP } ?>	
<OL>
	<?PHP while($candvicemayorrow = mysql_fetch_array($candvicemayormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candvicemayorsdet.php?candvicemayorid=".$candvicemayorrow['vicemayor_id']; ?>>
				<?PHP echo $candvicemayorrow['firstname']; ?>	
				<?PHP if(!empty($candvicemayorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candvicemayorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candvicemayorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($candvicemayormem);
	?>							
</OL>	
<?PHP if ($numcandcouncilormem > 0) { ?>
	<B>For Councilors</B><BR>
<?PHP } ?>
<OL>
	<?PHP while($candcouncilorrow = mysql_fetch_array($candcouncilormem)) { ?>
		<LI><A HREF=<?PHP echo "/vote/candcouncilorsdet.php?candcouncilorid=".$candcouncilorrow['councilor_id']; ?>>
				<?PHP echo $candcouncilorrow['firstname']; ?>	
				<?PHP if(!empty($candcouncilorrow['middleinitial'])) { ?>
      				&nbsp;<?PHP echo $candcouncilorrow['middleinitial'].". "; ?>
				<?PHP } ?>
				<?PHP echo $candcouncilorrow['lastname']; ?>
			</A>
	<?PHP } 
		mysql_free_result($candcouncilormem);
	?>	
</OL>	
<!-- End of 1st Column --->	
	</TD>
	<TD WIDTH="1%">
<!-- Start of 2nd Column to act as spacer between 1st and 3rd column --->	
&nbsp;
<!-- End of 2nd Column to act as spacer between 1st and 3rd column --->		
	</TD>
	<TD VALIGN="TOP" WIDTH="1%">
<!-- Start of 3rd Column --->
&nbsp;
<!-- End of 3rd Column --->	
	</TD>
</TR>
</TABLE>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

