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

require_once("MilitaryBase.class.inc.php");
	require_once("MilitaryConstants.class.inc.php");
	require_once($GLOBALS['path_www_scripts']."buildings/BuildingConstants.class.inc.php");
	
	if( !class_exists("UndeadMagiciansMilitary")) {
		class UndeadMagiciansMilitary extends MilitaryBase {
			var $picture = "wizards.gif";
			var $MilitaryConst = NULL;
			
			function UndeadMagiciansMilitary( $militaryID ) {

				$this->MilitaryConst = $GLOBALS['MilitaryConst'];

				$info = "The liches, the slimy wizards of the undead. This creature i wouldn't even trust if I was one of the undead. The liches seems to have an agenda of their own so keep an open eye and make sure they'r doing what theyr told to do. To get this unit you must torture your slaves trough another 24 days of 'training'";
				$type = $this->MilitaryConst->WIZARDS;
				$ticks = 24;
				$cost = array("gold"=>1000, "metal"=>0, "food"=>100);
				$strength = array("attack"=>1, "defense"=>1);
				$this->MilitaryBase($militaryID, "Liches", $info ,$type, $ticks, $cost, $strength);
//				$this->MilitaryBase($militaryID, "Recruits", 12, 300, 0, 50, 1, 1, 0, );
			}

			function scienceRequirements() {
				return array("military" =>1, "infrastructure" => 0, "magic" => 0, "thievery" => 0);
			}

			function pictureFile() {
				return $this->picture;
			}

			function housingRequirements() {
				return true;
			}

			function getHouseConst() {
				$build = new BuildingConstants();
				return $build->WIZARD_HOUSING;
			}

			function raceRequirements() {
				return "Undead";
			}

			function trainFrom() {
				return "Slaves";
			}
			
			function sciReqTxt() {
				$txt = "<ul><b>Knowledge req:</b><br><br><li>Infrastructure: 0<li>Military: 1<li>Magic: 0<li>Thievery: 0<br>&nbsp;";
				return $txt;
			}

		}
		
	}
?>