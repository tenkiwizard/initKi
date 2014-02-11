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

class Controller_Talksto_Chatwork_About_Gitlab extends Controller
{
	public function before()
	{
		parent::before();
		\Lang::load('zenkins::vocabulary');
	}

	public function post_push($room_id = null, $api_key = null)
	{
		$room_id = $this->override('room_id', $room_id, 'required');
		$api_key = $this->override('api_key', $api_key);

		$things = Listener_Gitlab_Push::forge()->listen();

		\Debug::dump($things);

		$body = __('gitlab.push', array(
			'user_name' => \Arr::get($things, 'user_name'),
			'repository.name' => \Arr::get($things, 'repository.name'),
			'repository.homepage' => \Arr::get($things, 'repository.homepage'),
			'before' => \Arr::get($things, 'before'),
			'after' => \Arr::get($things, 'after'),
			));

		\Debug::dump($body);exit;

		Talker_Chatwork::forge($api_key)
			->talk(array(
				'root_id' => $room_id,
				'body' => $body,
				));
	}

}
