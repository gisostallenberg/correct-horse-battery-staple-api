# correct-horse-battery-staple-api
Microservice for the password strength checker 'correct-horse-battery-staple'

## Usage examples
### Example 1
#### Request
```bash
curl -d "correcthorsebatterystaple" https://mypasswordchecker.com/
```
#### Response
```json
{"status":0,"message":"OK"}
```

### Example 2
#### Request
```bash
curl -d "123456" https://mypasswordchecker.com/
```
#### Response
```json
{"status":109,"message":"it is too simplistic\/systematic"}
```

### Example 3
#### Request
```bash
curl -d "correcthorsebatterystaple" http://mypasswordchecker.com/
```
#### Response
```json
{"status":-1,"message":"Only secure connections allowed"}
```
