package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"github.com/streadway/amqp"
	_ "github.com/go-sql-driver/mysql"
	"pagamento/queue"
	"time"
)

type Produto struct {
	Id string `json:"id"`
	Nome string `json:"nome"`
	Preco float64 `json:"preco,string"`
}

type Produtos struct {
	Produtos []Produto
}

type Order struct {
	Id string           `json:"id"`
	Nome string         `json:"nome"`
	Email string	    `json:"email"`
	Fone string		    `json:"fone"`
	ProdutoID string    `json:"produto_id"`
	Status string       `json:"status"`
	Preco float64        `json:"preco,string"`
	CreatedAt time.Time `json:"created_at,string"`
}

func main() {
	in := make(chan []byte)

	conexao := queue.Connect()
	queue.StartConsumo("order_queue", conexao, in)

	var order Order
	for conteudo := range  in{
		json.Unmarshal(conteudo, &order)
		order.Status = "Aprovado"
		insert(order.Status, order.Nome, order.CreatedAt, order.Email, order.Fone, order.ProdutoID, order.Preco)
		notificaPagamento(order, conexao)
	}
}

func insert(status string, nome string, createdAt time.Time, email string, fone string, produto string, preco float64) {
	db := DbConn()
	insForm, err := db.Prepare("INSERT INTO pagamento(status, nome, createdAt, email, fone, produto, preco) VALUES(?,?,?,?,?,?,?)")
	if err != nil {
		panic(err.Error())
	}
	insForm.Exec(status, nome, createdAt, email, fone, produto, preco)
	fmt.Println("foi")

	defer db.Close()
}

func DbConn() (db *sql.DB) {
	dbDriver := "mysql"
	dbUser := "root"
	dbPass := "root"
	dbName := "go"
	db, err := sql.Open(dbDriver, dbUser+":"+dbPass+"@/"+dbName)
	if err != nil {
		panic(err.Error())
	}
	return db
}

func notificaPagamento(order Order, ch *amqp.Channel){
	json, _ := json.Marshal(order)
	queue.Notify(json, "pagamento_ex","", ch)
	fmt.Println(string(json))
}