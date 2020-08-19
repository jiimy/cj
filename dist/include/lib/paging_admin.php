<?php

class YsPaging {
	/* 파라메타용 변수 */
	var $mCurPageNum;																									// 현제 페이지 번호
	var $mPageVar;																										// 페이지에 사용되는 변수명
	var $mExtraVar;																										// 추가 변수
	var $mTotalItem;																									// 글갯수
	var $mPerPage;																										// 출력 페이지수
	var $mPerItem;																										// 출력 글 수
	var $mPrevPage;																										// [이전 페이지] text 또는 img tag
	var $mNextPage;																										// [다음 페이지] text 또는 img tag
	var $mPrevPerPage;																									// [이전 $mPerPage 페이지] text 또는 img tag
	var $mNextPerPage;																									// [다음 $mPerPage 페이지] text 또는 img tag
	var $mFirstPage;																									// [처음] 페이지 text 또는 img tag
	var $mLastPage;																										// [마지막] 페이지 text 또는 img tag
	var $mPageCss;																										// 페이지 목록에 사용할 css
	var $mCurPageCss;																									// 현재 페이지에 사용할 css

	/* 내부사용 변수 */
	var $mPageCount;																									// 전체 페이지수
	var $mTotalBlock;																									// 전체 블럭수
	var $mBlock;																										// 현재 블럭수
	var $mFirstPerPage;																									// 한블럭의 첫 페이지번호
	var $mLastPerPage;																									// 한블럭의 마지막 페이지 번호

	/**
	* 생성자 - 온션을 성정하고 기본적인 페이지,블럭수 등을 계산
	* @param array $params
	*/
	function YsPaging($params) {
		if(!count($params)) {
			echo "[YsPaging Error : 파라메터가 없습니다.]";
			return;
		}

		$this->mCurPageNum = $params['curPageNum'] ? $params['curPageNum'] : 1;											// 현재 페이지 번호가 있으면 해당 페이지 번호 없으면 1
		$this->mPageVar = $params['pageVar'] ? $params['pageVar'] : 'pagenum';  										// 페이지에 사용되는 변수명
		$this->mExtraVar = $params['extraVar'] ? $params['extraVar'] : '';												// 추가 변수
		$this->mTotalItem = $params['totalItem'] ? $params['totalItem'] : 0;											// 전체 글 개수가 있으면 해당 글 개수 없으면 0
		$this->mPerPage = $params['perPage'] ? $params['perPage'] : 10;													// 출력 페이지수
		$this->mPerItem = $params['perItem'] ? $params['perItem'] : 15;													// 출력 글 수
		$this->mPrevPage = $params['prevPage'] ? $params['prevPage'] : '이전';											// [이전 페이지] text 또는 img tag
		$this->mNextPage = $params['nextPage'] ? $params['nextPage'] : '다음';											// [다음 페이지] text 또는 img tag
		$this->mPrevPerPage = $params['prevPerPage'] ? $params['prevPerPage'] : '이전그룹';																	// [이전 $mPerPage 페이지] text 또는 img tag
		$this->mNextPerPage = $params['nextPerPage'] ? $params['nextPerPage'] : '다음그룹';																	// [다음 $mPerPage 페이지] text 또는 img tag
		$this->mFirstPage = $params['firstPage'] ? $params['firstPage'] : '처음';																		// [처음] 페이지 text 또는 img tag
		$this->mLastPage = $params['lastPage'] ? $params['lastPage'] : '끝';																		// [마지막] 페이지 text 또는 img tag
		$this->mPageCss = $params['pageCss'] ? $params['lastPage'] : '';																			// 페이지 목록에 사용할 css
		$this->mCurPageCss = $params['curPageCss'] ? $params['lastPage'] : '';																	// 현재 페이지에 사용할 css

		$this->mPageCount = ceil($this->mTotalItem/$this->mPerItem);													// 전체 페이지수 = 전체 글 개수/출력 글 수
		$this->mTotalBlock = ceil($this->mPageCount/$this->mPerPage);													// 전체 블럭수 = 전체 페이지수/출력 페이지수
		$this->mBlock = ceil($this->mCurPageNum/$this->mPerPage);														// 현재 블럭수 = 현제 페이지 번호/ 출력 페이지수 
		$this->mFirstPerPage = ($this->mBlock-1)*$this->mPerPage;														// 한블럭의 첫 페이지번호 = (현재 블럭수-1) * 출력 페이지수
		$this->mLastPerPage = $this->mTotalBlock<=$this->mBlock ? $this->mPageCount : $this->mBlock*$this->mPerPage;	// 한블럭의 마지막 페이지 번호 = 전체 블럭수 <= 현재 블럭수 ? 전체 페이지수 : 현재 블럭수 * 출력 페이지수
	}	
	
