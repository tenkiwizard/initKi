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

class Controller_Talksto_Redmine_About_Gitlab extends Controller
{
	public function post_push($project_id = null, $api_key = null)
	{
		$project_id = $this->override('project_id', $project_id, 'required');
		$api_key = $this->override('api_key', $api_key);

		Talker_Redmine_Changeset::forge($api_key)
			->talk(array('id' => $project_id));
	}
}
