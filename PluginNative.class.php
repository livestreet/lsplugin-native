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

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attempt!');
}

class PluginNative extends Plugin {

	protected $aInherits=array(
		'action' =>array('ActionAjax','ActionBlog'),
		'module' =>array('ModuleViewer'),
	);

	/**
	 * Активация плагина
	 */
	public function Activate() {
		return true;
	}

	/**
	 * Инициализация плагина
	 */
	public function Init() {
		$this->Viewer_AppendScript(Plugin::GetWebPath(__CLASS__) . 'js/main.js?v=1.2.1');
	}
}
?>