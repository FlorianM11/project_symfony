<?php

namespace App\Controller;

use App\Entity\Lease;
use App\Form\LeaseType;
use App\Manager\LeaseManager;
use App\Repository\LeaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lease")
 */
class LeaseController extends AbstractController
{
    /**
     * @Route("/", name="lease_index", methods={"GET"})
     */
    public function index(LeaseRepository $leaseRepository): Response
    {
        return $this->render('lease/index.html.twig', [
            'leases' => $leaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lease_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lease = new Lease();
        $form = $this->createForm(LeaseType::class, $lease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $tenants = $form->get('tenants')->getData();
            foreach ($tenants as $tenant){
                $lease->addTenant($tenant);
            }

            $entityManager->persist($lease);
            $entityManager->flush();

            return $this->redirectToRoute('lease_index');
        }

        return $this->render('lease/new.html.twig', [
            'lease' => $lease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lease_show", methods={"GET"})
     */
    public function show(Lease $lease): Response
    {
        $form = $this->createForm(LeaseType::class, $lease, ['disabled' => true, 'required' => false]);

        $form->get('tenants')->setData($lease->getTenants());

        return $this->render('lease/show.html.twig', [
            'form' => $form->createView(),
            'lease' => $lease,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lease_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lease $lease, LeaseManager $leaseManager): Response
    {
        $form = $this->createForm(LeaseType::class, $lease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leaseManager->setTenants($lease, $form);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lease_index');
        }

        $form->get('tenants')->setData($lease->getTenants());

        return $this->render('lease/edit.html.twig', [
            'lease' => $lease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lease_delete", methods={"POST"})
     */
    public function delete(Request $request, Lease $lease): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lease->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lease);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lease_index');
    }
}
