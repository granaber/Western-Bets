<?php

class gridPdfGenerator {

	public $minOffsetTop = 10;
	public $minOffsetBottom = 10;
	public $minOffsetLeft = 10;
	public $minOffsetRight = 10;
	public $headerHeight = 7;
	public $rowHeight = 5;
	public $minColumnWidth = 13;
	public $pageNumberHeight = 10;
	public $fontSize = 8;
	public $dpi = 96;
	public $strip_tags = false;

	public $bgColor = 'D1E5FE';
	public $lineColor = 'A4BED4';
	public $headerTextColor = '000000';
	public $scaleOneColor = 'FFFFFF';
	public $scaleTwoColor = 'E3EFFF';
	public $gridTextColor = '000000';
	public $pageTextColor = '000000';

	public $footerImgHeight = 50;
	public $headerImgHeight = 50;
	public $lang = Array('a_meta_charset' => 'UTF-8', 'a_meta_dir' => 'ltr', 'a_meta_language' => 'en', 'w_page' => 'Pagina');

	private $orientation = 'P';
	private $columns = Array();
	private $rows = Array();
	private $summaryWidth;
	private $profile;
	private $header = false;
	private $footer = false;
	private $headerFile;
	private $footerFile;
	private $pageHeader = false;
	private $pageFooter = false;

	// print grid
	public function printGrid($xml,$f1,$f2) {
		
		$this->headerParse($xml->head);
		$this->mainParse($xml);
		$this->rowsParse($xml->row);
		$this->printGridPdf($f1,$f2);
	}
	
	
	// sets colors according profile
	private function setProfile() {
		switch ($this->profile) {
			case 'color':
				$this->bgColor = 'D1E5FE';
				$this->lineColor = 'A4BED4';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'E3EFFF';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
			case 'gray':
				$this->bgColor = 'E3E3E3';
				$this->lineColor = 'B8B8B8';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'EDEDED';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
			case 'bw':
				$this->bgColor = 'FFFFFF';
				$this->lineColor = '000000';
				$this->headerTextColor = '000000';
				$this->scaleOneColor = 'FFFFFF';
				$this->scaleTwoColor = 'FFFFFF';
				$this->gridTextColor = '000000';
				$this->pageTextColor = '000000';
				break;
		}
	}


	// parses main settings
	private function mainParse($xml) {
		$this->profile = (string) $xml->attributes()->profile;
		if ($xml->attributes()->header) {
			$this->header = (string) $xml->attributes()->header;
		}
		if ($xml->attributes()->footer) {
			$this->footer = (string) $xml->attributes()->footer;
		}
		if ($xml->attributes()->pageheader) {
			$this->pageHeader = (string) $xml->attributes()->pageheader;
		}
		if ($xml->attributes()->pagefooter) {
			$this->pageFooter = $xml->attributes()->pagefooter;
		}

		if (100/count($this->widths) < $this->minColumnWidth) {
			$this->orientation = 'L';
		}

		if ($xml->attributes()->orientation) {
			if ($xml->attributes()->orientation == 'landscape') {
				$this->orientation = 'L';
			} else {
				$this->orientation = 'P';
			}
		}
		$this->setProfile();
	}


	// parses grid header
	private function headerParse($header) {
		if (isset($header->columns)) {
			$columnsRows = $header->columns;
			$i = 0;
			foreach ($columnsRows as $columns) {
				$summaryWidth = 0;
				foreach ($columns as $column) {
					$columnArr = Array();
					$columnArr['text'] = trim((string) $column);
					$columnArr['width'] = trim((string) $column->attributes()->width);
					$columnArr['type'] = trim((string) $column->attributes()->type);
					$columnArr['align'] = trim((string) $column->attributes()->align);
					$columnArr['colspan'] = trim((string) $column->attributes()->colspan);
					$columnArr['rowspan'] = trim((string) $column->attributes()->rowspan);
					$summaryWidth += $columnArr['width'];
					$this->columns[$i][] = $columnArr;
					if ($i == 0) {
						$widths[] = $columnArr['width'];
					}
					if ($columnArr['colspan'] != '') {
						$columnArr['width'] = 0;
					}
				}
				$this->columns[$i]['width'] = $summaryWidth;
				if ($i == 0) {
					$this->summaryWidth = $summaryWidth;
				}
				$i++;
			}

			for ($i = 0; $i < count($this->columns); $i++) {
				$offset = 0;
				for ($j = 0; $j < count($widths); $j++) {
					if ($this->columns[$i][$j]['colspan'] != '') {
						$w = $widths[$j];
						for ($k = 1; $k < $this->columns[$i][$j]['colspan']; $k++) {
							$w += $widths[$j + $k];
							$this->columns[$i][$j + $k]['width'] = 0;
						}
						$this->columns[$i][$j]['width'] = $w;
						$j += $this->columns[$i][$j]['colspan'] - 1;
					} else {
						$this->columns[$i][$j]['width'] = $widths[$j];
					}
				}
			}

			for ($i = 0; $i < count($this->columns); $i++) {
				for ($j = 0; $j < count($widths); $j++) {
					if (($this->columns[$i][$j]['rowspan'] != '')&&(!isset($this->columns[$i][$j]['rowspanPos']))) {
						for ($k = 1; $k < $this->columns[$i][$j]['rowspan']; $k++) {
							$this->columns[$i + $k][$j]['rowspanPos'] = $this->columns[$i][$j]['rowspan'] - $k;
							$this->columns[$i + $k][$j]['rowspan'] = $this->columns[$i][$j]['rowspan'];
						}
						$this->columns[$i][$j]['rowspanPos'] = 'top';
					}
				}
			}
			$this->widths = $widths;
		} else {
			$columns = $header->column;
			$summaryWidth = 0;
			$i = 0;
			foreach ($columns as $column) {
				$columnArr = Array();
				$columnArr['text'] = trim((string) $column);
				$columnArr['width'] = trim((string) $column->attributes()->width);
				$columnArr['type'] = trim((string) $column->attributes()->type);
				$columnArr['align'] = trim((string) $column->attributes()->align);
				$columnArr['colspan'] = trim((string) $column->attributes()->colspan);
				$columnArr['rowspan'] = trim((string) $column->attributes()->rowspan);
				$summaryWidth += $columnArr['width'];
				$this->columns[$i][] = $columnArr;
				$widths[] = $columnArr['width'];
				if ($columnArr['colspan'] != '') {
					$columnArr['width'] = 0;
				}
			}
			$this->columns[$i]['width'] = $summaryWidth;
			$this->summaryWidth = $summaryWidth;
			$i++;
			$this->widths = $widths;
		}
	}


