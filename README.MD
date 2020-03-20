# Nylas 2.1 API SDK
A PHP SDK for the Nylas API.

A big thank you to the following resources which helped clarify the process of building this PHP SDK:

- [Nylas Documentation](https://docs.nylas.com/docs/quickstart-node)
- [How to write a SDK for our REST API? Best Practices?](https://www.reddit.com/r/PHP/comments/40u74q/how_to_write_a_sdk_for_our_rest_api_best_practices/)
- [lanlin's Nylas PHP SDK](https://github.com/lanlin/nylas-php)

# Getting Started
The SDK is broken up into four main parts:

- **Nylas:** The main nylas object representing the Nylas client account details. 
- **Services:** Different services that can be called such as Account, Messages, Threads, Webhooks, etc.
- **Collections:** An object returned by a Service when one is fetching a collection of resources.
- **Resource:** An Object that wraps the objects returned in a Collection or as single object response as a result of calling the Nylas API.

## Creating your Client Instance
Once you have set up your account with Nylas, following the instructions at 
[Getting Started](https://docs.nylas.com/docs/getting-started), get your Client ID and 
Client Secret.

```php
$nylas = new Nylas([client id], [client_secret]);
```

The client is your basic wrapper for calling the API. Each endpoint of the API can be called through one of the 
provided services in this SDK. Each service groups a set of endpoints dealing with a resource. I.E. `Messages` has 
methods for calling the `/messages/*` related Nylas API endpoints. 

To retrieve a service, call the service on the Client and it will return an instance of that service, configured with 
the client, and you can then use one its methods to call the Nylas API. 

For example, to get the Messages service, do the following:

```php
$messages = $nylas->Messages();
``` 

## Using a Service to call the Nylas API
Continuing with the some example calls, you can perform the relevant calls to the Nylas enpoints using a simple
CRUD based method structure which all the Services generally have. (See each Service class to understand what methods are 
available and their signatures)

Get all messages: 
```
$nylas->Messages()->getMessages([array of filters]);
```

Get a message: 
```
$nylas->Messages()->getMessage('[message_id]');
```

Create a draft:
```
$nylas->Drafts()->createDraft([...to name+email pairs], [...from name+email pairs], '[subject]', 'message body');
```

Delete a draft:
```
$nylas->Drafts()->deleteDraft('[draft_id]');
```

Send a draft:
```
$nylas->Send()->sendDraft('[draft_id]', '[version]');
```

Send a direct draft/message:
```
$nylas->Send()->sendDirect([...to name+email pairs], [...from name+email pairs], '[subject]', 'message body');
```

Each of the methods, based on the type of call, will return either:

- Collection of Resource objects (which can be looped over using `foreach ($collection->items() as $item)`. `$item` would be a corresponding Resource type.
- Specific Resource type
- bool true if the request as a single action like with the HTTP verb `delete`

# To do

The following needs to be completed:

1) Add Thread Service and Resource
1) Add Message modify
1) Add get raw message
1) Add Folder Service and Resource
1) Add Labels Service and Resource
1) Add Calendars Service and Resource
1) Add Events Service and Resource
1) Add Contacts Service and Resource
1) Add Search Service
1) Add Long Polling Delta updates
1) Add Streaming Delta updates
