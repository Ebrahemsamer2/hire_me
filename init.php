<?php 

include "Models/DB/DBConnection.php";
include "Models/DB/DBManager.php";

include "Models/Session.php";
include "Models/User.php";
include "Models/Job.php";

use \Models\DB\DBManager;
use \Models\Session;
use \Models\User;
use \Models\Job;

$main_title = "Hire Me | Get Hired OR Grow your Team by hiring talents.";
$main_description = "Hire Me | Get Hired OR Grow your Team by hiring talents.";


\Models\Session::start();