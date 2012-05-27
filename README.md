DB Fetcher
==========

This will fetch the db of a location (no matter how big), then delete the current database, replace it with a copy of the fetched db and then perform any custom SQL actions.

How to Run it
-------------

There are two ways which give the same result:
* Run the update_db_cli.php via a cron
* Run the update_db.php via a web browser

Config Settings
---------------

You need to create three config files in config/
* base_db.php
* target_db.php
* custom_actions.php

Each of these has an *.example.php in the config file.

Logging
--------

This will be added at a later date
