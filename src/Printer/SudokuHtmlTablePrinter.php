<?php
declare(strict_types=1);

namespace Sudoku\Printer;

use Sudoku\ValueInterpreter\ValueInterpreterInterface;

class SudokuHtmlTablePrinter implements SudokuPrinterInterface {
    private readonly ValueInterpreterInterface $valueInterpreter;

    public function __construct(ValueInterpreterInterface $valueInterpreter) {
        $this->valueInterpreter = $valueInterpreter;
    }

    public function print(array $board): void {
        echo '<table class="sudoku-table">';
        foreach ($board as $rowKey => $row) {
            $rowClass = 'sudoku-row';
            if (($rowKey +1) % 3 === 0) {
                $rowClass .= ' sudoku-border';
            }
            echo '<tr class = "' . $rowClass . '">';
            foreach ($row as $columnKey => $column) {
                $value = $this->valueInterpreter->convertValue($column);
                if ($value === ' ') {
                    $value = '&nbsp;';
                }

                $columnClass = 'sudoku-col';
                if (($columnKey + 1) % 3 === 0) {
                    $columnClass .= ' sudoku-border';
                }
                echo '<td class = "' . $columnClass . '">' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }

    public function getStyles(): string {
        return 'table { font-family: Calibri, sans-serif; }
        colgroup, tbody { border: solid medium; }
        td { border: solid thin; height: 1.4em; width: 1.4em; text-align: center; padding: 0; }

        *, *:before, *:after {
            box-sizing: border-box;
        }

        .sudoku-row:after {
            content: ".";
            visibility: hidden;
            display: block;
            height: 0;
            clear: both; }


        .sudoku-table {
            max-width: 416px;
            margin: auto;
            display: block;
            position: relative;
            border-radius: 6px;
            font-size: 2em;
            color: #777;
            float: left;
            margin-left: 100px;
        }

        .sudoku-table-bk {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index:1;
        }

        .sudoku-row {
            display: block;
            position: relative;
            width: 100%;
            z-index: 2;
        }

        .sudoku-col {
            min-height:45px;
            position: relative;
            float: left;
            border-color: #CCC;
            border-style: dashed;
            border-width: 2px 2px 0 0;
        }

        .sudoku-row.sudoku-border {
            border-bottom: #AAA solid 2px;
        }

        .sudoku-col.sudoku-border {
            border-right: #AAA solid 2px;
        }

        .sudoku-table .sudoku-row .sudoku-col:last-child {
            border-right: none;
        }
        ';
    }
}
