<?

class Socnet_Paginator_Item
{
  // rows count
  public $nPageSize;
  public $oUrl;
  public $oPaginator;
  public $info = null;
  public $page = null;

  function __construct ($url, $nPageSize)
  {
    $this->oUrl = new Socnet_URL($url);
    $this->nPageSize = $nPageSize;
    $this->oPaginator = new Socnet_Paginator($this->oUrl, 5 , 1 , MIN_NUMBER_LINE, 15);
    $this->setPage();
    $this->oPaginator->setPageNumber($this->page);
    $this->oPaginator->setNumRows($this->nPageSize);
    $this->setInfo();
  }

  function setInfo($info = null){
    if($info)
      $this->info = $info;
    else
      $this->info = $this->oPaginator->getPagingInfoDirect($this->page);
    return $this->info;
  }
  function getInfo(){
    return $this->info ? $this->info : $this->setInfo();
  }

  function setPage($page = null){
    if($page)
      $this->page = $page;
    else
      $this->page = getUrlParam('page');
    $this->page = ($this->page <= 0) ? $this->page = 1 :$this->page;
    return $this->page;
  }
  function getPage(){
    return $this->page ? $this->page : $this->setPage();
  }

}

?>