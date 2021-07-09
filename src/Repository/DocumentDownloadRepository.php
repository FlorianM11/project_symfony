<?php

/*
 * This file is part of Immobilus.
 * Copyright (c) 2019 - 2021 Cimali - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Developped by SILARHI <dev@silarhi.fr>
 */

namespace App\Repository;

use App\Entity\Document;
use App\Entity\DocumentDownload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentDownload|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentDownload|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentDownload[]    findAll()
 * @method DocumentDownload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentDownloadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentDownload::class);
    }

    /**
     * @return DocumentDownload[]
     */
    public function findByDocument(Document $document): array
    {
        return $this
            ->createQueryBuilder('dd')
            ->where('dd.document = :document')
            ->setParameter('document', $document)
            ->addOrderBy('dd.createdAt', 'desc')
            ->getQuery()
            ->execute();
    }
}
