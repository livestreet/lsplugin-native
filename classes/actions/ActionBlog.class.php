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


class PluginNative_ActionBlog extends PluginNative_Inherit_ActionBlog {

	/**
	 * Регистрация евентов
	 */
	protected function RegisterEvent() {
		$this->AddEvent('addcomment','AddComment');
		parent::RegisterEvent();
	}

	/**
	 * Обработка добавления комментария
	 *
	 * @return mixed
	 */
	protected function AddComment() {
		$this->Security_ValidateSendForm();
		/**
		 * Проверям авторизован ли пользователь
		 */
		if (!$this->User_IsAuthorization()) {
			$this->Message_AddErrorSingle($this->Lang_Get('need_authorization'),$this->Lang_Get('error'));
			return;
		}
		/**
		 * Обработка добавления коммента
		 */
		$this->SubmitComment();
		/**
		 * Переадресуем на страницу топика с якорем на комменте
		 */
		if (!($oTopic=$this->Topic_GetTopicById(getRequest('cmt_target_id')))) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return parent::EventNotFound();
		}
		/**
		 * Достаем ID нового комментария
		 */
		$aVars=$this->Viewer_GetVarsAjax();
		if (isset($aVars['sCommentId'])) {
			$sAnchor='#comment'.$aVars['sCommentId'];
		} else {
			$sAnchor='';
		}
		/**
		 * Регистрируем возможные ошибки в сессии
		 */
		$aErrors=$this->Message_GetError();
		if ($aErrors and isset($aErrors[0])) {
			$this->Message_AddErrorSingle($aErrors[0]['msg'],$aErrors[0]['title'],true);
		}

		Router::Location($oTopic->getUrl().$sAnchor);
		exit();
	}
}
?>