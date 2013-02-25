php-desk
========

PHP client for [Desk.com](http://desk.com) API, based on [Guzzle](http://guzzlephp.org)


Getting Started
---------------

Here's how to run the tests:

```
git clone https://github.com/bradfeehan/php-desk.git
cd php-desk
composer install --dev
vendor/bin/phpunit
```

You can also run "network" tests (which actually access the real Desk.com API) by making a few more changes:

1. Copy `phpunit.xml.dist` to `phpunit.xml`
2. Edit `phpunit.xml` and uncomment the `<server name="DESK_TEST_CONFIG" value="tests/service/test.json" />` line
3. Create `tests/service/test.json` and add some more detailed service builder configuration 
   in here. The file can be JSON or PHP (depending on its extension) as described in the [Guzzle docs][1]. For example:

[1]: <http://guzzlephp.org/tour/using_services.html>

```
{
	"includes": ["mock.json"],
	"services": {
		"test": {
			"params": {
				"subdomain": "my_desk_subdomain",
				"consumer_key": "xxxxxxxxxxxxxxxxxxxx",
				"consumer_secret": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
				"token": "xxxxxxxxxxxxxxxxxxxx",
				"token_secret": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
			}
		},
		"test.account": {
			"class": "Desk\\Account\\AccountClient",
			"extends": "test"
		}
	// ...
	}
}
```

Now, you can run the network test group:

```
vendor/bin/phpunit --group network
```

This will use services starting with `test.`, in the form `test.account` instead of `mock.account`.
