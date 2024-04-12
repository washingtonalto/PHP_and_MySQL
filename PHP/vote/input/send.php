<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>

<!--======================= Start of MetaHeaders =================-->
<?PHP if ($OS == "Windows_NT") { $votehome="D:/Documents/Data/web/production"; } else { $votehome="/home/vote/www"; } require("$votehome/vote/ssi/metaheaders.inc"); ?>
<?PHP require ("$votehome/vote/mysql_config.inc"); ?>
<?PHP require ("$votehome/vote/mathematics.inc"); ?>
<!--======================= End of MetaHeaders =================-->

<TITLE>Vote.ph : Thank you for submitting your post!</TITLE>
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
<B>Thank you for submitting your post!</B>
</TD>
</TR>
</TABLE>
<!--================ End of Breadcrumb Trails =======================-->		

<!--================= Start of Content Table ====================-->
<BR>
<?PHP if ($is_correct == 'Y') { ?>
	<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>YOUR POSTING HAS BEEN EMAILED TO US!</B></DIV>
<?PHP } else { ?>
	<DIV ALIGN="center" STYLE="background-color: #E6E6E6;"><B>YOUR POSTING HAS BEEN CANCELLED</B></DIV>
<?PHP } ?>
<BR>
<?PHP

if (empty($postersname)) { $postersname = ""; };
if (empty($postersrelation)) { $postersrelation = ""; };
if (empty($postersaddress)) { $postersaddress = ""; }; 
if (empty($posterstelnum)) { $posterstelnum = ""; }; 
if (empty($postersfaxnum)) { $postersfaxnum = ""; };
if (empty($postersemail)) { $postersemail = ""; }; 
if (empty($type)) { $type = ""; };  
if (empty($position)) { $position = ""; };
if (empty($lastname)) { $lastname = ""; };
if (empty($firstname)) { $firstname = ""; };
if (empty($middleinitial)) { $middleinitial = ""; };
if (empty($partyname)) { $partyname = ""; };
if (empty($coalitionname)) { $coalitionname = ""; };         
if (empty($municity)) { $municity = ""; };
if (empty($ncrmunicity)) { $ncrmunicity = ""; };
if (empty($legdist)) { $legdist = ""; }; 
if (empty($province)) { $province = ""; };
if (empty($civilstatus)) { $civilstatus = ""; };
if (empty($nickname)) { $nickname = ""; };
if (empty($birthdate)) { $birthdate = ""; };
if (empty($birthplace)) { $birthplace = ""; };    
if (empty($telnos)) { $telnos = ""; };
if (empty($faxnos)) { $faxnos = ""; };
if (empty($email)) { $email = ""; };           
         
if (empty($biography)) { $biography = ""; }; 
if (empty($platform)) { $platform = ""; };
if (empty($programofgovt)) { $programofgovt = ""; };                                                           
if (empty($standonissues)) { $standonissues = ""; };
if (empty($accomplishments)) { $accomplishments = ""; };                                                                                                                      
if (empty($workexperiences)) { $workexperiences = ""; }; 
if (empty($educattainment)) { $educattainment = ""; };     
if (empty($familyinfo)) { $familyinfo = ""; };    

if (empty($link1)) { $link1 = ""; };
if (empty($link2)) { $link2 = ""; };
if (empty($link3)) { $link3 = ""; };                                                                                                                                                                                                                                                                                              
                                                           
$bodyemail = "
<B>Name of poster:</B>&nbsp;$postersname<BR> 
<B>Relation of posters to candidate/incumbent:</B>&nbsp;$postersrelation<BR>
<B>Poster's address:</B>&nbsp;$postersaddress<BR>
<B>Poster's telephone nos.:</B>&nbsp;$posterstelnum<BR>
<B>Poster's fax nos.:</B>&nbsp;$postersfaxnum<BR>
<B>Poster's e-mail.:</B>&nbsp;$postersemail<BR>
<BR>
---------------------------<BR>
<B>Type:</B>&nbsp;$type<BR>
<B>Position:</B>&nbsp;$position<BR>
<B>Last Name:</B>&nbsp;$lastname<BR>
<B>First Name:</B>&nbsp;$firstname<BR>
<B>Middle Initial:</B>&nbsp;$middleinitial<BR>
<B>Party:</B>&nbsp;$partyname<BR>
<B>Coalition:</B>&nbsp;$coalitionname<BR>
<B>Municipality/City:</B>&nbsp;$municity<BR>
<B>NCR Municipality/City:</B>&nbsp;$ncrmunicity<BR>
<B>Legislative District:</B>&nbsp;$legdist<BR>
<B>Province:</B>&nbsp;$province<BR>
<B>Civil Status:</B>&nbsp;$civilstatus<BR>
<B>Nick Name:</B>&nbsp;$nickname<BR>
<B>Birth Date:</B>&nbsp;$birthdate<BR>
<B>Birth Place:</B>&nbsp;$birthplace<BR>
<B>Tel Nos.:</B>&nbsp;$telnos<BR>
<B>Fax Nos.:</B>&nbsp;$faxnos<BR>
<B>Email:</B>&nbsp;$email<BR>
<B>Biography:</B><BR>
-----------------------------------------------------------------------<BR>
$biography<BR>
-----------------------------------------------------------------------<BR>
<B>Platform:</B><BR>
-----------------------------------------------------------------------<BR>
$platform<BR>
-----------------------------------------------------------------------<BR>
<B>Program of Government:</B><BR>
-----------------------------------------------------------------------<BR>
$programofgovt<BR>
-----------------------------------------------------------------------<BR>
<B>Stand on Certain Issues:</B><BR>
-----------------------------------------------------------------------<BR>
$standonissues<BR>
-----------------------------------------------------------------------<BR>
<B>Work Experience:</B><BR>
-----------------------------------------------------------------------<BR>
$workexperiences<BR>
-----------------------------------------------------------------------<BR>
<B>Educational Attainment:</B><BR>
-----------------------------------------------------------------------<BR>
$educattainment<BR>
-----------------------------------------------------------------------<BR>
<B>Family Information:</B><BR>
-----------------------------------------------------------------------<BR>
$familyinfo<BR>
-----------------------------------------------------------------------<BR>
<B>Accomplishments:</B><BR>
-----------------------------------------------------------------------<BR>
$accomplishments<BR>
-----------------------------------------------------------------------<BR>
<B>Link 1:</B><BR>
$link1<BR>
<B>Link 2:</B><BR>
$link2<BR>
<B>Link 3:</B><BR>
$link3<BR>
";
echo "<B><SPAN STYLE='color: Blue;'>The ff. are your posts:</SPAN></B><BR><BR>";
echo $bodyemail;
echo "<BR><BR>";
echo "<DIV ALIGN='CENTER'>";
if ($is_correct == 'Y' AND mail('postinfo@vote.ph',$postersemail." has sent you a post",$bodyemail,"From: ".$postersemail."\n")) {
	echo "Your post has been sent successfully sent to us.";
} else { 
	echo "Your posts has not been sent due to an error. Please try again at some later time. We're sorry
	for the inconvenience.";
}
echo "</DIV>";
?>

<BR>				
<!--================= End of Content Table ====================-->
<!--=========================== Start of Bottom Bar ======================-->
<?PHP require("$votehome/vote/ssi/bottombar.inc"); ?>
<!--============================ End of Bottom Bar ======================-->
</BODY>
</HTML>

