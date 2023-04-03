<?php

error_reporting(E_ERROR | E_PARSE);

// get the end point
$endpoint = $_GET['endpoint'];

// get the query
$query = $_GET['query'];
$query = str_replace(" ","+",$query);

// handle a title search
if ($endpoint == 'searchByTitle') {
$api_url = 'https://openlibrary.org/search.json?title=' . $query;
}

// handle an author search
if ($endpoint == 'searchByAuthor') {
$api_url = 'https://openlibrary.org/authors/OL23919A/works.json';
}

// Read the JSON response
$json_data = file_get_contents($api_url);

// Turn the JSON response into an array
$response_data = json_decode($json_data,true);



if ($endpoint == 'searchByTitle') {
  // Prepare our response for a Title Search
// Count the instances of the title
$instances = count($response_data['docs']);

$response = array();
  // Sort out the information we need
  foreach ($response_data['docs'] as $key => $docs) {

    // Add the title to the response
    $response[$key]["title"] = $docs['title'];
    // Add the author to the response
    $response[$key]["author"] = $docs['author_name'][0];
    // Add the publish_year to the response
    $response[$key]["publish_year"] = $docs['publish_year'][0];
    // Add the ISBN to the response
    $response[$key]["isbn"] = $docs['isbn'][0];
    // Add the key to the response
    $response[$key]["key"] = $docs['key'];
    
  }
}

if ($endpoint == 'searchByAuthor') {
  // Prepare our response for an Author Search
// Count the instances of the author

print_r($response_data);
$instances = count($response_data['entries']);
$response = array();
  // Sort out the information we need
  foreach ($response_data['entries'] as $key => $entries) {

    // Add the title to the response
    $response[$key]["title"] = $entries['title'];
    
  }
}

  // Define response content type
  header('Content-Type: application/json');

  // Send response
  echo json_encode($response);


