<?php
declare(strict_types=1);

namespace Sudoku\Printer;

interface SudokuPrinterInterface {
    public function print(array $board): void;
}
