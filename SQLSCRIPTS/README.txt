========================
===First Time Running===
========================

1. Download .rar file 
2. Extract all files to their intended folders
3. In MySQL Workbench:
    - Create a new local instance using the localhost
    - Import the .sql files into the instance and run the files in this order:
        = Database.sql
        = Data.sql
        = add_access_level.sql
        = update_access_levels.sql
        = addGeorgeForeman.sql
    - Go to the 'Management' tab in the Navigator sidebar and select "Users and Privileges"
    - Create an account with the login name 'webtest' and the password 'robertcollier'
    - Go to the 'Administrative Roles' tab within the Users and Privileges, and check off role 'DBA'
    - Hit 'apply' at the bottom right corner to confirm all these changes. 
3. Start WAMP or WAMP equivalent
    - Note, please ensure that your PHP settings has its 'Display Errors' option unchecked to avoid extraneous debug messages
4. Open up your preferred web browser (For best results please use Google Chrome) and enter in 'localhost/otafest_database/index.php'
5. Upon reaching the login page, you can enter the following to enter:
    - To enter as an administrator, use username '0' and password 'deathtotrees'
    - To enter as an manager, use any username between (and including) 1 and 4 and use password 'manager'
    - To enter as a volunteer, use any username between (and including) 5 and 19 and use password 'volunteer'