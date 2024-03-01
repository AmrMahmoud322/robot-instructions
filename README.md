# Robot Instruction Parser

## Introduction

This project provides a Laravel application to parse robot instructions and generate a file with the final position for each instruction set.

## Features

The application allows users to input a string of robot instructions consisting of the following characters:

- F: Move forward (increasing y-coordinate)
- B: Move backward (decreasing y-coordinate)
- R: Move right (increasing x-coordinate)
- L: Move left (decreasing x-coordinate)

The application then parses these instructions and calculates the final position of the robot. It generates a text file containing the instructions and the final position (x, y) and returns the file path.

## How it Works
### Input Instructions:
-Users provide a string of robot instructions via the application's API endpoint.
### Validation:
-The application validates the input instructions to ensure they are in the correct format.  Instructions must consist of the characters 'F', 'B', 'R', or 'L'.
### Parsing:
-Upon successful validation, the application parses the instructions to calculate the final position of the robot. It counts the occurrences of each instruction character and calculates the final x and y coordinates based on the movements specified.
### File Generation:
-After parsing the instructions, the application generates a text file containing the original instructions along with the calculated final position (x, y). The file is stored in the storage directory of the Laravel application.
### Response:
-The application returns the file path of the generated output file as a response to the user, allowing them to access and download the result.


## Installation

To get started with this project, follow these steps:

1. Clone the repository.

2. Navigate to the project directory.

3. Install PHP dependencies using Composer:
   ```shell
   composer install
   ```

4. Create a `.env` file by copying `.env.example`:
   ```shell
   cp .env.example .env
   ```

5. Generate a new Laravel application key:

   ```shell
   php artisan key:generate
   ```

6. Start the Laravel development server:

   ```shell
   php artisan serve
   ```

   Access the application at `http://127.0.0.1:8000/api/v1/robot/parser?instructions=FFBBFRRLRFF`.


## Testing

To run unit tests, use the following command:

```shell
php artisan test
```

This command will execute all test units located in the tests directory, including those for the RobotController.

The tests cover various scenarios, including:

-Parsing valid robot instructions.
-Parsing invalid robot instructions.
-Handling empty requests (without the instructions parameter).

The tests validate the API responses to ensure that the application behaves correctly under different conditions.


## Docker Support

This project includes Docker support for containerization. You can use the provided `Dockerfile` and `docker-compose.yml` files to set up and run the project in a Docker container.

### Building and Running with Docker

1. Clone the repository as mentioned above.

2. Navigate to the project directory.

3. Build and start the Docker containers:

   ```shell
   docker-compose up -d
   ```

4. Access the application at `http://127.0.0.1:8000/api/v1/robot/parser?instructions=FFBBFRRLRFF` in your web browser.

5. When done, stop the containers:
   ```shell
   docker-compose down
   ```