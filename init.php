<?php 

include "Models/DB/DBConnection.php";
include "Models/DB/DBManager.php";

include "Models/Session.php";
include "Models/User.php";
include "Models/Category.php";
include "Models/Job.php";
include "Models/JobUser.php";
include "Models/Contact.php";

use \Models\DB\DBManager;
use \Models\Session;
use \Models\User;
use \Models\Category;
use \Models\Job;
use \Models\JobUser;
use \Models\Contact;

$main_title = "Hire Me | Get Hired OR Grow your Team by hiring talents.";
$main_description = "Hire Me | Get Hired OR Grow your Team by hiring talents.";


\Models\Session::start();