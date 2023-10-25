<?php

namespace App\ESM\Repository\AuditTrail;

use App\ESM\Entity\AuditTrail\DeviationSystemAuditTrail;
use App\ESM\Repository\AuditTrailTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeviationSystemAuditTrail|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviationSystemAuditTrail|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviationSystemAuditTrail[]    findAll()
 * @method DeviationSystemAuditTrail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviationSystemAuditTrailRepository extends ServiceEntityRepository
{
	use AuditTrailTrait;

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, DeviationSystemAuditTrail::class);
	}

	/**
	 * @return QueryBuilder
	 */
	public function auditTrailListGen()
	{
		return $this->createQueryBuilder('at')
			->innerJoin('at.entity', 'd')
			->leftJoin('at.user', 'u')
			;
	}
}
