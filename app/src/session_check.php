<?php
	
if (session_status() == PHP_SESSION_NONE) { // check if session already started
    session_start();
};
