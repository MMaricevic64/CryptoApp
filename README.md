# CryptoApp
Crypto application created by using Laravel (MVC).

## Data
Crypto data is pulled through an API and stored in MySQL database. Laravel Controller is used to get the data from the database and pass them to a specific view. Values ​​are displayed on the webpage in two tables. The first table contains all cryptocurrencies and their prices, while the second contains 10 cryptocurrencies that have recorded the largest price change in the past 15 minutes.

## API
https://api.coinpaprika.com/v1/tickers

## Model
- ID
- symbol (ex. BTC)
- name (ex. Bitcoin)
- price
- percent_change_15m
- update_enabled (Bool type, Used to detect if the user manually changed cryptocurrency value)

## Update/Add crypto values
Cryptocurrency values ​​in database are updated/added in the background every 15 minutes by Laravel console command. User can manually change cryptocurrency value ​​but then crypto can not receive future updates from the API.

## How to use the application?
- Install MySql, create database and change MySql database connection details in .env file 
- Open Linux terminal, navigate to the application folder and run next command to create crypto_currencies table in MySQL database
```
php artisan migrate
```
- Run the next command in Linux terminal to fullfill database with crypto models
```
php artisan crypto:update
```
- Run this command in Linux terminal to update the value of cryptocurrencies in the background every 15 minutes
```
php artisan schedule:work
```
- In new Linux terminal, run this command to run the local server
```
php artisan serve
```
- Open the webpage: http://127.0.0.1:8000/crypto

