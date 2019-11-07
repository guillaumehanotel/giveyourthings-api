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

}