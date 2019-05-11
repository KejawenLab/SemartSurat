<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Controller\Admin;

use KejawenLab\Semart\Surat\Entity\Group;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use KejawenLab\Semart\Surat\Security\Authorization\Permission;
use KejawenLab\Semart\Surat\Security\Service\GroupService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/groups")
 *
 * @Permission(menu="GROUP")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class GroupController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="groups_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator)
    {
        $groups = $paginator->paginate(Group::class, (int) $request->query->get('p', 1));

        if ($request->isXmlHttpRequest()) {
            $table = $this->renderView('group/table-content.html.twig', ['groups' => $groups]);
            $pagination = $this->renderView('group/pagination.html.twig', ['groups' => $groups]);

            return new JsonResponse([
                'table' => $table,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('group/index.html.twig', ['title' => 'Grup', 'groups' => $groups]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="groups_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, GroupService $service, SerializerInterface $serializer)
    {
        $group = $service->get($id);
        if (!$group) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($group, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="groups_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, GroupService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $group = $service->get($primary);
        } else {
            $group = new Group();
        }

        if (!$group) {
            throw new NotFoundHttpException();
        }

        $requestHandler->handle($request, $group);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($group);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="groups_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, GroupService $service)
    {
        if (!$group = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($group);

        return new JsonResponse(['status' => 'OK']);
    }
}
