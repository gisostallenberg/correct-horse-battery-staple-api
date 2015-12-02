# correct-horse-battery-staple-api
Microservice for the password strength checker 'correct-horse-battery-staple'

## Usage examples
### Example 1
**Request**
```bash
curl -d "correcthorsebatterystaple" https://mypasswordchecker.com/
```
**Response**
```json
{"status":0,"message":"OK"}
```


### Example 2
**Request**
```bash
curl -d "123456" https://mypasswordchecker.com/
```
**Response**
```json
{"status":109,"message":"it is too simplistic\/systematic"}
```


### Example 3
**Request**
```bash
curl -d "correcthorsebatterystaple" http://mypasswordchecker.com/
```
**Response**
```json
{"status":-1,"message":"Only secure connections allowed"}
```

## Possible status codes in json
* 0, OK
* -1, error
* 1, unknown
* 100, it does not contain enough DIFFERENT characters
* 101, it is all whitespace
* 102, it is based on a (reversed) dictionary word
* 103, it is based on a dictionary word
* 104, it is based on your username
* 105, it is based upon your password entry
* 106, it is derivable from your password entry
* 107, it is derived from your password entry
* 108, it is too short
* 109, it is too simplistic/systematic
* 110, it is WAY too short
* 111, you are not registered in the password file
