# BasicRedis

This is a code piece that can ease the use of Redis with the help of [Predis](https://github.com/nrk/predis)

## Installation

You will need to install [Composer](http://getcomposer.org/) following the instructions on their site.

Then, simply run the following command to install dependencies:


```bash
composer install
```

Then, create a dotenv file and enter and edit the below data.
```dotenv
USER_RETRY_LIMIT=10
USER_RETRY_TIMEOUT=60 # seconds

REDIS_NAME="master"
REDIS_HOST="127.0.0.1"
REDIS_PORT=6379
```

You are ready to use `BasicRedis` class.

Please visit `examples/` folder to see the usage.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[GNU GPLv3](https://choosealicense.com/licenses/gpl-3.0/)