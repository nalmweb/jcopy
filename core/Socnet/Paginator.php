<?php

 class Socnet_Paginator
 {
    // rows count
    public $nRows;
    // current page
    public $nPage;
    // rows per page
    public $nPageSize;
    // rows per page
    public $nFrameSize; //pages per frame
    // count of pages
    public $nPagesCount;
    // first row for limit statement
    public $nFirstRow;
    // last row
    public $nLastRow; // last row

    // field for current sorting
    public $sSortField='';
    // order (asc/desc) of current sort
    public $sSortOrder='';

    // aliases of available for sorting fields
    public $aFields = array();

    public $oUrl;

    /*
    function __construct ($oUrl, $nRows, $nPage , $nPageSize , $nFrameSize )
    {
        $this->oUrl = $oUrl;
        $this->nRows      = max(intVal($nRows), 0);
        $this->nPageSize  = max(intVal($nPageSize), 1);
        $this->nFrameSize = max(intVal($nFrameSize), 1);
        $this->nPagesCount = ceil($this->nRows / $this->nPageSize);
        //$this->nPage       = min($this->nPagesCount, max(intVal($nPage), 1));
        $this->nPage       = max(1, min($this->nPagesCount, intVal($nPage)));
        $this->nFirstRow   = $this->nPageSize*($this->nPage-1);
        //$this->nFirstRow   = $this->nPageSize*($nPage-1);
        $this->nLastRow    = min($this->nFirstRow + $this->nPageSize, $this->nRows);
    }
    */
    
    
    function __construct ($oUrl, $nRows, $nPage , $nPageSize , $nFrameSize)
    {
        $this->oUrl = $oUrl;
        $this->nRows      = max(intVal($nRows), 0);
        $this->nPageSize  = max(intVal($nPageSize), 1, MIN_NUMBER_LINE);
        $this->nFrameSize = max(intVal($nFrameSize), 1);
        $this->nPagesCount = ceil($this->nRows / $this->nPageSize);
        //$this->nPage       = min($this->nPagesCount, max(intVal($nPage), 1));
        $this->nPage       = max(1, min($this->nPagesCount, intVal($nPage)));
        // first 
        $this->nFirstRow   = $this->nPageSize*($this->nPage-1);
        //$this->nFirstRow   = $this->nPageSize*($nPage-1);
        $this->nLastRow    = min($this->nFirstRow + $this->nPageSize, $this->nRows);
        $this->sSortOrder = 'down';
    }
    

    function getFirst()
    {
    	 return $this->nLastRow;
         // return $this->nFirstRow;
    }

    function getLimit()
    {
            return $this->nLastRow - $this->nFirstRow;
    }

    function setNumRows($n)
    {
        $this->nRows=$n;
        $this->nPagesCount = ceil($this->nRows / $this->nPageSize);
    }

    function setCurPageNum ($num)
    {
        $this->nPage = $num;
    }

    function getPagingInfo($pageNum)
    {
        $this->nPage = $pageNum;
        
        // echo "psize=".$this->nPageSize;
        // echo $this->nRows." div=".$this->nRows/$this->nPageSize;
        $this->nPagesCount = ceil($this->nRows / $this->nPageSize);
        
        // echo "page count".$this->nPagesCount;
        $p = 'page';
        $sFirstUrl = '';
        $sPrevUrl  = '';
        $sNextUrl  = '';
        $sLastUrl  = '';
        $aUrls = array();
        
        if(1 != $this->nPage)
        {
	       $this->oUrl->setParam($p, 1);
	       $sFirstUrl = $this->oUrl->getUrl();
	       $this->oUrl->setParam($p, $this->nPage-1);
	       $sPrevUrl = $this->oUrl->getUrl();
        }

        list($nStart, $nEnd) = $this->_getPos();

        for ($i=$nEnd; $i >= $nStart; --$i)
        {
            if ($this->nPage == $i)
                $aUrls[''] = $i;
            else
            {
                $this->oUrl->setParam($p, $i);
                $aUrls[$this->oUrl->getUrl()] = $i;
            }
        }

        if ($this->nPagesCount != $this->nPage)
        {
            $this->oUrl->setParam($p, $this->nPage+1);
            $sNextUrl = $this->oUrl->getUrl();
            $this->oUrl->setParam($p, $this->nPagesCount);
            $sLastUrl = $this->oUrl->getUrl();
        }
        
        $myurl = " ";
        $sLastUrlNumber = $this->getPageNumber($sLastUrl);
        $sNextUrlNumber = $this->getPageNumber($sNextUrl);
        $sPrevUrlNumber = $this->getPageNumber($sPrevUrl);
        $sFirstUrlNumber= $this->getPageNumber($sFirstUrl);

        return array(
                'totalPages' => $this->nPagesCount,
                'totalRows'  => $this->nRows,
                'current'    => $this->nPage,
                /* org
	                'fromRow'    => $this->nFirstRow+1,
	                'toRow'      => $this->nLastRow,                
                */
                'fromRow'    => $this->nLastRow,
                'toRow'      => $this->nFirstRow+1,
                'firstUrl'   => $sLastUrl,
                'firstUrlNum'=> $sLastUrlNumber,
                'prevUrl'    => $sNextUrl,
                'prevUrlNum' => $sNextUrlNumber, 
                'nextUrl'    => $sPrevUrl,
                'nextUrlNum' => $sPrevUrlNumber,
                'lastUrl'    => $sFirstUrl,
                'lastUrlNum'    => $sFirstUrlNumber,
                'urls'       => $aUrls,
                'nFrameSize' => $this->nFrameSize
                );
    }

	function getPagingInfoDirect($pageNum)
	{           
		$this->nPage = $pageNum;
		$this->nPagesCount = ceil($this->nRows / $this->nPageSize);
		$p = 'page';

 		$sFirstUrl = '';
        $sPrevUrl  = '';
        $sNextUrl  = '';
        $sLastUrl  = '';
            
        $aUrls = array();

        if (1 != $this->nPage)
        {
                $this->oUrl->setParam($p, 1);
                $sFirstUrl = $this->oUrl->getUrl();
                $this->oUrl->setParam($p, $this->nPage-1);
                $sPrevUrl = $this->oUrl->getUrl();
        }

        list($nStart, $nEnd) = $this->_getPos();
                
        for ($i=$nStart; $i <= $nEnd; ++$i)
        {
            if ($this->nPage == $i)
                $aUrls[''] = $i;
            else
            {
                $this->oUrl->setParam($p, $i);
                $aUrls[$this->oUrl->getUrl()] = $i;
            }
        }

        if ($this->nPagesCount != $this->nPage)
        {
                        $this->oUrl->setParam($p, $this->nPage+1);
                       $sNextUrl = $this->oUrl->getUrl();
            $this->oUrl->setParam($p, $this->nPagesCount);
                       $sLastUrl = $this->oUrl->getUrl();
                }

          return array(
                'totalPages' => $this->nPagesCount,
                'totalRows'  => $this->nRows,
                'current'    => $this->nPage,
                'fromRow'    => $this->nFirstRow+1,
                'toRow'      => $this->nLastRow,
                'firstUrl'   => $sFirstUrl,
                'prevUrl'    => $sPrevUrl,
                'nextUrl'    => $sNextUrl,
                'lastUrl'    => $sLastUrl,
                'urls'       => $aUrls
                );
    }


    
    

    function _getPos()
    {
        $nStart = 1;

        if (($this->nPage - $this->nFrameSize/2)>0)
        {
             if (($this->nPage + $this->nFrameSize/2) > $this->nPagesCount)
                  $nStart = (($this->nPagesCount - $this->nFrameSize)>0) ?
                                ( $this->nPagesCount - $this->nFrameSize + 1) : 1;
             else
                    $nStart = $this->nPage - floor($this->nFrameSize/2);
        }

        $nEnd = (($nStart + $this->nFrameSize - 1) < $this->nPagesCount) ?
        			($nStart + $this->nFrameSize - 1) : $this->nPagesCount;
        return array($nStart, $nEnd);
    }

   ///
   function getSortingInfo($aFields)
   {
        $aSortParam = array();

        $sField = $aFields[0];

        $sOrder  = ('up'   == $aFields[1] ? 'up': 'down');
        $sROrder = ('down' == $sOrder    ? 'up': 'down');

        $oUrl = $this->oUrl;
        $oUrl->setParam('page', null);
        for($i=2, $n=sizeof($aFields); $i<$n; ++$i)
        {
            $oUrl->setParam('field', $aFields[$i]);
            $oUrl->setParam('order', $sField == $aFields[$i] ? $sROrder : 'down');
            $aSortParam[$aFields[$i]]['url'] = $oUrl->getUrl();
            $aSortParam[$aFields[$i]]['img'] = '0.gif';
        }

        $oUrl->setParam('field', $sField);
        $oUrl->setParam('order', $sROrder);

        $aSortParam[$sField]['url'] = $oUrl->getUrl();
        $aSortParam[$sField]['img'] = ('down'== $sOrder ? 'down.gif' : 'up.gif');

        $aSortParam[0] = $sField;
        $aSortParam[1] = $sOrder=='up'?'asc':'desc';

    return $aSortParam;
    }

    // new functions
////////////////////////////////////////////
    function getSorting($oUrl)
    {
        // array url + img
        $aSortParam = array();

        $oUrl->setParam('page', null);
        foreach($this->aFields as $sField)
        {
            $oUrl->setParam('field', $sField);
            $oUrl->setParam('order', 'up');
            $aSortParam[$sField]['url'] = $oUrl->getUrl();
            $aSortParam[$sField]['img'] = '0.gif';
        }

        $oUrl->setParam('field', $this->sSortField);
        $oUrl->setParam('order', ('up' == $this->sSortOrder ? 'down': 'up'));

        $aSortParam[$this->sSortField]['url'] = $oUrl->getUrl();
        $aSortParam[$this->sSortField]['img'] = ('down'== $this->sSortOrder ? 'down.gif' : 'up.gif');

        return $aSortParam;
    }


    function getPaging($oUrl)
    {
        $sFirstUrl = '';
        $sPrevUrl  = '';
        $sNextUrl  = '';
        $sLastUrl  = '';

        $aUrls = array();
        $oUrl = $this->oUrl;

        if (1 != $this->nPage)
        {
            $oUrl->setParam('', 1);
            $sFirstUrl = $oUrl->getUrl();
            $oUrl->setParam('', $this->nPage-1);
            $sPrevUrl = $oUrl->getUrl();
        }

        list($nStart, $nEnd) = $this->_getPos();
        for ($i=$nStart; $i <= $nEnd; ++$i)
        {
            if ($this->nPage == $i)
                $aUrls[''] = $i;
            else
            {
                $oUrl->setParam('', $i);
                $aUrls[$oUrl->getUrl()] = $i;
            }
        }
        
        if ($this->nPagesCount != $this->nPage)
        {
            $oUrl->setParam('', $this->nPage+1);
            $sNextUrl = $oUrl->getUrl();
            $oUrl->setParam('', $this->nPagesCount);
            $sLastUrl = $oUrl->getUrl();
        }
        
        

        return array(
            'totalPages' => $this->nPagesCount,
            'totalRows'  => $this->nRows,
            'current'    => $this->nPage,
            'fromRow'    => $this->nFirstRow+1,
            'toRow'      => $this->nLastRow,
            'firstUrl'   => $sFirstUrl,
            'prevUrl'    => $sPrevUrl,
            'nextUrl'    => $sNextUrl,
            'lastUrl'    => $sLastUrl,
            'urls'       => $aUrls,
            'nFrameSize' => $this->nFrameSize
        );
    }

	// 
    function getInfo()
    {
        return array($this->nFirstRow, $this->nLastRow, $this->sSortField, $this->sSortOrder);
    }

    function setSorting($aFields, $sField, $sOrder='up')
    {
       $this->sSortField = in_array($sField, $aFields) ? $sField : current($aFields);
       $this->sSortOrder = ($sOrder == 'up' ? 'up' : 'down');
       $this->aFields    = $aFields;
    }
    
    /**
     *  url: site/param/taram/page/1 - get 1.
     *  $aUrlParams - array of url params.
     */
    function getPageNumber($aUrlParams)
    {	   
	   if(empty($aUrlParams)) return "";
	   
	   else if(is_string($aUrlParams))
	   	$aUrlParams = explode("/",$aUrlParams);
	   	
	   for($i=0;$i<count($aUrlParams); $i++)
	   {
	   		if($aUrlParams[$i]=="page")
	   		{
	   		  if(isset($aUrlParams[$i+1]))
	   		  		return $aUrlParams[$i+1];
	   		  else return 1;		 	
	   		}
	   }
	   return 0;
    }
    
    function setPageNumber($n){
		$this->nPage = $n;
	}
	function getPageSize(){
    	return $this->nPageSize;
    }
	
    
}

?>