<?php
declare(strict_types=1);

namespace Sudoku\ValueInterpreter;

interface ValueInterpreterInterface {
    public function convertValue(int $value): string;
}
