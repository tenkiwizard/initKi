<?php
/**
 * 
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Controller_Asksto_Gitlab_About extends Controller
{
	public function get_users($id = null, $api_key = null)
	{
		$id = $this->override('id', $id);
		$api_key = $this->override('api_key', $api_key);
		$this->response(
			Talker_Gitlab_Users::forge($api_key)->talk(array('id' => $id)));
	}
}
