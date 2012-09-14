<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

class PluginNative_ModuleViewer extends PluginNative_Inherit_ModuleViewer {

	/**
	 * Возвращает ajax переменные
	 *
	 * @return array
	 */
	public function GetVarsAjax() {
		return $this->aVarsAjax;
	}
}
?>