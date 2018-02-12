# schalk&friends WordPress Trial work
So, you want to join our awesome WordPress Team?

Here we have a little task for you!

## Mission
1. Fork this Repo into your own Github Account
2. Create a WordPress plugin, that adds a "Lifetime Class" field to the WordPress post
3. The field should be manageable in the admin area while creating/editing a post
4. The field may consist of 3 Values "HOUR", "DAY", "WEEK"
5. When a post is requested via HTTP, the plugin should add a "X-Lifetime-Class" HTTP header with the selected value
6. If no value is set, treat it as "Lifetime Class" = "HOUR"
7. Send us a pull request.

## How we test
* We will clone this repo into an empty WordPress installations plugins folder
* We will enable the plugin in the backend
* We will```curl``` the demo post created during installation.
* We want to see the following:
```
$ curl -I http://localhost:8080/hello-world
HTTP/1.1 200 OK
Host: localhost:8080
Date: Mon, 12 Feb 2018 07:58:40 +0000
Connection: close
X-Powered-By: PHP/7.1.12
X-Lifetime-Class: HOUR
Content-type: text/html; charset=UTF-8
```
* We will review your code approach with our team.

## Rules of engagement
* You can use Google or any other search engine for research
* Installing a third party plugin fullfilling the needs is not allowed, but if you know one, tell us.
* Your code should comply with the [WordPress Coding Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/)
* Write awesome code!
* In case you have any questions you can always get back to us!  
