<?php 

$result = array(
	array("Month name", "Salary payment date", "Bonus payment date")
);

// get current month
$month = (int)date('m');
// get next month
// if December is the current month, then start from January.
// else, start from the next month
$month = $month == 11 ? 0 : $month+1;
for ($x = $month; $x < $month + 12; $x++) {	
	// get month's name
	$monthName = date('F', mktime(0, 0, 0, $x, 1));
	
	// get salary payment date
	$paymentDate = getSalaryPaymentDay($x);
	
	// get bonus payment date
	$bonusPaymentDate = getBonusPaymentDay($x+1);
	
	// add payments to result array
	$monthPayment = array($monthName, $paymentDate, $bonusPaymentDate);
	$result []= $monthPayment;	
}

writeToFile($result);

// Get salary payment day
function getSalaryPaymentDay($month){
	$numOfDays = date('t', mktime(0, 0, 0, $month, 1));
	$nameOfLastDay = date('D', mktime(0, 0, 0, $month, $numOfDays));
	if(	strcmp($nameOfLastDay, "Fri") == 0 ){
		$numOfDays -= 1;
	}else if( strcmp($nameOfLastDay, "Sat") == 0 ){
		$numOfDays -= 2;
	}
	return date('Y-m-d', mktime(0, 0, 0, $month, $numOfDays));
}

// Get bonus payment date
function getBonusPaymentDay($month){
	$halfMonth = 15;
	$nameOfHalfMonth = date('D', mktime(0, 0, 0, $month, $halfMonth));
	if(	strcmp($nameOfHalfMonth, "Fri") == 0 ){
		$halfMonth += 5;
	}else if( strcmp($nameOfHalfMonth, "Sat") == 0 ){
		$halfMonth += 4;
	}
	return date('Y-m-d', mktime(0, 0, 0, $month, $halfMonth));
}

// Insert data into a CSV file
function writeToFile($result){
	$name = "result.csv";
	$file = fopen($name, "w");
	foreach ($result as $line){
	  fputcsv($file,$line);
	}
	fclose($file);
}
?>