	/**
	* 현재 글번호를 리턴
	* @return integer
	*/
	function getItemNum() {
		return $this->mTotalItem-($this->mCurPageNum-1)*$this->mPerItem; // 현재 아이템 번호 계산
	}

	/**
	* 첫페이지 번호 링크를 리턴
	* @return str
	*/
	function getFirstPage() {
		//if(empty($this->mFirstPage) || empty($this->mFirstPerPage) || $this->mFirstPerPage == 1) return NULL;
		if($this->mCurPageNum == 1 || $this->mPageCount == 0) return NULL;
		return '<li><a href="#" onclick="go_page(1);return false;">'.$this->mFirstPage.'</a></li> ';
	}

	/**
	* 끝페이지 번호 링크를 리턴
	* @return string
	*/
	function getLastPage() {
		//if(empty($this->mLastPage) || $this->mLastPerPage >= $this->mPageCount || $this->mTotalItem == 0) return NULL;
		if($this->mCurPageNum == $this->mPageCount || $this->mPageCount == 0) return NULL;
		return '<li><a href="#" onclick="go_page('.$this->mPageCount.');return false;">'.$this->mLastPage.'</a></li> ';
	}

	/**
	* 이전블럭 링크를 리턴
	* @return string
	*/
	function getPrevPerPage() {
		if(empty($this->mPrevPerPage) || $this->mBlock <= 1) return NULL;
		return '<li><a href="#" onclick="go_page('.$this->mFirstPerPage.');return false;">'.$this->mPrevPerPage.'</a></li> ';
	}

	/**
	* 다음블럭 링크를 리턴
	* @return string
	*/
	function getNextPerPage() {
		if(empty($this->mNextPerPage) || $this->mBlock >= $this->mTotalBlock) return NULL;
		return '<li><a href="#" onclick="go_page('.($this->mLastPerPage+1).');return false;">'.$this->mNextPerPage.'</a></li> ';
	}

	/**
	* 이전 페이지 링크를 리턴
	* @return string
	*/
	function getPrevPage() {
		if($this->mCurPageNum > 1)
			return '<li><a href="#" onclick="go_page('.($this->mCurPageNum-1).');return false;">'.$this->mPrevPage.'</a></li> ';
		else
			//return $this->mPrevPage;
			return NULL;
	}

	/**
	* 다음 페이지 링크를 리턴
	* @return string
	*/
	function getNextPage() {
		if($this->mCurPageNum != $this->mPageCount && $this->mPageCount)
			return '<li><a href="#" onclick="go_page('.($this->mCurPageNum+1).');return false;">'.$this->mNextPage.'</a></li> ';
		else
			//return $this->mNextPage;
			return NULL;
	}

	/**
	* 페이지 목록 링크를 리턴
	* @return string
	*/
	function getPageList() {
		$rtn = '';
		for($i=$this->mFirstPerPage+1;$i<=$this->mLastPerPage;$i++) {
			if($this->mCurPageNum == $i)
				if(empty($this->mCurPageCss))
					$rtn .= '<li class="active"><a href=""#"">'.$i.'</a></li> ';
				else
					$rtn .= '<li><a href="#" class="'.$this->mCurPageCss.'">'.$i.'</a></li> ';
			else {
				$rtn .= '<li><a href="#" onclick="go_page('.$i.$this->mExtraVar.');return false;"> ';
				if(empty($this->mPageCss)) 
					$rtn .= ''.$i.'</a></li> ';
				else
					$rtn .= '<span class="'.$this->mPageCss.'">'.$i.'</span></a></li> ';
			}
		}
		return $rtn;
	}

	/**
	* 기본 페이지를 프린트, 상속후 변경 가능
	*/
	function printPaging() {
		echo $this->getFirstPage();
		echo '';
		//echo $this->getPrevPerPage();
		echo '';
		echo $this->getPrevPage();
		//echo '';
		//echo '<span>';
		echo $this->getPageList();
		echo '';
		//echo '</span>';
		echo $this->getNextPage();
		//echo '';
		//echo $this->getNextPerPage();
		echo '';
		echo $this->getLastPage();
	}
}

?>