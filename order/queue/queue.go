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
		amqp.Publishing{ContentType: "application/json",
						Body: []byte(payload),
		   },
		)
	if err != nil {
		panic(err.Error())
	}
	fmt.Println("mensagem enviada")
}


func StartConsumo(nomeFila string, ch *amqp.Channel, in chan []byte)  {
	fila, err := ch.QueueDeclare(
		nomeFila,
		true,
		false,
		false,
		false,
		nil,
		)
	if err != nil {
		panic(err.Error())
	}
	mensagens, err := ch.Consume(
		fila.Name,
		"checkout",
		true,
		false,
		false,
		false,
		nil,
		)
	if err != nil {
		panic(err.Error())
	}

	go func() {
		for i := range  mensagens{
				in <- []byte(i.Body)
			}
			close(in)
	}()
}