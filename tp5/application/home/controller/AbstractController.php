<?php
namespace app\home\controller;

class AbstractController extends CommonController
{
    public function miss(){
        return returnCodeJson(40500,'请求接口不存在');
    }
    /**
     * 策略模式
     */
    public function call()
    {
    	$bro = new Browser();
    	echo $bro->charge('app\home\controller\AliCharge');
    }

/**
 *单例模式
 * 比如：DB，仅仅需要在一次生命周期中建一个连接就好
 */
    public function getDB()
    {
        $db1 = DanliDb::getInstance();
        $db2 = DanliDb::getInstance();

        var_dump($db1 === $db2);
    }

/**
 * 适配器模式
 * 比如：玩具接口适配遥控接口
 */

    public function toy()
    {
        $adaptee_dog = new Dog();
        echo "给狗套上红遥控器<BR>";
        $adapter_red = new RedRemote($adaptee_dog);

        //使用遥控器的接口去控制 张闭嘴（以保证扩展时，不修改基础类）
        $adapter_red->doOpen();
        $adapter_red->doClose();

    }

/**
 *冒泡排序
 * 两个循环
 * j为已确定最小的个数
 * i最后一个数位置（从最后把最小的排到最前面）
 */
    public function bubbleSort()
    {
        $array = [4,3,2,1,-1,8,12];
        $length = count($array);
        for ($j = 0;$j<$length;$j++)
        {
            for ($i=$length-1;$i>$j;$i--)
            {
                if ($array[$i]<$array[$i-1])
                {
                    $zhong = $array[$i-1];
                    $array[$i-1] = $array[$i];
                    $array[$i] = $zhong;
                }
            }
        }
        print_r($array);
    }

    /**
     * 选择排序
     * 把第一个作为最小值，往后依次比较，找到最小值
     * 找到第一个最小值，放在第一位。
     * 依次，找到第二个，放到第二位
     * ......
     */
    public function selectSort()
    {
        $arr = [2,1,5,55,6,8,10,2];
        for ($i =0;$i<count($arr);$i++)
        {
            $min = $i;
            for ($j=$i+1;$j<count($arr);$j++)
            {
                if ($arr[$j]<$arr[$min]) $min = $j;
            }
            $mid = $arr[$i];
            $arr[$i] = $arr[$min];
            $arr[$min] = $mid;
        }
        print_r($arr);exit();

    }

    /** 快速排序 找基准数 左右分组交换至左小右大
     * （双路快排）
     * @param array $ar
     * @param int $left
     * @param null $right
     * 原则：
     * 1.找一个基数（一般找第一个）
     * 2.通过比较把基数放到中间（从后到前找小的，从前到后找大的，两者互换）
     * 3.找到基准的位置（前边边的指针的数组key = 后边的key)
     * 4.基准左边的进行快排，右边的也进行快排
     */
    public function quickSort(array &$ar= [3,2,1], $left = 0, $right = null)
    {
        //default left = 0 ,right = len-1
         if ($right === null)
         {
             $right = sizeof($ar) - 1;
         }
         if ($left >= $right)
         {//not need to sort
              return;
         }
         //mark the default value
         $first_index = $left;
         $last_index = $right;
         $key = $ar[$left];//default key as first element
         while ($left != $right)
         {//find 2 swap element to sort into 2 parts
             while ($ar[$right] >= $key && $left < $right)
             { // [l--r] is [small--big]
                 $right--;
             }//until a[r] < key
             while ($ar[$left] <= $key && $left < $right)
             {
                 $left++;
             } //until a[l] > key
            if ($left < $right)
            { //swap
                echo "<br/> swap ar[$left] = $ar[$left] <-->ar[$right] = $ar[$right] <br/>";
                $t = $ar[$left];
                $ar[$left] = $ar[$right];
                $ar[$right] = $t;
            }
        }//finish 2 sorted parts
        //left == right == mid
        if ($first_index != $left) {//first_index == mid_index not need to swap, just len = 1
          echo "put key ar[$first_index] = $key <--> ar[$left] =$ar[$left] <br/>"; //put mid to first(location of key)
        $ar[$first_index] = $ar[$left];
        //put key into mid
        $ar [$left] = $key;
        }
        print_r(json_encode($ar));
        //continue cut and sort
        //left == right == mid
        echo " <br/> cut into: $first_index ---- | $left |---- $last_index <br/>";
        $this->quickSort($ar, $first_index, $left - 1);
        $this->quickSort($ar, $left + 1, $last_index);

    }


    /**
     * 插入排序
     * //区分 哪部分是已经排序好的
       //哪部分是没有排序的
        //找到其中一个需要排序的元素
        //这个元素 就是从第二个元素开始，到最后一个元素都是这个需要排序的元素
         //利用循环就可以标志出来
        //i循环控制 每次需要插入的元素，一旦需要插入的元素控制好了，
       //间接已经将数组分成了2部分，下标小于当前的（左边的），是排序好的序列
     */
    function insertSort($arr = [4,3,8,5,1])
    {

    $len=count($arr);
    for ($i=1; $i < $len; $i++)
    {
        //获得当前需要比较的元素值。
        $tmp = $arr[$i];
        print_r($tmp);
        //内层循环控制 比较 并 插入
        for ($j = $i - 1; $j >= 0; $j--)
        {
            //$arr[$i];//需要插入的元素; $arr[$j];//需要比较的元素
            if ($tmp < $arr[$j])
            {
                //发现插入的元素要小，交换位置
                //将后边的元素与前面的元素互换
                $arr[$j + 1] = $arr[$j];
                //将前面的数设置为 当前需要交换的数
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素
                //由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
    }
    //返回
    print_r($arr);
    }


    /**
     * 归并排序
     * （本质：分治算法的思想）
     * 把大数组不停地拆分，直到拆到最小，然后在排序合并
     */

    public function mergeSort()
    {

    }



    /**
     * 二分查找
     * 1.要求数组已经排好顺序
     */
    public function bin_search($f = 4,$low =1,$n =10,$arr = [] )
    {
//        array_rand(range(1,100),10)
        if (!$arr) $arr = array_rand(range(1,100),10);
        $mid = intval(($n-$low+1)/2);

        if (($low==$mid) && ($f != $arr[$n-1]) && $f != $arr[$low-1])
        {
            exit('找不到');
        }
        if ($f == $arr[$mid-1])
        {
            print_r($arr);
            print_r('--'.$f.'--');
            return $mid;
        }
        elseif ($f<$arr[$mid-1]) $this->bin_search($f,$low,$mid,$arr);
        else $this->bin_search($f,$mid,$n,$arr);

    }


    /**
     * 一群猴子排成一圈，按1，2，...，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，
     * 再数到第m只，在把它踢出去...，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
     * 要求编程模拟此过程，输入m、n,输出最后那个大王的编号。（新浪）（小米）
     */

    public function king($n = 7,$m =2)
    {
        $monkey = range(1, $n);
        $i = 0;

        while (count($monkey) >1) {
            $i += 1;
            $head = array_shift($monkey);//出列最前面的猴子
            if ($i % $m !=0) {
                #如果不是m的倍数，则把猴子返回尾部
                array_push($monkey,$head);
            }

            // 剩下的最后一个就是大王了
            echo  $monkey[0];
        }

    }



}
