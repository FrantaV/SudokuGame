<?php
declare(strict_types=1);

namespace Sudoku\Printer;

use Sudoku\ValueInterpreter\ValueInterpreterInterface;

class SudokuConsolePrinter implements SudokuPrinterInterface {
    private readonly ValueInterpreterInterface $valueInterpreter;

    public function __construct(ValueInterpreterInterface $valueInterpreter) {
        $this->valueInterpreter = $valueInterpreter;
    }

    public function print(array $board): void {
        $boardSize = count($board);
        $subGridSize = (int)sqrt($boardSize);
        $rowSeparator = str_repeat('-', (4 * $boardSize) + $subGridSize + 2);

        echo $rowSeparator . "\n";
        foreach ($board as $rowKey => $row) {
            echo '||';
            foreach ($row as $columnKey => $column) {
                $columnSeparator = " |";
                if (($columnKey + 1) % $subGridSize === 0) {
                    $columnSeparator = " ||";
                }
                echo " " . $this->valueInterpreter->convertValue($column) . $columnSeparator;
            }
            echo "\n";
            if (($rowKey + 1) % $subGridSize === 0) {
                echo $rowSeparator . "\n";
            }
        }
    }
}
