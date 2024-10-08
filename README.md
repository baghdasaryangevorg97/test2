https://github.com/baghdasaryangevorg97/test2.gita# Project Setup Instructions

Follow these steps to set up the project:

1. **Create `.env` File**:
   - Copy the contents of `env.example` to a new file named `.env`.

2. **Install Dependencies**:
   - Go cd api and run the following command to install all necessary dependencies:
     ```bash
     composer install
     ```

3. **Generate Application Key**:
   - Run the following command to generate a new application key:
     ```bash
     php artisan key:generate
     ```

4. **Run Migrations and Seed Database**:
   - Run the following command to migrate the database and seed it with initial data:
     ```bash
     php artisan migrate 
     ```

That's it! Your project should now be set up and ready to use.