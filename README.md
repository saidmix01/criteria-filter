# Product Filter Library in PHP using Criteria Method

This project is an example of how to implement a product filter in PHP using the criteria method. The code retrieves data from a fake product API and filters it according to the parameters provided in the URL.

## Description

The project consists of a PHP class `FilterWithCriteria` that filters product data based on various criteria such as sorting, filtering by value, and limiting the number of results.

## Features

- Filter products based on parameters provided in the URL.
- Sort products by specified fields in ascending or descending order.
- Limit the number of results and apply an offset.

## Usage

To use this library, you need to include the `FilterWithCriteria.php` file in your project and create an instance of the `FilterWithCriteria` class. You can then call the `search` method with the data and parameters to filter the products.


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

### Class: FilterWithCriteria

#### Methods

- `search($data = [], $params = [])`: Handles the main logic of retrieving and filtering the products, and returns the response as a JSON string.
- `filter($data, $params)`: Filters an array of data based on specified parameters such as sorting, filtering by value, and limiting the number of results.
- `get_params($params)`: Extracts and returns specific parameters from an array input.

