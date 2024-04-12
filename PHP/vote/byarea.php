<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!----- Initialize MySQL Queries ----------->
<?PHP	
$query = "SELECT  provinces.province_id As province_id,regions.regionname As region, regions.fullname As regionfullname, provinces.name As province
  FROM regions, provinces 
  WHERE regions.region_id = provinces.region_id
  ORDER BY regions.regorder, provinces.name";
$provinces =  getqueryresults($query);

$query = "SELECT nationalcapitalregion.municity_id As municity_id, nationalcapitalregion.name As municity
  FROM nationalcapitalregion
  ORDER BY nationalcapitalregion.name";
$municityncr = getqueryresults($query);

?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Browse By Area</TITLE>
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
<B>By Area</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>BROWSE BY AREA</B></DIV>
<BR>
<B>NCR - National Capital Region</B>					
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
<TR><TD WIDTH="5%">&nbsp;</TD>
<TD ALIGN="left">
<?PHP
$municityrow = mysql_fetch_array($municityncr);
while ($municityrow) {
?>
	<A HREF=<?PHP echo "/vote/ncrmunicitydet.php?municityid=".$municityrow['municity_id']; ?>><?PHP echo $municityrow['municity']; ?></A>&nbsp;
	<?PHP 
	   $municityrow = mysql_fetch_array($municityncr); 
	   if ($municityrow) {
	     echo ",&nbsp;";
	   } 
	?>
<?PHP 
}
?>
<?PHP mysql_free_result($municityncr); ?>
</TD>
</TABLE>
<BR>
<?PHP
$provrow = mysql_fetch_array($provinces);
while ($provrow) {
?>
	<?PHP 
		$region = $provrow['region'];
	?>
	<B><?PHP echo $provrow['region']; ?> 
	   - <?PHP echo $provrow['regionfullname']; ?></B>	
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center">
		<TR><TD WIDTH="5%">&nbsp;</TD>
			<TD ALIGN="left">	
			<?PHP
			     while ($region == $provrow['region']) { 
			?>
			    	<A HREF=<?PHP echo "/vote/provincedet.php?provinceid=".$provrow['province_id']; ?>><?PHP echo $provrow['province']; ?></A>&nbsp;
					<?PHP  $provrow = mysql_fetch_array($provinces); ?>
					<?PHP if($region ==$provrow['region']) { ?>
				  		,&nbsp;
					<?PHP } ?> 
			<?PHP } ?>
			</TD>	
		</TR>
	</TABLE>	
	<BR>
<?PHP	
}
?>
<?PHP mysql_free_result($provinces); ?>
<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
