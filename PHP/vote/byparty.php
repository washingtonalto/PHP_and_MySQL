<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	

$query = "SELECT coalitions.coalition_id, coalitions.acronym, coalitions.name as coalitionname
          FROM coalitions
		  ORDER BY coalitions.name";
$coalitions = getqueryresults($query);
		  
$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname,party.yearfounded As yearfounded
  FROM party,party_type
  WHERE party.is_national = 'Y' AND party.partytype_id = party_type.partytype_id AND party_type.type = 'political'
  ORDER BY party.acronym,party.partyname";
$natpolparties = getqueryresults($query);

$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname,party.yearfounded As yearfounded,party.province_id As province_id,provinces.name As province
  FROM party,party_type,provinces
  WHERE (party.is_national = 'N') AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (party.province_id = provinces.province_id)
  ORDER BY party.acronym,party.partyname";
$provpolparties = getqueryresults($query);
$numprovpolparties = mysql_num_rows($provpolparties);

$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname,party.yearfounded As yearfounded,party.municity_id As municity_id,municity.name As municity
  FROM party,party_type,municity
  WHERE (party.is_national = 'N') AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (party.municity_id = municity.municity_id)
  ORDER BY party.acronym,party.partyname";
$munipolparties = getqueryresults($query);
$nummunipolparties = mysql_num_rows($munipolparties);

$query = "SELECT  party.party_id As polparty_id, party.acronym As acronym, party.name As partyname,party.yearfounded As yearfounded,party.ncrmunicity_id As municity_id,nationalcapitalregion.name As municity
  FROM party,party_type,nationalcapitalregion
  WHERE (party.is_national = 'N') AND (party.partytype_id = party_type.partytype_id) AND (party_type.type = 'political') AND (party.ncrmunicity_id = nationalcapitalregion.municity_id)
  ORDER BY party.acronym,party.partyname";
$ncrpolparties = getqueryresults($query);  
$numncrpolparties = mysql_num_rows($ncrpolparties);
  
$query = "SELECT  party.party_id, party.acronym, party.name As partyname, party.yearregistered
  FROM party,candpartylist
  WHERE party.party_id = candpartylist.party_id AND party.acronym IS NOT NULL
  ORDER BY party.acronym,party.partyname";
$partylists = getqueryresults($query);  
$numpartylists = mysql_num_rows($partylists);  
  
?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Browse By Party</TITLE>
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
<B>By Party</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>BROWSE BY PARTY</B></DIV>
<BR>

