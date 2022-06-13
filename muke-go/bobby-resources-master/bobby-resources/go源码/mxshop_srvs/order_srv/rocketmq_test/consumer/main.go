package main

import (
	"context"
	"fmt"
	"time"

	"github.com/apache/rocketmq-client-go/v2"
	"github.com/apache/rocketmq-client-go/v2/consumer"
	"github.com/apache/rocketmq-client-go/v2/primitive"
)

func main() {
	c, _ := rocketmq.NewPushConsumer(  //服务器主动推过来
		consumer.WithNameServer([]string{"192.168.0.104:9876"}),
		consumer.WithGroupName("mxshop"),  //不同的消费者，相同的groupname能避免重复消费
	)
        //订阅 topic  imooc1  下的数据，这个方法是放在一个协程中去做的，所以要sleep主协程
	if err := c.Subscribe("imooc1", consumer.MessageSelector{}, func(ctx context.Context, msgs ...*primitive.MessageExt) (consumer.ConsumeResult, error) {
		for i := range msgs {
			fmt.Printf("获取到值： %v \n", msgs[i])
		}
		return consumer.ConsumeSuccess, nil //返回consumesuccess 这个值就不会再被取到，consumeretryLate 会再次取到
	}); err != nil {
		fmt.Println("读取消息失败")
	}
	_ = c.Start()
	//不能让主goroutine退出
	time.Sleep(time.Hour)
	_ = c.Shutdown()
}
