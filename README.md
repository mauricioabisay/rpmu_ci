# RPM UPAEP CodeIgniter #

### Introduction

RPM (Research Project Management) UPAEP, it's a piece of software developed to help share current research projects both developed and under development by the Universidad Popular Autonoma del Estado de Puebla.

It is compose of 2 main parts:

- Public, available to all public
- Admin, available only to the University faculty members

The project is a final presentation to comply with the requirements needed to comclude the Web Development course of 2018.

### Requirements

PHP >= 5.6

MySQL >= 5.5

Apache >= 2

### Setup

#### Basic

To continue/contribute to project development you will need:

- Docker
- Docker Compose
- NodeJS and npm (both optional)

Clone the project.

First you have to install all PHP dependencies. So after installing docker and docker compose you should run the command:

`docker run --rm --volume $PWD:/app composer install`

Then update the application/config.php file, it must have 1 extra variable:

`$config['google_oauth'] //this is the Google Auth key that allows you to get info from gmail accounts`

If this variable is missing the admin part will not work, since you will not be able to login. 

Enter docker MySQL container:

`docker ps`
`docker exec -it <mysql container id> bash`

And run command:

`mysql -u root -p ci<bu.sql` 

The .sql file contains the database structure and some dummy data.

Also, for development, you have to add a new "ADMIN" user via command line in MySQL, it must have a valid gmail account.

After that you may run:

`docker-compose build`

Then

`docker-compose run`

And you are all set to code.

#### Extra

For a more smooth development experience you can use the Gulp workflow included with the project. For this you need to install NodeJS and npm.

Then run the command

`npm install`

After the dependencies have been installed, run

`gulp`

And that is it.

Remember the gulp server runs on port 3001, take a close look to browsers URL after logging in and out from the admin dashboard.

The project sass and js files are and should be placed on the `resources/_dev` folder, either in public or admin subfolders, accordingly

### Contact

If you are in doubts give me a ring at:

mauricioabisay.lopez@gmail.com