<?php
require 'vendor/autoload.php';

use Sudoku\Printer\SudokuHtmlTablePrinter;
use Sudoku\Sudoku;
use Sudoku\ValueInterpreter\IntegerValueInterpreter;
use Sudoku\ValueInterpreter\SmileEmojiValueInterpreter;

$boardSize = 9;
$sudoku = new Sudoku($boardSize);
$sudoku->generateValuesToBoard();
$playableBoard = $sudoku->createPlayableBoard(50);
$sudokuSmileEmojiPrinter = new SudokuHtmlTablePrinter(new SmileEmojiValueInterpreter());
$sudokuIntegerPrinter = new SudokuHtmlTablePrinter(new IntegerValueInterpreter());

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sudoku</title>
    <style>
        <?php echo $sudokuSmileEmojiPrinter->getStyles();  ?>
        a {
            background-color: #67acff;
            color: white;
            padding: 1em 1.5em;
            text-decoration: none;
            text-transform: uppercase;
        }

        a:hover {
            background-color: #125cda;
        }

        a:active {
            background-color: black;
        }

        a:visited {
            background-color: #ccc;
        }
    </style>
</head>
<body>
<h1>Sudoku generátor</h1>
<br>
<div style=" clear: both;"><a href=".">Generate sudoku</a> </div>
<br><br>
<?php
$sudokuSmileEmojiPrinter->print($playableBoard);
$sudokuIntegerPrinter->print($playableBoard);
?>
</body>
</html>
