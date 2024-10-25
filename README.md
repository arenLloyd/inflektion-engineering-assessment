# inflektion-engineering-assignment
## _Setup Guide_
After cloning, please follow these:

## Database setup

On the project folder, update ```.env``` file. To match the database locally.

```sh
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
After the Database connection setup, verify if can connect successfully using this command.
```sh
php artisan migrate
```

## Hourly email extraction setup
1. Open the crontab file by running the following command in your terminal:
```sh
crontab -e
```
2. Add the following line to your crontab file (_/raw-email/extractor is where the file is located_):
```sh
* * * * * php /raw-email/extractor schedule:run >> /dev/null 2>&1
```
After the Cron job setup, verify if it works successfully.
```sh
php artisan emails:extract-email
```

## Program running/deployment
To run the program. Go to the project folder and input this command
```sh
php artisan serve
```

## API Endpoints

Store
This endpoint will create a new record in the successful_emails table and automatically parse it with the method above.
```sh
POST /successful-emails/storeEmail
```
Request:
```yaml
{
   "affiliate_id": "affiliate id",
    "envelope": "envelope",
    "from": "email from",
    "subject": "email subject",
    "dkim": "dkim",
    "SPF": "SPF",
    "spam_score": "spam score",
    "email": "email body",
    "sender_ip": "ip address",
    "to": "email",
    "timestamp": "timestamp"
}
```

Get by ID
This endpoint will fetch a single record by ID.
```sh
GET /successful-emails/getEmailById/{id}
```

Update By ID
This endpoint will update a single record based on the ID passed.
```sh
PUT successful-emails/updateEmail/{id}
```
Request:
```yaml
{
   "affiliate_id": "affiliate id",
    "envelope": "envelope",
    "from": "email from",
    "subject": "email subject",
    "dkim": "dkim",
    "SPF": "SPF",
    "spam_score": "spam score",
    "email": "email body",
    "raw_text": "raw email body",
    "sender_ip": "ip address",
    "to": "email",
    "timestamp": "timestamp"
}
```

Get All
This endpoint will return all records excluding deleted items. Pagination is optional.
```sh
GET /successful-emails/getAllEmails
```

Delete by ID
This endpoint will delete a record based on the ID passed. The delete should only be a soft delete and should not erase data from the database.
```sh
DELETE /successful-emails/deleteEmailById/{id}
```

Get CSRF Token
This endpoint will return a CSRF token to add on the headers for these API endpoints: Delete by ID, Update By ID and Store
```sh
GET /csrf-token
```
