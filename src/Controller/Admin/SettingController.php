<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Surat\Controller\Admin;

use KejawenLab\Semart\Surat\Entity\Setting;
use KejawenLab\Semart\Surat\Pagination\Paginator;
use KejawenLab\Semart\Surat\Request\RequestHandler;
use KejawenLab\Semart\Surat\Security\Authorization\Permission;
use KejawenLab\Semart\Surat\Setting\SettingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/settings")
 *
 * @Permission(menu="SETTING")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class SettingController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="settings_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator)
    {
        $settings = $paginator->paginate(Setting::class, (int) $request->query->get('p', 1));

        if ($request->isXmlHttpRequest()) {
            $table = $this->renderView('setting/table-content.html.twig', ['settings' => $settings]);
            $pagination = $this->renderView('setting/pagination.html.twig', ['settings' => $settings]);

            return new JsonResponse([
                'table' => $table,
                'pagination' => $pagination,
            ]);
        }

        return $this->render('setting/index.html.twig', ['title' => 'Setting', 'settings' => $settings]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="settings_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, SettingService $service, SerializerInterface $serializer)
    {
        $setting = $service->get($id);
        if (!$setting) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($setting, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="settings_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, SettingService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $setting = $service->get($primary);
        } else {
            $setting = new Setting();
        }

        if (!$setting) {
            throw new NotFoundHttpException();
        }

        $requestHandler->handle($request, $setting);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($setting);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="settings_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, SettingService $service)
    {
        if (!$setting = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($setting);

        return new JsonResponse(['status' => 'OK']);
    }
}
