# germande

Gerrymander - https://www.codechef.com/FEB17/problems/GERMANDE

## Problem

Na wejściu dostajemy: 
- liczbę testów $t i dla każdego testu mamy
- dwie zmienne nieparzyste **$o1** i **$o2** oznaczające ilość dystryktów i stanów 
- liczba głosów oznaczoną jako $d będącą tablicą długości $n = $o1 * $o2 - zawierającą zmienne z przedziału <0,1>, które oznaczają czy ktoś zagłosował na partie 1 lub 0 
Dla każdego ciągu długości $n mamy zależność taką, że wyrazy $d oraz $d+1 są kolejnymi następującymi po sobie liczbami przy czym 1 ≤ $d[$i] ≤ $n-1 oraz 1 i $n także są kolejnymi następującymi po sobie liczbami.

Głosy $n dzielimy na dystrykty $o1, które z kolei zawierają w sobie $o2 stanów (powiatów). Jeśli w powiecie jest przewaga głosów na 1 to wygrywa tam partia 1, jeśli nie to 
partia 0. W całym kraju wybierany jest prezydent w zależności jeśli więcej powiatów wybrało partię 1 to wybierany jest prezydent1 jeśli nie to prezydent0.
Na wyjściu trzeba zwrócić 0 jeśli wybrany został prezydent0 lub 1 jeśli wybrany został prezydent1.

## Algorytm

Zadanie [GERMANDE](https://www.codechef.com/FEB17/problems/GERMANDE) wskazówki do algorytmu: [video algorytm](https://www.youtube.com/watch?v=0b95f4y5s6A)

0. Obsługa przypadków wyjątkowych. Jeśli $o2 == 1 to wystarczy że sprawdzimy tylko ilość 0 i 1 ze zbioru liczb głosów $d i w zależności od tego czego było więcej to to drukujemy na wyjście
```php
if ($o2 == 1) {
    $outcome = array_count_values($d);
    $output = $outcome[1] > $outcome[0] ? 1 : 0;
} else {} // cala reszta ponizej
```

1. Robimy pętle po $n+$o2-1 z licznikiem $i. Przed wejściem w pętle tworzymy tablicę $accumulator do przechowywania sumy z $n[$i] + $accumulator[$i] elementów dla $i>0
Dla $i==0 wstawiamy $accumulator[$i] = $n[$i]. Uzupełniamy tablicę $accumulator dodatkowymi $o2-1 elementami, które są przesuniciem dla ostanich elementów z tablicy.
```php
$accumulator = array();
for ($i=0; $i<$n+$o2-1; $i++) {
    if ($i==0) {
        $accumulator[$i] = $d[$i];
    } else {
        $k = $i % $n;
        $k1 = $i > $n ? $k - 1 : $i-1;
        $accumulator[$i] = $accumulator[$k1] + $d[$k];
    }
} 

/* symulacja - akumaulator wypelniony testowymi danymi
$accumulator[0] = 0;
$accumulator[1] = 0;
$accumulator[2] = 1;
$accumulator[3] = 2;
$accumulator[4] = 2;
$accumulator[5] = 3;
$accumulator[6] = 4;
$accumulator[7] = 4;
$accumulator[8] = 4;

$accumulator[9] = 4;
$accumulator[10] = 4;  //dopisanych o $o2-1 elementów ponad $n
$n = 9
*/

```

2. Po zakończeniu pętli z pkt1, ustawiamy zmienną tablicową $states, będzie ona przechowywać 1 - jeśli w danym powiecie wygrała partia 1 lub 0 jeśli w danym powiecie wygrała partia 0. Następnie robimy kolejną pętle po $n z licznikiem $j zwiększanym o $o2
```php
// 111 010 010  // 110 100 101  // 101 001 011
// 001 101 100  // 011 011 001  // 110 110 000
$output = 0;
$halfDistrict = ceil($o2/2);
for ($i=0; $i<$o1; $i++) {  //petla po dystryktach
    $results = array();
    
    /* symulacja
    $k = 3;
    $i = 0;
    $accumulator[2] - 0 = 1 - 0 = 1 => 0
    $k = 6;
    $i = 0;
    $accumulator[5] - $accumulator[2] = 3 - 1 = 2 => 1
    $k = 9;
    $i = 0;
    $accumulator[8] - $accumulator[5] = 4 - 3 = 1 => 0

    $k = 3;
    $i = 1;
    $accumulator[3] - $accumulator[0] = 2 - 0 = 2 => 1
    $k = 6;
    $i = 1;
    $accumulator[6] - $accumulator[3] = 4 - 2 = 2 => 1
    $k = 9;
    $i = 1;
    $accumulator[9] - $accumulator[6] = 4 - 4 = 0 => 0

    $k = 3;
    $i = 2;
    $accumulator[4] - $accumulator[1] = 2 - 0 = 2 => 1
    $k = 6;
    $i = 2;
    $accumulator[7] - $accumulator[4] = 4 - 2 = 2 => 1
    $k = 9;
    $i = 2;
    $accumulator[10] - $accumulator[7] = 4 - 4 = 0 => 0
    */


    for ($k=$o2; $k<=$n; $k+=$o2) {
        if ($k == $o2 && $i == 0) {
            $licznik = 0;
        } else {
            $licznik = $accumulator[$k+$i-$o2-1];
        }
        $results[] = $accumulator[$k+$i-1] - $licznik >= $halfDistrict ? 1 : 0;
    }
    // w results powinnismy miec 0 lub 1 per dystrykt
    $outcome = array_count_values($results);
    if ($outcome[1] > $outcome[0]) {
        $output = 1;
        break;
    }
}

```

3. W zmiennej $output powinniśmy mieć wynik, który wydrukowujemy na ekran dla każdego testu.
```php
echo $output . PHP_EOL;
```

4. Złożoność obliczeniowa algorytmu: **O(2N)**
 

