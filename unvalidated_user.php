<?php
require_once('path/to/engine/start.php');

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
    echo $user->guid;            // User GUID
    echo $user->time_created;    // Time Created (Unix Timestamp)
    echo $user->name;            // Name
    echo $user->username;        // User Name
    echo $user->email;           // Email
}

?>
