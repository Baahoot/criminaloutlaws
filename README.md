Criminal Outlaws (Open Source) PHP Game Engine
====================

**Criminal Outlaws** is a PHP online text based game built on top of CodeIgniter. This engine was built by me in 2010 summer when I launched my online game, CriminalOutlaws.com and it has been used to power an online game reaching thousands of players.

The engine was built entirely from scratch, and it **does not have any documentation**. Though CodeIgniter's documentation is very extensive, and my code is built to adhere them, it makes it much easier hence why I decided to release it as it may be useful to someone.

As I'm very busy at the moment and cannot continue the online game or the source code, I would love the community to implement changes and help document it for others. I will accept community changes provided they are reasonable.

Installation
---------------------
Step 1: Download CodeIgniter from codeigniter.com
Step 2: Replace /application folder from CodeIgniter to the one in this repository
Step 3: Insert /static folder into CodeIgniter installation
Step 4: Create MySQL database and import schema.sql file into it
Step 5: Update /application/config files with respective data (MySQL database only required; others are optional)
Step 6: Installation complete!
 
Notes
---------------------
- Redis is installed, but is installed due to performance issues
- URLs may need to be updated from criminaloutlaws.com in some places
- Code is not documented; we would appreciate any contributions
- MySQL data is included such as items, courses, crimes, etc.
- Facebook Connect is installed, but you need to configure it with your FB app id, secret, etc in /application/config/facebook.php
- Rackspace Cloud is installed for CDN, but is disabled by default
- nginx.conf is the nginx configuration for Criminal Outlaws, and htaccess (rename to .htaccess) for Apache

And, finally, if you need me for help with the code or installation, tweet me @bilawalhameed