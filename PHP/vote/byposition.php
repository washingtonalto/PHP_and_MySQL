<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/terms.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP

$query = "SELECT COUNT(*) As numrepresentatives 
          FROM representatives
		  WHERE YEAR(representatives.term_begin) = ".$repterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numrepresentatives = $personsrow['numrepresentatives'];

$query = "SELECT COUNT(*) As numgovernors 
          FROM governors
		  WHERE YEAR(governors.term_begin) = ".$govterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numgovernors = $personsrow['numgovernors'];

$query = "SELECT COUNT(*) As numvgovernors 
          FROM vicegovernors
		  WHERE YEAR(vicegovernors.term_begin) = ".$vicegovterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numvgovernors = $personsrow['numvgovernors'];

$query = "SELECT COUNT(*) As numboardmem 
          FROM provboardmembers
		  WHERE YEAR(provboardmembers.term_begin) = ".$provterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numboardmem = $personsrow['numboardmem'];

$query = "SELECT COUNT(*) As nummayors 
          FROM mayors
		  WHERE YEAR(mayors.term_begin) = ".$mayterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$nummayors = $personsrow['nummayors'];

$query = "SELECT COUNT(*) As numvmayors 
          FROM vicemayors
		  WHERE YEAR(vicemayors.term_begin) = ".$vmayterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numvmayors = $personsrow['numvmayors'];

$query = "SELECT COUNT(*) As numcouncilors 
          FROM councilors
		  WHERE YEAR(councilors.term_begin) = ".$counterm;	
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcouncilors = $personsrow['numcouncilors'];

$query = "SELECT COUNT(*) As numcrepresentatives 
          FROM candrepresentatives";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcrepresentatives = $personsrow['numcrepresentatives'];

$query = "SELECT COUNT(*) As numcgovernors 
          FROM candgovernors";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcgovernors = $personsrow['numcgovernors'];

$query = "SELECT COUNT(*) As numcvgovernors 
          FROM candvicegovernors";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcvgovernors = $personsrow['numcvgovernors'];

$query = "SELECT COUNT(*) As numcboardmem 
          FROM candboardmem";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcboardmem = $personsrow['numcboardmem'];

$query = "SELECT COUNT(*) As numcmayors 
          FROM candmayors";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcmayors = $personsrow['numcmayors'];

$query = "SELECT COUNT(*) As numcvmayors 
          FROM candvicemayors";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numcvmayors = $personsrow['numcvmayors'];

$query = "SELECT COUNT(*) As numccouncilors 
          FROM candcouncilors";
$persons = getqueryresults($query);		  
$personsrow = mysql_fetch_array($persons);
$numccouncilors = $personsrow['numccouncilors'];

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Browse By Position</TITLE>
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
<B>By Position</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		
<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>BROWSE BY POSITION</B></DIV>
<BR>
<B>House Representatives</B><BR>
<A HREF="representativeslist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numrepresentatives); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?> |&nbsp; <A HREF="candrepresentativeslist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcrepresentatives); ?></SPAN>) <?PHP } ?> <BR><BR> 
<B>Governor</B><BR>
<A HREF="governorlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numgovernors); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candgovernorlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcgovernors); ?></SPAN>) <?PHP } ?> <BR><BR> 
<B>Vice Governor</B><BR>
<A HREF="vicegovernorlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numvgovernors); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candvicegovernorlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcvgovernors); ?></SPAN>) <?PHP } ?>  <BR><BR> 
<B>Provincial Board Members</B><BR>
<A HREF="provboardmemlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numboardmem); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candprovboardmemlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcboardmem); ?></SPAN>) <?PHP } ?> <BR><BR> 
<B>Mayors</B><BR>
<A HREF="mayorlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($nummayors); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candmayorlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcmayors); ?></SPAN>) <?PHP } ?> <BR><BR> 
<B>Vice Mayors</B><BR>
<A HREF="vicemayorlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numvmayors); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candvicemayorlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcvmayors); ?></SPAN>) <?PHP } ?> <BR><BR>
<B>Councilors</B><BR>
<A HREF="councilorlist.php">View Incumbents</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numcouncilors); ?></SPAN>)&nbsp;<?PHP if ($isdisplaycand == "Y") { ?>|&nbsp; <A HREF="candcouncilorlist.php">View Candidates</A>&nbsp;(<SPAN STYLE="color: Maroon;"><?PHP echo number_format($numccouncilors); ?></SPAN>) <?PHP } ?> <BR><BR>
<BR>
<B>Note:</B> You may also use the <A HREF="/vote/search/search.php">special search engine</A> to facilitate your search for specific names,
municipality/cities, province or party.  
<BR><BR> 
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
