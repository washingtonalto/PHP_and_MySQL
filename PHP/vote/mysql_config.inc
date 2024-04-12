<?PHP
/* This PHP module is inserted at the beginning of each
   PHP page that makes use of the centralized database  */
   
/* ================= Variable Definitions ============= */
if ($OS == "Windows_NT") {
	$fil_mysqlhost = "localhost";
	$fil_mysqldbname = "vote";
	$fil_mysqluser = "root";
	$fil_mysqlpassword = "mscs9391533";
	$webmasteremail = "vote@vote.ph";
} else {
	$fil_mysqlhost = "mysql5.siteprotect.com";
	$fil_mysqldbname = "vote";
	$fil_mysqluser = "vote";
	$fil_mysqlpassword = "mscs9391533";
	$webmasteremail = "vote@vote.ph";
}	
/* ==================================================== */

// Attempts to connect to the database
mysql_pconnect($fil_mysqlhost,$fil_mysqluser,$fil_mysqlpassword)
              or die("Unable to connect to SQL server");  

/* ============== User-Defined Function Declaration ======== */
/* Function slashstripper takes an associative array as input and
   removes all backslashes added by addslashes function (as necessary
   in MySQL  */
function slashstripper ($arrayinput) { 
    foreach ($arrayinput as $key => $element) {
	   if (is_string($element)) {
	       $arrayinput[$key] = stripslashes($element);
	   } else {
	       $arrayinput[$key] = $element;
	   }
	}
	return $arrayinput;
}

/* Function get_queryresults accepts a query statement and returns
   the queryresults using the global variable $fil_mysqldbname */
function getqueryresults ($query) {
  
  global $fil_mysqldbname;
  mysql_select_db($fil_mysqldbname);
  $queryresults = mysql_query($query) or die("Select failed! (Possibly due to some duplicate entries found...)");
  return $filevents =  $queryresults;
}

/* Function displayerrormsg accepts query results and outputs error
   messages if applicable. */
function displayerrormsg ($queryresults,$querytype) {

switch ($querytype) {
   case "insert" :
      if($queryresults != "1") {
           $error = mysql_errno().": ".mysql_error();
           print "There was an error inserting the data: <pre>$error</pre>\n";
           print "use your back button and try again.\n";
		   print $error;
      } else {
           echo "Data successfully entered to database!<BR><BR>";
      }
      break;
   case "delete":
      if($queryresults != "1") {
           $error = mysql_errno().": ".mysql_error();
           print "There was an error deleting the data: <pre>$error</pre>\n";
           print "use your back button and try again.\n";
		   print $error;
      } else {
           echo "Data successfully deleted from the database!<BR><BR>";
      }
      break;  
   default:
       break;	
}

}
?>