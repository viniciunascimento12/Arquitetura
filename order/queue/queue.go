package queue

import (
	"fmt"
	"github.com/streadway/amqp"
)

func  Connect() *amqp.Channel {
	conn, _ := amqp.Dial("amqp://guest:guest@localhost:5672")

	canal, err := conn.Channel()
	if err != nil {
		panic(err.Error())
	}
	return canal
}

func Notify(payload []byte, exchange string, routingKey string, ch *amqp.Channel )  {
	err := ch.Publish(
		exchange,
		routingKey,
		false,
		false,
		amqp.Publishing{ContentType: "applicatio/json",
						Body: []byte(payload),
		   },
		)
	if err != nil {
		panic(err.Error())
	}
	fmt.Println("mensagem enviada")
}