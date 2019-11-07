<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('/api');
});

// Home
$app->get("/api", "HomeController:index")->setName('home');

// Users Endpoints
$app->get("/api/users", "UserController:index")->setName('users.index');
$app->get("/api/users/{id}", "UserController:show")->setName('users.show');
$app->post("/api/users", "UserController:store")->setName('users.store');
$app->put("/api/users/{id}", "UserController:update")->setName('users.update');
$app->delete("/api/users/{id}", "UserController:destroy")->setName('users.destroy');

// Ads Endpoints
$app->get("/api/ads/online", "AdController:getOnlineAds")->setName('ads.getOnlineAds');
$app->get("/api/ads", "AdController:index")->setName('ads.index');
$app->get("/api/ads/{id}", "AdController:show")->setName('ads.show');
$app->post("/api/users/{user_id}/ads", "AdController:store")->setName('ads.store');
$app->put("/api/users/{user_id}/ads/{id}", "AdController:update")->setName('ads.update');
$app->delete("/api/ads/{id}", "AdController:destroy")->setName('ads.destroy');

$app->get("/api/users/{user_id}/ads", "AdController:getByUser")->setName('ads.getbyuser');
$app->get("/api/users/{user_id}/ads/{state}", "AdController:getAdsByStateAndUser")->setName('ads.getAdsByStateAndUser');


// Categories Endpoints
$app->get("/api/categories", "CategoryController:index")->setName('categories.index');
$app->get("/api/categories/{id}", "CategoryController:show")->setName('categories.show');

// Discussion Endpoints
$app->get("/api/discussions", "DiscussionController:index")->setName('discussions.index');
$app->get("/api/discussions/{id}", "DiscussionController:show")->setName('discussions.show');
$app->post("/api/users/{user_id}/ads/{ad_id}/discussions", "DiscussionController:store")->setName('discussions.store');

$app->get("/api/users/{user_id}/ads/{ad_id}/discussions", "DiscussionController:getDiscussionsByUserAndAd")->setName('discussions.getDiscussionsByUserAndAd');

// Discussion Replies Endpoints
$app->get('/api/discussion_replies/{id}', "DiscussionReplyController:show")->setName('discussion_replies.show');
$app->get('/api/discussions/{id}/discussion_replies', "DiscussionReplyController:getRepliesByDiscussion")->setName('discussion_replies.getRepliesByDiscussion');
$app->post('/api/discussions/{discussion_id}/users/{user_id}/discussion_replies', "DiscussionReplyController:store")->setName('discussion_replies.store');
