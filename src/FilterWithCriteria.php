<?php

/*
This code is an example of how to implement a product filter in PHP using the criteria method.
The code retrieves data from a fake product API and filters it according to the parameters provided in the URL.
*/

final class FilterWithCriteria
{

    private $products = [];

    /**
     * The main search function that filters the provided data based on the given parameters.
     *
     * @param array $data The array of product data to be filtered.
     * @param array $params The array of parameters for filtering.
     * @return string JSON encoded response with the filtered data.
     */
    public function search($data = [], $params = [])
    {
        $params = $this->get_params($params);
        $response = array(
            'status' => 'error',
            'data' => [],
            'message' => ''
        );
        try {
            if (empty($data)) {
                throw new Exception("No data provided");
            }
            if (empty($params)) {
                throw new Exception("No parameters provided");
            }
            $this->products = $data;
            $response['status'] = 'success';
            $response['data'] = $this->products = $this->filter($this->products, $params);
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
        }
        return json_encode($response);
    }

    /**
     * The function filters an array of data based on specified parameters such as sorting, filtering
     * by value, and limiting the number of results.
     *
     * @param array $data The array containing the data that needs to be filtered.
     * @param array $params The array containing the filtering parameters.
     * @return array The filtered and sorted data based on the parameters provided.
     */
    private function filter($data, $params)
    {
        if (count($data) != 0) {

            if (!empty($params['orderBy']) && !empty($params['order'])) {
                if ($params["order"] == "asc") {
                    usort($data, function ($a, $b) use ($params) {
                        return $a[$params['orderBy']] <=> $b[$params['orderBy']];
                    });
                } else {
                    usort($data, function ($a, $b) use ($params) {
                        return $b[$params['orderBy']] <=> $a[$params['orderBy']];
                    });
                }
            }
            if (!empty($params['param']) && !empty($params['value']) && !empty($params['operator'])) {
                $data = array_filter($data, function ($producto) use ($params) {
                    $field = $params['param'];
                    $operator = $params['operator'];
                    $value = $params['value'];

                    switch ($operator) {
                        case 'equals':
                            return $producto[$field] == $value;
                        case 'between':
                            return $producto[$field] >= $value[0] && $producto[$field] <= $value[1];
                        case 'greater':
                            return $producto[$field] > $value;
                        case 'less':
                            return $producto[$field] < $value;
                        default:
                            return false;
                    }
                });
            }
            if (!empty($params['limit']) && !empty($params['offset'])) {
                $data = array_slice($data, $params['offset'], $params['limit']);
            }
        }

        return $data;
    }

    /**
     * The function `get_params` extracts and returns specific parameters from an array input.
     *
     * @param array $params The array of parameters to extract from.
     * @return array An array containing the extracted parameters.
     */
    private function get_params($params)
    {
        $queryParams = isset($params['query']) ? $params['query'] : [];

        $order = isset($queryParams['order']) ? $queryParams['order'] : 'asc';
        $orderBy = isset($queryParams['orderBy']) ? $queryParams['orderBy'] : 'asc';
        $limit = isset($queryParams['limit']) ? (int)$queryParams['limit'] : 10;
        $offset = isset($queryParams['offset']) ? (int)$queryParams['offset'] : 0;
        $category = isset($queryParams['category']) ? $queryParams['category'] : '';
        $param = isset($queryParams['param']) ? $queryParams['param'] : '';
        $value = isset($queryParams['value']) ? $queryParams['value'] : '';
        $operator = isset($queryParams['operator']) ? $queryParams['operator'] : '';

        return [
            'orderBy' => $orderBy,
            'order' => $order,
            'limit' => $limit,
            'offset' => $offset,
            'category' => $category,
            'param' => $param,
            'value' => $value,
            'operator' => $operator
        ];
    }
}