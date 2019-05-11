<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Controller\Admin;

use KejawenLab\Semart\Surat\Entity\Menu;
use KejawenLab\Semart\Surat\Menu\MenuService;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use KejawenLab\Semart\Surat\Security\Authorization\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/menus")
 *
 * @Permission(menu="MENU")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class MenuController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="menus_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator, MenuService $menuService)
    {
        $menus = $paginator->paginate(Menu::class, (int) $request->query->get('p', 1));

        if ($request->isXmlHttpRequest()) {
            $table = $this->renderView('menu/table-content.html.twig', ['menus' => $menus]);
            $pagination = $this->renderView('menu/pagination.html.twig', ['menus' => $menus]);

            return new JsonResponse([
                'table' => $table,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('menu/index.html.twig', ['title' => 'Menu', 'menus' => $menus, 'parents' => $menuService->getActiveMenus()]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="menus_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, MenuService $service, SerializerInterface $serializer)
    {
        $menu = $service->get($id);
        if (!$menu) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($menu, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="menus_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, MenuService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $menu = $service->get($primary);
        } else {
            $menu = new Menu();
        }

        if (!$menu) {
            throw new NotFoundHttpException();
        }

        $requestHandler->handle($request, $menu);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($menu);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="menus_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, MenuService $service)
    {
        if (!$menu = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($menu);

        return new JsonResponse(['status' => 'OK']);
    }
}
