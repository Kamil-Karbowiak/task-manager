<?php

namespace Tests;

use Mvc2\Pagination\ArrayAdapter;
use Mvc2\Pagination\Pagination;

class PaginationTest extends \PHPUnit\Framework\TestCase
{
    private $arrayAdapter;
    private $pagination;

    public function setUp(){
        $this->arrayAdapter = $this->getMockBuilder(ArrayAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->pagination = new Pagination();
    }

    public function setArrayAdapterNrResults($itemsCount){
        $this->arrayAdapter
            ->expects($this->any())
            ->method('getItemsCount')
            ->willReturn($itemsCount);
    }

    /**
     * @dataProvider getResultsPerPageProvider
     */
    public function testGetResultsPerPage($itemsCount, $limit, $pageNr, $perPageExpected){
        $this->setArrayAdapterNrResults($itemsCount);
        $this->pagination->paginate($this->arrayAdapter, $limit, $pageNr);
        $this->assertSame($perPageExpected, $this->pagination->getResultsPerPage());
    }
    public function getResultsPerPageProvider(){
        // itemsCount, limit, pageNr, perPage
        return[
            [100, 10, 1, 10],
            [100, 1, 1, 1],
            [100, 200, 1, 5],
            [100, 0, 1, 5],
        ];
    }

    /**
     * @dataProvider getPagesCountProvider
     */
    public function testGetPagesCount($itemsCount, $limit, $pageNr, $pagesCountExpected){
        $this->setArrayAdapterNrResults($itemsCount);
        $this->pagination->paginate($this->arrayAdapter, $limit, $pageNr);
        $this->assertSame($pagesCountExpected, $this->pagination->getPagesCount());
    }

    public function getPagesCountProvider(){
        // itemsCount, limit, pageNr, pagesCount
        return [
            [100, 10, 1, 10],
            [10, 10, 1, 1],
            [200, 10, 1, 20],
            [0, 10, 1, 0],
            [100, 150, 1, 20],
            [100, 0, 1, 20],
            [0, 150, 1, 0],
        ];
    }
    /**
     * @dataProvider getCurrentPageProvider
     */
    public function testGetCurrentPage($itemsCount, $limit, $pageNr, $currentPageExpected){
        $this->setArrayAdapterNrResults($itemsCount);
        $this->pagination->paginate($this->arrayAdapter, $limit, $pageNr);
        $this->assertSame($currentPageExpected, $this->pagination->getCurrentPage());
    }
    public function getCurrentPageProvider(){
        // itemsCount, limit, currentPageNr, currentPageNrExpected
        return [
            [100, 5, 21, 1],
            [100, 5, -1, 1],
            [10, 50, 2, 1],
            [0, 5, 0, 1],
        ];
    }

    /**
     * @dataProvider getFirstItemNrProvider
     */
    public function testGetFirstItemNr($itemsCount, $limit, $pageNr, $firstItemNrExpected){
        $this->setArrayAdapterNrResults($itemsCount);
        $this->pagination->paginate($this->arrayAdapter, $limit, $pageNr);
        $this->assertSame($firstItemNrExpected, $this->pagination->getFirstItemNr());
    }
    public function getFirstItemNrProvider(){
        // itemsCount, limit, currentPageNr, firstItemNrExpected
        return[
            [100, 5, 1, 1],
            [100, 5, 2, 6],
            [100, 5, 21, 1],
            [100, 110, 2, 6],
        ];
    }
}
