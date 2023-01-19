<?php 

namespace Shamshadinye\MyPhpProject\Http\Controllers; 

use Shamshadinye\MyPhpProject\Model\Repository\AdvertRepository;
use Shamshadinye\MyPhpProject\Model\Validators\AdvertValidator;
use Slim\Http\ServerRequest;
use Slim\Http\Response;
use Slim\Views\Twig;

class AdvertController
{
	public function index(ServerRequest $request, Response $response)
	{
		$advertsRepo = new AdvertRepository();
		$adverts	 = $advertsRepo->getAll();
		
		$view = Twig::fromRequest($request);
		
		return $view->render($response, 'adverts/index.twig', ['adverts' => $adverts]);
	}
	
	public function newAdvert(ServerRequest $request, Response $response) {
        $advertsRepo = new AdvertRepository();
        $categories = $advertsRepo->getCategories();
        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/new.twig', ['categories'=>$categories]);
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $categories = $repo->getCategories();

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData, $categories);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/new.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->create($advertData);

        return $response->withRedirect('/adverts');
    }

    public function show(ServerRequest $request, Response $response)
    {
        $advertId = $request->getAttribute('id');

        $repo = new AdvertRepository();
        $advert = $repo->findById($advertId);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/ad.twig', ['advert' => $advert]);
    }

    public function edit(ServerRequest $request, Response $response)
    {
        $advertId = $request->getAttribute('id');

        $repo = new AdvertRepository();
        $advert = $repo->findById($advertId);

        $categories = $repo->getCategories();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'adverts/edit.twig', ['advert' => $advert, 'categories'=>$categories]);
    }

    public function update(ServerRequest $request, Response $response)
    {
        $advertId = $request->getAttribute('id');

        $repo        = new AdvertRepository();
        $advertData  = $request->getParsedBodyParam('advert', []);

        $categories = $repo->getCategories();

        $validator = new AdvertValidator();
        $errors    = $validator->validate($advertData, $categories);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'adverts/edit.twig', [
                'data'   => $advertData,
                'errors' => $errors,
            ]);
        }

        $repo->update($advertData, $advertId);

        return $response->withRedirect('/adverts');
    }

}
