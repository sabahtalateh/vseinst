## Run docker for database
```bash
docker run -p33322:5432 --name vseinst -e POSTGRES_PASSWORD=PNiG3nEP87TVCMQsW2 -e POSTGRES_USER=vseinst -e POSTGRES_DB=vseinst -d postgres:12.1
```

## Setup database schema
```bash
vendor/bin/doctrine orm:schema-tool:create
```


