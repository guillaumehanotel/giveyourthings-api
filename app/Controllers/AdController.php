<?php


namespace App\Controllers;


use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use App\Validation\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class AdController extends Controller {

    public function __construct($container) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response) {
        $ads = Ad::orderBy('created_at', 'desc')->get();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($ads);
    }

    public function discussedAds(Ad $ad) {
        return $ad->discussions()->exists();
    }

    public function getOnlineAds(Request $request, Response $response) {
        $onlineAds = Ad::where('is_given', '=', 'false')->get();
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($onlineAds);
    }

    public function getAdsByStateAndUser(Request $request, Response $response, $args) {
        $id = $args['user_id'];
        $state = $args['state'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");
        }

        if(!in_array($state, ['finalized', 'reserved', 'online'])) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("state should be finalized|reserved|online");
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        switch ($state){
            case 'finalized':
                $ads = $user->ads()->where('is_given', '=', true)->get();
                break;
            case 'reserved':
                $ads = $user->ads()->where('is_given', '=', false)->where('booker_id', '!=', null)->get();
                break;
            case 'online':
                $ads = $user->ads()->where('is_given', '=', '0')->whereNull('booker_id')->get();
                break;
            default:
                $ads = [];
        }

        $discussedAds = $ads->filter([$this, 'discussedAds'])->values();

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($discussedAds);
    }


    public function getByUser(Request $request, Response $response, $args) {
        $id = $args['user_id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }
        $ads = $user->ads()->get();
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($ads);
    }

    public function show(Request $request, Response $response, $args) {
        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            $ad = Ad::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($ad);
    }

    public function store(Request $request, Response $response, $args) {

        $userId = $args['user_id'];

        if (v::intVal()->validate($userId) == false) {
            return $response->withStatus(400);
        }

        /** @var Validator $validation */
        $validation = $this->validator->validate($request, [
            'title' => v::notEmpty(),
            'type' => v::notEmpty(),
            'description' => v::notEmpty(),
            'condition' => v::notEmpty(),
            'category_id' => v::notEmpty()
        ]);

        if ($validation->failed()) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write(json_encode($validation->getErrors()));
        }

        $data = $request->getParsedBody();

        try {
            User::findOrFail($userId);
            Category::findOrFail($data['category_id']);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $ad = new Ad();
        $ad->title = $data['title'];
        $ad->description = $data['description'];
        $ad->type = $data['type'];
        $ad->localisation = $data['localisation'] ?? null;
        $ad->latitude = $data['latitude'] ?? null;
        $ad->longitude = $data['longitude'] ?? null;
        $ad->condition = $data['condition'];
        $ad->user_id = $userId;
        $ad->category_id = $data['category_id'];
        $ad->save();

        return $response->withStatus(201)
            ->withHeader('Content-Type', 'text/html')
            ->withHeader('Location', APP_URL . ':' . $_SERVER['SERVER_PORT'] . '/api/ads/' . $ad->id);
    }

    public function update(Request $request, Response $response, $args) {
        $userId = $args['user_id'];
        $adId = $args['id'];

        if (v::intVal()->validate($userId) == false && v::intVal()->validate($adId) == false) {
            return $response->withStatus(400);
        }

        $data = $request->getParsedBody();

        try {
            $ad = Ad::findOrFail($adId);
            User::findOrFail($userId);
            if(isset($data['category_id']))
                Category::findOrFail($data['category_id']);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        $ad->title = $data['title'] ?? $ad->title;
        $ad->description = $data['description'] ?? $ad->description;
        $ad->type = $data['type'] ?? $ad->type;
        $ad->localisation = $data['localisation'] ?? $ad->localisation;
        $ad->latitude = $data['latitude'] ?? $ad->latitude;
        $ad->longitude = $data['longitude'] ?? $ad->longitude;
        $ad->condition = $data['condition'] ?? $ad->condition;
        $ad->category_id = $data['category_id'] ?? $ad->category_id;
        $ad->save();

        return $response->withStatus(200);
    }

    public function destroy(Request $request, Response $response, $args) {
        $id = $args['id'];
        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400);
        }
        Ad::destroy($id);
        return $response->withStatus(204);
    }


}