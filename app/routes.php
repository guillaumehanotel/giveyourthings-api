<?php

// Home
$app->get("/", "HomeController:index")->setName('home');

// Users Endpoints
$app->get("/api/users", "UserController:index")->setName('users.index');
$app->get("/api/users/{id}", "UserController:show")->setName('users.show');
$app->post("/api/users", "UserController:store")->setName('users.store');
$app->put("/api/users/{id}", "UserController:update")->setName('users.update');
$app->delete("/api/users/{id}", "UserController:destroy")->setName('users.destroy');

// Ads Endpoints
$app->get("/api/ads", "AdController:index")->setName('ads.index');
$app->get("/api/ads/{id}", "AdController:show")->setName('ads.show');
$app->post("/api/users/{user_id}/ads", "AdController:store")->setName('ads.store');
$app->put("/api/users/{user_id}/ads/{id}", "AdController:update")->setName('ads.update');
$app->delete("/api/ads/{id}", "AdController:destroy")->setName('ads.destroy');

$app->get("/api/users/{user_id}/ads", "AdController:getByUser")->setName('ads.getbyuser');

// Categories Endpoints
$app->get("/api/categories", "CategoryController:index")->setName('categories.index');
$app->get("/api/categories/{id}", "CategoryController:show")->setName('categories.show');