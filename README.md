# Project Setup

Basic project start up. Initialise with admin database and some modules ready to use. 

# Steps to follow

 1. Please fire below command on terminal on ROOT folder of project

	 `composer install`
	 
 2. Give permission to storage folder on root folder of project
 
	  `sudo chmod -R 777 storage/`

 3. Create a database
 4. Set database details in .env file
 5. Create database structure by fire a below command on ROOT folder of project
 
	 `php artisan migrate`

 6.  For initial records, Please fire below command  
 
	 `php artisan db:seed`

 7. Below are admin details : from ROOT folder
 
	 URL : /admin

	 Email : webclues.superadmn@gmail.com
	 
	 Password : testadmin
	 
