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

require_once ("../scripts/globals.inc.php");
require_once ($GLOBALS['path_www_scripts'] . "Database.class.inc.php");
require_once ($GLOBALS['path_www_scripts'] . "User.class.inc.php");
require_once ($GLOBALS['path_www_administration'] . "admin_all.inc.php");
require_once ($GLOBALS['path_www_administration'] . "Div.class.inc.php");
require_once ($GLOBALS['path_www_scripts'] . "isLoggedOn.inc.php");
require_once ("requireLogon.inc.php");
require_once ("GameInfo.class.inc.php");

if ((intval($GLOBALS['user']->access) & $GLOBALS['constants']->USER_GAME_ADMIN) ) 
	$info = new GameInfo($GLOBALS['database']);
else die("tkoc.net");
//var_export($info);

$html = '<table cellpadding=5; cellspacing=0; border=0; style="width:100%">
			<TR class="subtitle"><TD class="TL">Province/User:</TD><TD class="TLR">Kingdom</TD></TR>
			<TR bgcolor=#CCCCCC>
				<!-- Province details -->
				<TD class="TL">
				'.$info->showProvinceInfo().'
				</TD>
				<TD class="TLR">
				'.$info->showKingdomInfo().'
				</TD>
			</TR>
			<TR class="subtitle"><TD colspan=2 class="TLR">History:</TD></TR>
			<TR bgcolor=#CCCCCC>
				<!-- Province details -->
				<TD class="TLRB" colspan=2>
				'.showHistory().'
				</TD>
			</TR>
		</table>
';
AdminTemplateDisplay("Game Information",$user,$html);
function showHistory()
{
	$GLOBALS['database']->query("SELECT ID, Age, Provinces, Logins, Tick, ServerStatus, Heroes from Log where Tick='".($GLOBALS['config']['ticks']-1)."' order by Age");	

//	print_r($GLOBALS);
	$lastage=0;
	$html = "<table border=1>\n";
	$html .= '<TR><TH>LogID</TH><TH>Tick</TH><TH>Age</TH><TH>Provinces</TH><TH>Change</TH><TH>Logins</TH></TR>';
	while (($row=$GLOBALS['database']->fetchArray()))
	{
		$html .= "<tr>";
		$html .= "<td>". $row['ID'] ."</td>";
		$html .= "<td>". $row['Tick'] ."</td>";
		$html .= "<td>". $row['Age'] ."</td>";
		$html .= "<td>". $row['Provinces'] ."</td>";
		$html .= "<td>". ($row['Provinces'] - $lastage) ."</td>";
		$html .= "<td>". ($row['Logins']) ."</td>";
//		$html .= "<td>". $row['Age'] ."</td>";
		$html .= "</tr>";
		$lastage = $row['Provinces'];

	}	
	$html .= "</table>\n";

	$html .= '<img src="test.php?Age='.$GLOBALS['config']['age'].'">stats</img>';
	
	return $html;
}
?>