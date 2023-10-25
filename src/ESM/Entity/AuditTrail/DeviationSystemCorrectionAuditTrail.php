<?php

namespace App\ESM\Entity\AuditTrail;

use App\ESM\Entity\DeviationSystemCorrection;
use App\ESM\Repository\AuditTrail\DeviationSystemCorrectionAuditTrailRepository;
use App\ESM\Service\AuditTrail\AbstractAuditTrailEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviationSystemCorrectionAuditTrailRepository::class)
 */
class DeviationSystemCorrectionAuditTrail extends AbstractAuditTrailEntity
{
	/**
	 * @ORM\ManyToOne(targetEntity="App\ESM\Entity\DeviationSystemCorrection")
	 * @ORM\JoinColumn(nullable=false)
	 *
	 * @var DeviationSystemCorrection
	 */
	private $entity;

	/**
	 * @return DeviationSystemCorrection
	 */
	public function getEntity(): DeviationSystemCorrection
	{
		return $this->entity;
	}

	/**
	 * @param DeviationSystemCorrection $entity
	 */
	public function setEntity(DeviationSystemCorrection $entity): void
	{
		$this->entity = $entity;
	}
}
