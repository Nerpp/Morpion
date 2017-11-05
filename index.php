<?php
//that's because the PHP_EOF thing
//linux uses \n, while windows uses \r\n
//if you change the input you will fix that

$input = <<<EOT
XOX
XXO
OOX
 
 
XOX
XXO
OOO
EOT;
 
$separator = PHP_EOL;
 
$masks = array();
for ($i = 0; $i < 3; $i++) {
    array_push($masks, array(array($i, 0), array($i, 1), array($i, 2)));
    array_push($masks, array(array(0, $i), array(1, $i), array(2, $i)));
}
array_push($masks, array(array(0, 0), array(1, 1), array(2, 2)));
array_push($masks, array(array(0, 2), array(1, 1), array(2, 0)));
 
 
 
class NoughtsCrossesState {
    private $state;
 
    function __construct($stateStr)
    {
        $this->state = NoughtsCrossesState::parseGame($stateStr);
    }
 
    private static function parseGame($stateStr) {
        return array(
            array($stateStr[0], $stateStr[1], $stateStr[2]),
            array($stateStr[3], $stateStr[4], $stateStr[5]),
            array($stateStr[6], $stateStr[7], $stateStr[8]),
        );
    }
 
    public function getWinner() {
        global $masks;
        for ($i = 0, $len = count($masks); $i < $len; $i++) {
            $cell0 = $masks[$i][0];
            $cell1 = $masks[$i][1];
            $cell2 = $masks[$i][2];
 
            $value0 = $this->state[$cell0[0]][$cell0[1]];
            $value1 = $this->state[$cell1[0]][$cell1[1]];
            $value2 = $this->state[$cell2[0]][$cell2[1]];
 
            if ($value0 == $value1 && $value0 == $value2) {
                return $value0;
            }
        }
        return null;
    }
 
    public function __toString()
    {
        $str = '';
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $str .= $this->state[$i][$j];
            }
            $str .= PHP_EOL;
        }
        return $str;
    }
}
 
 
function main() {
    global $input, $separator;
 
    $stateStr = strtok($input, $separator);
    while ($stateStr !== false) {
        $stateStr .= strtok($separator);
        $stateStr .= strtok($separator);
 
        $game = new NoughtsCrossesState($stateStr);
 
        print('Game:'.PHP_EOL);
        print($game);
        print('Winner: '.$game->getWinner().PHP_EOL);
        
        echo ' tested by echo Winner: '.$game->getWinner().PHP_EOL;
 
        $stateStr = strtok($separator);
    }
}
 
 
main();
