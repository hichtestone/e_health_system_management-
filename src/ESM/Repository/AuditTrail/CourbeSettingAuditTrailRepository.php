<?php

namespace App\ESM\Repository\AuditTrail;

use App\ESM\Entity\AuditTrail\CourbeSettingAuditTrail;
use App\ESM\Repository\AuditTrailTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourbeSettingAuditTrail|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourbeSettingAuditTrail|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourbeSettingAuditTrail[]    findAll()
 * @method CourbeSettingAuditTrail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourbeSettingAuditTrailRepository extends ServiceEntityRepository
{
    use AuditTrailTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourbeSettingAuditTrail::class);
    }
}
