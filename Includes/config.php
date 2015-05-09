<?php
//defined constants for connection
defined("DB_SERVER") ? null:define("DB_SERVER","localhost");
defined("DB_USER")   ? null:define("DB_USER","root");
defined("DB_PASS")   ? null:define("DB_PASS","");
defined("DB_NAME")   ? null:define("DB_NAME","kolaci");
 defined("DB_DSN")   ? null:define("DB_DSN",'mysql:host=DB_SERVER;dbname=DB_NAME;charset=utf8');
//defined constant for error mod
defined("TEST_MOD")  ? null:define("TEST_MOD",FALSE);




?>