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

class Controller_Talksto_Redmine_About_Gitlab extends \Initki\Controller_Restful
{
	public function get_index()
	{
		//
	}

	public function post_push($project_id = null, $api_key = null)
	{
		if ($project_id === null)
		{
			$project_id = \Input::get('project_id');
		}

		if ($api_key === null)
		{
			$api_key = \Input::get('api_key');
		}

		if ( ! $project_id)
		{
			throw new \HttpNotFoundException();
		}

		Talker_Redmine_Changeset::forge($api_key)
			->talk(array('id' => $project_id));
	}
}
