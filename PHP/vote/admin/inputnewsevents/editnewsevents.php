<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<!----- Initialize MySQL Queries ----------->

<?PHP	

if (empty($hassubmit)) {
    $query = "SELECT  newsevents_id, body, start_date, end_date, province_id, municity_id, ncrmunicity_id, is_national,
             source, title
       FROM newsevents
       WHERE newsevents_id = ".$newseventsid;
    $newsevents =  getqueryresults($query);
    $newseventsrow = mysql_fetch_array($newsevents);

	$query = "SELECT name As province, province_id FROM provinces ORDER by provinces.name";
	$province = getqueryresults($query);   
	
	$query = "SELECT municity.municity_id, municity.name As municity,
	          provinces.name As province FROM municity, legdistricts, provinces
	          WHERE (municity.legdist_id = legdistricts.legdist_id) AND 
			        (legdistricts.province_id = provinces.province_id)
			  ORDER BY provinces.name, municity.name";
	$municity = getqueryresults($query);	
	
	$query = "SELECT nationalcapitalregion.municity_id, 
	                 nationalcapitalregion.name As municity
	          FROM nationalcapitalregion ORDER BY nationalcapitalregion.name";
	$ncrmunicity = getqueryresults($query);		  

}

?>

<!--======================= End of MetaHeaders =================-->
<TITLE>Vote.ph : Edit News, Events, Activity</TITLE>
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
<A HREF="/vote/admin/inputnewsevents/viewnewsevents.php"><B>Data Entry for News, Events and Activities</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Edit News, Events, Activity</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>EDIT NEWS, EVENTS AND ACTIVITIES</B></DIV>
<BR>
<?PHP if (empty($hassubmit)) { ?>

<FORM ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="post">
<B>Date to Start Display (YYYY-MM-DD):</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="start_date" VALUE="<?PHP echo $newseventsrow['start_date']?>" SIZE="12"><BR>
<B>Date to Stop Display (YYYY-MM-DD):</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="end_date" VALUE="<?PHP echo $newseventsrow['end_date']?>" SIZE="12"><BR>
<B>Title:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="title" VALUE="<?PHP echo stripslashes(trim($newseventsrow['title'])); ?>" SIZE="75" MAXLENGTH="120"><BR>
<B>Is News, Events and Activities National?</B><BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="is_national" VALUE="Y" <?PHP if($newseventsrow['is_national'] == "Y") echo "CHECKED"; ?>>&nbsp;Yes<BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="radio" NAME="is_national" VALUE="N" <?PHP if($newseventsrow['is_national'] == "N") echo "CHECKED"; ?>>&nbsp;No<BR>
<B>NCR Municipality/City:</B>&nbsp;&nbsp;
	<SELECT NAME="ncrmunicity_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($ncrmunicityrow = mysql_fetch_array($ncrmunicity)) { ?>
			<OPTION VALUE="<?PHP echo $ncrmunicityrow['municity_id']; ?>" <?PHP if ($newseventsrow['ncrmunicity_id'] == $ncrmunicityrow['municity_id']) echo "SELECTED"; ?>>
			  <?PHP echo $ncrmunicityrow['municity']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($ncrmunicity); ?>
<B>Province:</B>&nbsp;&nbsp;
	<SELECT NAME="province_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($provincerow = mysql_fetch_array($province)) { ?>
			<OPTION VALUE="<?PHP echo $provincerow['province_id']; ?>" <?PHP if ($newseventsrow['province_id'] == $provincerow['province_id']) echo "SELECTED"; ?>>
			  <?PHP echo $provincerow['province']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($province); ?>
<B>Provincial Municipality/City:</B>&nbsp;&nbsp;
	<SELECT NAME="municity_id" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<?PHP while ($municityrow = mysql_fetch_array($municity)) { ?>
			<OPTION VALUE="<?PHP echo $municityrow['municity_id']; ?>" <?PHP if ($newseventsrow['municity_id'] == $municityrow['municity_id']) echo "SELECTED"; ?>>
			  <?PHP echo $municityrow['municity']; ?>&nbsp;&nbsp;of&nbsp;&nbsp;<?PHP echo $municityrow['province']; ?>
			</OPTION>
		<?PHP } ?>
	</SELECT><BR>
	<?PHP mysql_free_result($municity); ?>
<B>Source:</B>&nbsp;&nbsp;<INPUT TYPE="text" NAME="source" VALUE="<?PHP echo $newseventsrow['source']?>" SIZE="50" MAXLENGTH="50"><BR>
<B>Body:</B>&nbsp;&nbsp;<BR>
<TEXTAREA COLS="80" ROWS="25" NAME="body"><?PHP echo stripslashes($newseventsrow['body']); ?></TEXTAREA><BR>
<BR>
<INPUT TYPE="hidden" NAME="newseventsid" VALUE="<?PHP echo $newseventsid; ?>">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Submit">
</FORM>

<?PHP } else { ?>

<?PHP
    if (empty($is_national)) {
	  $is_national = "";
	}
	$query = "UPDATE newsevents SET body = '".addslashes($body).
	                        "', start_date = '".addslashes($start_date).
                            "', end_date = '".addslashes($end_date).							
						    "', title = '".addslashes($title).    
        				    "', source = '".addslashes(trim($source)).
							"', municity_id = ".$municity_id.
							",  ncrmunicity_id = ".$ncrmunicity_id.							
							", is_national = '".$is_national.
							"', province_id = ".$province_id.	
						    " WHERE (newsevents_id = ".$newseventsid.")";
	echo "<B>Query Executed:</B><BR>";
	echo $query."<BR>";
	$results = getqueryresults($query);
	displayerrormsg($results,"insert");
?>
Click <A HREF="<?PHP echo $HTTP_REFERER; ?>">here</A> to go to page you last visited.<BR>
Click <A HREF="/vote/admin/inputnewsevents/viewnewsevents.php">here</A> to go back to Data Entry for News, Events and Activities Page.
<BR><BR>
<?PHP } ?>
<BR>		
<BR>
<BR>
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

