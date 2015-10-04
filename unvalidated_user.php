<?php
require_once('path/to/engine/start.php');
$cutofftime = time() - (7 * 24 * 60 * 60);
$limit = get_input('limit', elgg_get_config('default_limit'));
$offset = get_input('offset', 0);

$ia = elgg_set_ignore_access(TRUE);
$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

$options = array(
    'type' => 'user',
    'wheres' => uservalidationbyemail_get_unvalidated_users_sql_where(),
    'limit' => $limit,
    'offset' => $offset,
    'count' => TRUE,
);
$count = elgg_get_entities($options);

if (!$count) {
    access_show_hidden_entities($hidden_entities);
    elgg_set_ignore_access($ia);

    echo elgg_autop(elgg_echo('uservalidationbyemail:admin:no_unvalidated_users'));
    return TRUE;
}

$options['count']  = FALSE;
$users = elgg_get_entities($options);

foreach($users as $user){
    echo "Name: ".$user->name . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Email ID: ".$user->email . "\n";
    echo "GUID: ". $user->guid . "\n";
    echo "Created Time: ". date("Y-m-d H:i:s",$user->time_created) . "\n";
    $guid = $user->guid;
    $usr = get_entity($guid);
    $createtime = $user->time_created;
    $is_validated = elgg_get_user_validation_status($guid);
    echo "Action: ";
    if($createtime <= $cutofftime) {
        if ($is_validated !== FALSE || !$usr->delete()) {
            echo elgg_echo('uservalidationbyemail:errors:could_not_delete_user');
        }else{
            echo elgg_echo('uservalidationbyemail:messages:deleted_user');
        }
    }else{
        if ($is_validated !== FALSE || !uservalidationbyemail_request_validation($guid)) {
            echo elgg_echo('uservalidationbyemail:errors:could_not_resend_validation');
        }else{
            echo elgg_echo('uservalidationbyemail:messages:resent_validation');
        }
    }
    echo "\n\n";
}
?>
