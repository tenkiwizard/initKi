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

        if ( ! $api_key or ! $project_id)
        {
            throw new \HttpNotFoundException();
        }

        //\Debug::dump(Listener_Gitlab_Push::forge()->get('project_id'));
        Talker_Redmine_Changeset::forge('nzbNgURmarSMM3Qi7bL6')->talk(array('id' => 'il-tools'))
        exit;
    }
}
