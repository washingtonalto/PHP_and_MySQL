<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Input Data for <?PHP echo ucfirst($type); ?>&nbsp;<?PHP echo ucfirst($position); ?> to the Database (Via Parser)</TITLE>
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
<A HREF="/vote/admin/input/"><B>Input Options</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Input <?PHP echo ucfirst($type); ?>&nbsp;<?PHP echo ucfirst($position); ?> via Parser</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>INPUT DATA FOR <?PHP echo strtoupper($type); ?>&nbsp;<?PHP echo strtoupper($position); ?> TO THE DATABASE (VIA PARSER)</B></DIV>
<BR>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<B>IMPORTANT INSTRUCTIONS:</B><BR>
<OL>
<LI>The text box will only accept comma-separated values strings where each line is terminated by semi-colon.
<LI>Check the syntax below these important instructions for correctness
<LI>All alphanumeric values are case-insensitive ie. last names, first names, etc.
<LI>If vote values have commas, remove them so that program can distinguish delimited fields. <B>Make sure to remove the "," for ",Jr.", ",Sr."</B>
<LI>The important delimiters to remember are the "," and the ";". Spaces are discarded by the parser.
<LI>Failure to follow any of the instructions above may result in a page-full of errors. Garbage-in, garbage-out.
<LI>This service is provided as-is with no warranties provided, implied or expressed. 
</OL>
<FORM ACTION=<?PHP echo $PHP_SELF; ?> METHOD="post">
<B>Type:</B>&nbsp;&nbsp;<?PHP echo $type; ?><BR>
<B>Position:</B>&nbsp;&nbsp;<?PHP echo $position; ?><BR><BR>
<?PHP if ($position == "Representative" OR 
          $position == "Mayor" OR 
		  $position == "Vice Mayor" OR
		  $position == "Councilor") { ?>
<TABLE WIDTH="300" BORDER="1" CELLSPACING="0" CELLPADDING="4" ALIGN="left">
	<TR>
		<TD ALIGN="center" BGCOLOR="#FFBBBB"><B>Class</B></TD>
	</TR>
	<TR>
		<TD>
<INPUT TYPE="radio" NAME="class" VALUE="NCR" CHECKED>NCR<BR>
<INPUT TYPE="radio" NAME="class" VALUE="Provincial">Provincial<BR>
		</TD>
	</TR>
</TABLE>
<BR><BR><BR><BR><BR><BR><BR>		  
<?PHP } ?>		
<?PHP if ($type == "Incumbent") { ?>
<B>Term begin:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="term_begin" VALUE="<?PHP echo "2001-06-30"; ?>"><BR><BR>
<?PHP } ?>
<B>Syntax:</B><BR>
<?PHP
	switch ($position) { 
		case "President": 
		case "Vice-president":
		case "Senator":
		case "Party-list Representative":
			echo "[last name],[first name],[middle initial],[party acronym];";
			break;
		case "Representative":
			echo "[last name],[first name],[middle initial],[party acronym],[province | NCR municipality or city],[legislative district number];";		
			break;	
		case "Provincial Board Member":
			echo "[last name],[first name],[middle initial],[party acronym],[province],[legislative district];";		
			break;
		case "Governor":
		case "Vice Governor":
			echo "[last name],[first name],[middle initial],[party acronym],[province];";
			break;
		case "Mayor":
		case "Vice Mayor":
			   echo "[last name],[first name],[middle initial],[party acronym],[province],[municipality or city]; for provincial OR <BR>";		
			   echo "[last name],[first name],[middle initial],[party acronym],[municipality or city]; for NCR";			  		
			break;
		case "Councilor":	
			   echo "[last name],[first name],[middle initial],[party acronym],[province],[municipality or city],[councilor district number]; for provincial OR <BR>";		
			   echo "[last name],[first name],[middle initial],[party acronym],[municipality or city],[councilor district number]; for NCR";			  		
			break;		
	}	
	echo "<BR>";
	echo "<BR>";
?>
<B>Enter input in comma-delimited format:</B><BR>
<TEXTAREA COLS="80" ROWS="18" NAME="parseinput"></TEXTAREA>
<BR>
<BR>
<BR>
<INPUT TYPE="hidden" NAME="type" VALUE="<?PHP echo $type; ?>">
<INPUT TYPE="hidden" NAME="position" VALUE="<?PHP echo $position; ?>">
<DIV ALIGN="center"><INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit"></DIV>
</FORM>

