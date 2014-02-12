<?php

return array(
	'gitlab' => array(
		'push' =>
			"■Pushが発生しました\n".
			"した人：:user_name\n".
			"対象リポジトリ：:repository.name\n".
			"差分を見る：:repository.homepage/compare/:before...:after",
		'mergerequest' =>
			"■Merge Request【!:iid :title】が :state になりました\n".
			"した人：:author_id\n".
			"された人：:assignee_id\n".
			":source_project_id :source_branch → :target_project_id :target_branch\n".
			"マージステータス（って何？）は :merge_status です。\n".
			"差分を見る：未実装\n".
			"コメント：\n".
			"--------------------\n".
			":description\n".
			"--------------------",
	),
);
