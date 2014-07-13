<?php
class Socnet_Common_Paging
{
    private $_db;

    /**
     * page length
     * @var integer
     */
    public $postPerPage;

    /**
     * all data length
     * @var integer
     */
    public $totPosts;

    /**
     * count of pages
     * @var integer
     */
    public $totPages;

    /**
     * Uri without paging params.
     * @var string
     */
    public $link;

    /**
     * page length
     * @var integer
     */
    public $pageLength;

    public function __construct($totPosts, $postPerPage, $link)
    {
        $this->_db = Zend::registry('DB');

        $this->totPosts    = $totPosts;
        $this->postPerPage = $postPerPage;
        $this->totPages    = ceil($this->totPosts/$this->postPerPage);
        $this->pageLength  = 2;
        $this->link        = $link;
    }

    public function makePaging($currPage)
    {
        $i=0;
        if (floor($currPage)>$this->totPages && $this->totPages>0) header("location: ".$this->link."/page/".$this->totPages."/");
        if (floor($currPage)<1) header("location: ".$this->link."/page/1/");
        
        if ( $this->pageLength > $this->totPages ) {
            $this->pageLength = $this->totPages;
        }

        $str = '';
        $indent = intval($this->pageLength/2);
        $indent_r = $this->pageLength - $indent;

        if ($currPage + $indent_r >= $this->totPages) {
            $start = $currPage - ($this->pageLength - ($this->totPages - $currPage) + 1);
        } else {
            $start = $currPage - $indent;
        }

        if ($start <= 1 ) {
            $start=2;
        }
        
        $fromTo = (($currPage-1)*$this->postPerPage+1). "-" .($currPage==$this->totPages ? $this->totPosts : $currPage*$this->postPerPage);
        $str.= '<div class="Paginator">'.$fromTo.' из '.$this->totPosts.' всего</div><div class="Pagination">';
        
        if ($start > 2) {
            $str.= '<a href="'.$this->link.'/page/'.($currPage-1).'/">&laquo; Предыд.</a> <a href="'.$this->link.'/page/1/">1</a>..';
        }else {
            if ($currPage==1) {
                $str.= '<a class="Current">1</a> '; // $str.= '<a class="Current">&laquo; Prev</a><a class="Current">1</a> ';
            } else {
                $str.= '<a href="'.$this->link.'/page/'.($currPage-1).'/">&laquo; Предыд.</a> <a href="'.$this->link.'/page/1/">1</a> ';
            }
        }
        if ($this->totPages > 2) {
            if ($currPage-$indent > 0) {
                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=$start; $i<= $finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="Current">' . $i . '</a> ';
                    }else {
                        $str .= "<a href='" . $this->link . "/page/" . $i . "/'>" . $i . "</a> ";
                    }
                }
            }else {

                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=2; $i<=$finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="Current">' . $i . "</a> ";
                    } else {
                        $str .= "<a href='" . $this->link . "/page/" . $i ."/'>" . $i . "</a> ";
                    }
                }
            }
        }

        if ($i < $this->totPages  && $i>0) {
            $str.= " ..<a href='".$this->link."/page/".$this->totPages."/'>".$this->totPages.'</a> <a href="'.$this->link.'/page/'.($currPage+1).'/">След. &raquo;</a>';
        }else {
            if ($currPage==$this->totPages) {
                $str.='<a class="Current">'.$this->totPages.'</a>'; // $str.='<a class="Current">'.$this->totPages.'</a> <a class="Current">Next &raquo;</a>';
            }else {
                $str.= " <a href='".$this->link."/page/".$this->totPages."/'>".$this->totPages.'</a> <a href="'.$this->link.'/page/'.($currPage+1).'/">След. &raquo;</a>';
            }
        }
        
        $str.="</div>";
        if ($this->totPosts==0) {
            return '<div class="Paginator">&nbsp;</div><div class="Pagination">&nbsp;</div>';
        }elseif ($this->totPages<2) {
            return '<div class="Paginator">'.$fromTo.' из '.$this->totPosts.' всего</div><div class="Pagination"></div>';
        } else {
            return $str;
        }
    }
    
    public function makeInfoPaging($currPage)
    {
        
        $fromTo = (($currPage-1)*$this->postPerPage+1). "-" .($currPage==$this->totPages ? $this->totPosts : $currPage*$this->postPerPage);
        if ($this->totPosts==0) {
            return '&nbsp;';
        }else {
            return $fromTo.' из '.$this->totPosts.' всего';
        }
    }
        
    public function makeLinkPaging($currPage, $activeClassName = 'Current')
    {
        $i=0;
        if (floor($currPage)>$this->totPages && $this->totPages>0) header("location: ".$this->link."/page/".$this->totPages."/");
        if (floor($currPage)<1) header("location: ".$this->link."/page/1/");
        
        if ( $this->pageLength > $this->totPages ) {
            $this->pageLength = $this->totPages;
        }

        $str = '';
        $indent = intval($this->pageLength/2);
        $indent_r = $this->pageLength - $indent;

        if ($currPage + $indent_r >= $this->totPages) {
            $start = $currPage - ($this->pageLength - ($this->totPages - $currPage) + 1);
        } else {
            $start = $currPage - $indent;
        }

        if ($start <= 1 ) {
            $start=2;
        }
        
        $fromTo = (($currPage-1)*$this->postPerPage+1). "-" .($currPage==$this->totPages ? $this->totPosts : $currPage*$this->postPerPage);
        
        if ($start > 2) {
            $str.= '<a href="'.$this->link.'/page/'.($currPage-1).'/">&laquo; Пред.</a> <a href="'.$this->link.'/page/1/">1</a>..';
        }else {
            if ($currPage==1) {
                $str.= '<a class="'.$activeClassName.'">1</a> '; 
            } else {
                $str.= '<a href="'.$this->link.'/page/'.($currPage-1).'/">&laquo; Пред.</a> <a href="'.$this->link.'/page/1/">1</a> ';
            }
        }
        if ($this->totPages > 2) {
            if ($currPage-$indent > 0) {
                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=$start; $i<= $finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="'.$activeClassName.'">' . $i . '</a> ';
                    }else {
                        $str .= "<a href='" . $this->link . "/page/" . $i . "/'>" . $i . "</a> ";
                    }
                }
            }else {

                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=2; $i<=$finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="'.$activeClassName.'">' . $i . "</a> ";
                    } else {
                        $str .= "<a href='" . $this->link . "/page/" . $i ."/'>" . $i . "</a> ";
                    }
                }
            }
        }

        if ($i < $this->totPages  && $i>0) {
            $str.= " ..<a href='".$this->link."/page/".$this->totPages."/'>".$this->totPages.'</a> <a href="'.$this->link.'/page/'.($currPage+1).'/">След. &raquo;</a>';
        }else {
            if ($currPage==$this->totPages) {
                $str.='<a class="'.$activeClassName.'">'.$this->totPages.'</a>'; 
            }else {
                $str.= " <a href='".$this->link."/page/".$this->totPages."/'>".$this->totPages.'</a> <a href="'.$this->link.'/page/'.($currPage+1).'/">След. &raquo;</a>';
            }
        }
        
        if ($this->totPages<2) {
            return '';
        } else {
            return $str;
        }
    }
    
    public function makeAjaxLinkPaging($currPage, $ajaxPrefix, $ajaxPostfix, $activeClassName = 'Current')
    {
        $i=0;
        if (floor($currPage)>$this->totPages && $this->totPages>0) return ;//header("location: ".$this->link."/page/".$this->totPages."/");
        if (floor($currPage)<1) return ;// header("location: ".$this->link."/page/1/");
        
        if ( $this->pageLength > $this->totPages ) {
            $this->pageLength = $this->totPages;
        }

        $str = '';
        $indent = intval($this->pageLength/2);
        $indent_r = $this->pageLength - $indent;

        if ($currPage + $indent_r >= $this->totPages) {
            $start = $currPage - ($this->pageLength - ($this->totPages - $currPage) + 1);
        } else {
            $start = $currPage - $indent;
        }

        if ($start <= 1 ) {
            $start=2;
        }
        
        $fromTo = (($currPage-1)*$this->postPerPage+1). "-" .($currPage==$this->totPages ? $this->totPosts : $currPage*$this->postPerPage);
        
        if ($start > 2) {
            $str.= "<a href=\"#null\" onclick=\"".$ajaxPrefix.($currPage-1).$ajaxPostfix."\">&laquo; Пред.</a> <a href=\"#null\" onclick=\"".$ajaxPrefix.'1'.$ajaxPostfix."\">1</a>..";
        }else {
            if ($currPage==1) {
                $str.= '<a class="'.$activeClassName.'">1</a> '; 
            } else {
                $str.= "<a href=\"#null\" onclick=\"".$ajaxPrefix.($currPage-1).$ajaxPostfix."\">&laquo; Пред.</a> <a href=\"#null\" onclick=\"".$ajaxPrefix.'1'.$ajaxPostfix."\">1</a> ";
            }
        }
        if ($this->totPages > 2) {
            if ($currPage-$indent > 0) {
                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=$start; $i<= $finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="'.$activeClassName.'">' . $i . '</a> ';
                    }else {
                        $str .= "<a href=\"#null\" onclick=\"".$ajaxPrefix.$i.$ajaxPostfix."\">" . $i . "</a> ";
                    }
                }
            }else {

                $finish = $start+$this->pageLength;
                if ($finish >= $this->totPages) {
                    $finish=$this->totPages-1;
                }
                for ($i=2; $i<=$finish; $i++) {
                    if ($currPage == $i) {
                        $str .= '<a class="'.$activeClassName.'">' . $i . "</a> ";
                    } else {
                        $str .= "<a href=\"#null\" onclick=\"".$ajaxPrefix.$i.$ajaxPostfix."\">" . $i . "</a> ";
                    }
                }
            }
        }

        if ($i < $this->totPages  && $i>0) {
            $str.= " ..<a href=\"#null\" onclick=\"".$ajaxPrefix.$this->totPages.$ajaxPostfix."\">".$this->totPages."</a> <a href=\"#null\" onclick=\"".$ajaxPrefix.($currPage+1).$ajaxPostfix."\">След. &raquo;</a>";
        }else {
            if ($currPage==$this->totPages) {
                $str.='<a class="'.$activeClassName.'">'.$this->totPages.'</a>'; 
            }else {
                $str.= " <a href=\"#null\" onclick=\"".$ajaxPrefix.$this->totPages.$ajaxPostfix."\">".$this->totPages."</a> <a href=\"#null\" onclick=\"".$ajaxPrefix.($currPage+1).$ajaxPostfix."\">След. &raquo;</a>";
            }
        }
        
        if ($this->totPages<2) {
            return '';
        } else {
            return $str;
        }
    }
    
}
