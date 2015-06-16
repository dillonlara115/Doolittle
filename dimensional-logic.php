<?php
//Form filter function hook.
add_filter("gform_pre_render", "trailer_form_pre_render");

/*
 * initiates the form update by ensuring the formID is
 * one of the appropriate trailer forms and not some other form
 * that we are not concerned about.
 * @params Gravity Forms form object
 * @return Gravity Forms form object (updated, if necessary)
 */
function trailer_form_pre_render($form){
	
	switch($form["id"]) {
		case 4 :		// MASTER DUMP TRAILERS
			$trailer = get_master_dump_properties();
			break;
		case 9 : 		// XTREME EQUIPMENT TRAILERS
			$trailer = get_xtreme_properties();
			break;
		case 10 : 		// CF EQUIPMENT TRAILERS
			$trailer = get_cf_equipment_properties();
			break;
		case 11 : 		// EZ LOADER EQUIPMENT TRAILERS
			$trailer = get_ez_loader_equipment_properties();
			break;
		case 12 :		// BRUTEFORCE XL DECKOVER TRAILERS
			$trailer = get_bruteforce_xl_deckover_properties();
			break;
		case 13 :		// BRUTEFORCE DECKOVER TRAILERS
			$trailer = get_bruteforce_deckover_properties();
			break;
		case 14 :		// RALLY SPORT UTILITY TRAILERS
			$trailer = get_rally_sport_utility_properties();
			break;
		case 15 :		// SS SERIES UTILITY TRAILERS
			$trailer = get_ss_series_utility_properties();
			break;
		case 16 :		// DOOLITTLE UTILITY TRAILERS
			$trailer = get_doolittle_utility_properties();
			break;
		case 17 :		// DOOLITTLE PREMIER CARGO TRAILERS
			$trailer = get_doolittle_premier_cargo();
			break;
		case 23 :		// CARGOMASTER CARGO TRAILERS
			$trailer = get_cargomaster_cargo_properties();
			break;
		case 24 :		// BULLITT CARGO TRAILERS
			$trailer = get_bullitt_cargo_properties();
			break;
		case 22 :		// EZ LOADER GT EQUIPMENT TRAILERS
			$trailer = get_ez_loader_gt_equipment_properties();
			break;
	}
	
	if (isset($trailer)) {
		perform_calculations($trailer, $form);
	}
	
	//Return form object.
	return $form;
}	

/*
 * updates the form fields choices to reflect the proper
 * price of options that require calculations
 * @params assoc. array

 */
function perform_calculations($properties, &$form) {

	// unload properties for easier access
	$length = $properties["length"];
	$width = $properties["width"];
	$axles = $properties["axles"];
	$tires = $properties["tires"];
	
	// iterate through the form's fields
	for ($i = 0; $i < count($form["fields"]); $i++) {
		
		// get form field choices
		$field = $form["fields"][$i]["choices"];
		
		// index to track field choice
		$index = 0;
		
		// iterate through the choices
		foreach ($field as $choice) {
			
			// get the addon's text and check for calculation wording
			$addonText = $choice["text"];
			
			// per linear foot calculation
			if (strpos($addonText, "**plf") !== false) {
			
				// get the price string
				$price = $choice["price"];
				
				// convert price string to float
				$newPrice = to_float($price);
				
				// round calculation result
				$newPrice = round($length * $newPrice);
							
				// convert price float to string
				$newPrice = to_string($newPrice);
				
				// assign new price back to form object
				$choice["price"] = $newPrice;
				
				// replace original text with new text
				$replacementText = array("**plf");
				$choice["text"] = str_replace($replacementText, $price . " Per Ln. Ft.", $addonText);
				
			} // end per linear foot if
			
			
			// per axle calculation
			if (strpos($addonText, "**pa") !== false) { 
				
				// get the price string
				$price = $choice["price"];
				
				// convert string to float
				$newPrice = to_float($price);
				
				// round calculation result
				$newPrice = round($axles * $newPrice);
							
				// convert price float to string
				$newPrice = to_string($newPrice);
				
				// assign new price back to form object
				$choice["price"] = $newPrice;
				
				// replace original text with new text
				$replacementText = array("**pa");
				$choice["text"] = str_replace($replacementText, $price . " Per Axle", $addonText);
				
			} // end per axle if
			
			// per square foot calculation
			if (strpos($addonText, "**psf") !== false) { 
				
				// get the price string
				$price = $choice["price"];
				
				// convert string to float
				$newPrice = to_float($price);
				
				// round calculation result
				$newPrice = round($length * $width * $newPrice);
							
				// convert price float to string
				$newPrice = to_string($newPrice);
				
				// assign new price back to form object
				$choice["price"] = $newPrice;
				
				// replace original text with new text
				$replacementText = array("**psf");
				$choice["text"] = str_replace($replacementText, $price . " Per Sq. Ft.", $addonText);
				
			} // end square foot if

			// widt per linear foot calculation
			if (strpos($addonText, "**wplf") !== false) { 
				
				// get the price string
				$price = $choice["price"];
				
				// convert string to float
				$newPrice = to_float($price);
				
				// round calculation result
				$newPrice = round($width * $newPrice);
							
				// convert price float to string
				$newPrice = to_string($newPrice);
				
				// assign new price back to form object
				$choice["price"] = $newPrice;
				
				// replace original text with new text
				$replacementText = array("**wplf");
				$choice["text"] = str_replace($replacementText, $price . " Per Ln. Ft. Width", $addonText);
				
			} // end square foot if
			
			
			// save back to form and increment index
			$form["fields"][$i]["choices"][$index] = $choice;
			$index++;
			
		} // end inner foreach loop
		
	} // end outer for loop


	return;
	
}

