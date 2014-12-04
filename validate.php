<?php

/**
 * This code checks validation of numbers based on check digits on following rules
 * ISBN-10 is made up of 9 digits plus a check digit (which may be 'X') and MPAN is made up of 12 digits plus a check digit. Spaces and hyphens may be included in a code, but are not significant. This means that 9780471486480 is equivalent to 978-0-471-48648-0 and 978 0 471 48648 0.

	The check digit for ISBN-10 is calculated by multiplying each digit by its position (i.e., 1 x 1st digit, 2 x 2nd digit, etc.), summing these products together and taking modulo 11 of the result (with 'X' being used if the result is 10).

	The check digit for MPAN is calculated by multiplying each digit alternately by 1 or 3 (i.e., 1 x 1st digit, 3 x 2nd digit, 1 x 3rd digit, 3 x 4th digit, etc.), summing these products together, taking modulo 10 of the result and subtracting this value from 10, and then taking the modulo 10 of the result again to produce a single digit.

 */

$string = '9780470059029';
var_dump(check_ref13($string));

function check_ref10($string){
	
	$sanitized_string = str_split(preg_replace('/[^A-Z0-9]+/', '', $string));   // ignoring spaces and other characters
	$check_digit =0;
	if(count($sanitized_string) == 10){
		for($i=0;$i<count($sanitized_string)-1;$i++){
			$check_digit += $sanitized_string[$i] * ($i+1);
		}
		
		if($check_digit % 11 == end($sanitized_string) || ($check_digit % 11 == 10 && end($sanitized_string) == 'X') )  //validation rules
			return true;
	}
	return false;
}

function check_ref13($string){

	$sanitized_string = str_split(preg_replace('/[^0-9]+/', '', $string)); // ignoring spaces and other characters
	$check_digit =0;
	if(count($sanitized_string) == 13){
		for($i=0;$i<count($sanitized_string)-1;$i++){
			if($i % 2 == 0)  					
				$check_digit += $sanitized_string[$i] * 1;
			else
				$check_digit += $sanitized_string[$i] * 3;
		}
		if((10-($check_digit % 10))%10 == end($sanitized_string)) // validation rules
			return true;
	}
	return false;
}


