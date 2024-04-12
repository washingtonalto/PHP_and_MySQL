<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:\Documents\Data\web\production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>

<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : File Uploads</TITLE>
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
<A HREF="/vote/admin/fileuploads/"><B>File Uploads Main</B></A>
<IMG SRC="/vote/graphics/rightarrow.gif" WIDTH="25" HEIGHT="12" BORDER="0" ALT="-->">
<B>Upload</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>FILE UPLOADS</B></DIV>
<BR>
<?PHP if (empty($hassubmit)) { ?>
<FORM ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="post" ENCTYPE="multipart/form-data">
<B>Select File to Upload (File size should be up to 150 KB only):</B>&nbsp;&nbsp;<INPUT TYPE="file" NAME="uploadedfile"><BR><BR>
<B>Select Type of Upload:</B>&nbsp;&nbsp;
<SELECT NAME="uploadtype" SIZE="1">
		<OPTION VALUE="0">&nbsp;</OPTION>
		<OPTION VALUE="1">Attachments</OPTION>
		<OPTION VALUE="2">Graphics</OPTION>
		<OPTION VALUE="3">Pictures</OPTION>				
</SELECT><BR><BR><BR>
<INPUT TYPE="hidden" NAME="FAX_FILE_SIZE" VALUE="30720">
<INPUT TYPE="submit" NAME="hassubmit" VALUE="Upload">
</FORM>
<?PHP } else { ?>

<?PHP 

    if    (($uploadedfile_type <> "image/jpeg") 
	    OR ($uploadedfile_type <> "image/gif")) {

	}	
	if ($uploadtype == 1) {
		$filename = $votehome."/vote/attachments/".$uploadedfile_name;
	} else if ($uploadtype == 2) {
		$filename = $votehome."/vote/graphics/".$uploadedfile_name;	
	} else if ($uploadtype == 3) {
		$filename = $votehome."/vote/pictures/".$uploadedfile_name;	
	}
	if (copy ($uploadedfile,$filename)) {
		echo "The file ".$uploadedfile_name." was successfully loaded";		
	} else {
		echo "The file ".$uploadedfile_name." failed to successfully load";			
	}
?><BR><BR>

<?PHP } ?>
<BR>							
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>
