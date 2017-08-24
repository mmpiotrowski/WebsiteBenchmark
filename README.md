# WebsiteBenchmark
PHP Website Benchmark - console tool for comprasion page loading time

## Requirements:
- Composer to install and loads dependencies 


## How to install:
- clone or download repo
- use composer install dependencies (PHPMailer,Config_Lite)
- check benchmark shell script is executable

## Before use check configure file config (config/config.ini):
- complete email section

## Use example:
./benchmark subject_website_url competitors_website_url

or

./benchmark subject_website_url competitor_website_url,competitor2_website_url,competitor3_website_url

or

./benchmark competitor_website_url subject_website_url competitor_website_url competitor2_website_url 

With default config file, the results will be in:
- console output
- log file (logs/log.txt)
- send to email (if email config is properly)

## Notes:
You can easily modified outputs by changing config callbacks in benchmark section:
- Console - console outputs,
- Logs - logs outps,
- Email - email outs

You can also created own callbacks classes see source ConsoleCallbacks or EmailCallbacks source for example



