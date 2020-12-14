package main

import (
	"encoding/json"
	"fmt"
	"github.com/gorilla/mux"
	"html/template"
	"io/ioutil"
	"net/http"
	"os"
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
	Nome string `json:"nome"`
	Email string	`json:"email"`
	Fone string		`json:"fone"`
	ProdutoID string `json:"produto_id"`
}
var produtoUrl string

func  init(){
	produtoUrl = os.Getenv("PRODUTO_URL")
}

func mostrarChekcout(escrita http.ResponseWriter, leitura *http.Request)  {
	vars := mux.Vars(leitura)
	response, erro := http.Get(produtoUrl + "/produtos/" + vars["id"])
	if erro != nil{
		fmt.Printf("Falha no http response %s\n", erro)
	}
	data, _ := ioutil.ReadAll(response.Body)
	fmt.Print(string(data))

	var produt Produto
	json.Unmarshal(data, &produt)

	t := template.Must(template.ParseFiles("templates/checkout.html"))
	t.Execute(escrita, produt)
}

func finish(escrita http.ResponseWriter, leitura *http.Request)  {
	var order Order
	order.Nome = leitura.FormValue("nome")
	order.Email = leitura.FormValue("email")
	order.Fone = leitura.FormValue("fone")
	order.ProdutoID = leitura.FormValue("produto_id")

	data, _ := json.Marshal(order)
	fmt.Println(string(data))

	escrita.Write([]byte("Finalizado!"))
}

func main(){
	r := mux.NewRouter()
	r.HandleFunc("/finish", finish)
	r.HandleFunc("/{id}", mostrarChekcout)
	http.ListenAndServe(":4003", r)
}