	// parses rows
	private function rowsParse($rows) {
		foreach ($rows as $row) {
			$rowArr = Array();
			$cells = $row->cell;
			foreach ($cells as $cell) {
				if ($this->strip_tags == true) {
					$rowArr[] = strip_tags(trim((string) $cell));
				} else {
					$rowArr[] = trim((string) $cell);
				}
			}
			$this->rows[] = $rowArr;
		}
	}
	
	
	// returns header image name
	private function headerImgInit() {
		if (file_exists('./imgs/header.png')) {
			$this->headerFile = './imgs/header.png';
			return true;
		}
		return false;
	}


	// returns footer image name
	private function footerImgInit() {
		if (file_exists('./imgs/footer.png')) {
			$this->footerFile = './imgs/footer.png';
			return true;
		}
		return false;
	}


	public function printGridPdf($f1,$f2) {
		if (($this->header)||($this->pageHeader)) {
			$this->headerImgInit();
		}
		if (($this->footer)||($this->pageFooter)) {
			$this->footerImgInit();
		}

		// initials PDF-wrapper
		$this->wrapper = new gridPdfWrapper($this->minOffsetTop, $this->minOffsetRight, $this->minOffsetBottom, $this->minOffsetLeft, $this->orientation, $this->fontSize, $this->dpi, $this->lang);
		
		// checking if document will have one page
		$pageHeight = $this->wrapper->getPageHeight() - $this->minOffsetTop - $this->minOffsetBottom;
		if (($this->header)||($this->pageHeader)) {
			$pageHeight -= $this->headerImgHeight;
		}
		if (($this->footer)||($this->pageFooter)) {
			$pageHeight -= $this->footerImgHeight;
		}
		$numRows = floor(($pageHeight - $this->headerHeight)/$this->rowHeight);
		// denies page numbers if dpcument have one page
		if ($numRows >= count($this->rows)) {
			$this->wrapper->setNoPages();
		}
		
		$rows = Array();
		$pageNumber = 1;
		$startRow = 0;
		// circle for printing all pages
		while ($startRow < count($this->rows)) {
			$numRows = $this->printGridPage($startRow, $pageNumber,$f1,$f2);
			$startRow += $numRows;
			$pageNumber++;
		}
		
		// outputs PDF in browser
		$this->wrapper->pdfOut();
	}


	// prints one page
	private function printGridPage($startRow, $pageNumber,$f1,$f2) {
		// adds new page
		$this->wrapper->addPage();
	
		// calculates top offset
		if ((($this->header)&&($pageNumber == 1))||($this->pageHeader)) {
			$offsetTop = $this->headerImgHeight;
		} else {
			$offsetTop = 0;
		}

		// calculates bottom offset
		if ($this->pageFooter) {
			$offsetBottom = $this->footerImgHeight;
		} else {
			$offsetBottom = 0;
		}

		// calculates page height without top and bottom offsets
		$pageHeight = $this->wrapper->getPageHeight() - $offsetTop - $offsetBottom - $this->minOffsetTop - $this->minOffsetTop;
		// calculates rows number on current page
		$numRows = floor(($pageHeight - $this->headerHeight*count($this->columns))/$this->rowHeight);
		// check if it's last page
		$lastPage = ((count($this->rows) - $startRow) <= $numRows);

		// prints footer if needs
		if (($this->footer)&&($lastPage)) {
			$offsetBottom = $this->footerImgHeight;
		}

		$offsetRight = $this->minOffsetRight;
		$offsetLeft = $this->minOffsetLeft;
		// sets page offsets
		$this->wrapper->setPageSize($offsetTop, $offsetRight, $offsetBottom, $offsetLeft);

		// prints grid header
		$this->wrapper->headerDraw($this->headerHeight, $this->columns, $this->summaryWidth, $this->headerTextColor, $this->bgColor, $this->lineColor,$f1,$f2);
		// prints grid values
		$rowsNum = $this->wrapper->gridDraw($this->rowHeight, $this->rows, $this->widths, $startRow, $numRows, $this->scaleOneColor, $this->scaleTwoColor, $this->profile);
		
		// prints footer if needs
		if (($this->pageFooter)||(($lastPage)&&($this->footer))) {
			$this->wrapper->drawImgFooter($this->footerFile, $this->footerImgHeight);
		}

		// prints header if needs
		if ((($this->header)&&($pageNumber == 1))||($this->pageHeader)) {
			$this->wrapper->drawImgHeader($this->headerFile, $this->headerImgHeight);
		}
		// returns number of printed rows ;
		return $rowsNum;
	}
}


?>