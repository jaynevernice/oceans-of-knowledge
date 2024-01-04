<?php

	include_once 'dbh.php';

	unset($user_id);
	session_unset();
	session_destroy();
	
	header("Location: index.php");
