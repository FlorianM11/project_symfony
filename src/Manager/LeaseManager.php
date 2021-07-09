<?php


namespace App\Manager;


use App\Entity\Lease;
use Symfony\Component\Form\FormInterface;

class LeaseManager
{

    public function setTenants(Lease $lease, FormInterface $form)
    {
        $tenantsInForm = $form->get('tenants')->getData();
        $tenants = $lease->getTenants();

        //init
        foreach ($tenants as $tenant){
            $lease->removeTenant($tenant);
        }

        //Add
        foreach ($tenantsInForm as $tenantInForm){
            $lease->addTenant($tenantInForm);
        }
    }
}