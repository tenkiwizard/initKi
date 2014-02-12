<?php
/**
 * GitLab mergerequest listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Gitlab_Mergerequest extends Listener_Gitlab
{
	protected function things()
	{
		return \Input::json()['object_attributes'];
	}
}
