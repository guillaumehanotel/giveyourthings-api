<?php


namespace App\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class CategoryController extends Controller {

    public function __construct($container) {
        parent::__construct($container);
    }

    public function index($request, $response) {
        $categories = Category::all();
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(formatResponse($categories));
    }

    public function show(Request $request, Response $response, $args) {
        $id = $args['id'];

        if (v::intVal()->validate($id) == false) {
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'text/html')
                ->write("Incorrect ID");;
        }

        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'text/html')
                ->write($exception->getMessage());
        }

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(formatResponse($category));
    }

}