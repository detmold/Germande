<?php
class Germande {
    public $test;
    public $o1;
    public $o2;
    public $d = array();
    public $n;
    public $output = false;
    public $accumulator = array();
    
    private function checkEdgeCase() {
        if (empty($this->d)) {
            $this->output = 0;
        }
        else if ($this->o2 == 1) {
            $outcome = array_count_values($this->d);
            $this->output = $outcome[1] > $outcome[0] ? 1 : 0;
        }
    }

    private function fillAccumulator() {
        $this->accumulator = array();
        for ($i=0; $i<$this->n+$this->o2-1; $i++) {
            if ($i==0) {
                $this->accumulator[$i] = $this->d[$i];
            } else {
                $k = $i % $this->n;
                $k1 = $i > $this->n ? $k - 1 : $i-1;
                $this->accumulator[$i] = $this->accumulator[$k1] + $this->d[$k];
            }
        } 
    }

    private function process() {
        $this->output = 0;
        $halfDistrict = ceil($this->o2/2);
        for ($i=0; $i<$this->o1; $i++) {  //petla po dystryktach
            $results = array();
            
            for ($k=$this->o2; $k<=$this->n; $k+=$this->o2) {
                if ($k == $this->o2 && $i == 0) {
                    $licznik = 0;
                } else {
                    $licznik = $this->accumulator[$k+$i-$this->o2-1];
                }
                $results[] = $this->accumulator[$k+$i-1] - $licznik >= $halfDistrict ? 1 : 0;
            }
            // w results powinnismy miec 0 lub 1 per dystrykt
            $outcome = array_count_values($results);
            if ($outcome[1] > $outcome[0]) {
                $this->output = 1;
                break;
            }
        }
    }

    public function init() {
        $this->test = trim(stream_get_line(STDIN, 100, PHP_EOL));
        for ($i=0; $i<$this->test; $i++) {
            $this->output = false;
            $states = explode(' ', stream_get_line(STDIN, 100000, PHP_EOL));
            $this->o1 = $states[0];
            $this->o2 = $states[1];
            $this->d = explode(' ', stream_get_line(STDIN, 1000000, PHP_EOL));
            $this->n = count($this->d);

            $this->checkEdgeCase();
            if ($this->output !== false) {
                echo $this->output .  PHP_EOL;
            } else {
                $this->fillAccumulator();
                $this->process();
                echo $this->output . PHP_EOL;
            }
        }

    }
}

$ger = new Germande();
$ger->init();