<?PHP } else { ?> <!-- display preview -->

<?PHP 
echo "<B>Type:</B>:&nbsp".$type."<BR>";
echo "<B>Position:</B>:&nbsp".$position."<BR>";
if (!empty($class)) {
  echo "<B>Class:</B>:&nbsp".$class."<BR>";
}
echo "<B>Input</B>:<BR>";
echo $parseinput; 
echo "<BR><BR>";
echo "<B>Queries executed</B>:<BR>";
$linearray = explode(";",$parseinput);
for ($ctr=0;$ctr < sizeof($linearray)-1;$ctr++) {
	echo strval($ctr+1)."&nbsp<BR>";
	switch ($position) { 
		case "President": 
		                  list($lastname,$firstname,$middleinitial,$partyacronym) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candpresidents (firstname,lastname,middleinitial,party_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].")";
						  } else {
						  		$query = "INSERT INTO presidents (firstname,lastname,middleinitial,party_id,term_begin) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."')";						  
						  }		
						  break; 						  
		case "Vice-president":
		                  list($lastname,$firstname,$middleinitial,$partyacronym) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candvicepresidents (firstname,lastname,middleinitial,party_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].")";
						  } else {
						  		$query = "INSERT INTO vicepresidents (firstname,lastname,middleinitial,party_id,term_begin) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."')";						  
						  }		
						  break; 						  
		case "Senator":
		                  list($lastname,$firstname,$middleinitial,$partyacronym) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candsenators (firstname,lastname,middleinitial,party_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].")";
						  } else {
						  		$query = "INSERT INTO senators (firstname,lastname,middleinitial,party_id,term_begin) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."')";						  
						  }		
						  break; 						  
		case "Party-list Representative":
		                  list($lastname,$firstname,$middleinitial,$partyacronym) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candrepresentatives (firstname,lastname,middleinitial,party_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].")";
						  } else {
						  		$query = "INSERT INTO representatives (firstname,lastname,middleinitial,party_id,term_begin) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."')";						  
						  }		
						  break; 			
		case "Representative":			
		                  list($lastname,$firstname,$middleinitial,$partyacronym,$province,$districtnum) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($class == "NCR") { 
						  	$query = "SELECT legdistricts.legdist_id FROM legdistricts, nationalcapitalregion WHERE (legdistricts.ncrmunicity_id = nationalcapitalregion.municity_id) AND (nationalcapitalregion.name = '".trim(strtoupper($province))."') AND (legdistricts.dist_num = ".strval($districtnum).")";
						    echo $query."<BR>";	
						  	$legdistricts = getqueryresults($query);
							$legdistrictsrow = mysql_fetch_array($legdistricts);
						  } else {
						  	$query = "SELECT legdistricts.legdist_id FROM legdistricts, provinces WHERE (legdistricts.province_id = provinces.province_id) AND (provinces.name = '".trim(strtoupper($province))."') AND (legdistricts.dist_num = ".strval($districtnum).")";
						  	echo $query."<BR>";
							$legdistricts = getqueryresults($query);
							$legdistrictsrow = mysql_fetch_array($legdistricts);
						  }
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candrepresentatives (firstname,lastname,middleinitial,party_id,legdist_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$legdistrictsrow['legdist_id'].")";
						  } else {
						  		$query = "INSERT INTO representatives (firstname,lastname,middleinitial,party_id,term_begin,legdist_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$legdistrictsrow['legdist_id'].")";						  
						  }		
						  break; 		
		case "Provincial Board Member":	
		                  list($lastname,$firstname,$middleinitial,$partyacronym,$province,$districtnum) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  $query = "SELECT legdistricts.legdist_id FROM legdistricts, provinces WHERE (legdistricts.province_id = provinces.province_id) AND (provinces.name = '".trim(strtoupper($province))."') AND (legdistricts.dist_num = ".strval($districtnum).")";
						  echo $query."<BR>";
						  $legdistricts = getqueryresults($query);
						  $legdistrictsrow = mysql_fetch_array($legdistricts);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candboardmem (firstname,lastname,middleinitial,party_id,legdist_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$legdistrictsrow['legdist_id'].")";
						  } else {
						  		$query = "INSERT INTO provboardmembers (firstname,lastname,middleinitial,party_id,term_begin,legdist_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$legdistrictsrow['legdist_id'].")";						  
						  }		
						  break;						  
		case "Governor":		
		                  list($lastname,$firstname,$middleinitial,$partyacronym,$province) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  $query = "SELECT provinces.province_id FROM provinces WHERE (provinces.name = '".trim(strtoupper($province))."')";
						  echo $query."<BR>";
						  $provinces = getqueryresults($query);
						  $provincesrow = mysql_fetch_array($provinces);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candgovernors (firstname,lastname,middleinitial,party_id,province_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$provincesrow['province_id'].")";
						  } else {
						  		$query = "INSERT INTO governors (firstname,lastname,middleinitial,party_id,term_begin,province_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$provincesrow['province_id'].")";						  
						  }											  	
			  			  break;
		case "Vice Governor":								  
 		                  list($lastname,$firstname,$middleinitial,$partyacronym,$province) = split(",",$linearray[$ctr]);	
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  $query = "SELECT provinces.province_id FROM provinces WHERE (provinces.name = '".trim(strtoupper($province))."')";
						  echo $query."<BR>";
						  $provinces = getqueryresults($query);
						  $provincesrow = mysql_fetch_array($provinces);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candvicegovernors (firstname,lastname,middleinitial,party_id,province_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$provincesrow['province_id'].")";
						  } else {
						  		$query = "INSERT INTO vicegovernors (firstname,lastname,middleinitial,party_id,term_begin,province_id) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$provincesrow['province_id'].")";						  
						  }											  	
			  			  break;
		case "Mayor":	
						  if ($class == "Provincial") { 		
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$province,$municity) = split(",",$linearray[$ctr]);	
							 $query = "SELECT municity.municity_id FROM municity, provinces, legdistricts WHERE (municity.name = '".trim(strtoupper($municity))."') AND (provinces.name = '".trim(strtoupper($province))."') AND (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id)";
						  	 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "municity_id";
						  } else {
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$municity) = split(",",$linearray[$ctr]);						  
						  	 $query = "SELECT nationalcapitalregion.municity_id FROM nationalcapitalregion WHERE nationalcapitalregion.name = '".trim(strtoupper($municity))."'"; 
							 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "ncrmunicity_id";							 
						  }
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candmayors (firstname,lastname,middleinitial,party_id,".$municityvar.") VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$municityrow['municity_id'].")";
						  } else {
						  		$query = "INSERT INTO mayors (firstname,lastname,middleinitial,party_id,term_begin,".$municityvar.") VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$municityrow['municity_id'].")";						  
						  }											  	
						  break;	
		case "Vice Mayor":							  		  						  
						  if ($class == "Provincial") { 		
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$province,$municity) = split(",",$linearray[$ctr]);	
							 $query = "SELECT municity.municity_id FROM municity, provinces, legdistricts WHERE (municity.name = '".trim(strtoupper($municity))."') AND (provinces.name = '".trim(strtoupper($province))."') AND (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id)";
						  	 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "municity_id";
						  } else {
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$municity) = split(",",$linearray[$ctr]);						  
						  	 $query = "SELECT nationalcapitalregion.municity_id FROM nationalcapitalregion WHERE nationalcapitalregion.name = '".trim(strtoupper($municity))."'"; 
							 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "ncrmunicity_id";							 
						  }
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candvicemayors (firstname,lastname,middleinitial,party_id,".$municityvar.") VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$municityrow['municity_id'].")";
						  } else {
						  		$query = "INSERT INTO vicemayors (firstname,lastname,middleinitial,party_id,term_begin,".$municityvar.") VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$municityrow['municity_id'].")";						  
						  }											  	
						  break;	
		case "Councilor":							  		  						  						  
						  if ($class == "Provincial") { 		
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$province,$municity,$coundistrictnum) = split(",",$linearray[$ctr]);	
							 $query = "SELECT municity.municity_id FROM municity, provinces, legdistricts WHERE (municity.name = '".trim(strtoupper($municity))."') AND (provinces.name = '".trim(strtoupper($province))."') AND (municity.legdist_id = legdistricts.legdist_id) AND (legdistricts.province_id = provinces.province_id)";
						  	 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "municity_id";
						  } else {
 		                  	 list($lastname,$firstname,$middleinitial,$partyacronym,$municity,$coundistrictnum) = split(",",$linearray[$ctr]);						  
						  	 $query = "SELECT nationalcapitalregion.municity_id FROM nationalcapitalregion WHERE nationalcapitalregion.name = '".trim(strtoupper($municity))."'"; 
							 echo $query."<BR>";	
							 $municity = getqueryresults($query);
							 $municityrow = mysql_fetch_array($municity);
							 $municityvar = "ncrmunicity_id";							 
						  }
						  $query = "SELECT party.acronym, party.party_id FROM party WHERE party.acronym	= '".trim(strtoupper($partyacronym))."'";
						  echo $query."<BR>";	
	                      $party = getqueryresults($query);
						  $partyrow = mysql_fetch_array($party);
						  if ($type == "Candidate") {
						  		$query = "INSERT INTO candcouncilors (firstname,lastname,middleinitial,party_id,".$municityvar.",counlegdist) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",".$municityrow['municity_id'].",".trim(strval($coundistrictnum)).")";
						  } else {
						  		$query = "INSERT INTO councilors (firstname,lastname,middleinitial,party_id,term_begin,".$municityvar.",counlegdist) VALUES ('".ucfirst(trim($firstname))."','".ucfirst(trim($lastname))."','".ucfirst(trim($middleinitial))."',".$partyrow['party_id'].",'".$term_begin."',".$municityrow['municity_id'].",".trim(strval($coundistrictnum)).")";						  
						  }											  	
						  break;	

	}
	echo $query."<BR>";		  
	$results = getqueryresults($query);		
	displayerrormsg($results,"insert");
}
echo "<BR><BR>";
echo "<B>There were ".$ctr." records successfully added to the database!</B>";
?>
<BR>

<?PHP } ?> <!-- End of if (empty($submit)) -->
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
