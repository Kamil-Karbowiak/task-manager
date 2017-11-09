<?php
namespace TaskManager\Pagination;

class Pagination
{
    private $resultsPerPage = 5;
    private $items          = [];
	private $pagesCount     = 0;
	private $resultsCount   = 0;
	private $currentPage    = 1;
	private $firstItemNr    = 0;

    public function getResultsPerPage()
    {
        return $this->resultsPerPage;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getPagesCount()
    {
        return $this->pagesCount;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getFirstItemNr()
    {
        return $this->firstItemNr;
    }

    public function paginate(ArrayAdapter $items, $limit = 5, $page = 1)
    {
	    $this->items = $items;
        $this->resultsPerPage = $limit > 50 || $limit < 1 ? 5 : (int)$limit;
        $this->calculatePagesCount();
        $this->currentPage = $page > $this->pagesCount || $page < 1 ? 1 : $page;
	    $this->setItemsForCurrentPage();
	    $this->setFirstItemNr();
    }

    private function setItemsForCurrentPage()
    {
        $start = ($this->currentPage * $this->resultsPerPage) - $this->resultsPerPage;
        $this->items = $this->items->getSlice($start, $this->resultsPerPage);
    }

    private function setFirstItemNr()
    {
        $this->firstItemNr = ($this->currentPage -1) * $this->resultsPerPage +1 ;
    }

    private function calculatePagesCount()
    {
        $this->resultsCount = $this->items->getItemsCount();
        if($this->resultsCount == 0 || $this->resultsPerPage == 0){
            $this->pagesCount = 0;
        }else{
            $pagesNr = ceil($this->resultsCount / $this->resultsPerPage);
            $this->pagesCount = (int)$pagesNr;
        }
    }
}
