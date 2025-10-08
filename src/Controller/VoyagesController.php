<?php
namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoyagesController extends AbstractController{

    public string $voyages = "pages/voyages.html.twig";

    #[Route('/voyages', name: 'voyages')]
    public function index(): Response{
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render($this->voyages,
                ['visites' => $visites]);
    }

    #[Route('/voyages/tri/{champ}/{ordre}', name: 'voyages.sort')]
    public function sort($champ, $ordre): Response{
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render($this->voyages,
                ['visites' => $visites]);
    }

    #[Route('/voyages/recherche/{champ}', name: 'voyages.findallequal')]
    public function findAllEqual($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
        $valeur = $request->get("recherche");
        $visites = $this->repository->findByEqualValue($champ, $valeur);
        return $this->render($this->voyages,
                ['visites' => $visites]);
    }
    return $this->redirectToRoute("voyages");
        }

    #[Route('/voyages/voyage/{id}', name: 'voyages.showone')]
    public function showOne($id): Response{
        $visite = $this->repository->find($id);
        return $this->render($this->voyages,
                ['visite' => $visite]);
    }
    
     /**
     * @var VisiteRepository
     */
    private $repository;
     
    /**
     *
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository){
        $this->repository = $repository;
    }
}
