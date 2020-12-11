package main

import (
	"encoding/json"
	"fmt"
	"github.com/gorilla/mux"
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

func loadData() []byte {
	jsonFile, erro := os.Open("produtos.json")
	if erro != nil{
		fmt.Println(erro.Error())
	}
	defer jsonFile.Close()
	data, erro := ioutil.ReadAll(jsonFile)
	return  data
}

func ListarProdutos(escrita http.ResponseWriter, leitura *http.Request) {
	produtos := loadData()
	escrita.Write([]byte(produtos))
}

func ListarProdutosID(escrita http.ResponseWriter, leitura *http.Request) {
	vars := mux.Vars(leitura)
	data :=loadData()

	var produtos Produtos
	json.Unmarshal(data, &produtos)

	for _, i := range produtos.Produtos{
		if i.Id == vars["id"]{
			produto, _ := json.Marshal(i)
			escrita.Write([]byte(produto))
		}
	}
}



func main() {

	rota := mux.NewRouter()
	rota.HandleFunc("/produtos", ListarProdutos)
	rota.HandleFunc("/produtos/{id}", ListarProdutosID)
	http.ListenAndServe(":4000",rota)

}