# CarrotFlix

> [!WARNING]
> This repository is currently for educational purposes only.

## Description

CarrotFlix is a project designed to serve streaming movies, providing a platform for users to access and watch movies online.

## Table of Contents

-   [Getting Started](#getting-started)
    -   [Prerequisites](#prerequisites)
    -   [Installation](#installation)
    -   [Setting Up the Database](#setting-up-the-database)
    -   [Running the Development Server](#running-the-development-server)
-   [Usage](#usage)
-   [Contributing](#contributing)
-   [License](#license)

## Getting Started 🌟

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Before you begin, ensure you have the following installed:

-   Git: [Installation Guide](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
-   Composer: [Installation Guide](https://getcomposer.org/doc/00-intro.md)
-   PHP (with server capabilities)
    -   For Windows: [Installation Guide](https://www.php.net/manual/en/install.windows.php)
    -   For macOS: [Installation Guide](https://www.php.net/manual/en/install.macosx.php)
    -   For Linux: [Installation Guide](https://www.php.net/manual/en/install.unix.php)

### Installation

1. **Clone the repository:**

    ```
    git clone https://github.com/arques89/CarrotFlix.git
    ```

2. **Install dependencies:**
   Navigate to the root directory of the project and run:
    ```
    composer install
    ```

### Setting Up the Database

1. **Configure the Database:**

    - In the `/includes` directory, create a `.env` file and add the following database connection details:

    ```
    DB_HOST=your server
    DB_USER=db user
    DB_PASS=db password
    DB_NAME=db name
    ```

2. **Initializing the Database:**
    - Execute the script `/sql/creates.sql` in your database to create the necessary tables.

### Running the Development Server

1. **Start the server:**
   From the `/public` directory, execute:
    ```
    php -S localhost:3000
    ```

## Usage

Explain how to use the project once it's set up. Provide examples and usage scenarios.

## Contributing

> [!NOTE]
> We welcome contributions to CarrotFlix! If you'd like to contribute, please follow these guidelines:

### Getting Started

1. Fork the repository.
2. Clone your forked repository to your local machine:
    ```
    git clone https://github.com/your-username/CarrotFlix.git
    ```
3. Create a new branch for your feature or bug fix:
    ```
    git checkout -b feature-new-feature
    ```
4. Make your changes, commit them, and push to your fork:

    ```
    git add .
    ```

    ```
    git commit -m "Description of changes"
    ```

    ```
    git push origin feature-new-feature
    ```

5. Open a pull request to the `main` branch of the original repository.

### Contribution Guidelines

-   Ensure your code follows the project's coding style and conventions.
-   Write descriptive commit messages and comments for better understanding.
-   Test your changes thoroughly before submitting a pull request.
-   Be respectful and considerate in your communication and interactions with others.

Thank you for considering contributing to CarrotFlix! We appreciate your time and effort in making this project better.

## License

This project is licensed under the [GNU General Public License v3.0 (GPL-3.0)](https://www.gnu.org/licenses/gpl-3.0.html) - see the [LICENSE](LICENSE) file for details.
