# Estore Demo API

A API for inventory managment built for managing products of Estore. Developed using Symfony 4,Doctrine, Mysql and the API Platform. Deployed in Docker.

Main Symfony 4 Packages Used
==================================
- The API Platform - For API Development 
  - Used Annotations for access control
- Doctrine ORM
- LexikJWTAuthenticationBundle - Used JWT authentication for some end points.
  - I have used "name" provided in sample json file to generate username and password. eg: John Smith will create username John_Smith and 
    password as John_Smith  
- Monolog - Used for logging messages
- PHPUnit
  - Unit test cases for API token generation 
  
