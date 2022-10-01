# Installation

**Step 1:** Clone the project repository

**Step 2:** Install the packages of laravel using the commands below:

```
cd project-directory/api
composer install
```

**Step 3:** Install the packages of vue.js using the commands below:

```
cd project-directory/web
npm install
```

**Step 4:** Run the following command to generate an application key and link the storage folder to public folder:

```
cd project-directory/api
php artisan config:cache
php artisan key:generate
php artisan storage:link
```

**Step 5:** Rename the `.env.example` file to `.env`, and configure the appropriate database credentials

**Step 6:** Create a database, then run migrate command to create the tables:

```
php artisan migrate
```

**Step 7:** To run the laravel RESTful API on the server follow the commands below:

```
cd project-directory/api
php artisan serve --port=8001
```

**Step 8:** To run the web UI on the server follow the commands below:

```
cd project-directory/web
npm run serve
```

**Step 9:** Access the website:

Open your browser and type **localhost:8080** then enter
