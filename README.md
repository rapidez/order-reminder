# Rapidez Order Reminder
This package provides functionality within Rapidez to create order reminders for customers, prompting them to reorder products after a specified period.

## Installation
```
composer require rapidez/order-reminder
```

## Configuration
You can publish the config with:
```
php artisan vendor:publish --tag=rapidez-order-reminder-config
```

## Views
You can publish the views with:
```
php artisan vendor:publish --tag=rapidez-order-reminder-views
```

## Order Reminder Forms
### Product Detail Page
To display the order reminder form on a product page, add the following to the product page, for example in `resources/views/vendor/rapidez/product/overview`:
```html
<x-rapidez-order-reminder::add :productSku="$product->sku" :defaultTimespan="2" />
```
This example adds the form with a default timespan of 2 automatically selected.

### Order Detail Page
To create an order reminder from an order, you can add the following to the order template, for example in `resources/views/vendor/rapidez/account/order.blade.php`:
```html
<x-rapidez-order-reminder::form products="Object.values(data.customer.orders.items[0].items)" key="product_sku" default-timespan="2" no-email />
```
This makes it possible to add one or more products to an order reminder.

## Order Reminder Confirmation and Management
When an order reminder is added, a confirmation email will be sent to the provided email address. Once the order reminder is approved, it will appear in the account center at the URL `/account/order-reminders`. Here, users can view, edit and delete the order reminders.
