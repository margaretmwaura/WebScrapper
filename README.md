## The French Web Scrapper

This is a short php command that I wrote to scrap the french letters and sounds from https://www.rocketlanguages.com/french/lessons/french-alphabet in order to get the data that I needed to work on a mobile application to make it easy to learn french

## Get started
- Set up a database with a database table


   CREATE TABLE `vowels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;


- Clone the repo run -> git clone https://github.com/margaretmwaura/WebScrapper.git
- Run composer install to install the vendor packages
- Run php artisan scrape_french_info in your virtual environment to get the data from the website
