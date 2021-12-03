## The French Web Scrapper

This is a short php command that I wrote to scrap the french letters and sounds
from https://www.rocketlanguages.com/french/lessons/french-alphabet in order to get the data that I needed to work on a
mobile application to make it easy to learn french

## Get started

### Setting up locally

- Set up a database with a database table

CREATE TABLE `vowels` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(200) DEFAULT NULL,
`description` varchar(200) DEFAULT NULL,
`filename` varchar(200) DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`deleted_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

- Clone the repo run -> git clone https://github.com/margaretmwaura/WebScrapper.git
- Run composer install to install the vendor packages
- Run php artisan scrape_french_info in your virtual environment to get the data from the website

### Accessing production

- The app is now hosted in production using AWS Lamda.
- The data is now saved in AWS RDS whenever it is cloned allowing it to be accessed via the api gateway.
- The audio files are saved in AWS s3 buckets.

Below are resources that I used to do the setup.

https://www.youtube.com/watch?v=rWExnXzUBqc

https://www.youtube.com/watch?v=Ng_zi11N4_c

-To scrap the data hit https://yc5l3py01m.execute-api.us-east-2.amazonaws.com/dev/api/get_data

-To get the vowels hit https://yc5l3py01m.execute-api.us-east-2.amazonaws.com/dev/api/french_words

-To get an audio file for a vowel
hit https://yc5l3py01m.execute-api.us-east-2.amazonaws.com/dev/api/audio?filename=151831-1.6.a-normalized.mp3 while
passing the audio file name. Important to note is that the audio file will be decoded hence one will need to encode it
in order to access it

### Saving of audio files

- When running on local the audio files will be saved in ones local storage
