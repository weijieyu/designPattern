<?php


/*
 * 一. 策略模式
 * 多用组合，少用继承，有一个比是一个更好。继承僵硬，组合弹性。interface热拔插。
*/

// 抽象类
class AdminController
{

    // 经常变化的单独抽象出来外包   
    public $checkBehavior;

    // 基本不变的交给继承
    public function index()
    {
        
        $input = $_GET;

        // check相关的动作通过checkBehavior行为来操作，隔离具体方法，实现热拔插
        $this->checkBehavior->checkInput($input);
    }

    // 动态改变checkBehavior的实现方案
    public function setCheckBehavior($checkBehavior)
    {
        $this->checkBehavior = $checkBehavior;
    }

}

// 接口(api)，向调用者提供服务，屏蔽背后实现和变化。承前启后，向后被具体算法族们实现，向前被类们拥有调用。
interface CheckBehavior
{

    public function checkInput($input);

}

// CheckBehavior的一种简单的实现
class SimpleCheckBehavior implements CheckBehavior
{

    
    public function checkInput($input)
    {

        echo $input['id'];

        if (@$input['id'] === 1) {
            return true;
        } else {
            return false;
        }
    }

}

// CheckBehavior的另一种返回页面的实现
class ReturnCheckBehavior implements CheckBehavior
{

    
    public function checkInput($input)
    {

        echo 'this will return to the page'.$input['id'];

        if (@$input['id'] === 1) {
            return true;
        } else {
            return false;
        }
    }

}

// 具体业务类
class DataFunnelController extends AdminController
{

    public function __construct()
    {
        $this->checkBehavior = new SimpleCheckBehavior();
    }
}


$a = new DataFunnelController;
$a->index();
$a->setCheckBehavior(new ReturnCheckBehavior);//运行时动态改变
$a->index();


