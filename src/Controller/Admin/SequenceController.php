<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Controller\Admin;

use KejawenLab\Semart\Surat\Entity\Sequence;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Sequence\SequenceService;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use KejawenLab\Semart\Surat\Security\Authorization\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/sequences")
 *
 * @Permission(menu="SEQUENCE")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SequenceController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="sequences_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator)
    {
        $sequences = $paginator->paginate(Sequence::class, (int) $request->query->get('p', 1));

        if ($request->isXmlHttpRequest()) {
            $table = $this->renderView('sequence/table-content.html.twig', ['sequences' => $sequences]);
            $pagination = $this->renderView('sequence/pagination.html.twig', ['sequences' => $sequences]);

            return new JsonResponse([
                'table' => $table,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('sequence/index.html.twig', ['title' => 'Penomeran', 'sequences' => $sequences]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="sequences_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, SequenceService $service, SerializerInterface $serializer)
    {
        $sequence = $service->get($id);
        if (!$sequence) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($sequence, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="sequences_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, SequenceService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $sequence = $service->get($primary);
        } else {
            $sequence = new Sequence();
        }

        $requestHandler->handle($request, $sequence);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($sequence);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="sequences_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, SequenceService $service)
    {
        if (!$sequence = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($sequence);

        return new JsonResponse(['status' => 'OK']);
    }
}
