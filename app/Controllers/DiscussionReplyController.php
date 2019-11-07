<?php


namespace App\Controllers;


use App\Models\Discussion;
use App\Models\DiscussionReply;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Respect\Validation\Validator as v;

class DiscussionReplyController extends Controller {

    public function __construct($container) {
        parent::__construct($container);
    }

    public function show(Request $request, Response $response, $args) {
        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            $discussionReply = DiscussionReply::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussionReply);
    }

    public function getRepliesByDiscussion(Request $request, Response $response, $args) {

        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            /** @var Discussion $discussion */
            $discussion = Discussion::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $discussionReplies = $discussion->replies()->orderByDesc('created_at')->get();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussionReplies);
    }

    public function store(Request $request, Response $response, $args) {

        $discussionId = $args['discussion_id'];
        $userId = $args['user_id'];

        if (v::intVal()->validate($userId) == false && v::intVal()->validate($discussionId) == false) {
            return $response->withStatus(400);
        }

        try {
            User::findOrFail($userId);
            Discussion::findOrFail($discussionId);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $data = $request->getParsedBody();

        $discussionReply = new DiscussionReply();
        $discussionReply->user_id = $userId;
        $discussionReply->discussion_id = $discussionId;
        $discussionReply->message = $data['message'];
        $discussionReply->save();

        return $response->withStatus(201)
            ->withHeader('Content-Type', 'text/html')
            ->withHeader('Location', APP_URL . ':' . $_SERVER['SERVER_PORT'] . '/api/discussion_replies/' . $discussionReply->id);
    }

}