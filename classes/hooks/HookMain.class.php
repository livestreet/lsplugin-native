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

class PluginNative_HookMain extends Hook {
	/**
	 * Текущий пользователь
	 *
	 * @var null
	 */
	protected $oUserCurrent=null;

	public function __construct() {
		$this->oUserCurrent=$this->User_GetUserCurrent();
	}

	/**
	 * Регистрируем хуки
	 */
	public function RegisterHook() {
		$this->AddHook('init_action', 'InitAction',__CLASS__,10000);
		$this->AddHook('template_comment_tree_end','InjectCommentForm');
		$this->AddHook('template_html_head_end', 'InjectHeader');
	}
	/**
	 * Действия при инициализации
	 */
	public function InitAction() {
		if (!$this->oUserCurrent) {
			$this->Lang_AddMessage('comment_unregistered','');
			$this->Viewer_Assign('aLang',$this->Lang_GetLangMsg());
		}

		if ($this->oUserCurrent) {
			$this->PluginNative_Main_CheckRewriteRequest(true);
		}
	}
	/**
	 * Добавляем форму для добавления комментария
	 *
	 * @param $aVar
	 *
	 * @return string
	 */
	public function InjectCommentForm($aVar) {
		if (!$this->oUserCurrent) {
			$this->Viewer_Assign('iTargetId',isset($aVar['iTargetId']) ? $aVar['iTargetId'] : false);
			$this->Viewer_Assign('sTargetType',isset($aVar['sTargetType']) ? $aVar['sTargetType'] : false);
			return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.comment.form.tpl');
		}
		return '';
	}
	/**
	 * Прогружаем значение JS переменных
	 */
	public function InjectHeader() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.header.tpl');
	}

}
?>