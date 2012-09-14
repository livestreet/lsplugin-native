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
 * Основной модуль плагина
 */
class PluginNative_ModuleMain extends Module {

	const REQUEST_DATA_STATUS_NEW=1;
	const REQUEST_DATA_STATUS_READY_LOAD=2;

	public function Init() {

	}

	/**
	 * Сохраняет в сессию данные реквестов
	 *
	 * @param   string   $sPath
	 * @param null|array $aData
	 */
	public function SaveRequestData($sPath,$aData=null) {
		if (is_null($aData)) {
			$aData=array(
				'post' => $_POST,
				'get' => $_GET,
				'path' => $sPath,
				'status' => PluginNative_ModuleMain::REQUEST_DATA_STATUS_NEW,
			);
		}
		$this->Session_Set('store_request_data',$aData);
	}
	/**
	 * Удаляет из сессии даные реквестов
	 */
	public function DeleteRequestData() {
		$this->Session_Drop('store_request_data');
	}
	/**
	 * Загружает из сессии даные реквестов
	 *
	 * @param bool $bRewrite	Переписывать или нет текущий реквест
	 *
	 * @return bool
	 */
	public function LoadRequestData($bRewrite=false) {
		$aData=$this->Session_Get('store_request_data');
		if ($aData) {
			if ($bRewrite) {
				if (isset($aData['status']) and $aData['status']==PluginNative_ModuleMain::REQUEST_DATA_STATUS_READY_LOAD) {
					if (isset($aData['post'])) {
						$_POST=$aData['post'];
					}
					if (isset($aData['get'])) {
						$_GET=$aData['get'];
					}
					if (isset($aData['get']) and isset($aData['post'])) {
						$_REQUEST=array_merge($_POST,$_GET);
					}
				} else {
					return false;
				}
			}
			return $aData;
		}
		return false;
	}
	/**
	 * Проверяет необходимость перезаписи реквеста
	 *
	 * @param bool $bRedirect	Выполнять редирект или возвращать путь
	 *
	 * @return bool
	 */
	public function CheckRewriteRequest($bRedirect=true) {
		if ($aData=$this->LoadRequestData() and isset($aData['status'])) {
			if ($aData['status']==PluginNative_ModuleMain::REQUEST_DATA_STATUS_NEW) {
				$aData['status']=PluginNative_ModuleMain::REQUEST_DATA_STATUS_READY_LOAD;
				$this->SaveRequestData(null,$aData);
				if (isset($aData['path'])) {
					if ($bRedirect) {
						func_header_location($aData['path']);
					} else {
						return $aData['path'];
					}
				}
			} elseif ($aData['status']==PluginNative_ModuleMain::REQUEST_DATA_STATUS_READY_LOAD) {
				if ($this->LoadRequestData(true)) {
					$this->DeleteRequestData();
				}
			}
		}
		return false;
	}
}
?>