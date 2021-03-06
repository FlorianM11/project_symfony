<?php

namespace App\Controller;

use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\TenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tenant")
 */
class TenantController extends AbstractController
{
    /**
     * @Route("/", name="tenant_index", methods={"GET"})
     */
    public function index(TenantRepository $tenantRepository): Response
    {
        return $this->render('tenant/index.html.twig', [
            'tenants' => $tenantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tenant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tenant = new Tenant();
        $form = $this->createForm(TenantType::class, $tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tenant);
            $entityManager->flush();

            return $this->redirectToRoute('tenant_index');
        }

        return $this->render('tenant/new.html.twig', [
            'tenant' => $tenant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tenant_show", methods={"GET"})
     */
    public function show(Tenant $tenant): Response
    {
        $form = $this->createForm(TenantType::class, $tenant, ['disabled' => true, 'required' => false]);
        return $this->render('tenant/show.html.twig', [
            'form' => $form->createView(),
            'tenant' => $tenant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tenant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tenant $tenant): Response
    {
        $form = $this->createForm(TenantType::class, $tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tenant_index');
        }

        return $this->render('tenant/edit.html.twig', [
            'tenant' => $tenant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tenant_delete", methods={"POST"})
     */
    public function delete(Request $request, Tenant $tenant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tenant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tenant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tenant_index');
    }
}
