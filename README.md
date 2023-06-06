# PHP: Алгоритм быстрая сортировка
Сортировка массива с помощью алгоритма «Быстрая сортировка».
Сложность: O(n log n)
<pre>
// тестовый массив
$data = [ 8, 99, 1, 3, 10, 199, 2, 8, 3, 99, 3 ]; 

// Решение с удалением повторяющихся значений:
echo '&lt;pre&gt;', var_dump( qsort( $data ) ) ,'&lt;/pre&gt;';
// &gt; array(7) {
// &gt;   [0]=&gt;
// &gt;   int(1)
// &gt;   [1]=&gt;
// &gt;   int(2)
// &gt;   [2]=&gt;
// &gt;   int(3)
// &gt;   [3]=&gt;
// &gt;   int(8)
// &gt;   [4]=&gt;
// &gt;   int(10)
// &gt;   [5]=&gt;
// &gt;   int(99)
// &gt;   [6]=&gt;
// &gt;   int(199)
// &gt; }}

// Решение с сохранением повторяющихся значений:
echo '&lt;pre&gt;', var_dump( qsortWithRepeats( $data ) ) ,'&lt;/pre&gt;';
// &gt; array(11) {
// &gt;   [0]=&gt;
// &gt;   int(1)
// &gt;   [1]=&gt;
// &gt;   int(2)
// &gt;   [2]=&gt;
// &gt;   int(3)
// &gt;   [3]=&gt;
// &gt;   int(3)
// &gt;   [4]=&gt;
// &gt;   int(3)
// &gt;   [5]=&gt;
// &gt;   int(8)
// &gt;   [6]=&gt;
// &gt;   int(8)
// &gt;   [7]=&gt;
// &gt;   int(10)
// &gt;   [8]=&gt;
// &gt;   int(99)
// &gt;   [9]=&gt;
// &gt;   int(99)
// &gt;   [10]=&gt;
// &gt;   int(199)
// &gt; }
</pre>
https://developer.donnoval.ru/qsort-php/