<H2 CLASS="HIGHLIGHTS">Coalitions</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD>
</TR>
<?PHP
$ctr = 0;
$coalitionsrow = mysql_fetch_array($coalitions);
while ($coalitionsrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/coalitiondet.php?coalitionid=".$coalitionsrow['coalition_id']; ?>>
				<?PHP if(!empty($coalitionsrow['acronym'])) { ?>
					<?PHP echo $coalitionsrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $coalitionsrow['coalitionname']; ?></TD>	
			<?PHP $coalitionsrow = mysql_fetch_array($coalitions); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($coalitions); ?>	

<H2 CLASS="HIGHLIGHTS">National Political Parties</H2>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD><TD><B>Year Founded</B></TD>
</TR>
<?PHP
$ctr = 0;
$natpolpartiesrow = mysql_fetch_array($natpolparties);
while ($natpolpartiesrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$natpolpartiesrow['polparty_id']; ?>>
				<?PHP if(!empty($natpolpartiesrow['acronym'])) { ?>
					<?PHP echo $natpolpartiesrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $natpolpartiesrow['partyname']; ?></TD>	
			<TD>
				<?PHP if(!empty($natpolpartiesrow['yearfounded'])) { ?>				
					<?PHP	echo $natpolpartiesrow['yearfounded']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
			</TD>
			<?PHP $natpolpartiesrow = mysql_fetch_array($natpolparties); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($natpolparties); ?>	
<?PHP if ($numprovpolparties > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Political Parties</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numprovpolparties > 0) { ?>
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD><TD><B>Year Founded</B></TD><TD><B>Province</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$provpolpartiesrow = mysql_fetch_array($provpolparties);
while ($provpolpartiesrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$provpolpartiesrow['polparty_id']; ?>>
				<?PHP if(!empty($provpolpartiesrow['acronym'])) { ?>
					<?PHP echo $provpolpartiesrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $provpolpartiesrow['partyname']; ?></TD>	
			<TD>
				<?PHP if(!empty($provpolpartiesrow['yearfounded'])) { ?>				
					<?PHP	echo $provpolpartiesrow['yearfounded']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
			</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provpolpartiesrow['province_id']; ?>><?PHP echo $provpolpartiesrow['province']; ?></A>
			</TD>
			<?PHP $provpolpartiesrow = mysql_fetch_array($provpolparties); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($provpolparties); ?>	

<?PHP if ($numncrpolparties > 0) { ?>
<H2 CLASS="HIGHLIGHTS">NCR Political Parties</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numncrpolparties > 0) { ?>
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD><TD><B>Year Founded</B></TD><TD><B>City/Municipality</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$ncrpolpartiesrow = mysql_fetch_array($ncrpolparties);
while ($ncrpolpartiesrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$ncrpolpartiesrow['polparty_id']; ?>>
				<?PHP if(!empty($ncrpolpartiesrow['acronym'])) { ?>
					<?PHP echo $ncrpolpartiesrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $ncrpolpartiesrow['partyname']; ?></TD>	
			<TD>
				<?PHP if(!empty($ncrpolpartiesrow['yearfounded'])) { ?>				
					<?PHP	echo $ncrpolpartiesrow['yearfounded']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
			</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$ncrpolpartiesrow['municity_id']; ?>><?PHP echo $ncrpolpartiesrow['municity']; ?></A>
			</TD>
			<?PHP $ncrpolpartiesrow = mysql_fetch_array($ncrpolparties); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($ncrpolparties); ?>	

<?PHP if ($nummunipolparties > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Provincial Municpality/City Political Parties</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($nummunipolparties > 0) { ?>
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD><TD><B>Year Founded</B></TD><TD><B>City/Municipality</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$munipolpartiesrow = mysql_fetch_array($munipolparties);
while ($munipolpartiesrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$munipolpartiesrow['polparty_id']; ?>>
				<?PHP if(!empty($munipolpartiesrow['acronym'])) { ?>
					<?PHP echo $munipolpartiesrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $munipolpartiesrow['partyname']; ?></TD>	
			<TD>
				<?PHP if(!empty($munipolpartiesrow['yearfounded'])) { ?>				
					<?PHP	echo $munipolpartiesrow['yearfounded']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
			</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/municitydet.php?municityid=".$munipolpartiesrow['municity_id']; ?>><?PHP echo $munipolpartiesrow['municity']; ?></A>
			</TD>
			<?PHP $munipolpartiesrow = mysql_fetch_array($munipolparties); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($munipolparties); ?>	

<?PHP if ($numpartylists > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Registered Party-List for the May 14, 2001 Election</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numpartylists > 0) { ?>
<TR>
<TD><B>#</B></TD><TD><B>Acronym</B></TD><TD><B>Full Name</B></TD><TD><B>Year Registered</B></TD>
</TR>
<?PHP } ?>
<?PHP
$ctr = 0;
$partylistsrow = mysql_fetch_array($partylists);
while ($partylistsrow) {
?>
	<?PHP $ctr++; ?>
	<?PHP if ($ctr % 2 == 0) { ?>
		<TR BGCOLOR="#C5E0FE">
	<?PHP } else { ?>
		<TR>
	<?PHP } ?>	
			<TD><?PHP echo $ctr; ?>&nbsp;&nbsp;</TD>
			<TD>
				<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$partylistsrow['party_id']; ?>>
				<?PHP if(!empty($partylistsrow['acronym'])) { ?>
					<?PHP echo $partylistsrow['acronym']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
				</A>
			</TD>	
			<TD><?PHP	echo $partylistsrow['partyname']; ?></TD>	
			<TD>
				<?PHP if(!empty($partylistsrow['yearregistered'])) { ?>				
					<?PHP	echo $partylistsrow['yearregistered']; ?>
				<?PHP } else { ?>
					&nbsp;
				<?PHP } ?>		
			</TD>
			<?PHP $partylistsrow = mysql_fetch_array($partylists); ?>
	</TR>
<?PHP 
} 
?>
</TABLE>
<?PHP mysql_free_result($partylists); ?>	
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
