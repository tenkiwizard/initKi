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

class Controller_Asksto_Gitlab_About_Users extends \Initki\Controller_Restful
{
	public function get_index($id = null, $api_key = null)
	{
		$this->response(Talker_Gitlab_Users::forge($api_key)->talk());
	}
}
