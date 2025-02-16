# Product Filter in PHP using Criteria Method

This project is an example of how to implement a product filter in PHP using the criteria method. The code retrieves data from a fake product API and filters it according to the parameters provided in the URL.

## Description

The project consists of a single PHP class `Index` that retrieves product data from a fake store API and filters it based on various criteria such as sorting, filtering by value, and limiting the number of results.

## Features

- Retrieve product data from a fake store API.
- Filter products based on parameters provided in the URL.
- Sort products by specified fields in ascending or descending order.
- Limit the number of results and apply an offset.

## Usage

To use this project, you need to set up a local server (e.g., XAMPP) and place the `index.php` file in the server's root directory. You can then access the script via a web browser and provide the filtering parameters in the URL.

### Example URL

http://localhost/index.php?query[orderBy]=code&query[order]=asc&query[limit]=10&query[offset]=0&query[param]=price&query[value]=10&query[operator]=greater


### Parameters

- `orderBy`: The field by which the data should be ordered.
- `order`: The order direction (`asc` for ascending, `desc` for descending).
- `limit`: The maximum number of results to return.
- `offset`: The number of results to skip before starting to collect the result set.
- `param`: The field to filter by.
- `value`: The value to filter by.
- `operator`: The operator to use for filtering (`equals`, `between`, `greater`, `less`).

## Code Overview

### Class: Index

#### Properties

- `private $products`: An array to store the product data.

#### Methods

- `__construct()`: Initializes the `products` property by calling the `get_products` method.
- `index()`: Handles the main logic of retrieving and filtering the products, and returns the response as a JSON string.
- `get_products($qty)`: Retrieves a specified quantity of product information from the fake store API and returns an array of product details.
- `filter($data, $params)`: Filters an array of data based on specified parameters such as sorting, filtering by value, and limiting the number of results.
- `get_params($params)`: Extracts and returns specific parameters from an array input.

