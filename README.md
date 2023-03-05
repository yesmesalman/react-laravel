# Dockerized React.js and Laravel Application

This is a sample application that demonstrates how to Dockerize a React.js and Laravel application and create a Docker Compose environment.

## Prerequisites

To run this application, you must have the following installed on your system:

- Docker
- Docker Compose

## Getting Started

1. Clone this repository to your local machine:

``` git clone https://github.com/yesmesalman/react-laravel.git ```

2. Navigate to the project directory:
``` cd react-laravel ```

3. Create the necessary directories for your React.js and Laravel applications:
``` mkdir react-app laravel-app ```


4. Copy the application files to the appropriate directories:

- Copy your React.js application files to the `react-app` directory.
- Copy your Laravel application files to the `laravel-app` directory.

5. Create a `.env` file in the root directory of the project and set the following environment variables:

``` APP_KEY=your-app-key 
    DB_DATABASE=your-db-name 
    DB_USERNAME=your-db-username 
    DB_PASSWORD=your-db-password
```

6. Start the Docker Compose environment:

``` docker-compose up ``` 


This will start the containers for your React.js and Laravel applications, as well as the MySQL database.

7. You should now be able to access your React.js application by visiting http://localhost:3000 in your web browser and your Laravel application by visiting http://localhost:8000 in your web browser.

## Running Commands

To run commands inside a Docker container, you can use the `docker-compose exec` command. For example, to run the `composer install` command inside the Laravel container, you can run:

``` docker-compose exec laravel-app composer install ```


## Credits

This application was created by [yesmesalman](https://github.com/yesmesalman).

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