/*
 * Gets the page's URL variables
 * @returns string : trailer model number from query string
 */
function retrieve_get_variable() {
	//Assign array to local variable.
	$getArray = $_GET;
	
	//Grab last variable in URL.
	$lastVariable = end($getArray);
	
	//Model number.
	$modelNumber = $lastVariable;
		
	return($modelNumber);
}

/*
 * Converts a price string to a float
 * @params string
 * @returns float
 */
function to_float($price) {
	
	// echo price per linear foot
	//echo("<br/>Price before: " . $price);
	
	// convert to float
	$newPrice = str_replace("$", "", $price);
	$newPrice = floatval($newPrice);
		
	return($newPrice);
}

/*
 * Converts a float to a price string
 * @params float
 * @returns string
 */
function to_string($price) {
	
	// reformat for save/display
	$newPrice = "$" . $price;
	
	//echo actual cost based on trailer dimensions
	//echo("<br/>Price after: " . $newPrice . "<br/><br/>");
	
	return($newPrice);
}

/*
 * Below are help functions that return an associative
 * array containing the properties of the trailer currently
 * selected in the quote builder
 * @returns assoc. array
 */
function get_master_dump_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "MD2813" :		// 6000 series
		case "MD3164" :
		case "MD3497" :
			$properties["length"] = 8;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD3397" :
		case "MD3689" :
			$properties["length"] = 10;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD3767" :		// 7200 series
		case "MD4192" :
		case "MD4116" :
		case "MD4541" :
		case "MD4617" :
		case "MD5042" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD4725" :
		case "MD5335" :
		case "MD5186" :
		case "MD5723" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD5006" :		// 8200 series
		case "MD5577" :
		case "MD5373" :
		case "MD5924" :
			$properties["length"] = 12;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD5825" :
		case "MD6196" :
			$properties["length"] = 14;
			$$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "MD6682" :
			$properties["length"] = 16;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
	}
	
	return($properties);
}

function get_xtreme_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "DL2406" :
		case "DL2873" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2550" :
		case "DL3017" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3474" :
			$properties["length"] = 18;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3619" :
			$properties["length"] = 20;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
	}
	
	return($properties);
}

function get_cf_equipment_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "DL2094" :
		case "DL2487" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2238" :
		case "DL2631" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3225" :
			$properties["length"] = 18;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3369" :
			$properties["length"] = 20;
			$properties["width"] = 6.833333;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
	}
	
	return($properties);
}

function get_ez_loader_equipment_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "EZ2499" :
		case "EZ3274" :
		case "EZ3946" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "EZ2643" :
		case "EZ3418" :
		case "EZ4090" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
	}
	
	return($properties);
}

