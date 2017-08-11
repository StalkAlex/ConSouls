<?php

namespace RPGBundle\Controller;

use RPGBundle\Service\SumService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var SumService
     */
    private $sumService;

    /**
     * DefaultController constructor.
     *
     * @param \Twig_Environment $twig
     * @param SumService        $sumService
     */
    public function __construct(\Twig_Environment $twig, SumService $sumService)
    {
        $this->twig = $twig;
        $this->sumService = $sumService;
    }

    /**
     * @return Response
     */
    public function indexAction() : Response
    {
        return new Response(
            $this->twig->render('RPGBundle:Default:index.html.twig')
        );
    }

    /**
     * @param string $a
     * @param string $b
     *
     * @return JsonResponse
     */
    public function sumAction(string $a, string $b) : JsonResponse
    {
        return new JsonResponse(
            [
                'sum'      => $this->sumService->makeSum($a, $b),
            ],
            Response::HTTP_OK
        );
    }
}
