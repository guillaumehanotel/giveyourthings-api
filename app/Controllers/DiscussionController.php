<?php


namespace App\Controllers;

use App\Models\Ad;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class DiscussionController extends Controller {

    public function __construct($container) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response) {
        $discussions = Discussion::all();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussions);
    }

    public function show(Request $request, Response $response, $args) {
        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            $discussion = Discussion::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussion);
    }

    public function getDiscussionsByUserAndAd(Request $request, Response $response, $args) {
        $userId = $args['user_id'];
        $adId = $args['ad_id'];

        if (v::intVal()->validate($userId) == false && v::intVal()->validate($adId) == false) {
            return $response->withStatus(400);
        }

        try {
            /** @var User $user */
            User::findOrFail($userId);
            /** @var Ad $ad */
            $ad = Ad::findOrFail($adId);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $discussions = $ad->discussions()->get();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussions);
    }

    public function store(Request $request, Response $response, $args) {

        $userId = $args['user_id'];
        $adId = $args['ad_id'];

        if (v::intVal()->validate($userId) == false && v::intVal()->validate($adId) == false) {
            return $response->withStatus(400);
        }

        try {
            User::findOrFail($userId);
            Ad::findOrFail($adId);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $discussion = new Discussion();
        $discussion->ad_id = $adId;
        $discussion->requester_id = $userId;
        $discussion->save();

        return $response->withStatus(201)
            ->withHeader('Content-Type', 'text/html')
            ->withHeader('Location', APP_URL . ':' . $_SERVER['SERVER_PORT'] . '/api/discussions/' . $discussion->id);

    }



}