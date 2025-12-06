package main

import (
	"log"
	"myDocker/internal"
)

func main() {
	log.Println("-- Iniciando --")

	if err := internal.Start(); err != nil {
		log.Fatal("Erro ao iniciar: ", err)
	}
}
