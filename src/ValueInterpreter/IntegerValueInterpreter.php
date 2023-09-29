<?php
declare(strict_types=1);

namespace Sudoku\ValueInterpreter;

class IntegerValueInterpreter implements ValueInterpreterInterface {
    public function convertValue(int $value): string {
        return $value === 0 ? ' ' : (string)$value;
    }
}
