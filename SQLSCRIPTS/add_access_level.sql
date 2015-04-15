ALTER TABLE `volunteerDatabase`.`Volunteer` 
ADD COLUMN `access_level` INT NOT NULL DEFAULT 2 AFTER `date_of_birth`;

