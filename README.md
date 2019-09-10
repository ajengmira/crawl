# php-price-crawler
codeigniter based price crawler using Xpath to crawl ecommerce data.

The ideas for user is:
1. Entry new website
2. Give example url containing product detail consist of name of product and price.
3. Give xpath location for price and name
4. Give starter url to crawl.
5. Get data grow for link and product price summary.

Behind the scene:
We need to put 1 url in cronjob.
1st script is collecting data from the URL

In the end of the day you got bunch of price data.

Prequisite:
1. PHP 5.2 and above
2. Apache or nginx
3. MySQL


How to install:
1. Dump crawl.sql
2. Edit application/config/config.php change the base url to your own.
3. Modify database credential in application/config/database.php
4. Put cron script into cronjob : http://your-host.com/test/cron/  (ideally every 1 hour)

That's for now.
