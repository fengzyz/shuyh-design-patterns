<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 22:52
 */
namespace Fengzyz\DesignPatterns\php\Observer;
class Order implements Observable
{
    // 订单状态
    private $state = 0;

    // 保存观察者
    private $observers = array();

    // 订单状态有变化时发送通知
    public function addOrder()
    {

        $this->state = 1;
        // 发送邮件
        Email::update($this->state);
        // 短信通知
        Message::update($this->state);
        // 记录日志
        Log::update();
        // 其他更多通知
    }

    // 添加（注册）观察者
    public function attach(Observer $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key === false) {
            $this->observers[] = $observer;
        }
    }

    // 移除观察者
    public function detach(Observer $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    // 遍历调用观察者的update()方法进行通知，不关心其具体实现方式
    public function notify()
    {
        foreach ($this->observers as $observer) {
            // 把本类对象传给观察者，以便观察者获取当前类对象的信息
            $observer->update($this);
        }
    }
}