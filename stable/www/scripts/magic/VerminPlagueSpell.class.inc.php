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

/* VerminPlagueSpell class is the class of a spell, derived from SpellBase.
 *
 * Author: �ystein Fladby 28.04.2003
 * 
 * Changelog:
 *
 * Version: 1.0
 * 
 */
 
require_once( "SpellBase.class.inc.php" );
if( !class_exists( "VerminPlagueSpell" ) ) {

class VerminPlagueSpell extends SpellBase {
	var $addFoodIncome = -15;		// give  less food income each tick
	var $raceReq = array( "Undead" ); // this spell is available to
	var $mana = 5;
	var $costPeasants = 0.05;
	
	function VerminPlagueSpell( $sID ) {
		$this->SpellBase( 	$sID, 									// spell ID
							"Vermin plague",						// name
							1,						// gold cost pr acre
							1,						// metal cost pr acre
							0,						// food cost pr acre
							0.20,					// needed wizards pr acre
							1,					// cast on enemies
							1,					// type indirect
							"Vermin plague gives the target ".abs($this->addFoodIncome)."% less
							food than usual each tick. Only undead may cast this spell.",	// description
							false);									// picture
	}	
	function getNeededMana() {
		return $this->mana;
	}
	function addFoodIncome () {
		return $this->addFoodIncome;
	}
	function raceRequirements() {
		return $this->raceReq;
	}
	function getCostPeasants() {
		return $this->costPeasants;
	}
}
} // end if ! class exists
?>