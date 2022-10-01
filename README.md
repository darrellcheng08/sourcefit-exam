# Installation

Laravel version: 9
PHP Version: 8
Composer: 2.2

**Step 1:** Clone the project repository

**Step 2:** Setup the Backend API(Laravel) using the commands below:

```
1. Go to project-directory/api
2. Run composer install
3. Run php artisan config:cache
4. Run php artisan key:generate
5. Run php artisan storage:link
6. Rename the `.env.example` file to `.env`, and configure the appropriate database credentials
7. Create a database, then run migrate command to create the tables: php artisan migrate
8. To run the Backend API on the server follow this command: php artisan serve --port=8001
```

**Step 3:** Setup the Frontend (Vue.js) using the commands below:

```
1. Go to project-directory/ui
2. Run npm install
3. To run the web UI on the server follow this command: npm run serve
```

**Step 4:** Access the website:

Open your browser and type **localhost:8080** then enter
