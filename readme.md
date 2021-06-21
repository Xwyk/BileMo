# BileMo

This is the 5th project in PHP/Symfony OpenClassroom training.
In this project, an API was created to allow authenticated users to access to a list of mobile phones, accessible by all users and a list of sub-users, proper to each authenticated users.

## Requirements

The above application require following environment :
-   php >= 7.0
-   mysql >= 5.6
-   symfony >= 5.2.5
-   composer >= 2.0.8

## Installation

In this installation guide, it's supposed that you have your environment configured (see requirements)
1.  Download zip and extract it on your server or clone repository from github :
```lang-console
git clone https://github.com/Xwyk/BileMo.git
```
2.  Create your .env.local file from .env present in project's root

3.  Install dependancies
```lang-console
composer install
```

4.  (Optionnal) Init project by injecting default datas. initProject create datatabase, inject datas and install certificate for HTTPS use.
   This create 2 users, "user1" and "user2", with password "user1" and "user2"
```lang-console
composer initProject
```
5.  (Optionnal) In case of prod reset, you can use :
```lang-console
composer reset
```
6.  (Optionnal) In case of test reset, you can use :
```lang-console
composer resetForTests
```