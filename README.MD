# Nylas 2.0 API SDK
A PHP SDK for the Nylas API

# Installation
Install the sdk using composer

```
composer required fndry/nylas
```

# Getting Started
The SDK is broken up into four main parts:

- **Client:** The main client that is configured with your Nylas client account details. 
- **Services:** Different services that can be called such as Account, Messages, Threads, Webhooks, etc.
- **Collections:** An object returned by a Service when one is fetching a collection of resources.
- **Resources:** Objects that wrap the objects returned in a Collection as a result of calling the Nylas API.

## Creating your Client Instance
Once you have set up your account with Nylas, following there instructions at 
[https://docs.nylas.com/docs/getting-started](https://docs.nylas.com/docs/getting-started), get your Client ID and 
Client Secret.

```php
$Nylas = new Client([client id], [client_secret]);
```

The client is your basic wrapper for calling the API. Each endpoint of the API can be called through one of the 
provided services in this SDK. Each service groups a set of endpoints dealing with a resource. I.E. `Messages` has 
methods for calling the `/messages/*` related Nylas API endpoints. 

To retrieve a service, call the service on the Client and it will return an instance of that service, configured with 
the client, and you can then use one its methods to call the Nylas API. 

For example, to get the Messages service, do the following:

```php
$Messages = $Nylas->Messages();
``` 

## Using a Service to call the Nylas API



# To do
