package main

import (
	"database/sql"
	"encoding/json"
	"flag"
	"fmt"
	"github.com/streadway/amqp"
	_ "github.com/go-sql-driver/mysql"
	"order/queue"
	"os"
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
	Id string   `json:"id"`
	Nome string `json:"nome"`
	Email string	`json:"email"`
	Fone string		`json:"fone"`
	ProdutoID string `json:"produto_id"`
	Status string `json:"status"`
	Preco float64 `json:"preco,string"`
	CreatedAt time.Time `json:"created_at,string"`
}

var produtoUrl string

func  init(){
	produtoUrl = os.Getenv("PRODUTO_URL")
}

func main()  {
	var parametro string
	flag.StringVar(&parametro, "opt", "value", "Usage")
	flag.Parse()

	in := make(chan []byte)
	conexao := queue.Connect()

	switch parametro {
	case "checkout":
		queue.StartConsumo("checkout_queue", conexao, in)
		for conteudo := range  in{
			notifyOrderCriated(creatOrder(conteudo), conexao)
			fmt.Println(string(conteudo))

		}
	case "pagamento":
		queue.StartConsumo("pagamento_queue", conexao, in)
		var order Order
		for conteudo := range  in{
			json.Unmarshal(conteudo, &order)
			fmt.Println("Pagamento:", string(conteudo))

		}
	}
}

func creatOrder(conteudo []byte) Order {
	var order Order
	json.Unmarshal(conteudo, &order)
	//order.Id = "123"
	order.Status = "Pendente"
	order.CreatedAt = time.Now()
	insert(order.Status, order.Nome, order.CreatedAt, order.Email, order.Fone)
	return order
}

func insert(status string, nome string, createdAt time.Time, email string, fone string) {
	db := DbConn()
	insForm, err := db.Prepare("INSERT INTO ordens(ordem, nome, createdAt, email, fone) VALUES(?,?,?,?,?)")
	if err != nil {
		panic(err.Error())
	}
	insForm.Exec(status, nome, createdAt, email, fone)
	fmt.Println("Ordem enviada")

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

func notifyOrderCriated(order Order, ch *amqp.Channel){
	json, _ := json.Marshal(order)
	queue.Notify(json, "order_ex", "", ch)
}

/*
func saveOrder(order Order)  {


	json, _ := json.Marshal(order)
	conexao := db.Conecta()

	err := conexao.Set(order.Id, string(json),0).Err()
	if err != nil {
		panic(err.Error())
	}
}

func GetProdutoId(id string) Produto {
	response, err := http.Get(produtoUrl + "/produtos/" + id)
	if err != nil {
		fmt.Printf("Erro no http response %s\n", err)
	}
	data, _ := ioutil.ReadAll(response.Body)
	var produto Produto
	json.Unmarshal(data, &produto)
	return produto
}
*/