package main

import (
	"encoding/json"
	"fmt"
	"github.com/gorilla/mux"
	"html/template"
	"io/ioutil"
	"net/http"
	"os"
	_ "github.com/gorilla/mux"
)

type Produto struct {
	Id string `json:"id"`
	Nome string `json:"nome"`
	Preco float64 `json:"preco,string"`
}

type Produtos struct {
	Produtos []Produto
}

var produtoUrl string

func  init(){
	produtoUrl = os.Getenv("PRODUTO_URL")
}

func loadProdutos() []Produto{
	response, erro:= http.Get(produtoUrl + "/produtos")
	if erro != nil{
		fmt.Println("Erro de HTTP")
	}
	data, _ := ioutil.ReadAll(response.Body)

	var produtos Produtos
	json.Unmarshal(data, &produtos)
	fmt.Println(string(data))
	return produtos.Produtos
}

func  main(){
	r := mux.NewRouter()
	r.HandleFunc("/",ListarProdutos)
	r.HandleFunc("/produtos/{id}",MostrarProdutos)
	http.ListenAndServe(":4001", r)
}

func ListarProdutos(escrita http.ResponseWriter, leitura *http.Request){
	produtos := loadProdutos()
	t := template.Must(template.ParseFiles("templates/catalogo.html"))
	t.Execute(escrita,produtos)
}


func MostrarProdutos(escrita http.ResponseWriter, leitura *http.Request){
	vars := mux.Vars(leitura)
	response, erro := http.Get(produtoUrl + "/produtos/" + vars["id"])
	if erro != nil{
		fmt.Printf("Falha no http response %s\n", erro)
	}
	data, _ := ioutil.ReadAll(response.Body)

	var produt Produto
	json.Unmarshal(data, &produt)

	t := template.Must(template.ParseFiles("templates/ver.html"))
	t.Execute(escrita, produt)
}