<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP
	//President
	$query = "SELECT presidents.president_id,presidents.lastname, presidents.firstname, presidents.middleinitial, links.title As urltitle, links.url 
      FROM presidents, links
      WHERE presidents.president_id = links.president_id
	  ORDER BY presidents.lastname";
	$presidents =  getqueryresults($query);
	$numpresidents = mysql_num_rows($presidents);

	//Vice-President
	$query = "SELECT vicepresidents.vicepresident_id,vicepresidents.lastname, vicepresidents.firstname, vicepresidents.middleinitial, links.title As urltitle, links.url 
      FROM vicepresidents, links
      WHERE vicepresidents.vicepresident_id = links.vicepresident_id
	  ORDER BY vicepresidents.lastname";
	$vicepresidents =  getqueryresults($query);
	$numvicepresidents = mysql_num_rows($vicepresidents);

	//Senator
	$query = "SELECT senators.senator_id,senators.lastname, senators.firstname, senators.middleinitial, links.title As urltitle, links.url 
      FROM senators, links
      WHERE senators.senator_id = links.senator_id
	  ORDER BY senators.lastname";
	$senators =  getqueryresults($query);
	$numsenators = mysql_num_rows($senators);

	//Representatives
	$query = "SELECT representatives.representative_id,representatives.lastname, representatives.firstname, representatives.middleinitial, links.title As urltitle, links.url 
      FROM representatives, links
      WHERE representatives.representative_id = links.representative_id
	  ORDER BY representatives.lastname";
	$representatives =  getqueryresults($query);
	$numrepresentatives = mysql_num_rows($representatives);

	//Governor
	$query = "SELECT governors.governor_id,governors.lastname, governors.firstname, governors.middleinitial, links.title As urltitle, links.url 
      FROM governors, links
      WHERE governors.governor_id = links.governor_id
	  ORDER BY governors.lastname";
	$governors =  getqueryresults($query);
	$numgovernors = mysql_num_rows($governors);
	
	//Vice Governor
	$query = "SELECT vicegovernors.vicegovernor_id,vicegovernors.lastname, vicegovernors.firstname, vicegovernors.middleinitial, links.title As urltitle, links.url 
      FROM vicegovernors, links
      WHERE vicegovernors.vicegovernor_id = links.vicegovernor_id
	  ORDER BY vicegovernors.lastname";
	$vicegovernors =  getqueryresults($query);
	$numvicegovernors = mysql_num_rows($vicegovernors);

	//Provincial Board Members
	$query = "SELECT provboardmembers.provboardmember_id,provboardmembers.lastname, provboardmembers.firstname, provboardmembers.middleinitial, links.title As urltitle, links.url 
      FROM provboardmembers, links
      WHERE provboardmembers.provboardmember_id = links.provboardmember_id
	  ORDER BY provboardmembers.lastname";
	$provboardmembers =  getqueryresults($query);
	$numprovboardmembers = mysql_num_rows($provboardmembers);

	//Mayor
	$query = "SELECT mayors.mayor_id,mayors.lastname, mayors.firstname, mayors.middleinitial, links.title As urltitle, links.url 
      FROM mayors, links
      WHERE mayors.mayor_id = links.mayor_id
	  ORDER BY mayors.lastname";
	$mayors =  getqueryresults($query);
	$nummayors = mysql_num_rows($mayors);

	//Vice Mayor
	$query = "SELECT vicemayors.vicemayor_id,vicemayors.lastname, vicemayors.firstname, vicemayors.middleinitial, links.title As urltitle, links.url 
      FROM vicemayors, links
      WHERE vicemayors.vicemayor_id = links.vicemayor_id
	  ORDER BY vicemayors.lastname";
	$vicemayors =  getqueryresults($query);
	$numvicemayors = mysql_num_rows($vicemayors);

	//Councilor	
	$query = "SELECT councilors.councilor_id,councilors.lastname, councilors.firstname, councilors.middleinitial, links.title As urltitle, links.url 
      FROM councilors, links
      WHERE councilors.councilor_id = links.councilor_id
	  ORDER BY councilors.lastname";
	$councilors =  getqueryresults($query);
	$numcouncilors = mysql_num_rows($councilors);

	//Presidential Candidates
	$query = "SELECT candpresidents.president_id,candpresidents.lastname, candpresidents.firstname, candpresidents.middleinitial, links.title As urltitle, links.url 
      FROM candpresidents, links
      WHERE candpresidents.president_id = links.candpresident_id
	  ORDER BY candpresidents.lastname";
	$candpresidents =  getqueryresults($query);
	$numcandpresidents = mysql_num_rows($candpresidents);

	//Vice Presidential Candidates
	$query = "SELECT candvicepresidents.vicepresident_id,candvicepresidents.lastname, candvicepresidents.firstname, candvicepresidents.middleinitial, links.title As urltitle, links.url 
      FROM candvicepresidents, links
      WHERE candvicepresidents.vicepresident_id = links.candvicepresident_id
	  ORDER BY candvicepresidents.lastname";
	$candvicepresidents =  getqueryresults($query);
	$numcandvicepresidents = mysql_num_rows($candvicepresidents);	

	//Senatorial Candidates
	$query = "SELECT candsenators.senator_id,candsenators.lastname, candsenators.firstname, candsenators.middleinitial, links.title As urltitle, links.url 
      FROM candsenators, links
      WHERE candsenators.senator_id = links.candsenator_id
	  ORDER BY candsenators.lastname";
	$candsenators =  getqueryresults($query);
	$numcandsenators = mysql_num_rows($candsenators);

	//Candidate of House Representatives	
	$query = "SELECT candrepresentatives.representative_id,candrepresentatives.lastname, candrepresentatives.firstname, candrepresentatives.middleinitial, links.title As urltitle, links.url 
      FROM candrepresentatives, links
      WHERE candrepresentatives.representative_id = links.candrepresentative_id
	  ORDER BY candrepresentatives.lastname";
	$candrepresentatives =  getqueryresults($query);
	$numcandrepresentatives = mysql_num_rows($candrepresentatives);

	//Candidate for Governor	
	$query = "SELECT candgovernors.governor_id,candgovernors.lastname, candgovernors.firstname, candgovernors.middleinitial, links.title As urltitle, links.url 
      FROM candgovernors, links
      WHERE candgovernors.governor_id = links.candgovernor_id
	  ORDER BY candgovernors.lastname";
	$candgovernors =  getqueryresults($query);
	$numcandgovernors = mysql_num_rows($candgovernors);

	//Candidate for Vice Governor	
	$query = "SELECT candvicegovernors.vicegovernor_id,candvicegovernors.lastname, candvicegovernors.firstname, candvicegovernors.middleinitial, links.title As urltitle, links.url 
      FROM candvicegovernors, links
      WHERE candvicegovernors.vicegovernor_id = links.candvicegovernor_id
	  ORDER BY candvicegovernors.lastname";
	$candvicegovernors =  getqueryresults($query);
	$numcandvicegovernors = mysql_num_rows($candvicegovernors);	

	//Candidate for Provincial Board Members	
	$query = "SELECT candboardmem.provboardmember_id,candboardmem.lastname, candboardmem.firstname, candboardmem.middleinitial, links.title As urltitle, links.url 
      FROM candboardmem, links
      WHERE candboardmem.provboardmember_id = links.candboardmem_id
	  ORDER BY candboardmem.lastname";
	$candboardmem =  getqueryresults($query);
	$numcandboardmem = mysql_num_rows($candboardmem);

	//Candidate for Mayor	
	$query = "SELECT candmayors.mayor_id,candmayors.lastname, candmayors.firstname, candmayors.middleinitial, links.title As urltitle, links.url 
      FROM candmayors, links
      WHERE candmayors.mayor_id = links.candmayor_id
	  ORDER BY candmayors.lastname";
	$candmayors =  getqueryresults($query);
	$numcandmayors = mysql_num_rows($candmayors);	

	//Candidate for Vice Mayor	
	$query = "SELECT candvicemayors.vicemayor_id,candvicemayors.lastname, candvicemayors.firstname, candvicemayors.middleinitial, links.title As urltitle, links.url 
      FROM candvicemayors, links
      WHERE candvicemayors.vicemayor_id = links.candvicemayor_id
	  ORDER BY candvicemayors.lastname";
	$candvicemayors =  getqueryresults($query);
	$numcandvicemayors = mysql_num_rows($candvicemayors);	

	//Candidate for Councilor	
	$query = "SELECT candcouncilors.councilor_id,candcouncilors.lastname, candcouncilors.firstname, candcouncilors.middleinitial, links.title As urltitle, links.url 
      FROM candcouncilors, links
      WHERE candcouncilors.councilor_id = links.candcouncilor_id
	  ORDER BY candcouncilors.lastname";
	$candcouncilors =  getqueryresults($query);
	$numcandcouncilors = mysql_num_rows($candcouncilors);	
	
    //Party
	$query = "SELECT party.party_id, party.name, party.acronym, links.title As urltitle, links.url 
      FROM party, links
      WHERE party.party_id = links.party_id
	  ORDER BY party.name";
	$party =  getqueryresults($query);
	$numparty = mysql_num_rows($party);
	
