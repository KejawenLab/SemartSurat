<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Controller\Admin;

use KejawenLab\Semart\Surat\Entity\Letter;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Letter\LetterService;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use KejawenLab\Semart\Surat\Security\Authorization\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/letters")
 *
 * @Permission(menu="LETTER")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class LetterController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="letters_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator)
    {
        $letters = $paginator->paginate(Letter::class, (int) $request->query->get('p', 1));

        if ($request->isXmlHttpRequest()) {
            $table = $this->renderView('letter/table-content.html.twig', ['letters' => $letters]);
            $pagination = $this->renderView('letter/pagination.html.twig', ['letters' => $letters]);

            return new JsonResponse([
                'table' => $table,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('letter/index.html.twig', ['title' => 'Letter', 'letters' => $letters]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="letters_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, LetterService $service, SerializerInterface $serializer)
    {
        $letter = $service->get($id);
        if (!$letter) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($letter, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="letters_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, LetterService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $letter = $service->find($primary);
        } else {
            $letter = new Letter();
        }

        $requestHandler->handle($request, $letter);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($letter);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="letters_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, LetterService $service)
    {
        if (!$letter = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($letter);

        return new JsonResponse(['status' => 'OK']);
    }
}
