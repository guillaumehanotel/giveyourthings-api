<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller {

    public function __construct($container) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response) {
        $users = User::all();

        $queryParameters = $request->getQueryParams();

        if(isset($queryParameters['uid'])) {
            $uid = $queryParameters['uid'];
            $user = User::where('uid', '=', $uid)->first();
            if(empty($user)) {
                return $response->withStatus(404)
                    ->withHeader('Content-Type', 'text/html')
                    ->write("No user with UID : " . $uid);
            } else {
                return $response->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($user);
            }
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($users);
    }

    public function show(Request $request, Response $response, $args) {
        $id = $args['id'];

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

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($user);
    }

    public function store(Request $request, Response $response) {

        /** @var Validator $validation */
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->userEmailAvailable(),
            'username' => v::notEmpty(),
            'uid' => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write(json_encode($validation->getErrors()));
        }

        $data = $request->getParsedBody();
        $user = User::create([
            'uid' => $data['uid'],
            'username' => $data['username'],
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'photoUrl' => $data['photoUrl']
        ]);
        $user->save();

        return $response->withStatus(201)
            ->withHeader('Content-Type', 'text/html')
            ->withHeader('Location', APP_URL . ':' . $_SERVER['SERVER_PORT'] . '/api/users/' . $user->id);

    }

    public function update(Request $request, Response $response, $args) {
        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400);
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        /** @var Validator $validation */
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty(),
            'username' => v::noWhitespace()->notEmpty(),
        ]);


        if ($isEmailAlreadyExists = $this->checkUniqueEmail($request->getParam('email'), $id)) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Cet email existe déjà");
        }

        if ($validation->failed() || $isEmailAlreadyExists) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write(json_encode($validation->getErrors()));
        }

        $data = $request->getParsedBody();

        $user->update([
            'uid' => $data['uid'] ?? $user->uid,
            'email' => $data['email'] ?? $user->email,
            'username' => $data['username'] ?? $user->username,
            'firstname' => $data['firstname'] ?? $user->firstname,
            'lastname' => $data['lastname'] ?? $user->lastname,
            'photoUrl' => $data['photoUrl'] ?? $user->photoUrl,
        ]);

        return $response->withStatus(200);
    }

    public function destroy(Request $request, Response $response, $args) {
        $id = $args['id'];
        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400);
        }
        User::destroy($id);

        return $response->withStatus(204);
    }

    private function checkUniqueEmail($email, $id) {
        return (User::where('id', '!=', $id)
            ->where('email', $email)
            ->get())->isNotEmpty();
    }

}