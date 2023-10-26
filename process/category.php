<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if($action === 'loadAll')
    {
        $response_data['success'] = 1;
        $categories = (new \Models\Category)->loadCategories(0, 8);
        $response_data['categories'] = $categories;
        echo json_encode($response_data);
        exit;
    }

    if($action === 'load')
    {
        $response_data['success'] = 0;
        $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
        if(! $slug)
        {
            $response_data['message'] = 'Invalid Category.';
            echo json_encode($response_data);
            exit;
        }

        $category = new \Models\Category([$slug]);
        if(! $category->getId())
        {
            $response_data['message'] = 'Invalid Category.';
            echo json_encode($response_data);
            exit;
        }
        $response_data['success'] = 1;
        $response_data['category'] = $category;
        
        echo json_encode($response_data);
        exit;
    }
    
    if($action === 'save')
    {
        $response_data['success'] = 0;

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $slug = implode('-', explode(' ', $name)) . '-' . time();

        if(! $name || ! $slug)
        {
            $response_data['message'] = 'Invalid category data';
            echo json_encode($response_data);
            exit;
        }

        $category = new \Models\Category;
        $category->name = $name;
        $category->slug = $slug;
        
        $category->saveCategory();
        $response_data['success'] = 1;
        $response_data['message'] = 'Category has been created';
        echo json_encode($response_data);
        exit;
    }
}
