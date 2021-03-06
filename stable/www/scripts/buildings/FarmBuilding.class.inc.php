<?php
/*******************************************************************************
    The Kingdoms of Chaos - An online browser text game - <http://www.tkoc.net>
    Copyright (C) 2011 - Administrators of The Kingdoms of Chaos

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Contact Information:
    Petros Karipidis  - petros@rufunka.com - <http://www.rufunka.com/>
    Anastasios Nistas - tasosos@gmail.com  - <http://tasos.pavta.com/>

    Other Information
    =================
    The exact Author of each source file should be specified after this license
    notice. If not specified then the "Current Administrators" found at
    <http://www.tkoc.net/about.php> are considered the Authors of the source
    file.

    As stated at the License Section 5.d: "If the work has interactive user
    interfaces, each must display Appropriate Legal Notices; however, if the
    Program has interactive interfaces that do not display Appropriate Legal
    Notices, your work need not make them do so.", we require you give
    credits at the appropriate section of your interface.
********************************************************************************/

/* FarmBuilding class.
 * 
 * This class will handle all functions of a FarmBuilding requires BuildingBase.class.inc.php
 * For more details about functions, see BuildingBase.class.inc.php
 * 
 * Author: �ystein Fladby	22.02.2003
 * 
 * Version: test
 * 
 */

if( !class_exists( "FarmBuilding" ) ) {
require("BuildingBase.class.inc.php");

class FarmBuilding extends BuildingBase {
	var $foodIncome = 65;	//a farm produces 65 food units each tick
	var $startValue = 20;	//start with 20 Farm buildings
	var $picture = "farm.jpg";	

	function FarmBuilding( $buildingID ) {
		$this->BuildingBase( $buildingID, 	// id
							 "Farm", 		// name
							 10, 			// ticks
							 1000, 			// gold
							 0, 			// metal
							 "The farm produces $this->foodIncome units of food." );
	}
	function foodIncome() {
		return $this->foodIncome;
	}
	function startValue() {
		return $this->startValue;
	}	
	function pictureFile() {
		return $this->picture;
	}
} 
} // end if( !class_exists() )
?>