function get_bruteforce_xl_deckover_properties() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 8.5, "axles" => 2, "tires" => 4);
	
	switch($modelNumber) {
		case "DL4016" :
			$properties["length"] = 16;
			break;
		case "DL4126" :
			$properties["length"] = 18;
			break;
		case "DL4236" :
			$properties["length"] = 20;
			break;
		case "DL4346" :
			$properties["length"] = 22;
			break;
		case "DL4455" :
			$properties["length"] = 24;
			break;
		case "DL4671" :
			$properties["length"] = 26;
			break;
		case "DL4779" :
			$properties["length"] = 28;
			break;
		case "DL4888" :
			$properties["length"] = 30;
			break;
	}
	
	return($properties);
}

function get_bruteforce_deckover_properties() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 8.5, "axles" => 2, "tires" => 4);
	
	switch($modelNumber) {
		case "DL4537" :
		case "DL6804" :
			$properties["length"] = 20;
			break;
		case "DL4646" :
		case "DL6905" :
			$properties["length"] = 22;
			break;
		case "DL4755" :
		case "DL7006" :
			$properties["length"] = 24;
			break;
		case "DL4863" :
		case "DL7056" :
			$properties["length"] = 25;
			break;
		case "DL4971" :
		case "DL7106" :
			$properties["length"] = 26;
			break;
		case "DL5079" :
		case "DL7207" :
			$properties["length"] = 28;
			break;
		case "DL5188" :
		case "DL7308" :
			$properties["length"] = 30;
			break;
		case "DL7409" :
			$properties["length"] = 32;
			break;
		case "DL7510" :
			$properties["length"] = 34;
			break;
		case "DL7559" :
			$properties["length"] = 35;
			break;
		case "DL7611" :
			$properties["length"] = 36;
			break;
		case "DL7712" :
			$properties["length"] = 38;
			break;
		case "DL7812" :
			$properties["length"] = 40;
			break;
		case "DL6198" :
			$properties["length"] = 30;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
		case "DL6307" :
			$properties["length"] = 32;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
		case "DL6417" :
			$properties["length"] = 34;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
		case "DL6537" :
			$properties["length"] = 36;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
		case "DL6646" :
			$properties["length"] = 38;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
		case "DL6792" :
			$properties["length"] = 40;
			$properties["axles"] = 3;
			$properties["tires"] = $properties["axles"] *2;
			break;
	}
	
	return($properties);
}

function get_rally_sport_utility_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "RS731" :
		case "RS800" :
		case "RS901" :
			$properties["length"] = 8;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "RS844" :
		case "RS946" :
			$properties["length"] = 10;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "RS1017" :
			$properties["length"] = 12;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "RS1052" :
			$properties["length"] = 10;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "RS1052" :
		case "RS1305" :
			$properties["length"] = 12;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "RS1675" :
			$properties["length"] = 16;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
			
	}
	
	return($properties);
}

function get_ss_series_utility_properties() {
	
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "DL1217" :
			$properties["length"] = 8;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1217x" :
			$properties["length"] = 10;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1284" :
			$properties["length"] = 12;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1351" :
			$properties["length"] = 14;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1280" :
			$properties["length"] = 10;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1347" :
			$properties["length"] = 12;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1413" :
			$properties["length"] = 14;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1332" :
			$properties["length"] = 10;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1399" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1466" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1992" :
			$properties["length"] = 14;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1992x" :
			$properties["length"] = 16;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2059" :
			$properties["length"] = 18;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2092" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2092x" :
			$properties["length"] = 16;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2138" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2205" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
			
	}
	
	return($properties);

}

function get_doolittle_utility_properties() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "DL1167" :
			$properties["length"] = 8;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1167x" :
			$properties["length"] = 10;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1234" :
			$properties["length"] = 12;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "1301" :
			$properties["length"] = 14;
			$properties["width"] = 5.5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1230" :
			$properties["length"] = 10;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1297" :
		case "DL1613" :
			$properties["length"] = 12;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1363" :
		case "DL1679" :
			$properties["length"] = 14;
			$properties["width"] = 6.41666;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1282" :
			$properties["length"] = 10;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1349" :
		case "DL1667" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1416" :
		case "DL1732" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1875" :
			$properties["length"] = 12;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1942" :
		case "DL2588" :
			$properties["length"] = 14;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL1942x" :
		case "DL2588x" :
			$properties["length"] = 16;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2009" :
		case "DL2655" :
			$properties["length"] = 18;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2076" :
		case "DL2722" :
			$properties["length"] = 20;
			$properties["width"] = 6.41666;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2042" :
		case "DL2684" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2042x" :
		case "DL2694" :
			$properties["length"] = 16;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2088" :
		case "DL2750" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2155" :
		case "DL2816" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
			
	}
	
	return($properties);

}

