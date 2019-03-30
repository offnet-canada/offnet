<?php
//Secound copy of script used to auto update RSS feeds
require "../core/core.php";
require "rss.php";
\Apps\Rss::updateAll();
