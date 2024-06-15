# Getting Started with WireCart

To experience the WireCart demo app, follow these steps to set it up on your local machine:

## Step 1: Clone the Repository

Begin by cloning the WireCart repository. Open your terminal or command prompt and run the following command:

```bash
git clone https://github.com/realrashid/wire-cart.git
```

## Step 2: Install Dependencies

Navigate to the project directory and install the necessary dependencies using Composer and npm:

```bash
cd wire-cart
composer install && npm install && npm run build
```

## Step 3: Set Up Environment Variables

Copy the `.env.example` file and rename it to `.env`. Open the file and configure your database settings and other environment variables:

```bash
cp .env.example .env
```

## Step 4: Generate Application Key

Generate a unique application key:

```bash
php artisan key:generate
```

## Step 5: Migrate the Database

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

## Step 6: Seed the Database

Seed the database with initial data:

```bash
php artisan db:seed
```

## Step 7: Start the Application

Start the development server: 

```bash
php artisan serve
```

## Step 8: Access the Application

Open your web browser and go to `http://localhost:8000` to access the WireCart demo app.

## Step 9: Explore and Test

Now you can explore the features of the WireCart app.


Note: Please note that this demo app is for demonstration purposes only and may not have full production-level functionality.