function get_doolittle_premier_cargo() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" => 0, "tires" => 0);
	
	switch($modelNumber) {
		case "DL1957" :
			$properties["length"] = 8;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2150" :
			$properties["length"] = 10;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3474" :
			$properties["length"] = 12;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2332" :
			$properties["length"] = 8;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2565" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2909" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3115" :
			$properties["length"] = 14;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL2896" :
			$properties["length"] = 10;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3241" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL3817" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4084" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4208" :
			$properties["length"] = 14;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4437" :
			$properties["length"] = 16;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4220" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4459" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4689" :
			$properties["length"] = 16;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4918" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL5149" :
			$properties["length"] = 20;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4735" :
			$properties["length"] = 14;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL4965" :
			$properties["length"] = 16;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL5194" :
			$properties["length"] = 18;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL5423" :
			$properties["length"] = 20;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL5653" :
			$properties["length"] = 22;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "DL5883" :
			$properties["length"] = 24;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		
	}
	
	return($properties);

}

function get_cargomaster_cargo_properties() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" => 0, "tires" => 0);
	
	switch($modelNumber) {
		case "CM1659" :
			$properties["length"] = 8;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM1825" :
			$properties["length"] = 10;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2131" :
			$properties["length"] = 12;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM1977" :
			$properties["length"] = 8;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2172" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2463" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2637" :
			$properties["length"] = 14;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2452" :
			$properties["length"] = 10;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM2743" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3248" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3472" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3577" :
			$properties["length"] = 14;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3770" :
			$properties["length"] = 16;
			$properties["width"] = 6;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3587" :
			$properties["length"] = 12;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3790" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM3982" :
			$properties["length"] = 16;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4174" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4021" :
			$properties["length"] = 14;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4214" :
			$properties["length"] = 16;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4407" :
			$properties["length"] = 18;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4601" :
			$properties["length"] = 20;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4795" :
			$properties["length"] = 22;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "CM4988" :
			$properties["length"] = 24;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;

		
	}
	
	return($properties);

}

function get_bullitt_cargo_properties() {
	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" => 0, "tires" => 0);
	
	switch($modelNumber) {
		case "BL1523" :
			$properties["length"] = 8;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL1673" :
			$properties["length"] = 10;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL1958" :
			$properties["length"] = 12;
			$properties["width"] = 5;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL1812" :
			$properties["length"] = 8;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL1990" :
			$properties["length"] = 10;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL2257" :
			$properties["length"] = 12;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL2414" :
			$properties["length"] = 14;
			$properties["width"] = 6;
			$properties["axles"] = 1;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL3477" :
			$properties["length"] = 14;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL3655" :
			$properties["length"] = 16;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL3831" :
			$properties["length"] = 18;
			$properties["width"] = 7;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL3691" :
			$properties["length"] = 14;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL3977" :
			$properties["length"] = 16;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL4043" :
			$properties["length"] = 18;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL4220" :
			$properties["length"] = 20;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL4519" :
			$properties["length"] = 22;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "BL4701" :
			$properties["length"] = 24;
			$properties["width"] = 8.5;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;

		
	}
	
	return($properties);

}

function get_ez_loader_gt_equipment_properties() {

	//Get variable at end of URL
	$modelNumber = retrieve_get_variable();
	
	//Properties determined by model
	$properties = array("length" => 0, "width" => 0, "axles" =>0, "tires" => 0);
	
	switch($modelNumber) {
		case "GT3654" :
		case "GT4469" :
			$properties["length"] = 18;
			$properties["width"] = 6.6667;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "GT3794" :
		case "GT4609" :
			$properties["length"] = 20;
			$properties["width"] = 6.6667;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
		case "GT4753" :
			$properties["length"] = 22;
			$properties["width"] = 6.6667;
			$properties["axles"] = 2;
			$properties["tires"] = $properties["axles"] * 2;
			break;
	}
	
	return($properties);
}





?>