<?php

namespace App\ESM\ListGen;

use App\ESM\Entity\Center;
use App\ESM\Entity\Project;
use App\ESM\Service\ListGen\AbstractListGenType;

/**
 * Class CenterList.
 */
class CenterList extends AbstractListGenType
{
    /**
     * @return mixed
     */
    public function getList(Project $project)
    {
        $repository = $this->em->getRepository(Center::class);
        $url = 'project.center.index.ajax';
        $urlArgs = ['id' => $project->getId()];

        $list = $this->lg->setAjaxUrl($this->router->generate($url, $urlArgs))
            ->setClass('table')
            ->setRowData(['id' => 'id'])
            ->addHiddenData([
                'field' => 'c',
                'alias' => 'center',
            ])
            ->addHiddenData([
                'field' => 'c.id',
            ])
            ->setRepository($repository)
            ->setRepositoryMethod('indexCenterListGen', [$project])
            ->setExportFileName('centers')
            ->addConstantSort('c.id', 'ASC')
            ->addMultiAction([
                'label' => 'Changer statut',
                'href' => $this->router->generate('project.center.attach_mass_popup', ['id' => $project->getId()]),
                'displayer' => function ($security) use ($project) {
                    return $security->isGranted('PROJECT_ACCESS_AND_OPEN', $project) && $security->isGranted('ROLE_CENTER_WRITE');
                },
                'displayerRow' => function ($row) {
                    return null === $row['center']->getDeletedAt();
                },
            ]);

        $list
            ->addColumn([
                'label' => 'entity.Center.label',
                'formatter' => function ($row) use ($project) {
                    return '<a href="'.$this->router->generate('project.center.show', ['id' => $project->getId(), 'idCenter' => $row['center']->getId()]).'">'.
                        $row['center']->getNumber().' '.$row['center']->getName().'</a>';
                },
                'formatter_csv' => function ($row) {
                    return $row['center']->getNumber().' '.$row['center']->getName();
                },
                'field' => 'c.number',
            ])
           ->addColumn([
                'label' => 'entity.Institution.label',
                'formatter' => function ($row) use ($project) {
                    $arr = array_map(function ($institution) use ($row, $project) {
                        $str = $institution->getName().' '.$institution->getCity().' '.$institution->getAddress1();

                        return '<a href="'.$this->router->generate('project.center.show.institution.show', ['id' => $project->getId(), 'idCenter' => $row['center']->getId(), 'institutionID' => $institution->getId()]).'" data-sw-link="'.$this->router->generate('project.center.show.institution.show', ['id' => $project->getId(), 'idCenter' => $row['center']->getId(), 'institutionID' => $institution->getId()]).'" data-sw-type="information" data-sw-title="'.$str.'">'.$str.'</a>';
                    }, $row['center']->getInstitutions()->toArray());

                    return implode('<br />', $arr);
                },
                'formatter_csv' => function ($row) {
                    $arr = array_map(function ($institution) {
                        return $institution->getName().' '.$institution->getCity().' '.$institution->getAddress1();
                    }, $row['center']->getInstitutions()->toArray());

                    return implode('; ', $arr);
                },
                'field' => 'i.name',
            ])
			->addColumn([
			   'label' => 'entity.Institution.field.country',
			   'field' => 'p.code',
		   ])
			->addColumn([
				'label' => 'entity.Center.field.principal_investigator',
				'formatter' => function ($row) use ($project) {
					$arr = array_map(function ($interlocuteur) use ($project) {
						return '<a href="'.$this->router->generate('project.interlocutor.show', ['id' => $project->getId(), 'idInterlocutor' => $interlocuteur->getId()]).'">'.$interlocuteur->getFullName().'</a>';
					}, $row['center']->getPrincipalInvestigators()->toArray());

					return implode('<br />', $arr);
				},
				'formatter_csv' => function ($row) {
					$arr = array_map(function ($interlocuteur) {
						return $interlocuteur->getFullName();
					}, $row['center']->getPrincipalInvestigators()->toArray());

					return implode('; ', $arr);
				},
				'field' => 'i.name',
			])
			->addColumn([
				'label' => 'Nombre de patients',
				'formatter' => function ($row) {
					return count($row['center']->getPatients());
				},
				'formatter_csv' => function ($row) {
					return count($row['center']->getPatients());
				},
				'field' => 'c.number',
			])
			->addColumn([
				'label' => 'entity.Center.field.centerStatus',
				'formatter' => function ($row) {
					return $row['center']->getCenterStatus();
				},
				'formatter_csv' => function ($row) {
					return $row['center']->getCenterStatus();
				},
				'sortField' => 'c.centerStatus',
			])
            ->addAction([
                'href' => function ($row) use ($project) {
                    return $this->router->generate('project.center.show', ['id' => $project->getId(), 'idCenter' => $row['center']->getId()]);
                },
                'formatter' => function ($row) {
                    return '<i class="fa fa-eye c-grey"></i>';
                },
            ])
            ->addFilter([
                'label' => 'entity.Center.field.number',
                'field' => 'c.id',
                'selectLabel' => 'c.number',
            ], 'select')
            ->addFilter([
                'label' => 'Statut',
                'field' => 'cs.id',
                'selectLabel' => 'cs.label',
            ], 'select')
        ;

        return $list;
    }
}
