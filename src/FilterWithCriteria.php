<?php

/*
This code is an example of how to implement a product filter in PHP using the criteria method.
The code retrieves data from a fake product API and filters it according to the parameters provided in the URL.
*/

final class FilterWithCriteria
{

    private $products = [];

    public function search($data = [])
    {
        $params = $this->get_params($_GET);
        $response = array(
            'status' => 'error',
            'data' => [],
            'message' => ''
        );
        try {
            if(empty($data)) {
                throw new Exception("No data provided");
            }
            if(empty($params)) {
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
     * @param data The `filter` function takes two parameters: `` and ``. The ``
     * parameter is an array containing the data that needs to be filtered. The function applies
     * filtering based on the conditions specified in the `` array.
     * @param params - orderBy: The field by which the data should be ordered.
     * 
     * @return The function `filter` is returning the filtered and sorted data based on the parameters
     * provided. If the input data is not empty, it first checks for sorting parameters (`orderBy` and
     * `order`), then filters the data based on comparison parameters (`param`, `value`, `operator`),
     * and finally applies limit and offset if specified. The filtered and sorted data is then
     * returned.
     */
    private function filter($data, $params) {
        if(count($data) != 0) {
            
            if(!empty($params['orderBy']) && !empty($params['order'])) {
                if($params["order"] == "asc") {
                    usort($data, function($a, $b) use ($params) {
                        return $a[$params['orderBy']] <=> $b[$params['orderBy']];
                    });
                } else {
                    usort($data, function($a, $b) use ($params) {
                        return $b[$params['orderBy']] <=> $a[$params['orderBy']];
                    });
                }
                
            }
            if(!empty($params['param']) && !empty($params['value']) && !empty($params['operator'])) {
                $data = array_filter($data, function($producto) use ($params) {
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
            if(!empty($params['limit']) && !empty($params['offset'])) {
                $data = array_slice($data, $params['offset'], $params['limit']);
            }
        }

        return $data;
    }

    /**
     * The function `get_params` extracts and returns specific parameters from an array input.
     * 
     * @param params The `get_params` function takes an array `` as input and extracts specific
     * parameters from the 'query' key within this array. Here are the parameters extracted by the
     * function:
     * 
     * @return An array containing the following key-value pairs is being returned:
     * - 'orderBy' => value of 'orderBy' from ['query'] or 'asc' if not set
     * - 'order' => value of 'order' from ['query'] or 'asc' if not set
     * - 'limit' => integer value of 'limit' from ['query'] or 10
     */
    // Example: http://localhost/index.php?query[orderBy]=code&query[order]=asc&query[limit]=10&query[offset]=0&query[param]=code&query[value]=1&query[operator]=between
    // Example: http://localhost/index.php?query[orderBy]=code&query[order]=asc&query[limit]=10&query[offset]=0&query[param]=price&query[value]=10&query[operator]=greater
    private function get_params($params) {

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
