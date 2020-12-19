package main

import (
	"database/sql"
	_ "database/sql"
	"fmt"
	_ "github.com/go-redis/redis/v7"
	_ "github.com/go-sql-driver/mysql"
)

/*

func Conecta() *redis.Client {
	cliente := redis.NewClient(&redis.Options{
		Addr: os.Getenv("REDIS_HOST"),
		Password: "",
		DB: 0,
	})
	return cliente

}
 */
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

var db *sql.DB

func Insert(dado string) {
	db := DbConn()
		insForm, err := db.Prepare("INSERT INTO ordens(ordem) VALUES(?)")
		if err != nil {
			panic(err.Error())
		}
		insForm.Exec(dado)
		fmt.Println("foi")

		defer db.Close()
}

/*
func main()  {
	Insert("Testando")
}

 */






