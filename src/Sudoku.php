<?php
declare(strict_types=1);

namespace Sudoku;

/**
 * Code for Sudoku generation taken from page: https://www.geeksforgeeks.org/program-sudoku-generator/
 */
class Sudoku {
    private array $board;
    private int $boardSize;
    private int $subGridSize;

    public function __construct(int $boardSize) {
        $this->boardSize = $boardSize;
        $this->subGridSize = (int)sqrt($boardSize);
        $this->board = [];
        $this->createEmptyBoard($boardSize);
    }

    private function createEmptyBoard(int $boardSize): void {
        for ($row = 0; $row < $boardSize; $row++) {
            $this->board[$row] = array_fill(0, $boardSize, 0);
        }
    }

    public function generateValuesToBoard(): void {
        $this->fillDiagonal();
        $this->fillRemaining(0, $this->subGridSize);
    }

    public function fillDiagonal(): void {
        for ($row = 0; $row < $this->boardSize; $row += $this->subGridSize) {
            $this->fillSubGrid($row, $row);
        }
    }

    public function fillSubGrid($startRow, $startColumn): void {
        for ($rowIndex = 0; $rowIndex < $this->subGridSize; $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->subGridSize; $columnIndex++) {
                do {
                    $num = $this->randomNumber($this->boardSize);
                } while (!$this->isUnusedInSubGrid($startRow, $startColumn, $num));
                $this->board[$startRow + $rowIndex][$startColumn + $columnIndex] = $num;
            }
        }
    }

    public function isUnusedInSubGrid($startRow, $startCol, $num): bool {
        for ($i = 0; $i < $this->subGridSize; $i++) {
            for ($j = 0; $j < $this->subGridSize; $j++) {
                if ($this->board[$startRow + $i][$startCol + $j] === $num) {
                    return false;
                }
            }
        }
        return true;
    }

    public function randomNumber($max): int {
        return (int)floor((mt_rand() / (double)(mt_getrandmax() + 1) * $max + 1));
    }

    public function isSafeToPlace($row, $column, $num): bool {
        return
            $this->isUnusedInRow($row, $num)
            && $this->isUnusedInColumn($column, $num)
            && $this->isUnusedInSubGrid(
                $row - $row % $this->subGridSize,
                $column - $column % $this->subGridSize,
                $num
            );
    }

    public function isUnusedInRow($row, $num): bool {
        for ($column = 0; $column < $this->boardSize; $column++) {
            if ($this->board[$row][$column] === $num) {
                return false;
            }
        }
        return true;
    }

    public function isUnusedInColumn($column, $num): bool {
        for ($row = 0; $row < $this->boardSize; $row++) {
            if ($this->board[$row][$column] === $num) {
                return false;
            }
        }
        return true;
    }

    public function fillRemaining($row, $column): bool {
        if ($column >= $this->boardSize && $row < $this->boardSize - 1) {
            $row++;
            $column = 0;
        }

        if ($row >= $this->boardSize && $column >= $this->boardSize) {
            return true;
        }

        if ($row < $this->subGridSize) {
            if ($column < $this->subGridSize) {
                $column = $this->subGridSize;
            }
        } elseif ($row < $this->boardSize - $this->subGridSize) {
            if ($column === (int)($row / $this->subGridSize) * $this->subGridSize) {
                $column += $this->subGridSize;
            }
        } elseif ($column === $this->boardSize - $this->subGridSize) {
                $row++;
                $column = 0;
                if ($row >= $this->boardSize) {
                    return true;
                }
        }

        for ($num = 1; $num <= $this->boardSize; $num++) {
            if ($this->isSafeToPlace($row, $column, $num)) {
                $this->board[$row][$column] = $num;
                if ($this->fillRemaining($row, $column + 1)) {
                    return true;
                }
                $this->board[$row][$column] = 0;
            }
        }

        return false;
    }

    public function getBoard(): array {
        return $this->board;
    }

    public function createPlayableBoard(int $numberOfValuesToHide): array {
        $playableBoard = $this->board;
        $sizeOfBoard = count($playableBoard, COUNT_RECURSIVE) - count($playableBoard);
        $numberOfPicketValues = $sizeOfBoard - $numberOfValuesToHide;

        if ($numberOfPicketValues < 1) {
            $numberOfPicketValues = 1;
        }

        $cells = array_rand(range(0, $sizeOfBoard), $numberOfPicketValues);
        if (!is_array($cells)) {
            $cells = [$cells];
        }
        $index = 0;
        foreach ($playableBoard as &$row) {
            foreach ($row as &$cell) {
                if (!in_array($index++, $cells)) {
                    $cell = 0;
                }
            }
        }
        return $playableBoard;
    }
}
