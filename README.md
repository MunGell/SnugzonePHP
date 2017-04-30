# Snugzone API Client

Snugzone is a small heating company based in Dublin.

It has a mobile application and a website to top-up and control your heating account.
This API wrapper allows you to login and use some basic functionality of their API.

## Available methods

* `login(email, username, token)`
* `getInformation()`
* `getStatistics()`
* `getRemoteControl()`
* `setRemoteControl()`

## Token

Token for your account is SHA1 hash of your account password.

## License

MIT
