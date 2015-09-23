<?php

/**
 * Samples\Controller
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Samples\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Samples\Entity\Sample;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineExtensions\Query\Mysql\Year;

//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;


//fine per migrazione

class StatsController extends EntityUsingController
{

    /**
     * @var Samples\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Samples\Mapper\SampleMapper
     */
    protected $sampleMapper;

    /**
     *
     * @var type Samples\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->sampleMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }
    
    public function indexAction()
    {

    }

    public function stat1Action()
    {
        $year = $sampleId = $this->getEvent()->getRouteMatch()->getParam('year');
        
        if ($year == 0) {
            return array(
                'showSelect' => true,
            );            
        }
        
        $processedStatus = [
            \Samples\Entity\Status::STATUS_TYPE_PROCESSED,
            \Samples\Entity\Status::STATUS_TYPE_SHIPPED
        ];

        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomStringFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $config->addCustomStringFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');



        $total = $this->getEntityManager()->createQuery('SELECT SUM(s.qta) tot, MONTH(s.createdDate) m FROM Samples\Entity\Sample s WHERE YEAR(s.createdDate) = ' . $year . ' GROUP BY m');
        $processed = $this->getEntityManager()->createQuery('SELECT SUM(s.qta) tot, MONTH(s.createdDate) m FROM Samples\Entity\Sample s WHERE s.status IN (' . implode(',', $processedStatus) . ') AND YEAR(s.createdDate) = ' . $year . ' GROUP BY m');

        return array(
            'totals' => $total->getResult(),
            'processed' => $processed->getResult(),
            'year' => $year,
        );
    }




}
