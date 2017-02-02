# roadsec-web-1

Steps:
Clone
Change FLAG value in Dockerfile

$ docker-compose build
$ docker-compose up web mongo

Create admin user on mongodb
$ docker exec -it roadsecweb1_mongo_1 mongo hackaflag
> db.users.insertOne({user:"admin", pass:"bfe7dc0d4bf2f0b83ad0a9e04f0bf0d"})

Maybe you have to run phantomJS (Have to fix this)
$ docker exec -d -t roadsecweb1_web_1 /root/phantomjs /root/bot.js

Video solution:
https://www.youtube.com/watch?v=iMdMtbKmvzc
