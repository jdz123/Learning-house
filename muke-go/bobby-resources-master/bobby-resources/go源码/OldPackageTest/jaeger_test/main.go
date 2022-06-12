package main

import (
	"time"

	"github.com/opentracing/opentracing-go"

	"github.com/uber/jaeger-client-go"

	jaegercfg "github.com/uber/jaeger-client-go/config"
)

func main() {
	cfg := jaegercfg.Configuration{
		Sampler: &jaegercfg.SamplerConfig{
			Type:  jaeger.SamplerTypeConst,
			Param: 1,
		},
		Reporter: &jaegercfg.ReporterConfig{
			LogSpans:           true,
			LocalAgentHostPort: "192.168.0.104:6831",
		},
		ServiceName: "mxshop",
	}

	tracer, closer, err := cfg.NewTracer(jaegercfg.Logger(jaeger.StdLogger))
	if err != nil {
		panic(err)
	}
	opentracing.SetGlobalTracer(tracer)
	// 嵌套span
	//parentSpan := opentracing.StartSpan("main")
	//span1 := opentracing.StartSpan("funcA", opentracing.ChildOf(parentSpan.Context()))
	//span1.Finish()
	//
	//span2 := opentracing.StartSpan("funcB",opentracing.ChildOf(parentSpan.Context()))
	//span2.Finish()
	//parentSpan.Finish()
	
	defer closer.Close()
	span := opentracing.StartSpan("go-grpc-web")
	time.Sleep(time.Second)
	defer span.Finish()
}
