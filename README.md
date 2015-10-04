# Elgg-Unvalidated-Users

Code for automatic "Resend validation" and "Delete" for unvalidated users


Before starting the article just a small noted to everyone, "uservalidationbyemail" plugin is required and should be enabled for the script to work.


Here's what the script does:

1. Send validation mail to all the user who have registered in the past 7 days and have not validated their email ID yet.

2. Delete all the unvalidated users who have not validated their email IDs for more than 7 days.


Step 1: Save the following source code to a an php file (Example: unvalidated_users.php") 


Step 2: Now Configure your script

a. Set path of your start.php file at line 2: require_once('path/to/engine/start.php');

b. Set the cutofftime at line 3 that will delete the unvalidated user beyond that time. For me its 7 days (7 * 24 * 60 * 60);


Step 3: Save the file and configure your cronjob.

0 0 * * * /usr/bin/curl www.domain.com/path/to/your/file/unvalidated_users.php


Step 4: You are all set. Now sit back and let the script do all the work.
