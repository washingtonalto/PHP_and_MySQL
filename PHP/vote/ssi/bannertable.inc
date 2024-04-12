<?PHP 

// generates a random value between 0 and $max - 1
function random( $max )
{	
		srand((double)microtime()*1000000);
        $x = rand();
        $y = getrandmax();

        $r = $x / $y * ($max -1 );

        $r = round( $r++ );
        return $r;
}

$array[0] = "";
$url[0] = "";

// picks out a banner at random
$randbanner = random(sizeof($array));

// This is used for testing purposes only
// for ($ctr=0;$ctr < sizeof($array);$ctr++) {
//   	echo $array[$ctr];
// }
                
?>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
<TR VALIGN="top"><TD>	
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
		<TR BGCOLOR="#FFFFFF" CLASS="BANNER_TABLE">
			<TD HEIGHT="85" ALIGN="left" VALIGN="middle">
<IMG ALT="Vote.ph Banner" BORDER="0" SRC="/vote/graphics/vote-logo.gif" HSPACE="0" VSPACE="0" WIDTH="150" HEIGHT="60" USEMAP="#votelogo" ALIGN="LEFT">
<MAP NAME="votelogo">
<AREA ALT="Vote.ph Home Page" COORDS="0,0,241,65" HREF="/vote/" SHAPE="RECT">
</MAP>
			</TD>
			<TD ALIGN="center" VALIGN="middle">
				<?PHP if (strlen(trim($array[$randbanner])) <> 0) { ?>
					<A HREF=<?PHP echo $url[$randbanner]; ?>>
					<IMG SRC=<?PHP echo "/vote/advertisements/".$array[$randbanner]; ?> WIDTH="468" HEIGHT="60" BORDER="2" ALT=""></A>			
				<?PHP } ?>
			</TD>
			<TD ALIGN="right" VALIGN="top" NOWRAP><?PHP
echo "<SPAN STYLE=color:#330033;font-size:8pt;><B>".strftime('%B %d, %Y')."</B></SPAN>";
?>&nbsp;&nbsp;
<BR>
<A HREF="/vote/search/search.php" TITLE=""><SPAN STYLE=font-size:10pt;>Search</SPAN></A>&nbsp;|&nbsp;
<A HREF="/vote/feedback/feedback.php" TITLE="Help us improve this website. Send us your feedback!"><SPAN STYLE=font-size:10pt;>Feedback</SPAN></A>&nbsp;&nbsp;<BR>
<A HREF="/vote/guide/" TITLE="Voter's Guide and Commentaries"><SPAN STYLE=font-size:10pt;>Voter's Guide</SPAN></A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</TD>
		</TR>
	</TABLE>
</TD></TR>
</TABLE>
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center" STYLE="border-width: 1px 1px 1px 1px;">
<TR VALIGN="middle" BGCOLOR="Red"><TD>
	<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="center" STYLE="border-color: #990033; border-width: 1px 1px 1px 1px;">		
		<TR STYLE="color: White; font-weight: bolder;">	
<SCRIPT LANGUAGE="javascript">
<!--
	function mouse_ovr(src,colorover) {
  		if (!src.contains(event.fromElement)) {
    		src.style.cursor = 'hand'; 
			src.bgColor = colorover;
  		}
	}
	function mouse_out(src,colorin) {
  		if (!src.contains(event.toElement)) {
    		src.style.cursor = 'default';
    		src.bgColor = colorin;
  		}
	}
	function go_location(src,location) {
  		if (!src.contains(event.toElement)) {
    		window.location.href = location;
  		}
	}
-->	
</SCRIPT>
<TD HEIGHT="12" ALIGN="center" VALIGN="middle" NOWRAP onClick="go_location(this,'/vote/newseventslist.php');" onMouseOver="mouse_ovr(this,'#168AFF')" onMouseOut="mouse_out(this,'Red')"><A HREF="/vote/newseventslist.php" STYLE="color:white;" TITLE="Current and Upcoming News, Events and Activities"><B><U>News</U></B></A></TD>
<TD HEIGHT="12" ALIGN="center" VALIGN="middle" NOWRAP onClick="go_location(this,'/vote/statistics/');" onMouseOver="mouse_ovr(this,'#168AFF')" onMouseOut="mouse_out(this,'Red')"><A HREF="/vote/statistics/" STYLE="color:white;" TITLE="Various Election Statistics"><B><U>Statistics</U></B></A></TD>
<TD HEIGHT="12" ALIGN="center" VALIGN="middle" NOWRAP onClick="go_location(this,'/vote/byarea.php');" onMouseOver="mouse_ovr(this,'#168AFF')" onMouseOut="mouse_out(this,'Red')"><A HREF="/vote/byarea.php" STYLE="color:white;" TITLE="Browse by Geographic Area"><B><U>Browse by Area</U></B></A></TD>
<TD HEIGHT="12" ALIGN="center" VALIGN="middle" NOWRAP onClick="go_location(this,'/vote/byposition.php');" onMouseOver="mouse_ovr(this,'#168AFF')" onMouseOut="mouse_out(this,'Red')"><A HREF="/vote/byposition.php" STYLE="color:white;" TITLE="Browse by Political Position"><B><U>Browse by Position</U></B></A></TD>
<TD HEIGHT="12" ALIGN="center" VALIGN="middle" NOWRAP onClick="go_location(this,'/vote/byparty.php');" onMouseOver="mouse_ovr(this,'#168AFF')" onMouseOut="mouse_out(this,'Red')"><A HREF="/vote/byparty.php" STYLE="color:white;" TITLE="Browse by Political and Sectoral Parties/Organizations/Coalitions "><B><U>Browse by Party</U></B></A></TD>
		</TR>
	</TABLE>
</TD></TR>
</TABLE>

