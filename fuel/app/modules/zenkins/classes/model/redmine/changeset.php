<?php
/**
 * Redmine changeset model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Redmine_Changeset extends Model_Redmine
{
	const CONFIG_KEY_NAME = 'fetch_changesets_key';

	protected static $_table_name = 'sys/fetch_changesets';
}
