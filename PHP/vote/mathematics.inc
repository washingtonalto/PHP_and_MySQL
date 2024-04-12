<?PHP

// returns the ordinal value given the number
function numtoordinal($number) {

if ($number == 1) {
	$ordnum = "1st";
} elseif ($number == 2) {
    $ordnum = "2nd";
} elseif ($number == 3) {
	$ordnum = "3rd";	
} else {	
	$ordnum = $number."th";
}
return $ordnum;

}

?>