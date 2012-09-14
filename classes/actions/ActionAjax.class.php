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
 * Экшен обработки ajax запросов
 * Ответ отдает в JSON фомате
 *
 * @package actions
 * @since 1.0
 */
class PluginNative_ActionAjax extends PluginNative_Inherit_ActionAjax {

	/**
	 * Регистрация евентов
	 */
	protected function RegisterEvent() {
		parent::RegisterEvent();

		$this->AddEventPreg('/^native/i','/^request/','/^save/','EventNativeRequestSave');
	}

	/**
	 * Сохранение реквеста
	 *
	 * @return bool
	 */
	protected function EventNativeRequestSave() {
		/**
		 * Сохранить реквест даем только гостям
		 */
		if ($this->oUserCurrent) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return false;
		}
		/**
		 * Получаем путь для обратного редиректа
		 */
		if (getRequest('sRequestSavePath')) {
			$this->PluginNative_Main_SaveRequestData(getRequest('sRequestSavePath'));
		} else {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
			return false;
		}
		return true;
	}
}
?>