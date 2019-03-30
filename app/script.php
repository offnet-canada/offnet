<?php
//Set this up on a cron to auto update RSS feeds
require "/home/offnet/public_html/offnet/core/core.php";
require "/home/offnet/public_html/offnet/app/apps/RSS/rss.php";
\Apps\Rss::updateAll();
