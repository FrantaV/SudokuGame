<?php
declare(strict_types=1);

namespace Sudoku\ValueInterpreter;

class SmileEmojiValueInterpreter implements ValueInterpreterInterface {
    public function convertValue(int $value): string {
        return match ($value) {
            0 => ' ',
            1 => '😎',
            2 => '😍',
            3 => '🤨',
            4 => '😨',
            5 => '🤓',
            6 => '🤠',
            7 => '🙁',
            8 => '😀',
            default => '💀'
        };
    }
}
