
# Bank System

Welcome to the Bank System project! This system is a simple banking application that allows users to perform various banking operations such as creating accounts, transferring funds between accounts, and checking transaction history.

## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- User authentication and authorization
- Create bank accounts
- Transfer funds between accounts (Card to Card, Paya)
- View transaction history
- Check individual transaction details
- Delete bank cards

## Getting Started

### Prerequisites

- PHP (>= 7.0)
- MySQL
- Web server (e.g., Apache, Nginx)

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/YaserZarifi/Bank-System
   ```

2. Set up your database:
   - Create a MySQL database named `bank`.
   - Import the `bank.sql` file into the database.

3. Update database connection:
   - Open `Controller/processSignup.php` and `Controller/processLogin.php`.
   - Modify the database connection parameters.

4. Configure web server:
   - Set the document root to the `View` directory.
   - Ensure the server supports PHP.

## Usage

1. Access the application through your web browser.

2. **Login or Sign Up:**
   - Use the provided login credentials or create a new account.

3. **Dashboard:**
   - Explore the dashboard and navigate to different features.

4. **Transactions:**
   - Perform transactions, check history, and manage your cards.

## Contributing

Contributions are welcome! Feel free to open issues and pull requests.