?>	
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Links</TITLE>
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
<B>Links</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>LINKS</B></DIV>
<BR>
<BR>
<!-- President -->
<?PHP if ($numpresidents > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">President</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numpresidents > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $presidentrow = mysql_fetch_array($presidents); ?>
<?PHP while ($presidentrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/presidentsdet.php?presidentid=".$presidentrow['president_id']; ?>>
			<?PHP echo $presidentrow['lastname']; ?>,&nbsp;
			<?PHP echo $presidentrow['firstname']; ?>
			<?PHP if (!empty($presidentrow['middleinitial'])) { ?>
				<?PHP echo $presidentrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $presidentid = $presidentrow['president_id']; ?>
				<?PHP while ($presidentid == $presidentrow['president_id']) { ?>
					<A HREF=<?PHP echo $presidentrow['url']; ?>><?PHP echo $presidentrow['urltitle']; ?></A><BR>
					<?PHP  $presidentrow = mysql_fetch_array($presidents); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Vice President -->
<?PHP if ($numvicepresidents > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Vice President</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numvicepresidents > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $vicepresidentrow = mysql_fetch_array($vicepresidents); ?>
<?PHP while ($vicepresidentrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/vicepresidentsdet.php?vicepresidentid=".$vicepresidentrow['vicepresident_id']; ?>>
			<?PHP echo $vicepresidentrow['lastname']; ?>,&nbsp;
			<?PHP echo $vicepresidentrow['firstname']; ?>
			<?PHP if (!empty($vicepresidentrow['middleinitial'])) { ?>
				<?PHP echo $vicepresidentrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $vicepresidentid = $vicepresidentrow['vicepresident_id']; ?>
				<?PHP while ($vicepresidentid == $vicepresidentrow['vicepresident_id']) { ?>
					<A HREF=<?PHP echo $vicepresidentrow['url']; ?>><?PHP echo $vicepresidentrow['urltitle']; ?></A><BR>
					<?PHP  $vicepresidentrow = mysql_fetch_array($vicepresidents); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Senator -->
<?PHP if ($numsenators > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Senators</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numsenators > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $senatorrow = mysql_fetch_array($senators); ?>
<?PHP while ($senatorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/senatorsdet.php?senatorid=".$senatorrow['senator_id']; ?>>
			<?PHP echo $senatorrow['lastname']; ?>,&nbsp;
			<?PHP echo $senatorrow['firstname']; ?>
			<?PHP if (!empty($senatorrow['middleinitial'])) { ?>
				<?PHP echo $senatorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $senatorid = $senatorrow['senator_id']; ?>
				<?PHP while ($senatorid == $senatorrow['senator_id']) { ?>
					<A HREF=<?PHP echo $senatorrow['url']; ?>><?PHP echo $senatorrow['urltitle']; ?></A><BR>
					<?PHP  $senatorrow = mysql_fetch_array($senators); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- House Representatives -->
<?PHP if ($numrepresentatives > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">House Representatives</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numrepresentatives > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $representativerow = mysql_fetch_array($representatives); ?>
<?PHP while ($representativerow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/representativesdet.php?representativeid=".$representativerow['representative_id']; ?>>
			<?PHP echo $representativerow['lastname']; ?>,&nbsp;
			<?PHP echo $representativerow['firstname']; ?>
			<?PHP if (!empty($representativerow['middleinitial'])) { ?>
				<?PHP echo $representativerow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $representativeid = $representativerow['representative_id']; ?>
				<?PHP while ($representativeid == $representativerow['representative_id']) { ?>
					<A HREF=<?PHP echo $representativerow['url']; ?>><?PHP echo $representativerow['urltitle']; ?></A><BR>
					<?PHP  $representativerow = mysql_fetch_array($representatives); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Governor -->
<?PHP if ($numgovernors > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numgovernors > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $governorrow = mysql_fetch_array($governors); ?>
<?PHP while ($governorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/governorsdet.php?governorid=".$governorrow['governor_id']; ?>>
			<?PHP echo $governorrow['lastname']; ?>,&nbsp;
			<?PHP echo $governorrow['firstname']; ?>
			<?PHP if (!empty($governorrow['middleinitial'])) { ?>
				<?PHP echo $governorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $governorid = $governorrow['governor_id']; ?>
				<?PHP while ($governorid == $governorrow['governor_id']) { ?>
					<A HREF=<?PHP echo $governorrow['url']; ?>><?PHP echo $governorrow['urltitle']; ?></A><BR>
					<?PHP  $governorrow = mysql_fetch_array($governors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Vice Governor -->
<?PHP if ($numvicegovernors > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Vice Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numvicegovernors > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $vicegovernorrow = mysql_fetch_array($vicegovernors); ?>
<?PHP while ($vicegovernorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/vicegovernorsdet.php?vicegovernorid=".$vicegovernorrow['vicegovernor_id']; ?>>
			<?PHP echo $vicegovernorrow['lastname']; ?>,&nbsp;
			<?PHP echo $vicegovernorrow['firstname']; ?>
			<?PHP if (!empty($vicegovernorrow['middleinitial'])) { ?>
				<?PHP echo $vicegovernorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $vicegovernorid = $vicegovernorrow['vicegovernor_id']; ?>
				<?PHP while ($vicegovernorid == $vicegovernorrow['vicegovernor_id']) { ?>
					<A HREF=<?PHP echo $vicegovernorrow['url']; ?>><?PHP echo $vicegovernorrow['urltitle']; ?></A><BR>
					<?PHP  $vicegovernorrow = mysql_fetch_array($vicegovernors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Provincial Board Members -->
<?PHP if ($numprovboardmembers > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Provincial Board Members</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numprovboardmembers > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $provboardmemberrow = mysql_fetch_array($provboardmembers); ?>
<?PHP while ($provboardmemberrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/provboardmembersdet.php?provboardmemberid=".$provboardmemberrow['provboardmember_id']; ?>>
			<?PHP echo $provboardmemberrow['lastname']; ?>,&nbsp;
			<?PHP echo $provboardmemberrow['firstname']; ?>
			<?PHP if (!empty($provboardmemberrow['middleinitial'])) { ?>
				<?PHP echo $provboardmemberrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $provboardmemberid = $provboardmemberrow['provboardmember_id']; ?>
				<?PHP while ($provboardmemberid == $provboardmemberrow['provboardmember_id']) { ?>
					<A HREF=<?PHP echo $provboardmemberrow['url']; ?>><?PHP echo $provboardmemberrow['urltitle']; ?></A><BR>
					<?PHP  $provboardmemberrow = mysql_fetch_array($provboardmembers); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Mayors -->
<?PHP if ($nummayors > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Mayors</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($nummayors > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $mayorrow = mysql_fetch_array($mayors); ?>
<?PHP while ($mayorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/mayorsdet.php?mayorid=".$mayorrow['mayor_id']; ?>>
			<?PHP echo $mayorrow['lastname']; ?>,&nbsp;
			<?PHP echo $mayorrow['firstname']; ?>
			<?PHP if (!empty($mayorrow['middleinitial'])) { ?>
				<?PHP echo $mayorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $mayorid = $mayorrow['mayor_id']; ?>
				<?PHP while ($mayorid == $mayorrow['mayor_id']) { ?>
					<A HREF=<?PHP echo $mayorrow['url']; ?>><?PHP echo $mayorrow['urltitle']; ?></A><BR>
					<?PHP  $mayorrow = mysql_fetch_array($mayors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Vice Mayors -->
<?PHP if ($numvicemayors > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Vice Mayors</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numvicemayors > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $vicemayorrow = mysql_fetch_array($vicemayors); ?>
<?PHP while ($vicemayorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/vicemayorsdet.php?vicemayorid=".$vicemayorrow['vicemayor_id']; ?>>
			<?PHP echo $vicemayorrow['lastname']; ?>,&nbsp;
			<?PHP echo $vicemayorrow['firstname']; ?>
			<?PHP if (!empty($vicemayorrow['middleinitial'])) { ?>
				<?PHP echo $vicemayorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $vicemayorid = $vicemayorrow['vicemayor_id']; ?>
				<?PHP while ($vicemayorid == $vicemayorrow['vicemayor_id']) { ?>
					<A HREF=<?PHP echo $vicemayorrow['url']; ?>><?PHP echo $vicemayorrow['urltitle']; ?></A><BR>
					<?PHP  $vicemayorrow = mysql_fetch_array($vicemayors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Councilor -->
<?PHP if ($numcouncilors > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Councilor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcouncilors > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $councilorrow = mysql_fetch_array($councilors); ?>
<?PHP while ($councilorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/councilorsdet.php?councilorid=".$councilorrow['councilor_id']; ?>>
			<?PHP echo $councilorrow['lastname']; ?>,&nbsp;
			<?PHP echo $councilorrow['firstname']; ?>
			<?PHP if (!empty($councilorrow['middleinitial'])) { ?>
				<?PHP echo $councilorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $councilorid = $councilorrow['councilor_id']; ?>
				<?PHP while ($councilorid == $councilorrow['councilor_id']) { ?>
					<A HREF=<?PHP echo $councilorrow['url']; ?>><?PHP echo $councilorrow['urltitle']; ?></A><BR>
					<?PHP  $councilorrow = mysql_fetch_array($councilors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Presidential Candidates -->
<?PHP if ($numcandpresidents > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Presidential Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandpresidents > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candpresidentrow = mysql_fetch_array($candpresidents); ?>
<?PHP while ($candpresidentrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candpresidentsdet.php?candpresidentid=".$candpresidentrow['president_id']; ?>>
			<?PHP echo $candpresidentrow['lastname']; ?>,&nbsp;
			<?PHP echo $candpresidentrow['firstname']; ?>
			<?PHP if (!empty($candpresidentrow['middleinitial'])) { ?>
				<?PHP echo $candpresidentrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candpresidentid = $candpresidentrow['president_id']; ?>
				<?PHP while ($candpresidentid == $candpresidentrow['president_id']) { ?>
					<A HREF=<?PHP echo $candpresidentrow['url']; ?>><?PHP echo $candpresidentrow['urltitle']; ?></A><BR>
					<?PHP  $candpresidentrow = mysql_fetch_array($candpresidents); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Vice Presidential Candidates -->
<?PHP if ($numcandvicepresidents > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Candidates for Vice-President</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandvicepresidents > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candvicepresidentrow = mysql_fetch_array($candvicepresidents); ?>
<?PHP while ($candvicepresidentrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candvicepresidentsdet.php?candvicepresidentid=".$candvicepresidentrow['vicepresident_id']; ?>>
			<?PHP echo $candvicepresidentrow['lastname']; ?>,&nbsp;
			<?PHP echo $candvicepresidentrow['firstname']; ?>
			<?PHP if (!empty($candvicepresidentrow['middleinitial'])) { ?>
				<?PHP echo $candvicepresidentrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candvicepresidentid = $candvicepresidentrow['vicepresident_id']; ?>
				<?PHP while ($candvicepresidentid == $candvicepresidentrow['vicepresident_id']) { ?>
					<A HREF=<?PHP echo $candvicepresidentrow['url']; ?>><?PHP echo $candvicepresidentrow['urltitle']; ?></A><BR>
					<?PHP  $candvicepresidentrow = mysql_fetch_array($candvicepresidents); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Senatorial Candidates -->
<?PHP if ($numcandsenators > 0) { ?>	
<H2 CLASS="HIGHLIGHTS">Senatorial Candidates</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandsenators > 0) { ?>	
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candsenatorrow = mysql_fetch_array($candsenators); ?>
<?PHP while ($candsenatorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candsenatorsdet.php?candsenatorid=".$candsenatorrow['senator_id']; ?>>
			<?PHP echo $candsenatorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candsenatorrow['firstname']; ?>
			<?PHP if (!empty($candsenatorrow['middleinitial'])) { ?>
				<?PHP echo $candsenatorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candsenatorid = $candsenatorrow['senator_id']; ?>
				<?PHP while ($candsenatorid == $candsenatorrow['senator_id']) { ?>
					<A HREF=<?PHP echo $candsenatorrow['url']; ?>><?PHP echo $candsenatorrow['urltitle']; ?></A><BR>
					<?PHP  $candsenatorrow = mysql_fetch_array($candsenators); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for House of Representatives -->
<?PHP if ($numcandrepresentatives > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for House Representatives</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandrepresentatives > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candrepresentativerow = mysql_fetch_array($candrepresentatives); ?>
<?PHP while ($candrepresentativerow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candrepresentativedet.php?candrepresentativeid=".$candrepresentativerow['representative_id']; ?>>
			<?PHP echo $candrepresentativerow['lastname']; ?>,&nbsp;
			<?PHP echo $candrepresentativerow['firstname']; ?>
			<?PHP if (!empty($candrepresentativerow['middleinitial'])) { ?>
				<?PHP echo $candrepresentativerow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candrepresentativeid = $candrepresentativerow['representative_id']; ?>
				<?PHP while ($candrepresentativeid == $candrepresentativerow['representative_id']) { ?>
					<A HREF=<?PHP echo $candrepresentativerow['url']; ?>><?PHP echo $candrepresentativerow['urltitle']; ?></A><BR>
					<?PHP  $candrepresentativerow = mysql_fetch_array($candrepresentatives); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Governor -->
<?PHP if ($numcandgovernors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandgovernors > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candgovernorrow = mysql_fetch_array($candgovernors); ?>
<?PHP while ($candgovernorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candgovernorsdet.php?candgovernorid=".$candgovernorrow['governor_id']; ?>>
			<?PHP echo $candgovernorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candgovernorrow['firstname']; ?>
			<?PHP if (!empty($candgovernorrow['middleinitial'])) { ?>
				<?PHP echo $candgovernorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candgovernorid = $candgovernorrow['governor_id']; ?>
				<?PHP while ($candgovernorid == $candgovernorrow['governor_id']) { ?>
					<A HREF=<?PHP echo $candgovernorrow['url']; ?>><?PHP echo $candgovernorrow['urltitle']; ?></A><BR>
					<?PHP  $candgovernorrow = mysql_fetch_array($candgovernors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Vice Governor -->
<?PHP if ($numcandvicegovernors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Vice Governor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandvicegovernors > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candvicegovernorrow = mysql_fetch_array($candvicegovernors); ?>
<?PHP while ($candvicegovernorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candvicegovernorsdet.php?candvicegovernorid=".$candvicegovernorrow['vicegovernor_id']; ?>>
			<?PHP echo $candvicegovernorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candvicegovernorrow['firstname']; ?>
			<?PHP if (!empty($candvicegovernorrow['middleinitial'])) { ?>
				<?PHP echo $candvicegovernorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candvicegovernorid = $candvicegovernorrow['vicegovernor_id']; ?>
				<?PHP while ($candvicegovernorid == $candvicegovernorrow['vicegovernor_id']) { ?>
					<A HREF=<?PHP echo $candvicegovernorrow['url']; ?>><?PHP echo $candvicegovernorrow['urltitle']; ?></A><BR>
					<?PHP  $candvicegovernorrow = mysql_fetch_array($candvicegovernors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Provincial Board Members -->
<?PHP if ($numcandboardmem > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Provincial Board Members</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandboardmem > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candboardmemrow = mysql_fetch_array($candboardmem); ?>
<?PHP while ($candboardmemrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candboardmemdet.php?candboardmemid=".$candboardmemrow['boardmem_id']; ?>>
			<?PHP echo $candboardmemrow['lastname']; ?>,&nbsp;
			<?PHP echo $candboardmemrow['firstname']; ?>
			<?PHP if (!empty($candboardmemrow['middleinitial'])) { ?>
				<?PHP echo $candboardmemrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candboardmemid = $candboardmemrow['boardmem_id']; ?>
				<?PHP while ($candboardmemid == $candboardmemrow['boardmem_id']) { ?>
					<A HREF=<?PHP echo $candboardmemrow['url']; ?>><?PHP echo $candboardmemrow['urltitle']; ?></A><BR>
					<?PHP  $candboardmemrow = mysql_fetch_array($candboardmem); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Mayor -->
<?PHP if ($numcandmayors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Mayor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandmayors > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candmayorrow = mysql_fetch_array($candmayors); ?>
<?PHP while ($candmayorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candmayorsdet.php?candmayorid=".$candmayorrow['mayor_id']; ?>>
			<?PHP echo $candmayorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candmayorrow['firstname']; ?>
			<?PHP if (!empty($candmayorrow['middleinitial'])) { ?>
				<?PHP echo $candmayorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candmayorid = $candmayorrow['mayor_id']; ?>
				<?PHP while ($candmayorid == $candmayorrow['mayor_id']) { ?>
					<A HREF=<?PHP echo $candmayorrow['url']; ?>><?PHP echo $candmayorrow['urltitle']; ?></A><BR>
					<?PHP  $candmayorrow = mysql_fetch_array($candmayors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Vice Mayor -->
<?PHP if ($numcandvicemayors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Vice Mayor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandvicemayors > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candvicemayorrow = mysql_fetch_array($candvicemayors); ?>
<?PHP while ($candvicemayorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candvicemayordet.php?candvicemayorid=".$candvicemayorrow['vicemayor_id']; ?>>
			<?PHP echo $candvicemayorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candvicemayorrow['firstname']; ?>
			<?PHP if (!empty($candvicemayorrow['middleinitial'])) { ?>
				<?PHP echo $candvicemayorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candvicemayorid = $candvicemayorrow['vicemayor_id']; ?>
				<?PHP while ($candvicemayorid == $candvicemayorrow['vicemayor_id']) { ?>
					<A HREF=<?PHP echo $candvicemayorrow['url']; ?>><?PHP echo $candvicemayorrow['urltitle']; ?></A><BR>
					<?PHP  $candvicemayorrow = mysql_fetch_array($candvicemayors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<!-- Candidates for Councilor -->
<?PHP if ($numcandcouncilors > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Candidates for Councilor</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numcandcouncilors > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $candcouncilorrow = mysql_fetch_array($candcouncilors); ?>
<?PHP while ($candcouncilorrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/candcouncilordet.php?candcouncilorid=".$candcouncilorrow['councilor_id']; ?>>
			<?PHP echo $candcouncilorrow['lastname']; ?>,&nbsp;
			<?PHP echo $candcouncilorrow['firstname']; ?>
			<?PHP if (!empty($candcouncilorrow['middleinitial'])) { ?>
				<?PHP echo $candcouncilorrow['middleinitial']; ?>.
			<?PHP } ?>
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $candcouncilorid = $candcouncilorrow['councilor_id']; ?>
				<?PHP while ($candcouncilorid == $candcouncilorrow['councilor_id']) { ?>
					<A HREF=<?PHP echo $candcouncilorrow['url']; ?>><?PHP echo $candcouncilorrow['urltitle']; ?></A><BR>
					<?PHP  $candcouncilorrow = mysql_fetch_array($candcouncilors); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>


<!-- Party -->
<?PHP if ($numparty > 0) { ?>
<H2 CLASS="HIGHLIGHTS">Political or Sectoral Party/Organization</H2>
<?PHP } ?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<?PHP if ($numparty > 0) { ?>
<TR><TD><B>No.</B></TD><TD><B>Name</B></TD><TD><B>External Links</B></TD></TR>
<?PHP } ?>
<?PHP $ctr=0; ?>
<?PHP $partyrow = mysql_fetch_array($party); ?>
<?PHP while ($partyrow) { ?>
	    <?PHP $ctr++; ?>
		<?PHP if ($ctr % 2 == 0) { ?>
			<TR BGCOLOR="#C5E0FE">
		<?PHP } else { ?>
			<TR>
		<?PHP } ?>
		<TD ALIGN="left" VALIGN="top">
			<?PHP echo $ctr; ?>	
		</TD>	
		<TD ALIGN="left" VALIGN="top">	
			<A HREF=<?PHP echo "/vote/partydet.php?partyid=".$partyrow['party_id']; ?>>
			<?PHP if (!empty($partyrow['acronym'])) { ?>
				<?PHP echo $partyrow['acronym']; ?>
			<?PHP } else { ?>
				<?PHP echo $partyrow['name']; ?>
			<?PHP } ?>	
			</A>
		</TD>
		<TD ALIGN="left" VALIGN="top">				
				<?PHP $partyid = $partyrow['party_id']; ?>
				<?PHP while ($partyid == $partyrow['party_id']) { ?>
					<A HREF=<?PHP echo $partyrow['url']; ?>><?PHP echo $partyrow['urltitle']; ?></A><BR>
					<?PHP  $partyrow = mysql_fetch_array($party); ?>
				<?PHP } ?>	
		</TD>
	</TR>
<?PHP } ?>
</TABLE>

<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
