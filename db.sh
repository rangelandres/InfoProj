#!/bin/sh

# Change DBPASSWORD, DBUSER, DBHOST and DBNAME to match the values
# your mysql_db_info file on the webdev server.
mysql --password='5zgnHEUfvtGe' --user='arangl' --host='dbdev.cs.uiowa.edu' 'db_arangl'
