# Archived
This project was written by me in 2015 before I had an formal software training. It was an interesting project at the time and I had fun building it but if I where to ever come back to it I would rewrite the whole project, this is why I am archiving this project.

# Offnet Server

## An SMS interface for the internet.

This is the server software that helps drive Offnet.

The server uses an SMS gateway such as Pilvo to send and recieve SMS messages.
When a message is recieved (As Plain Text or JSON), the Offnet server decodes the request, collects the desired information
from the internet then response with Plain Text or JSON VIA SMS or MMS (Using Email).

[![Support via PayPal](https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg)](https://www.paypal.me/offnet/)

### Demo

[Android App](https://i.imgur.com/LNSiAp3.gif)


[Plain Text](https://i.imgur.com/37hzyeM.gif)

### Features:

The following services can be used VIA SMS/MMS:

*  RSS/News feed reader
*  Dictionary
*  Google Dicrections
*  Weather (Currently being fixed)
*  Wikipedia
*  Any URL (in beta)

### How to install:

1. Install all depenancies
2. Clone the repo
3. Clone all submodules: git clone --recurse-submodules URL
4. Copy default.ini and rename as system.ini
5. Fill out config info
6. Create database with all required tables (/templates)

### Dependancies:

*  apache2
*  mysql-server
*  php
*  libapache2-mod-php
*  php-mysql
*  php-curl
*  phpmyadmin
*  php-mbstring
*  php-gettext


### How Use

Communicate with the number linked to the server via SMS using one of these two formats.
Accounts are automatically generated when a new number texts the server.

#### Plain text request

Application:Param:Param:Param

Example:
```
RSS:CNN:sports:1
```

#### JSON

Example:

```
{
    "s" : "Application"
    "p" {
       "location" : "Halifax, NS"
    }
}
```

### TODO:

*  Write better docs
*  Build auto install script
*  Fix RSS table bug
*  Update weather API
*  Clean up MMS
*  Put more opitions in the config
*  Make dbconn script one file

### Ideas:

*  Move settings to database
*  Make RSS feeds more customizable 
(Read sources from list in database)
(Make reader more generic)
*  Make generic HTML Scraper (Using CSS Selectors)
*  Implement NLP
